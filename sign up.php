<?php
if(isset($_POST['btn'])){
    require_once 'db.php';
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $conf = $_POST['cpass'];
    $code = md5(date("h:i:s").$fname);

    if ($pass == $conf) {
        $chec = $db->prepare("SELECT * FROM signup WHERE email = :email");
        $chec->bindParam('email',$email);
        $chec->execute();
       
        if ($chec->rowCount()>0) {    
            echo'This email is used';
        }else{
            $add = $db->prepare("INSERT INTO signup(f_name,l_name,email,password,code)
            VALUES(:f_name,:l_name,:email,:password,:code)");
            $add->bindParam('f_name',$fname);
            $add->bindParam('l_name',$lname);
            $add->bindParam('email',$email);
            $add->bindParam('password',$pass);
            $add->bindParam('code',$code);
    
            if ($add->execute()) {
                require_once 'mailer.php';
                $mail->setFrom('ilyeeees220@gmail.com', 'maison');
                $mail->addAddress($email);
                $mail->Subject = 'verification code';
                $mail->Body    = '<h1>Thank you for registering on our site</h1><p>To verify your account <a href="http://localhost/maison/active.php?code='.$code.'">Press here</a></p>';
                $mail->send();

                $login = $db->prepare("SELECT * FROM signup WHERE email = :email AND password = :password");
                $login->bindParam('email',$email);
                $login->bindParam('password',$pass);
                $login->execute();
                $user = $login->fetchObject();

                session_unset();
                session_destroy();
                session_start();
                $_SESSION['user'] = $user;
                header("location:active.php",true);
            }else{
                echo'an error occurred!!';
            }
        }
    } else {
        echo'Your password and confirm password must be the same!!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sign up.css">
    <title>sign up</title>
</head>
<body>
    <div>
        <form action="" method="POST">
            <h1>Sign Up</h1>
            <input type="text" placeholder="First Name" class="name" name="fname" require><br>
            <input type="text" placeholder="Last Name" class="name" name="lname" require><br>
            <input type="email" placeholder="Adress email" class="name" name="email" require><br>
            <input type="password" placeholder="Password" class="name" name="pass" require><br>
            <input type="password" placeholder="Confirm Password" class="name" name="cpass" require><br>
            <button type="submit" id="btn" name="btn">Submit</button>
            <p>Do you have an account?<a href="login.php">Sign In</a></p>
        </form>
    </div>
</body>
</html>