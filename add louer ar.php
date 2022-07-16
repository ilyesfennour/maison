<?php
    session_start();
    require_once 'db.php';
    // print_r($_SESSION);
    if(isset($_SESSION['user'])){
        if (isset($_POST['cadd'])) {
            $id = $_SESSION['user']->id;
            $name = $_SESSION['user']->f_name;
            $imgs = $_FILES['img'];
            $des = $_POST['des'];
            $wilaya = $_POST['wilaya'];
            $adress = $_POST['adress'];
            $f_num = $_POST['f_num'];
            $facb = $_POST['facb'];
            $prix = $_POST['prix'];
            $l_code = md5(date("h:i:s").$adress);

            if ($_FILES['img']['type'][0] == '') {
                echo'يجب اختيار صورة';
            }else{
                if ($wilaya == 'none') {
                    echo'يجب اختيار ولاية';
                }else{
                    $add = $db->prepare("INSERT INTO louer(user_id,name,disc,wilaya,adress,fonne,facebook,prix,l_code)
                    VALUES(:id,:name,:des,:wil,:adress,:fonne,:fac,:prix,:l_code)");
                    $add->bindParam('id',$id);
                    $add->bindParam('name',$name);
                    $add->bindParam('des',$des);
                    $add->bindParam('wil',$wilaya);
                    $add->bindParam('adress',$adress);
                    $add->bindParam('fonne',$f_num);
                    $add->bindParam('fac',$facb);
                    $add->bindParam('prix',$prix);
                    $add->bindParam('l_code',$l_code);
                    if ($add->execute()) {
                        echo 'تمت الإضافة بنجاح';
                    }
                    $l_id = $db->prepare("SELECT id FROM louer WHERE user_id = :id AND l_code = :l_code");
                    $l_id->bindParam('id',$id);
                    $l_id->bindParam('l_code',$l_code);
                    $l_id->execute();
                    $new_id = $l_id->fetchObject();
                    $_SESSION['louer'] = $new_id;
                    
                    for ($i=0; $i < count($_FILES['img']['name']); $i++) {
                        $type = $_FILES['img']['type'][$i];
                        $img = file_get_contents($_FILES['img']['tmp_name'][$i]);
                        $imgadd = $db->prepare("INSERT INTO image(louer_id,image,type)
                        VALUES(:id,:image,:type)");
                        $imgadd->bindParam('id',$new_id->id);
                        $imgadd->bindParam('image',$img);
                        $imgadd->bindParam('type',$type);
                        $imgadd->execute();
                    }
                }
            }
        }
        if (isset($_POST['anul'])) {
            header("location:louer ar.php",true);
        }
    }else{
        header("location:login ar.php",true);
    }
?>
<!DOCTYPE html>
<html lang="ar">
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
        .fr{
            margin: 0px;
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
            padding-bottom: 10px;
            margin: 2px;
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
            margin-top: 5px;
        }
        input[type="file"]{
            display: none;
        }
        @media screen and (max-height:500px) {
            .in{
                font-size: 13px;
                height: auto;
            }
            .btn{
                font-size: 13px;
                height: auto; 
                margin-top: 5px;
            }
            label{
                height: 30px;
                width: 130px;
                font-size: 13px;
            }
            label > img{
                width: 20px;
            }
            h2{
                margin: 0px;
            }
        }
        @media screen and (max-height:600px) {
            .btn{
                margin-top: 5px;
            }
            label{
                height: 45px;
            }
            .in{
                padding: 0px;
            }
            h2{
                margin: 0px;
            }
        }
    </style>
    <title>إضافة منزل</title>
</head>
<body dir="rtl">
    <div class="con">
        <h2>إضافة منزل</h2>
        <form action="" method="post" enctype="multipart/form-data" class="fr">
            <input type="file" id="file" name="img[]" class="img" accept="image/*,video/*" multiple>
            <label for="file"><img src="img/image.png" alt="" width="30px">اختيار صورة</label>
            <input type="text" placeholder="الوصف" name="des" class="in"><br>
            <select name="wilaya" id="wilaya" class="in">
                <option value="none">الولاية</option>
                <option value="Adrar">1 أدرار</option>
                <option value="Chlef">2 الشلف</option>
                <option value="Laghouat">3 الأغواط</option>
                <option value="Oum El Bouaghi">4 أم البوقي</option>
                <option value="Batna">5 باتنة</option>
                <option value="Béjaïa">6 بجاية</option>
                <option value="Biskra">7 بسكرة</option>
                <option value="Béchar">8 بشار</option>
                <option value="Blida">9 البليدة</option>
                <option value="Bouira">10 البويرة</option>
                <option value="Tamanrasset">11 تمنراست</option>
                <option value="Tébessa">12 تبسة</option>
                <option value="Tlemcen">13 تلمسان</option>
                <option value="Tiaret">14 تيارت</option>
                <option value="Tizi Ouzou">15 تيزي وزو</option>
                <option value="Alger">16 الجزائر</option>
                <option value="Djelfa">17 الجلفة</option>
                <option value="Jijel">18 جيجل</option>
                <option value="Sétif">19 سطيف</option>
                <option value="Saïda">20 سعيدة</option>
                <option value="Skikda">21 سكيكدة</option>
                <option value="Sidi Bel Abbès">22 سيدي بلعباس</option>
                <option value="Annaba">23 عنابة</option>
                <option value="Guelma">24 قالمة</option>
                <option value="Constantine">25 قسنطينة</option>
                <option value="Médéa">26 المدية</option>
                <option value="Mostaganem">27 مستغانم</option>
                <option value="M'Sila">28 المسيلة</option>
                <option value="Mascara">29 معسكر</option>
                <option value="d'Ouargla">30 ورقلة</option>
                <option value="Oran">31 وهران</option>
                <option value="El Bayadh">32 البيض</option>
                <option value="Illizi">33 إليزي</option>
                <option value="Bordj Bou Arreridj">34 برج بو عريريج</option>
                <option value="Boumerdès">35 بومرداس</option>
                <option value="El Tarf">36 الطارف</option>
                <option value="Tindouf">37 تندوف</option>
                <option value="Tissemsilt">38 تيسمسيلت</option>
                <option value="El Oued">39 الوادي</option>
                <option value="Khenchela">40 خنشلة</option>
                <option value="Souk Ahras">41 سوق أهراس</option>
                <option value="Tipaza">42 تيبازة</option>
                <option value="Mila">43 ميلة</option>
                <option value="Aïn Defla">44 عين الدفلى</option>
                <option value="Naâma">45 النعامة</option>
                <option value="Aïn Témouchent">46 عين تموشنت</option>
                <option value="Ghardaïa">47 غرداية</option>
                <option value="Relizane">48 غليزان</option>
                <option value="Timimoun">49 تيميمون</option>
                <option value="Bordj Badji Mokhtar">50 برج باجي مختار</option>
                <option value="Ouled Djellal">51 أولاد جلال</option>
                <option value="Béni Abbès">52 بني عباس</option>
                <option value="In Salah">53 عين صالح</option>
                <option value="In Guezzam">54 عين قزام</option>
                <option value="Touggourt">55 تقرت</option>
                <option value="Djanet">56 جانت</option>
                <option value="El M'Ghair">57 المغير</option>
                <option value="El Meniaa">58 المنيعة</option>
            </select><br>
            <input type="text" placeholder="العنوان" name="adress" class="in" required><br>
            <input type="text" placeholder="رقم الهاتف" name="f_num" class="in" required><br>
            <input type="text" placeholder="فيسبوك" name="facb" class="in"><br>
            <input type="number" placeholder="السعر" name="prix" class="in"><br>
            <button name="cadd" class="btn">إضافة</button>
        </form>
        <form action="" method="post">
            <button name="anul" class="btn">إلغاء</button>
        </form>
    </div>
</body>
</html>