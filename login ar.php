<?php
if(isset($_POST['btn'])){
    require_once 'db.php';
    $login = $db->prepare("SELECT * FROM signup WHERE email = :email AND password = :password");
    $login->bindParam('email',$_POST['email']);
    $login->bindParam('password',$_POST['pass']);
    $login->execute();
    if ($login->rowCount() == 1) {
        $user = $login->fetchObject();
        if ($user->active == 1) {
            session_unset();
            session_destroy();
            session_start();
            $_SESSION['user'] = $user;
            header("location:maison ar.php",true);
        }else{
            session_unset();
            session_destroy();
            session_start();
            $_SESSION['user'] = $user;
            header("location:active ar.php",true);
        }
    } else {
        echo 'كلمة مرور أو بريد إلكتروني خاطئ';
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>تسجيل الدخول</title>
</head>
<body dir="rtl">
    <div>
        <form action="" method="POST">
            <h1>تسجيل الدخول</h1>
            <input type="text" placeholder="البريد الإلكتروني" name="email" class="name" required><br>
            <input type="password" placeholder="كلمة المرور" name="pass" class="name" required><br>
            <button type="submit" name="btn" id="btn">تسجيل الدخول</button>
            <p>ليس لديك حساب؟<a href="sign up ar.php">إنشاء حساب</a> <br> <a href="Forget Password ar.php">نسيت كلمة المرور؟</a></p>
        </form>
    </div>
</body>
</html>