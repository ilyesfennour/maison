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
            header("location:maison fr.php",true);
        }else{
            session_unset();
            session_destroy();
            session_start();
            $_SESSION['user'] = $user;
            header("location:active fr.php",true);
        }
    } else {
        echo 'Mot de passe ou e-mail erroné';
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
    <title>connexion</title>
</head>
<body>
    <div>
        <form action="" method="POST">
            <h1>Connexion</h1>
            <input type="text" placeholder="E-mail" name="email" class="name" required><br>
            <input type="password" placeholder="Mot de passe" name="pass" class="name" required><br>
            <button type="submit" name="btn" id="btn">s'identifier</button>
            <p>Vous n'avez pas de compte ?<a href="sign up fr.php">S'inscrire</a> <br> <a href="Forget Password fr.php">Mot de passe oublié?</a></p>
        </form>
    </div>
</body>
</html>