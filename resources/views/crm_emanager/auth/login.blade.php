
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container min-vh-100 d-flex justify-content-center align-items-center">

    <div class="card border shadow rounded-4" style="width: 100%; max-width: 420px;">

        <div class="card-body p-4">

            <h3 class="text-center fw-bold mb-2">Welcome Back!</h3>
            <p class="text-center text-muted mb-4">Please login to your account</p>

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password">
                </div>

                <div class="d-flex justify-content-between mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="#" class="text-decoration-none">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    Login
                </button>
            </form>

            <hr>

            <p class="text-center mb-0">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Register</a>
            </p>

        </div>
    </div>
</div>

</body>
</html>
