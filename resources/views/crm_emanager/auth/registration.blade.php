
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container min-vh-100 d-flex justify-content-center align-items-center py-4">

    <div class="card border shadow rounded-4" style="width: 100%; max-width: 450px;">

        <div class="card-body p-4">

            <h3 class="text-center fw-bold mb-2">Create Account</h3>
            <p class="text-center text-muted mb-4">Register your new account</p>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter your name">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                </div>

                <button type="submit" class="btn btn-success w-100 py-2">
                    Register
                </button>
            </form>

            <hr>

            <p class="text-center mb-0">
                Already have an account?
                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Login</a>
            </p>

        </div>
    </div>
</div>

</body>
</html>
