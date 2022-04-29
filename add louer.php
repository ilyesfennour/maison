<?php
    session_start();
    $db = new PDO("mysql:host=localhost; dbname=sign;", "root", "");
    print_r($_SESSION);
    if(isset($_SESSION['user'])){
        if (isset($_POST['cadd'])) {
            $id = $_SESSION['user']->id;
            $name = $_SESSION['user']->f_name;
            $img = file_get_contents($_FILES['img']['tmp_name']);
            $type = $_FILES['img']['type'];
            $des = $_POST['des'];
            $adress = $_POST['adress'];
            $f_num = $_POST['f_num'];
            $facb = $_POST['facb'];
            $prix = $_POST['prix'];

            $add = $db->prepare("INSERT INTO louer(user_id,name,disc,adress,fonne,facebook,prix)
            VALUES(:id,:name,:des,:adress,:fonne,:fac,:prix)");
            $add->bindParam('id',$id);
            $add->bindParam('name',$name);
            $add->bindParam('des',$des);
            $add->bindParam('adress',$adress);
            $add->bindParam('fonne',$f_num);
            $add->bindParam('fac',$facb);
            $add->bindParam('prix',$prix);
            if ($add->execute()) {
                echo 'tm';
            }
            $l_id = $db->prepare("SELECT id FROM louer WHERE user_id = :id");
            $l_id->bindParam('id',$id);
            $l_id->execute();
            $new_id = $l_id->fetchObject();
            
            $imgadd = $db->prepare("INSERT INTO image(louer_id,image,type)
            VALUES(:id,:image,:type)");
            $imgadd->bindParam('id',$new_id->id);
            $imgadd->bindParam('image',$img);
            $imgadd->bindParam('type',$type);
            $imgadd->execute();
        }
        if (isset($_POST['anul'])) {
            header("location:louer.php",true);
        }
    }else{
        header("location:login.php",true);
        echo 'si hvhfir';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" placeholder="iùm" name="img" id="" accept="image/*,video/*" multiple><br>
        <input type="text" placeholder="des" name="des" id=""><br>
        <input type="text" placeholder="adr" name="adress" id=""><br>
        <input type="text" placeholder="nu f" name="f_num" id=""><br>
        <input type="text" placeholder="fa" name="facb" id=""><br>
        <input type="number" placeholder="pri" name="prix" id=""><br>
        <button name="cadd">add</button>
        <button name="anul">anuler</button>
    </form>
</body>
</html>