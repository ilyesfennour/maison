<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            background-color: #CCCCCC;
            font-family: DroidArabicKufiRegular,Muli,sans-serif;
            text-align: center;
        }
        .con{
            top: 50%;
            left: 50%;
            position: absolute;
            transform: translate(-50%,-50%);
            float: left;
            background-color: #e4ffff;
            padding: 10px;
            border-radius: 5px;
            width: 80%;
            text-align: center;
        }
        .in{
            width: 95%;
            border: none;
            margin: 5px 0px;
            color: rgba(0,0,0,.87)!important;
            padding: 5px 0px;
            height: 35px;
            background: none;
            font-size: 20px;
            border-bottom: 0.5px solid gainsboro;
            overflow: hidden;
            outline: none;            
        }
        .btn{
            width: 80%;
            height: 35px;
            margin-top: 15px;
            font-size: 20px;
            background: none;
            border: 2px solid #6C7336;
            border-radius: 5px;
        }
        .btn:hover{
            background-color: #ECF2BB;
        }
        h2{
            color: rgba(0,0,0,.87)!important;
            border-bottom: 0.5px solid gainsboro;
            width: auto;
        }
        label{
            height: 60px;
            width: 200px;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
            justify-content: center;
            align-items: center;
            display: flex;
            color: rgba(0,0,0,.87)!important;
            margin: auto;
            background-color: chartreuse;
        }
        input[type="file"]{
            display: none;
        }
    </style>
    <title>Modifier le compte</title>
</head>
<body>
<?php
session_start();
require_once 'db.php';
if(isset($_SESSION['user'])){
    if (isset($_POST['anul'])) {
        header("location:louer fr.php",true);
    }
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $show = $db->prepare("SELECT * FROM louer WHERE id = :id");
        $show->bindParam('id',$id);
        $show->execute();
        foreach ($show as $result) {
            echo'
            <div class="con">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" id="file" name="img[]" class="img" accept="image/*,video/*" multiple><br>
                    <label for="file"><img src="img/image.png" alt="" width="30px">Choisissez une photo</label>
                    <input type="text" value="'.$result['disc'].'" placeholder="La description" name="des" class="in"><br>
                    <select name="wilaya" id="wilaya" class="in">
                        <option value="none">wilaya</option>
                        <option value="Adrar">1 Adrar</option>
                        <option value="Chlef">2 Chlef</option>
                        <option value="Laghouat">3 Laghouat</option>
                        <option value="Oum El Bouaghi">4 Oum El Bouaghi</option>
                        <option value="Batna">5 Batna</option>
                        <option value="Béjaïa">6 Béjaïa</option>
                        <option value="Biskra">7 Biskra</option>
                        <option value="Béchar">8 Béchar</option>
                        <option value="Blida">9 Blida</option>
                        <option value="Bouira">10 Bouira</option>
                        <option value="Tamanrasset">11 Tamanrasset</option>
                        <option value="Tébessa">12 Tébessa</option>
                        <option value="Tlemcen">13 Tlemcen</option>
                        <option value="Tiaret">14 Tiaret</option>
                        <option value="Tizi Ouzou">15 Tizi Ouzou</option>
                        <option value="Alger">16 Alger</option>
                        <option value="Djelfa">17 Djelfa</option>
                        <option value="Jijel">18 Jijel</option>
                        <option value="Sétif">19 Sétif</option>
                        <option value="Saïda">20 Saïda</option>
                        <option value="Skikda">21 Skikda</option>
                        <option value="Sidi Bel Abbès">22 Sidi Bel Abbès</option>
                        <option value="Annaba">23 Annaba</option>
                        <option value="Guelma">24 Guelma</option>
                        <option value="Constantine">25 Constantine</option>
                        <option value="Médéa">26 Médéa</option>
                        <option value="Mostaganem">27 Mostaganem</option>
                        <option value="M'."'".'Sila">28 M'."'".'Sila</option>
                        <option value="Mascara">29 Mascara</option>
                        <option value="d'."'".'Ouargla">30 d'."'".'Ouargla</option>
                        <option value="Oran">31 Oran</option>
                        <option value="El Bayadh">32 El Bayadh</option>
                        <option value="Illizi">33 Illizi</option>
                        <option value="Bordj Bou Arreridj">34 Bordj Bou Arreridj</option>
                        <option value="Boumerdès">35 Boumerdès</option>
                        <option value="El Tarf">36 El Tarf</option>
                        <option value="Tindouf">37 Tindouf</option>
                        <option value="Tissemsilt">38 Tissemsilt</option>
                        <option value="El Oued">39 El Oued</option>
                        <option value="Khenchela">40 Khenchela</option>
                        <option value="Souk Ahras">41 Souk Ahras</option>
                        <option value="Tipaza">42 Tipaza</option>
                        <option value="Mila">43 Mila</option>
                        <option value="Aïn Defla">44 Aïn Defla</option>
                        <option value="Naâma">45 Naâma</option>
                        <option value="Aïn Témouchent">46 Aïn Témouchent</option>
                        <option value="Ghardaïa">47 Ghardaïa</option>
                        <option value="Relizane">48 Relizane</option>
                        <option value="Timimoun">49 Timimoun</option>
                        <option value="Bordj Badji Mokhtar">50 Bordj Badji Mokhtar</option>
                        <option value="Ouled Djellal">51 Ouled Djellal</option>
                        <option value="Béni Abbès">52 Béni Abbès</option>
                        <option value="In Salah">53 In Salah</option>
                        <option value="In Guezzam">54 In Guezzam</option>
                        <option value="Touggourt">55 Touggourt</option>
                        <option value="Djanet">56 Djanet</option>
                        <option value="El M'."'".'Ghair">57 El M'."'".'Ghair</option>
                        <option value="El Meniaa">58 El Meniaa</option>
                    </select><br>
                    <input type="text" value="'.$result['adress'].'" placeholder="Adresse" name="adress" class="in" required><br>
                    <input type="text" value="'.$result['fonne'].'" placeholder="Numéro de téléphone" name="f_num" class="in" required><br>
                    <input type="text" value="'.$result['facebook'].'" placeholder="Facebook" name="facb" class="in"><br>
                    <input type="number" ';if ($result['prix'] != '0') {echo' value="'.$result['prix'].'" ';}
                    if ($result['prix'] == '0') {echo' value="" ';} echo'placeholder="prix" name="prix" class="in"><br>
                    <button name="cadd" class="btn">Modifier</button>
                </form>
                <form action="" method="post">
                    <button name="anul" class="btn">Annuler</button>
                </form>
            </div>
            ';
        }
        if (isset($_POST['cadd'])) {
            $imgs = $_FILES['img'];
            $des = $_POST['des'];
            $wilaya = $_POST['wilaya'];
            $adress = $_POST['adress'];
            $f_num = $_POST['f_num'];
            $facb = $_POST['facb'];
            $prix = $_POST['prix'];

            if ($_FILES['img']['type'][0] == '') {
                echo'Doit choisir une photo';
            }else{
                if ($wilaya == 'none') {
                    echo'Doit choisir une Wilaya';
                }else{
                    $add = $db->prepare("UPDATE louer SET disc = :des,wilaya = :wil,adress = :adress,fonne = :fonne,facebook = :fac
                    ,prix = :prix WHERE id = :id");
                    $add->bindParam('id',$id);
                    $add->bindParam('des',$des);
                    $add->bindParam('wil',$wilaya);
                    $add->bindParam('adress',$adress);
                    $add->bindParam('fonne',$f_num);
                    $add->bindParam('fac',$facb);
                    $add->bindParam('prix',$prix);
                    if ($add->execute()) {
                        echo 'Modification réussie';
                    }
                    $imshow = $db->prepare("SELECT * FROM image WHERE louer_id = :id");
                    $imshow->bindParam('id',$id);
                    $imshow->execute();
                    if ($imshow->rowCount()>0) {
                        $del = $db->prepare("DELETE FROM image WHERE louer_id = :id");
                        $del->bindParam('id',$id);
                        $del->execute();
                    }
                    for ($i=0; $i < count($_FILES['img']['name']); $i++) {
                        $type = $_FILES['img']['type'][$i];
                        $img = file_get_contents($_FILES['img']['tmp_name'][$i]);
                        $imgadd = $db->prepare("INSERT INTO image(louer_id,image,type)
                        VALUES(:id,:image,:type)");
                        $imgadd->bindParam('id',$id);
                        $imgadd->bindParam('image',$img);
                        $imgadd->bindParam('type',$type);
                        $imgadd->execute();
                    }
                }
            }
        }
    }
}else{
    header("location:login fr.php",true);
}
?>
</body>
</html>