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
        $mail->Subject = 'réinitialiser le mot de passe';
        $mail->Body    = "<h1>Merci d'utiliser notre site</h1><p>Ceci est votre mot de passe:".$pass->password."<a href='http://localhost/maison/login fr.php?'>S'identifier</a></p>";
        $mail->send();
        echo'Nous avons envoyé un message à votre adresse e-mail '.$email;
    }else{
        echo'Cet e-mail est incorrect !';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <style>
        div{
            top: 50%;
            left: 50%;
            position: absolute;
            transform: translate(-50%,-50%);
            width: 440px;
        }
        @media screen and (max-width:310px){
            div{
                width: 230px;
            }
        }
        @media screen and (max-width:450px){
            div{
                width: 300px;
            }
        }
    </style>
    <title>Réinitialiser le mot de passe</title>
</head>
<body>
    <div>
        <form action="" method="POST">
            <h1>Réinitialiser le mot de passe</h1>
            <input type="text" placeholder="E-mail" name="email" class="name" required><br>
            <button type="submit" name="btn" id="btn">Réinitialiser</button>
            <p><a href="login fr.php">S'identifier</a></p>
        </form>
    </div>
</body>
</html>