<?php
if(isset($_POST['btn'])){
    $db = new PDO("mysql:host=localhost; dbname=sign;", "root", "");
    $login = $db->prepare("SELECT * FROM signup WHERE email = :email AND password = :password");
    $login->bindParam('email',$_POST['email']);
    $login->bindParam('password',$_POST['pass']);
    $login->execute();
    if ($login->rowCount() == 1) {
        $user = $login->fetchObject();
        if ($user->active == 1) {
            session_start();
            $_SESSION['user'] = $user;
            header("location:maison.php",true);
        }else{
            echo 'ok';
            header("location:active.php",true);
        }
    } else {
        echo 'not ok';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>login</title>
</head>
<body>
    <div>
        <form action="" method="POST">
            <h1>Login</h1>
            <input type="text" placeholder="Email" name="email" class="name" required><br>
            <input type="password" placeholder="Password" name="pass" class="name" required><br>
            <button type="submit" name="btn" id="btn">sign in</button>
            <p>Don't have an account?<a href="sign up.php">Sign Up</a> <br> <a href="Forget Password.php">Forget Password?</a></p>
        </form>
    </div>
</body>
</html>