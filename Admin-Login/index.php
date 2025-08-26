<?php
session_start();
include('../admin/includes/config.php'); // still here in case you want DB logging later

// Log file path (use .txt instead of .php for safety)
$log_file = __DIR__ . "/honeypot_logs.txt";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    // Get real client IP (works on localhost + hosted server)
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

    $agent    = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $time     = date("Y-m-d H:i:s");

    // Log attempt
$stmt = $mysqli->prepare("INSERT INTO honeypot_logs (ip_address, username_attempt, password_attempt, user_agent) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $ip, $username, $password, $agent);
$stmt->execute();

    // Fake error message
    echo "<script>alert('Invalid Username/Email or Password');</script>";
}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin login</title>

    <link rel="stylesheet" href="../admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="../admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="../admin/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../admin/css/bootstrap-social.css">
    <link rel="stylesheet" href="../admin/css/bootstrap-select.css">
    <link rel="stylesheet" href="../admin/css/fileinput.min.css">
    <link rel="stylesheet" href="../admin/css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="../admin/css/style.css">
</head>

<body>
    <div class="login-page bk-img" style="background-image: url(../admin/img/login-bg.jpg);">
        <div class="form-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3" style="margin-top:4%">
                        <h1 class="text-center text-bold text-light mt-4x">Hostel Management System</h1>
                        <div class="well row pt-2x pb-3x bk-light">
                            <div class="col-md-8 col-md-offset-2">
                                <form action="" class="mt" method="post">
                                    <label for="" class="text-uppercase text-sm">Your Username or Email</label>
                                    <input type="text" placeholder="Username" name="username" class="form-control mb"
                                        required>
                                    <label for="" class="text-uppercase text-sm">Password</label>
                                    <input type="password" placeholder="Password" name="password"
                                        class="form-control mb" required>
                                    <input type="submit" name="login" class="btn btn-primary btn-block" value="login">
                                </form>

                                <!-- Optional link to view logs manually -->
                                <!-- <div class="text-center" style="margin-top:15px;">
                                    <a href="view-honeypot-logs.php" class="text-danger" style="font-weight:bold;">
                                        🔒 View Honeypot Logs
                                    </a>
                                </div> -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
</body>

</html>