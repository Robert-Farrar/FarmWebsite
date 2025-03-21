<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="text-center mb-4">Login</h2>

    <form method="POST" action="index.php?action=login" class="mb-4 p-4 border rounded shadow">
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="text" name="passwrd" id="passwrd" class="form-control" required>
    </div>
    <button type="submit" name="verify" class="btn btn-primary w-100">Submit</button>
    </form>
    <div class="row">
        <div class="col-md-2">
            <small class="form-text text-muted">Do not have an account?</small>
        </div>
        <div class="col-md-2">
            <ul class="nav">
                <li class="nav-item">
                    <small class="form-text text-muted">
                        <a class="nav-link active" href="createAccount.php">Click here</a>
                    </small>
                </li>
            </ul>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>