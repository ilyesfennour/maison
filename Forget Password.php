<?php
if(isset($_POST['btn'])){
    require_once 'db.php';
    $email = $_POST['email'];

    $chec = $db->prepare("SELECT password FROM signup WHERE email = :email");
    $chec->bindParam('email',$email);
    $chec->execute();
   
    if ($chec->rowCount()>0) {
        $pass = $chec->fetchObject();
        require_once 'mailer.php';
        $mail->setFrom('ilyeeees220@gmail.com', 'maison');
        $mail->addAddress($email);
        $mail->Subject = 'Reset Password';
        $mail->Body    = '<h1>Thank you for using our site</h1><p>This is your password:'.$pass->password.'<a href="http://localhost/maison/login.php?">Sign in</a></p>';
        $mail->send();
        echo'We have sent a message to your email '.$email;
    }else{
        echo'This email is incorrect!';
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
    <title>Reset Password</title>
</head>
<body>
    <div>
        <form action="" method="POST">
            <h1>Reset Password</h1>
            <input type="text" placeholder="Email" name="email" class="name" required><br>
            <button type="submit" name="btn" id="btn">reset</button>
            <p><a href="login.php">Sign In</a></p>
        </form>
    </div>
</body>
</html>