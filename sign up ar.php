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
            echo'هذا لبريد مستخدم';
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
                $mail->Body    = '<h1>شكرا لك على التسجيل في موقعنا</h1><p>للتحقق من حسابك <a href="http://localhost/maison/active.php?code='.$code.'">اضغط هنا</a></p>';
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
                header("location:active ar.php",true);
            }else{
                echo'حدث خطأ!!';
            }
        }
    } else {
        echo'يجب أن تكون كلمة المرور الخاصة بك وتأكيد كلمة المرور متطابقتين !!';
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sign up.css">
    <title>فتح حساب</title>
</head>
<body>
    <div>
        <form action="" method="POST" dir="rtl">
            <h1>فتح حساب</h1>
            <input type="text" placeholder="الإسم" class="name" name="fname" require><br>
            <input type="text" placeholder="اللقب" class="name" name="lname" require><br>
            <input type="email" placeholder="عنوان البريد الإلكتروني" class="name" name="email" require><br>
            <input type="password" placeholder="كلمة المرور" class="name" name="pass" require><br>
            <input type="password" placeholder="تأكيد كلمة المرور" class="name" name="cpass" require><br>
            <button type="submit" id="btn" name="btn">تسجيل</button>
            <p>هل لديك حساب؟<a href="login ar.php">تسجيل الدخول</a></p>
        </form>
    </div>
</body>
</html>