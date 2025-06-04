<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login & Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: #f8f9fa;
        }

        main#main {
            width: 100%;
            height: calc(100%);
            background: white;
        }

        #login-right {
            position: absolute;
            right: 0;
            width: 50%;
            height: calc(100%);
            background: white;
            display: flex;
            align-items: center;
        }

        #login-left {
            position: absolute;
            left: 0;
            width: 50%;
            height: calc(100%);
            background: #59b6ec61;
            display: flex;
            align-items: center;
            background: url(assets/uploads/blood-cells.jpg);
            background-repeat: no-repeat;
            background-size: cover;
        }

        .register {
            margin: 5%;
            padding: 3%;
            background: #fff;
            border-radius: 10px;
        }

        .register-heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .btnRegister {
            width: 100%;
            border: none;
            border-radius: 1.5rem;
            padding: 1.5%;
            background: #0062cc;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <main id="main" class=" bg-danger">
        <div id="login-left"></div>
        <div id="login-right" class="bg-danger">
            <div class="container register">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" id="tabContent" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="login-tab" data-toggle="tab" href="#loginTab" role="tab">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="register-tab" data-toggle="tab" href="#registerTab" role="tab">Register</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tabContent">
                            <div class="tab-pane fade show active" id="loginTab" role="tabpanel">
                                <h3 class="register-heading">Login</h3>
                                <form id="loginForm">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email" id="email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Password" id="password" required>
                                    </div>
                                    <button type="submit" class="btnRegister">Login</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="registerTab" role="tabpanel">
                                <h3 class="register-heading">Register</h3>
                                <form id="registerForm">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="fname" placeholder="Username" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="reg_password" placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="cpassword" placeholder="Confirm Password" required>
                                        <span id="message" class="small"></span>
                                    </div>
                                    <button type="submit" class="btnRegister">Register</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const pass = document.getElementById('reg_password');
        const cpass = document.getElementById('cpassword');
        const msg = document.getElementById('message');

        cpass.addEventListener('keyup', () => {
            if (pass.value === cpass.value) {
                msg.textContent = 'Matched';
                msg.style.color = 'green';
            } else {
                msg.textContent = 'Not Matching';
                msg.style.color = 'red';
            }
        });

        document.getElementById("loginForm").addEventListener("submit", async function(e) {
            e.preventDefault();
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            try {
                const response = await fetch("http://127.0.0.1:3000/api/auth/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        email,
                        password
                    })
                });

                const result = await response.json();

                if (response.ok && result.token) {
                    $.post("session_login.php", {
                        token: result.token
                    }, function(res) {
                        if (res === "ok") {
                            window.location.href = "index.php?page=home";
                        } else {
                            alert("Login berhasil, tapi gagal menyimpan sesi.");
                        }
                    });
                } else {
                    alert("Login gagal: " + (result.message || "Cek kembali email dan password."));
                }
            } catch (error) {
                alert("Terjadi kesalahan koneksi.");
            }
        });

        document.getElementById("registerForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const username = document.querySelector('input[name="fname"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const password = document.getElementById("reg_password").value;
            const cpassword = document.getElementById("cpassword").value;

            if (password.length < 6) {
                alert("Password must be at least 6 characters.");
                return;
            }

            if (password !== cpassword) {
                alert("Password dan Confirm Password tidak cocok.");
                return;
            }

            try {
                const response = await fetch("http://127.0.0.1:3000/api/auth/register", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        username,
                        email,
                        password
                    })
                });

                const result = await response.json();

                if (result.token) {
                    $.post("session_login.php", {
                        token: result.token
                    }, function(res) {
                        if (res === "ok") {
                            alert("Registrasi berhasil.");
                            window.location.href = "index.php?page=home";
                        } else {
                            alert("Registrasi berhasil, tapi gagal menyimpan sesi.");
                        }
                    });
                } else if (result.message && result.message.toLowerCase().includes("success")) {
                    alert("Registrasi berhasil. Silakan login.");
                    document.getElementById("login-tab").click();
                } else {
                    alert("Registrasi gagal: " + (result.message || "Periksa kembali input."));
                }
            } catch (error) {
                alert("Terjadi kesalahan saat koneksi.");
            }
        });
    </script>
</body>

</html>