<?php
    require_once("database.php");
    // Proses dari form login
    $message = "";
    if (isset($_POST['login']) && $_POST['login'] == "Login") {
        $username    = $_POST['username']; //simpan input dari username ke var username
        $password    = $_POST['password']; //simpan input dari password ke var password

        $sql = "SELECT * FROM admin WHERE username = :username and password = SHA2(:password, 0)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        $valid_user = $stmt->fetch(PDO::FETCH_ASSOC);
        // jika user terdaftar
        if($valid_user){
                // buat Session
                session_start();
                $_SESSION["admin"] = $username;
                // login sukses, alihkan ke halaman timeline
                header("Location: index");
        }
        // jika ada akun belum terdaftar
        else {
            $message = "Username atau Password Salah";
        }
    }
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="../images/home.png">
    <title>Login Aplikasi Pengaduan Masyarakat</title>
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/admin.css" rel="stylesheet">
</head>

<body id="gradient">
    <div class="container">
        <div class="card container card-login mx-auto mt-5">
            <h3 class="text-center" style="padding-top:8px;">Login Admin</h3>
            <hr class="custom">
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input class="form-control" id="username" type="text" name="username" aria-describedby="userlHelp" placeholder="Enter Username" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input class="form-control" id="password" name="password" type="password" placeholder="Password" required>
                    </div>
                    <input type="submit" class="btn btn-primary btn-block " name="login" value="Login">
                </form>
            </div>
            <p class="text-center text-danger"><small><?php echo @$message; ?></small></p>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
