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
        $mail->Body    = '<h1>شكرا لكم لاستخدام موقعنا</h1><p>هذه هي كلمة مرورك: '.$pass->password.'<a href="http://localhost/maison/login ar.php?">تسجيل الدخول</a></p>';
        $mail->send();
        echo'لقد أرسلنا رسالة إلى بريدك الإلكتروني '.$email;
    }else{
        echo'هذا البريد الإلكتروني غير صحيح!';
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
    <title>إعادة تعيين كلمة المرور</title>
</head>
<body dir="rtl">
    <div>
        <form action="" method="POST">
            <h1>إعادة تعيين كلمة المرور</h1>
            <input type="text" placeholder="البريد الإلكتروني" name="email" class="name" required><br>
            <button type="submit" name="btn" id="btn">إعادة تعيين</button>
            <p><a href="login ar.php">تسجيل الدخول</a></p>
        </form>
    </div>
</body>
</html>