<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login - Ceylon Center Gem</title>
    <link href="/css/styles.css" rel="stylesheet"/>
    <link href="/css/custom_styles.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"></script>
    <style>
        body {
            min-height: 100vh;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .login-split {
        height: 650px;
        max-width: 1000px;
        margin: auto;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2rem 3.5rem rgba(15, 23, 42, 0.15);
        }
        .login-image {
            background-image: url('/images/Rare_Gemstones_570832b8-247b-4ce8-8055-2a81fdece1cd_480x480.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
            min-height: 100%;
        }
        .login-image::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15,23,42,0.12), rgba(15,23,42,0.55));
        }
        .login-image-content {
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        }
        .login-image-top {
            display: flex;
            flex-direction: column;
        }
        .login-image-content h1 {
        font-size: 2.2rem;
        margin: 0;
        color: #ffffff !important;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
        }
        .login-image-content p {
            max-width: 380px;
            line-height: 1.8;
            opacity: 0.92;
            text-align: center;
            padding: 1.5rem;
            background: rgba(15, 23, 42, 0.3);
            border-radius: 1rem;
        }
        .login-card {
        padding: 0.75rem;
        background: #fff;
        }
        .login-card .card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 1.5rem 2.5rem rgba(15, 23, 42, 0.08);
        }
        .login-card .form-control {
            border-radius: 0.85rem;
            border: 1px solid #d6d9e6;
            padding: 1rem 1.15rem;
            font-size: 0.95rem;
        }
        .login-card .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.12);
        }
        .login-card .btn-primary {
            border-radius: 0.85rem;
            padding: 0.95rem 1.75rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }
        .login-card .small-link {
            color: #6b7280;
            text-decoration: none;
        }
        .login-card .small-link:hover {
            color: #111827;
        }
        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 1.75rem;
            color: #111827;
        }
        .brand-badge svg {
            width: 2rem;
            height: 2rem;
            color: #4f46e5;
        }
        @media (max-width: 991.98px) {
            .login-split {
            min-height: 550px;
            max-width: 900px;
            margin: auto;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 2rem 3.5rem rgba(15, 23, 42, 0.15);
            }
            .login-image {
                min-height: 280px;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row login-split g-0 overflow-hidden">
                    <div class="col-lg-6 login-image">
                        <div class="login-image-content">
                            <div class="login-image-top">
                                <span class="badge badge-pill badge-primary px-3 py-2" style="background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.24); backdrop-filter: blur(10px);">
                                    Ceylon Center Gem
                                </span>
                                <h1>Welcome to Ceylon Center Gem</h1>
                            </div>
                            <p>Secure login for your gemstone management dashboard. Access inventory, GRN, and reporting from one elegant system.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 login-card d-flex align-items-center">
                        <div class="card w-100 p-4 p-md-5">
                            <div class="card-body">
                                <div class="brand-badge">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L20.4 7.5v9L12 22l-8.4-5.5v-9L12 2zm0 2.4L6.2 7.8l5.8 4.4 5.8-4.4L12 4.4zm-6.4 2.9 3.5 1.3-3.5 2.7V7.3zm12.8 0v3.1l-3.5-2.7 3.5-1.3zM12 19.3l5.3-3.5-2.2-3.7H8.9l-2.2 3.7L12 19.3z"/></svg>
                                    <span>Ceylon Center Gem</span>
                                </div>
                                <h2 class="h4 mb-3">Sign in to your account</h2>
                                <p class="text-muted mb-4">Enter your username and password to access the gemstone management dashboard.</p>

                                @if(session('msg'))
                                    <div class="alert alert-danger alert-dismissible fade show rounded" role="alert">
                                        <i class="feather-alert-circle mr-2"></i>{{ session('msg') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                        <form action="/Welcome/LoginUser" method="post" autocomplete="off" id="loginForm">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label font-weight-bold" for="username">Username</label>
                                                <input type="text" id="username" name="username" class="form-control" placeholder="Enter Username" required autofocus>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label font-weight-bold" for="password">Password</label>
                                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                                    <label class="form-check-label small text-muted" for="rememberMe">Remember Me</label>
                                                </div>
                                                <a href="#" class="small text-muted small-link">Forgot password?</a>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                                        </form>
                                        <div class="text-center mt-4">
                                            <span class="text-muted">Don't have login details?</span>
                                            <a href="#" class="small font-weight-bold small-link">Register</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        feather.replace();

        $('#loginForm').on('submit', function(e) {
            if (!$('#username').val() || !$('#password').val()) {
                alert('Username and password are required');
                e.preventDefault();
                return false;
            }
        });
    });
    </script>
</body>
</html>
