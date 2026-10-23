<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Invalid Verification Link | StaySwift</title>
    <style>
        body{margin:0;min-height:100vh;display:grid;place-items:center;background:#0b0b0b;color:#f5f5f5;font-family:system-ui,sans-serif;padding:16px}
        main{max-width:420px;text-align:center;border:1px solid #d4af37;border-radius:12px;padding:32px}
        h1{color:#d4af37;font-size:1.4rem;margin-top:0}
        a{display:inline-block;margin-top:16px;padding:10px 20px;background:#d4af37;color:#000;border-radius:8px;text-decoration:none;font-weight:600}
        a:focus-visible{outline:3px solid #fff;outline-offset:2px}
    </style>
</head>
<body>
    <main role="main">
        <h1>Link invalid or expired</h1>
        <p>This verification link is no longer valid. Log in and choose "Resend" to get a new one.</p>
        <a href="{{ url('/login') }}">Go to login</a>
    </main>
</body>
</html>