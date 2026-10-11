(function () {
    var form = document.getElementById('registrationForm');
    if (!form) return;

    var NAME_RE = /^\p{L}+(?:[ '\-]\p{L}+)*$/u;
    var EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
    var submitBtn = form.querySelector('.submit-btn');
    var byId = function (id) { return document.getElementById(id); };
    var touched = {};

    byId('userBirthdate').max = new Date().toLocaleDateString('en-CA');
    var phone = byId('userPhone');
    phone.setAttribute('inputmode', 'numeric');
    phone.setAttribute('autocomplete', 'tel');
    phone.placeholder = '09XXXXXXXXX';

    function nameRule(label, required) {
        return function (v) {
            if (!v) return required ? label + ' is required.' : '';
            return NAME_RE.test(v) ? '' : label + ' must contain letters only.';
        };
    }

    var rules = {
        userFirstName: nameRule('First name', true),
        userMiddleName: nameRule('Middle name', false),
        userLastName: nameRule('Last name', true),
        userBirthdate: function (v) {
            if (!v) return 'Birthdate is required.';
            return v > byId('userBirthdate').max ? 'Birthdate cannot be in the future.' : '';
        },
        userEmailAddress: function (v) {
            if (!v) return 'Email address is required.';
            return EMAIL_RE.test(v) ? '' : 'Enter a valid email address.';
        },
        userPhone: function (v) {
            if (!v) return 'Phone number is required.';
            return /^\d{11}$/.test(v) ? '' : 'Phone number must be exactly 11 digits.';
        },
        userPassword: function (v) {
            if (!v) return 'Password is required.';
            if (v.length < 6 || v.length > 20) return 'Password must be 6 to 20 characters.';
            return v.toLowerCase() === 'password' ? 'Password cannot be "password".' : '';
        },
        userConfirmPassword: function (v) {
            if (!v) return 'Please confirm your password.';
            return v !== byId('userPassword').value ? 'Passwords do not match.' : '';
        }
    };
    var ids = Object.keys(rules);

    function value(id) {
        var v = byId(id).value;
        return id.indexOf('Password') === -1 ? v.trim() : v;
    }

    function errorBox(input) {
        var box = byId('err-' + input.id);
        if (!box) {
            box = document.createElement('small');
            box.id = 'err-' + input.id;
            box.className = 'field-error';
            box.setAttribute('role', 'alert');
            box.hidden = true;
            input.insertAdjacentElement('afterend', box);
            input.setAttribute('aria-describedby', box.id);
        }
        return box;
    }

    function check(id, show) {
        var input = byId(id);
        var msg = rules[id](value(id));
        if (show) {
            var box = errorBox(input);
            box.textContent = msg;
            box.hidden = !msg;
            input.classList.toggle('is-invalid', !!msg);
            input.setAttribute('aria-invalid', msg ? 'true' : 'false');
        }
        return !msg;
    }

    function refresh() {
        submitBtn.disabled = !ids.every(function (id) { return check(id, false); });
    }

    function sanitize(id, input) {
        if (/^user(First|Middle|Last)Name$/.test(id)) {
            input.value = input.value
                .replace(/[^\p{L} '\-]/gu, '')
                .replace(/^[ '\-]+/, '')
                .replace(/([ '\-])[ '\-]+/g, '$1');
        } else if (id === 'userPhone') {
            input.value = input.value.replace(/\D/g, '').slice(0, 11);
        }
    }

    ids.forEach(function (id) {
        var input = byId(id);
        errorBox(input);
        input.addEventListener('input', function () {
            sanitize(id, input);
            if (touched[id]) check(id, true);
            if (id === 'userPassword' && touched.userConfirmPassword) check('userConfirmPassword', true);
            refresh();
        });
        ['blur', 'change'].forEach(function (evt) {
            input.addEventListener(evt, function () {
                touched[id] = true;
                check(id, true);
                refresh();
            });
        });
    });

    // Used by the inline onchange on the birthdate field
    window.calculateAge = function () {
        var v = byId('userBirthdate').value;
        var out = byId('userAge');
        if (!v) { out.value = ''; return; }
        var b = new Date(v + 'T00:00:00');
        var n = new Date();
        var age = n.getFullYear() - b.getFullYear();
        var m = n.getMonth() - b.getMonth();
        if (m < 0 || (m === 0 && n.getDate() < b.getDate())) age--;
        out.value = age >= 0 ? age : '';
        touched.userBirthdate = true;
        check('userBirthdate', true);
        refresh();
    };

    $(form).on('submit', function (e) {
        e.preventDefault();
        if (!ids.every(function (id) { return check(id, true); })) return;
        submitBtn.disabled = true;
        $.ajax({
            url: '/registrationFunction',
            method: 'POST',
            dataType: 'json',
            data: $(form).serialize()
        })
        .done(function (res) {
            if (res == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'REGISTERED SUCCESSFULLY',
                    text: 'Please check your email to verify your account.',
                    showConfirmButton: false,
                    timer: 1800
                }).then(function () { form.reset(); window.location.href = '/login'; });
            } else if (res == 2) {
                Swal.fire('EMAIL NOT AVAILABLE', 'Please choose another email', 'error');
            } else {
                Swal.fire('REGISTRATION FAILED', 'Please re-enter your details', 'error');
            }
        })
        .fail(function (xhr) {
            var msg = 'Something went wrong. Please try again.';
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                msg = Object.values(xhr.responseJSON.errors)[0][0];
            } else if (xhr.status === 429) {
                msg = 'Too many attempts. Please wait a minute.';
            }
            Swal.fire('REGISTRATION FAILED', msg, 'error');
        })
        .always(refresh);
    });

    refresh();
    setTimeout(refresh, 400); // catches browser autofill
})();