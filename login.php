<?php

require_once("confiq.php");

if (isset($_POST['login'])) {

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $admin = "SELECT * FROM users WHERE admin";

    $sql = "SELECT * FROM users WHERE username=:username OR email=:email";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":username" => $username,
        ":email" => $username
    );

    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // jika user terdaftar
    if ($user) {
        // verifikasi password
        if (password_verify($password, $user["password"])) {
            if ($user['admin'] == 1) {
                session_start();
                $_SESSION["user"];
                header("Location: admin.php");
            } else {
                // buat Session
                session_start();
                $_SESSION["user"] = $user;
                // login sukses, alihkan ke halaman timeline
                header("Location: timeline.php");
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Login 10</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/login.css">

</head>

<body class="img js-fullheight" style="background-image: url(img/login.jpg);">
    <section class="ftco-section">
        <div class="container-fluid">
            <div class="container " style="background-color: rgba(0, 0, 0, 0.55); margin: auto;">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-5">
                        <h2 class="heading-section">Ayo Bergabung</h2>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        <div class="login-wrap p-0">
                            <p class="mb-4 ">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                            <form action="#" class="signin-form" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="username" placeholder="Username atau email" required>
                                </div>
                                <div class="form-group">
                                    <input id="password-field" type="password" class="form-control" name="password" placeholder="Password" required>
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary submit px-3" name="login" value="Masuk" style="color: teal;">Sign In</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <div class="w-50">

                                    </div>
                                    <div class="w-50 text-md-right">

                                    </div>
                                </div>
                            </form>
                            <p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p>
                            <div class="social d-flex text-center">
                                <a href="#" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span> Facebook</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>