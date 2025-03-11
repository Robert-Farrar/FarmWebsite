<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = array(
        "username" => $_POST["username"],
        "password" => $_POST["password"]
    );

    $api_url = "http://customer-api:8001/login.php"; 

    $options = array(
        "http" => array(
            "header"  => "Content-Type: application/json",
            "method"  => "POST",
            "content" => json_encode($data)
        )
    );

    $context = stream_context_create($options);
    $response = file_get_contents($api_url, false, $context);
    $result = json_decode($response, true);

    if ($result["success"]) {
        $_SESSION["user_id"] = $result["user_id"];
        $_SESSION["username"] = $_POST["username"];
        header("Location: index.php"); 
        exit();
    } else {
        echo "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow p-4">
                    <h2 class="text-center mb-4">Login</h2>

                    <form method="POST" action="index.php?action=login">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="passwrd" id="passwrd" class="form-control" required>
                        </div>
                        <button type="submit" name="verify" class="btn btn-primary w-100">Submit</button>
                    </form>

                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <small class="form-text text-muted me-2">Do not have an account?</small>
                        <a class="nav-link text-primary" href="createAccount.php">Click here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
