<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="text-center mt-5">
    <h2 class="text-center mb-4">Create Account</h2>

    <form method="POST" action="index.php?action=add" class="mb-4 p-4 border rounded shadow">
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="text" name="passwrd" id= "passwrd" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="fullName" id="fullName" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" name=email id="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" name="customerAddress" id="customerAddress" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" required>
    </div>
    <button type="submit" name="create" class="btn btn-primary w-100">Submit</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>