<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    {{-- <script src="https://www.google.com/recaptcha/enterprise.js?render=6LcNiJEqAAAAAKYFRsu553R9XjTqkX2VoZ6vR4OM"></script> --}}





</head>

<body>
   
            <div class="container d-flex justify-content-center align-items-center vh-100">
                <div class="col-md-4 p-4 border rounded shadow-sm text-center">
                    <!-- Header Section -->
                    <div class="mb-4">
                       
                        <h4 class="fw-bold"><img src="/images/footer-logo-img.png" alt="logo" style="max-width: 100%; height: 60px;"></h4>
                    </div>

                    <!-- Form Section -->
                    <form action="{{ route('login-post') }}" id="myForm" method="post">
                        @csrf
                        <!-- Email Input -->
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label fw-semibold">Email/Username</label>
                            <input type="text" required class="form-control " name="email"
                                id="email" " placeholder="Enter your email">
                            <span class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <!-- Password Input -->
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" required class="form-control @error('password') is-invalid @enderror" name="password"
                                id="password" placeholder="Enter your password">
                            <span class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <!-- Forgot Password Link -->
                      

                        <!-- Display custom error if login fails -->
                        @if ($errors->has('errors'))
                            <div class="alert alert-danger">
                                <ul>
                                    <li>{{ $errors->first('errors') }}</li>
                                </ul>
                            </div>
                        @endif

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary fw-bold px-4"
                                style="background-color: #007bff; border: none;">
                                Login
                            </button>
                          
                        </div>
                    </form>
                </div>
            </div>

</body>

</html>
