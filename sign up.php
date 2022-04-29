<?php
if(isset($_POST['btn'])){
    $db = new PDO("mysql:host=localhost; dbname=sign;", "root", "");
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $code = md5(date("h:i:s").$fname);

    $chec = $db->prepare("SELECT * FROM signup WHERE email = :email");
    $chec->bindParam('email',$email);
    $chec->execute();
   
    if ($chec->rowCount()>0) {    
        echo'هذا الإمايل مستخدم';
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
            $mail->Body    = '<h1>شكرا لتسجيلك في موقعنا</h1><p>للتحقق من حسابك <a href="http://localhost/maison/active.php?code='.$code.'">إضغط هنا</a></p>';
            $mail->send();
            header("location:active.php",true);
        }else{
            echo'حدث خطأ!!';
        }
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
            <input type="checkbox" name="" id="">
            <span>I agree to the therm of services</span><br>
            <button type="submit" id="btn" name="btn">submit</button>
            <p>Do you have an account?<a href="login.php">Sign In</a></p>
        </form>
    </div>
</body>
</html>