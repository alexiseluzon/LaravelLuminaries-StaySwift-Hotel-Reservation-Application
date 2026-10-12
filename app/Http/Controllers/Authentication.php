<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Models\userModel;
use App\Models\userVerify;
use App\Mail\userVerifyMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Authentication extends Controller
{
    // ROUTING
    public function login()
    {
        return view('login');
    }

    public function registration()
    {
        return view('registration');
    }

    public function adminLogin()
    {
        return view('adminLogin');
    }

    public function privacyPolicy()
    {
        return view('privacyPolicy');
    }
    public function dataPrivacy()
    {
        return view('dataPrivacy');
    }
    public function notesRemarks()
    {
        return view('notedAndRemarks');
    }
    // ROUTING

    // FUNCTION FOR REGISTRATION
    public function registrationFunction(Request $request)
    {
        $namePattern = "/^\p{L}+(?:[ '\-]\p{L}+)*$/u";
        $request->validate([
            'userFirstName'     => ['required', 'max:50', 'regex:' . $namePattern],
            'userMiddleName'    => ['nullable', 'max:50', 'regex:' . $namePattern],
            'userLastName'      => ['required', 'max:50', 'regex:' . $namePattern],
            'userExtension'     => ['nullable', 'in:Jr.,Sr.,II,III,IV'],
            'userBirthdate'     => ['required', 'date', 'before:today'],
            'userEmailAddress'  => ['required', 'email', 'max:255'],
            'userPhone'         => ['required', 'digits:11'],
            'userPassword'      => ['required', 'string', 'min:6', 'max:20', 'not_in:password'],
        ]);

        $existingEmail = userModel::select('email')->where('email', '=', $request->userEmailAddress)->get();
        if ($existingEmail->isNotEmpty()) {
            return response()->json(2);
        } else {
            $registration = userModel::create([
                'photos' => '/storage/userPhotos/defaultImage.jpg',
                'lastname' => $request->userLastName,
                'firstname' => $request->userFirstName,
                'middlename' => $request->userMiddleName,
                'extention' => $request->userExtension,
                'email' => $request->userEmailAddress,
                'phoneNumber' => $request->userPhone,
                'birthday' => $request->userBirthdate,
                'age' => \Carbon\Carbon::parse($request->userBirthdate)->age,
                'password' => Hash::make($request->userPassword),
                'is_active' => 1,
                'is_admin' => 0,
                'email_verified' => 0,
            ]);

        try {
            $this->sendVerificationEmail($registration);
        } catch (\Throwable $e) {
            Log::error('Verification email failed: ' . $e->getMessage());
            return response()->json(3);
        }

        return response()->json(1);
        }
    }

    // FUNCTION FOR REGISTRATION

    private function sendVerificationEmail(userModel $user): void
    {
        $token = Str::random(64);
        userVerify::updateOrCreate(['user_id' => $user->user_id], ['token' => $token]);

        $email = $user->email;
        Mail::send('layouts.emailVerificationEmail', ['token' => $token], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Verify your Email');
        });
    }

    public function resendVerification(Request $request)
    {
        $request->validate(['email' => ['required', 'email', 'max:255']]);
        $email = strtolower(trim($request->email));
        $cooldownKey = 'resend-verify:' . sha1($email);

        // One request per address per minute
        if (! Cache::add($cooldownKey, 1, 60)) {
            return response()->json(['status' => 'wait'], 429);
        }

        $user = userModel::whereRaw('LOWER(email) = ?', [$email])
            ->where('is_active', 1)
            ->where('email_verified', 0)
            ->first();

        if ($user) {
            try {
                $this->sendVerificationEmail($user);
            } catch (\Throwable $e) {
                Cache::forget($cooldownKey);
                Log::error('Resend verification failed: ' . $e->getMessage());
                return response()->json(['status' => 'error'], 500);
            }
        }

        // Same answer whether or not the account exists (no account enumeration)
        return response()->json(['status' => 'sent']);
    }

    // EMAIL VERIFICATION
    public function userVerify($token)
    {
        $verifyUser = userVerify::where('token', $token)->first();

        if (!is_null($verifyUser)) {
            $user = $verifyUser->user_id;
            userModel::where([['user_id', '=', $user]])
                ->update(['email_verified' => 1]);
            return redirect()->to('login')->with('message', 'Email verified successfully!');
        }
    }
    // EMAIL VERIFICATION

    // FUNCTION FOR USER LOGIN
    protected function userCredentials(Request $request)
    {
        return [
            'email' => request()->userEmail,
            'password' => request()->userLoginPassword,
        ];
    }

    public function userLoginFunction(Request $request)
    {
        $guard = auth()->guard('userModel');

        if (! $guard->attempt($this->userCredentials($request))) {
            return response()->json(0); // WRONG CREDENTIALS
        }

        $user = $guard->user();
        $code = match (true) {
            $user->is_active == 0 => 3,       // INACTIVE ACCOUNT
            $user->is_admin === 1 => 0,       // ADMIN USING USER FORM
            $user->email_verified != 1 => 2,  // NOT VERIFIED EMAIL
            default => 1,
        };

        if ($code !== 1) {
            $guard->logout(); // attempt() already logged them in
            return response()->json($code);
        }

        $request->session()->regenerate();
        return response()->json(1);
    }

    public function adminLoginFunction(Request $request)
    {
        $guard = auth()->guard('userModel');

        if (! $guard->attempt($this->adminCredentials($request))) {
            return response()->json(0); // WRONG CREDENTIALS
        }

        $user = $guard->user();
        $code = match (true) {
            $user->is_active == 0 => 3,   // INACTIVE ACCOUNT
            $user->is_admin !== 1 => 0,   // NOT ADMIN
            default => 1,
        };

        if ($code !== 1) {
            $guard->logout();
            return response()->json($code);
        }

        $request->session()->regenerate();
        return response()->json(1);
    }

    protected function adminCredentials(Request $request)
    {
        return [
            'email' => request()->adminEmail,
            'password' => request()->adminPassword,
        ];
    }

    // DEMO LOGIN (only when DEMO_LOGIN_ENABLED=true)
    public function demoLoginFunction(Request $request, string $role)
    {
        abort_unless(config('app.demo_login'), 404);
    
        $isAdmin = $role === 'admin';
    
        $user = userModel::firstOrCreate(
            ['email' => $isAdmin ? \App\Http\Middleware\BlockDemoAdminWrites::DEMO_ADMIN_EMAIL
             : 'demo.user@stayswift.test'],
            [
                'photos'      => '/storage/userPhotos/defaultImage.jpg',
                'lastname'    => 'Demo',
                'firstname'   => $isAdmin ? 'Admin' : 'Guest',
                'middlename'  => '',
                'extention'   => '',
                'phoneNumber' => '09000000000',
                'birthday'    => '2000-01-01',
                'age'         => 26,
                'password'       => Hash::make(Str::random(32)),
                'is_active'      => 1,
                'is_admin'       => $isAdmin ? 1 : 0,
                'email_verified' => 1,
            ]
        );
    
        // keep the demo account valid even if it was edited/deactivated
        $user->forceFill([
            'is_active'      => 1,
            'email_verified' => 1,
            'is_admin'       => $isAdmin ? 1 : 0,
        ])->save();
    
        auth()->guard('userModel')->login($user);
        $request->session()->regenerate();
    
        return response()->json(1);
    }

    // LOGOUT FUNCTION
    public function logoutFunction()
    {
        $updateUtilized = userModel::where('user_id', '=', auth()->guard('userModel')->user()->user_id)
            ->update(array('updated_at' => now()));
        if ($updateUtilized) {
            Session::flush();
            Auth::logout();
            return response()->json(1);
        }
    }
    // LOGOUT FUNCTION

}
