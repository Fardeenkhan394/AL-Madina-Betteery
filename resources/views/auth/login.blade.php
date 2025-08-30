<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | ALmadina Bettery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Animation -->
    <style>
        body {
            background: linear-gradient(135deg, #ece9e6, #ffffff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            animation: fadeIn 1s ease-in-out;
            transition: transform 0.3s;
        }
        .login-card:hover {
            transform: scale(1.02);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card login-card shadow-lg border-0 p-4">
                <div class="card-body">
                    <h3 class="card-title text-center mb-3">🔋 ALmadina Bettery</h3>
                    <p class="text-center text-muted mb-4">Login to your account</p>
                 <form method="POST" action="{{ route('login') }}">
                    @csrf
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>

                        <!-- Forgot Password -->
                        <div class="mt-3 text-center">
                            <a href="/forgot-password" class="text-decoration-none">Forgot your password?</a>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-muted text-center small">
                    © 2025 ALmadina Bettery. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
