<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login - Ceylon Center Gem</title>
    <link href="{{ url('/css/styles.css') }}" rel="stylesheet"/>
    <link href="{{ url('/css/custom_styles.css') }}" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"></script>
    <style>
        body {
            min-height: 100vh;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-split {
            min-height: 90vh;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 2rem 3.5rem rgba(15, 23, 42, 0.15);
        }
        .login-image {
            background-image: url('{{ asset('images/Rare_Gemstones_570832b8-247b-4ce8-8055-2a81fdece1cd_480x480.jpg') }}');
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
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            color: #fff;
            z-index: 1;
            padding-top: 4rem;
        }
        .login-image-top {
            display: flex;
            flex-direction: column;
        }
        .login-image-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: -0.04em;
            margin-bottom: 1rem;
            color: #ffffff;
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
            padding: 3rem;
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
                min-height: auto;
                border-radius: 1rem;
            }
            .login-image {
                min-height: 280px;
            }
        }
    </style>
</head>
<body>
<<<<<<< HEAD
<<<<<<< Updated upstream
    <div id="layoutAuthentication" class="w-100">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8 col-sm-10">
                        <div class="card premium-card border-0">
                            <div class="card-header bg-transparent border-0 text-center pt-5 pb-0">
                                <img src="{{ asset('assets/images/vys.png') }}" 
                                     alt="VYS International" 
                                     style="max-width: 180px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));" 
                                     class="img-fluid mb-2">
                                <p class="text-muted mt-2 mb-0" style="font-size: 0.95rem;">Welcome back! Please login to your account.</p>
                            </div>
                            <div class="card-body p-4 pt-3">
=======
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row login-split g-0 overflow-hidden">
                    <div class="col-lg-6 login-image">
                        <div class="login-image-content">
                            <div class="login-image-top">
                                <h1 style="text-align: center;">
                                     Welcome to Ceylon Center Gem
                                </h1>
                            </div>
                            <p>Secure login for your gemstone management dashboard. Access inventory, and reporting from one elegant system.</p>
=======
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
>>>>>>> d2c05ed855d9a42e15dcf1f216f9b3838959b3d1
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

<<<<<<< HEAD
>>>>>>> Stashed changes
=======
>>>>>>> d2c05ed855d9a42e15dcf1f216f9b3838959b3d1
                                @if(session('msg'))
                                    <div class="alert alert-danger alert-dismissible fade show rounded" role="alert">
                                        <i class="feather-alert-circle mr-2"></i>{{ session('msg') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <form action="{{ url('Welcome/LoginUser') }}" method="post" autocomplete="off" id="loginForm">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label font-weight-bold" for="username">Username</label>
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Enter Username" required autofocus>
                                    </div>
                                    <div class="mb-4">
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
