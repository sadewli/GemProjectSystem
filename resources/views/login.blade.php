<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login - VYS International</title>
    <!-- Msway Based & Boostrap Styles -->
    <link href="{{ url('/css/styles.css') }}" rel="stylesheet"/>
    <link href="{{ url('/css/custom_styles.css') }}" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"></script>
    <style>
        body { 
            background: linear-gradient(135deg, #f0f4ff 0%, #e0efff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .premium-card {
            border-radius: 1.25rem;
            box-shadow: 0 1rem 3rem rgba(0,0,0,0.075);
            background: #ffffff;
        }
        .premium-input {
            border: 1px solid #e1e5eb;
            transition: all 0.2s;
        }
        .premium-input:focus {
            border-color: #4F46E5;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.15);
        }
        .premium-btn {
            background-color: #4F46E5;
            color: #fff;
            padding: 0.75rem 2.5rem;
            border-radius: 0.5rem;
            border: none;
            font-weight: 600;
            transition: all 0.2s;
        }
        .premium-btn:hover {
            background-color: #4338ca;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
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

>>>>>>> Stashed changes
                                @if(session('msg'))
                                    <div class="alert alert-danger alert-dismissible fade show rounded" style="border-radius: 0.5rem;" role="alert">
                                        <i class="feather-alert-circle mr-2"></i>{{ session('msg') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <form action="{{ url('Welcome/LoginUser') }}" method="post" autocomplete="off" id="loginForm">
                                    @csrf
                                    <div class="form-group mb-4">
                                        <label class="input-label font-weight-bold text-dark" for="company">Company <span class="text-danger">*</span></label>
                                        <select class="form-control premium-input custom-select" id="company" name="company" required>
                                            <option value="">-- Select Company --</option>
                                            @if(isset($companies) && $companies->isNotEmpty())
                                                @foreach($companies as $company)
                                                    <option value="{{ $company->idtbl_company }}">{{ $company->company }} ({{ $company->code }})</option>
                                                @endforeach
                                            @else
                                                <option value="">No companies available</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group mb-4" style="position: relative;">
                                        <label class="input-label font-weight-bold text-dark" for="branch">Branch <span class="text-danger">*</span></label>
                                        <select class="form-control premium-input custom-select" id="branch" name="branch" required>
                                            <option value="">-- Select Branch --</option>
                                        </select>
                                        <div id="branch_loading" style="display:none; position:absolute; right:15px; top:38px;">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                        <span id="branch_error" class="ajax-error text-danger small"></span>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="input-label font-weight-bold text-dark" for="username">Username <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0" style="border-radius: 0.5rem 0 0 0.5rem;"><i data-feather="user" style="width: 16px;"></i></span>
                                            </div>
                                            <input class="form-control premium-input border-left-0 pl-1" style="border-radius: 0 0.5rem 0.5rem 0;" id="username" name="username" type="text" placeholder="Enter username" autofocus required />
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="input-label font-weight-bold text-dark" for="password">Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0" style="border-radius: 0.5rem 0 0 0.5rem;"><i data-feather="lock" style="width: 16px;"></i></span>
                                            </div>
                                            <input class="form-control premium-input border-left-0 pl-1" style="border-radius: 0 0.5rem 0.5rem 0;" id="password" name="password" type="password" placeholder="••••••••" required />
                                        </div>
                                    </div>
                                    <div class="form-group d-flex align-items-center justify-content-between mt-5 mb-2">
                                        <a href="#" class="small text-muted" style="text-decoration: none; font-weight: 500;">Forgot Password?</a>
                                        <button type="submit" class="premium-btn" id="loginBtn">
                                            Login to Dashboard <i class="fas fa-arrow-right ml-2"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer bg-transparent border-0 text-center pb-4 pt-0">
                                <div class="small text-muted" style="font-weight: 500;">
                                    Copyright &copy; Erav Technology {{ date('Y') }}
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
        feather.replace(); // Initialize feather icons

        var branchUrl = '{{ route("welcome.getBranchesByCompany") }}';
        $('#company').change(function() {
            var company_id = $(this).val();
            var branchSelect = $('#branch');
            var loading = $('#branch_loading');
            var errorText = $('#branch_error');

            errorText.text('');
            branchSelect.empty().append('<option value="">-- Select Branch --</option>').prop('disabled', true);

            if(company_id) {
                loading.show();
                $.ajax({
                    url: branchUrl,
                    type: 'POST',
                    data: {company_id: company_id, _token: '{{ csrf_token() }}'},
                    dataType: 'json',
                    timeout: 30000,
                    success: function(resp) {
                        loading.hide();

                        if (resp.status === 'success' && resp.branches && resp.branches.length > 0) {
                            $.each(resp.branches, function(index, branch) {
                                branchSelect.append('<option value="' + branch.idtbl_company_branch + '">' + branch.branch + ' (' + branch.code + ')</option>');
                            });
                            branchSelect.prop('disabled', false);
                        } else if (resp.status === 'success') {
                            branchSelect.append('<option value="">No branches available</option>').prop('disabled', true);
                            errorText.text('No branches available for selected company.');
                        } else {
                            branchSelect.append('<option value="">Error loading branches</option>').prop('disabled', true);
                            errorText.text(resp.message || 'Could not load branches.');
                        }
                    },
                    error: function(xhr, status, error) {
                        loading.hide();
                        var msg = 'Failed to load branches. ' + (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : (xhr.statusText || 'Server error'));
                        console.log('AJAX Error: ', msg);
                        branchSelect.append('<option value="">Error loading branches</option>').prop('disabled', true);
                        errorText.text(msg);
                    }
                });
            }
        });

        $('#loginForm').on('submit', function(e) {
            if(!$('#company').val() || !$('#branch').val() || !$('#username').val() || !$('#password').val()) {
                alert('All fields are required');
                e.preventDefault();
                return false;
            }
        });

        if($('#company').val()) {
            $('#company').trigger('change');
        }
    });
    </script>
</body>
</html>