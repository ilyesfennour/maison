<?php
    session_start();
    require_once 'db.php';
    if(isset($_SESSION['user'])){
        if (isset($_POST['add'])) {
            header("location:add louer ar.php",true);
        }
        if (isset($_POST['exit'])) {
            session_unset();
            session_destroy();
            header("location:http://localhost/maison/login ar.php");
        }
        if (isset($_POST['edit'])) {
            header("location:http://localhost/maison/account ar.php");
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
    <link rel="stylesheet" href="maison.css" />
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <style>
        body{
            background-color: #CCCCCC;
            font-family: DroidArabicKufiRegular,Muli,sans-serif;
            margin: 0px;
            padding: 0px;
        }
        header{
            background-color: #e4ffff;
            margin: 0px;
            padding: 0px;
            height: 60px;
            width: 100%;
            display: block ruby;
            position: fixed;
            z-index: 2;
        }
        #m-over{
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            background-color: rgb(0,0,0,0.5);
            z-index: 9;
            position: fixed;
            display: none;
        }
        .menu{
            margin: 0px;
            padding: 0px;
            height: 60px;
            position: absolute;
            z-index: 10;
            top: 0px;
            float: right;
        }
        .menu a img{
            cursor: pointer;
            width: 20px;
            padding: 20px;
        }
        .menu a img:hover{
            background-color: gainsboro;
        }
        #c-menu{
            top: 0px;
            width: 0px;
            margin: 0px;
            padding: 0px;
            position: fixed;
            background-color: #e4ffff;
            display: block; 
            height: 100%;
            overflow-x: hidden;
            transition: 0.5s;
            z-index: 10;
        }
        .m-close{
            margin-top: 8px;
            font-size: 30px;
            color: rgba(0,0,0,.6)!important;
            cursor: pointer;
            font-weight: bold;
            margin-right: 219px;
            position: absolute;
            padding: 0px 10px;
            padding-bottom: 4px;
        }
        .m-close:hover{
            background-color: gainsboro;
            border-radius: 100px;
        }
        #p-menu{
            width: 0px;
            height: 30px;
            padding: 15px 95px;
            margin: 0px;
            font-size: 30px;
            color: rgba(0,0,0,.87)!important;
            border-bottom: 0.5px solid gainsboro;
            font-family: DroidArabicKufiRegular,Muli,sans-serif;
            transition: 0.3s;
        }
        #pr-menu{
            border-top: 0.5px solid gainsboro;
            float: right;
            padding: 8px 2px;
            margin-top: 3px;
            font-size: 1rem;
            width: 100%;
            color: rgba(0,0,0,.6)!important;
            font-family: DroidArabicKufiRegular,Muli,sans-serif;
            line-height: 1.2;
            font-weight: bold;
            transition: 0.3s;
        }
        #c-menu > a{
            float: right;
            padding: 15px 15px;
            text-decoration: none;
            font-size: 1rem;
            width: 100%;
            color: rgba(0,0,0,.87)!important;
            font-family: DroidArabicKufiRegular,Muli,sans-serif;
            line-height: 1.2;
        }
        #c-menu > a:hover{
            background-color: gainsboro;
        }
        #wilaya{
            background-color: #e4ffff;
            margin: 0px;
            font-size: 1rem;
            height: 40px;
            scrollbar-width: thin;
            color: rgba(0,0,0,.87)!important;
            width: 100%;
            border: none;
        }
        #wilaya:hover{
            background-color: gainsboro;
        }
        .sr{
            width: 40%;
            margin-right: 28%;
            line-height: 1.2;
            color: indigo;
            padding: 5px 0px;
            height: 35px;
            margin-top: 15px;
            font-size: 20px;
            background: none;
            border: none;
            border-radius: 5px;
            align-items: center;
            cursor: pointer;
        }
        .sr:hover{
            background-color: #CCCCCC;
            border-radius: 5px;
        }
        .ri{
            float: left;
        }
        .ri:hover{
            background-color: gainsboro;
        }
        #login{
            height: 30px;
            padding: 15px;
            color: rgba(0,0,0,.87)!important;
            margin: 0px;
            cursor: pointer;
            z-index: 10;
        }
        #login:hover{
            background-color: gainsboro;
        }
        #btn:hover{
            background-color: gainsboro;
        }
        #log{
            border-top: 0.5px solid gainsboro;
            visibility: hidden;
            background-color: #e4ffff;
            padding: 0px;
            text-align: center;
            margin: 0px;
            width: 300px;
            position: absolute;
            float: left;
            left: 0px;
            box-shadow: -5px 5px 20px rgb(0,0,0,0.1);
            z-index: 10;
        }
        #log > button{
            border: none;
            height: 44px;
            width: 100%;
            padding: 0px 20px;
            background-color: #e4ffff;
            font-size: 1.2em;
            text-decoration: none;
            color: rgba(0,0,0,.87)!important;
            text-align: center;
            font: 1em sans-serif;
            cursor: pointer;
        }
        #h-over{
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            z-index: 9;
            position: fixed;
            display: none;
        }
        .sec{
            margin-top: 70px;
            display: inline-block;
        }
        .sec-con{
            height: 100%;
            display: flex;
            flex-flow: wrap;
            margin-top: 50px;
            justify-content: center;
        }
        .add{
            margin-right: 10%;
            width: 80%;
            height: 40px;
            background-color: #e4ffff;
            border-radius: 5px;
            margin-bottom: 5px;
            text-align: center;
            display: block;
            position: absolute;
        }
        .add > a{
            float: right;
            padding: 5.5px 0px;
            text-decoration: none;
            font-size: 1.5rem;
            width: 100%;
            color: rgba(0,0,0,.87)!important;
            font-family: DroidArabicKufiRegular,Muli,sans-serif;
            line-height: 1.2;
            border-radius: 5px;
        }
        .add > a:hover{
            background-color: gainsboro;
        }
        .content{
            width: 300px;
            background-color: #e4ffff;
            margin: 4px;
            padding: 2px;
            float: left;
            font: 1em sans-serif;
            border-radius: 7px;
            display: flex;
            box-shadow: -5px 5px 20px rgb(0,0,0,0.25);
        }
        .content:hover .edi{
            display: block;
        }
        .edi:hover{
            display: block;
        }
        .content:hover .del{
            display: block;
        }
        .del:hover{
            display: block;
        }
        .edi{
            width: 25px;
            position: absolute;
            opacity: 80%;
            float: right;
            display: none;
            cursor: pointer;
            background-color: whitesmoke;
        }
        .del{
            width: 25px;
            position: absolute;
            opacity: 50%;
            float: right;
            margin-right: 275px;
            display: none;
            cursor: pointer;
            background-color: whitesmoke;
        }
        #al{
            display: none;
            position: fixed;
            z-index: 10;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            background-color: #e4ffff;
            font: 1em sans-serif;
            border-radius: 7px; 
            width: 250px;
            padding: 10px;
        }
        .cbtn{
            float: right;
            font-size: large;
            padding: 5px;
            color: rgba(0,0,0,.87)!important;
            cursor: pointer;
        }
        .cbtn:hover{
            background-color: #CCCCCC;
            border-radius: 5px;
        }
        .lg{
            float: left;
            font-size: large;
            text-decoration: none;
            color: red;
            padding: 5px;
            background: none;
            cursor: pointer;
            border: none;
        }
        .lg:hover{
            background-color: #CCCCCC;
            border-radius: 5px;
        }
        #images{
            width: 300px;
            overflow: hidden;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
        }
        .img{
            width: 97px;
            height: 97px;
            padding: 1.5px;
        }
        .model{
            z-index: 3;
            text-align: center;
            display: none;
            height: 100%;
            width: 100%;
            position: fixed;
            top: 60px;
            left: 0px;
            background-color: rgb(0,0,0,0.5);
        }
        .close{
            font-size: 50px;
            color: white;
            cursor: pointer;
            font-weight: bold;
            top: 3%;
            right: 2%;
            position: absolute;
        }
        .next{
            margin-bottom: 149px;
            cursor: pointer;
        }
        .back{
            margin-bottom: 149px;
            cursor: pointer;
        }
        .z_content{
            margin-top: 10%;
            width: 50%;
            height: 50%;
            animation: i_anim 0.5s ease;
        }
        @keyframes i_anim{
            from{
                transform: scale(0);
            }
            to{
                transform: scale(1);
            }
        }
        .text_cont{
            width: 100%;
            font-size: larger;
        }
        .b{
            border-bottom: 0.8px solid gainsboro;
        }
        .num_like{
            position: relative;
            padding-right: 55px;
        }
        .heart-n{
            cursor: pointer;
            background: url("img/img.png") no-repeat;
            background-position: right;
            background-size: 2900%;
            height: 29px;
            width: 75px;
            position: absolute;
            animation: animate .8s steps(28) 1;
            z-index: 1;
        }
        .heart-n.heart-n-active{
            background-position: left;
        }
        .heart{
            cursor: pointer;
            background: url("img/img.png") no-repeat;
            background-position: left;
            background-size: 2900%;
            height: 29px;
            width: 75px;
            position: absolute;
            z-index: 1;
        }
        .heart.heart-active{
            animation: animate .8s steps(28) 1;
            background-position: right;
            }
        @keyframes animate {
            0%{
                background-position: left;
            }
            100%{
                background-position: right;
            }
        }
        .bk{
            width: 20px;
            height: 15px;
            float: left;
            padding-top: 4px;
            margin-top: 4px;
            margin-right: 1px;
            cursor: pointer;
            background: url("img/bookmark.png") no-repeat;
            background-size: contain;
        }
        .bk.active{
            width: 20px;
            height: 15px;
            float: left;
            padding-top: 4px;
            margin-right: 1px;
            margin-top: 2px;
            cursor: pointer;
            background: url("img/bkm.png") no-repeat;
            background-size: cover;
        }
        .n-bk{
            width: 20px;
            height: 15px;
            float: left;
            padding-top: 4px;
            margin-top: 4px;
            margin-right: 1px;
            cursor: pointer;
            background: url("img/bkm.png") no-repeat;
            background-size: cover;
        }
        .n-bk.active{
            width: 20px;
            height: 15px;
            float: left;
            margin-top: 4px;
            padding-top: 4px;
            margin-right: 1px;
            cursor: pointer;
            background: url("img/bookmark.png") no-repeat;
            background-size: contain;
        }
        @media screen and (max-width:310px) {
            .content{
                width: 200px;
            }
            #images{
                width: 200px;
            }
        }
        @media screen and (max-width:650px){
            .n{
                display: none;
            }
            .m-close{
                margin-left: 210px;
            }
        }
    </style>
    <title>كراء المنازل</title>
</head>
<body dir="rtl">
    <header class="hed">
        <div class="menu">
            <div id="m-over"></div>
            <div id="c-menu">
                <span class="m-close">&times;</span>
                <div id="p-menu">القائمة</div>
                <a href="maison ar.php">صفحة البداية</a>
                <a href="louer ar.php">منازلي</a>
                <a href="bkm ar.php">محفوظاتي</a>
                <span id="pr-menu">اللغة</span>
                <a href="louer ar.php">العربية</a>
                <a href="louer.php">English</a>
                <a href="louer fr.php">Frencais</a>   
                <span id="pr-menu">خصائص</span>
                <form action="" method="post"><select name="wilaya" id="wilaya">
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
                </select>
                <button type="submit" name="sr" class="sr">ابحث</button></form>
            </div>
            <a><img src="img/menu-burger.png" alt="" class="s-menu"></a>
            <a href="maison ar.php" class="n"><img src="img/home.png" alt=""></a>
            <a href="bkm ar.php" class="n"><img src="img/bookmark.png" alt="" class="bok"></a>
        </div>
        <div class="ri">
            <?php
                echo '<form action="" method="POST">
                <div id="h-over"></div>
                <h2 id="login">'.$_SESSION['user']->f_name.'</h2>
                    <div id="log">
                        <button type="submit" name="edit" id="btn">تعديل حسابك</button>
                        <button type="submit" name="exit" id="btn">تسجيل الخروج</button>
                    </form>             
                ';                
            ?>        
        </div>
    </header>
    <section class="sec">
        <div class="add"><a href="add louer ar.php">أضف منزل</a></div>
        <div class="Alerts"></div>
        <div class="model">
            <span class="close" >&times;</span>
            <!-- <img src="img/back.png" alt="" class="back"> -->
            <img src="" alt="" class="z_content" id="myimage">
            <!-- <img src="img/next.png" alt="" class="next"> -->
        </div>
        <div class="sec-con">
            <div id="al">
                <p>هل أنت متأكد أنك تريد الحذف؟</p>
                <a class="cbtn">إلغاء</a>
                <div class="dl"><button class="lg" type="submit" name="d">حذف</button></div>
            </div>
        <?php
         if(isset($_SESSION['user'])){
            $id = $_SESSION['user']->id;
            if (isset($_POST['sr'])) {
                $wilaya = $_POST['wilaya'];
                if ($wilaya != 'none') {
                    $show = $db->prepare("SELECT * FROM louer WHERE user_id = :id AND wilaya = :wilaya");
                    $show->bindParam('id',$id);
                    $show->bindParam('wilaya',$wilaya);
                    $show->execute();
                }else{
                    $show = $db->prepare("SELECT * FROM louer WHERE user_id = :id");
                    $show->bindParam('id',$id);
                    $show->execute();    
                }
            } else {
                $show = $db->prepare("SELECT * FROM louer WHERE user_id = :id");
                $show->bindParam('id',$id);
                $show->execute();
            }

            foreach ($show as $result) {
                $imshow = $db->prepare("SELECT * FROM image WHERE louer_id = :id");
                $imshow->bindParam('id',$result['id']);
                $imshow->execute();

                echo'<div class="content"><form action="" method="POST">
                <div class="ed"><a href="edit ar.php?id='.$result['id'].'"><img src="img/editing.png" alt="" class="edi"></a></div>
                <img src="img/delete.png" alt="" class="del" data-id="'.$result['id'].'">
                <div id="images">'; 

                foreach ($imshow as $results) {
                    $imgshow = 'data:'.$results['type'].';base64,'.base64_encode($results['image']);       
                    echo'<img src="'.$imgshow.'" alt="" width="150" class="img" data-src="'.$imgshow.'" data-id="'.$result['id'].'" id="h'.$result['id'].'">';
                    }

                echo'
                </div>
                    <table class="text_cont">';
                        if ($result['disc'] != '') {
                            echo'<tr><td class="b">'.$result['disc'].'</td></tr>';
                        }
                        echo'<tr><td>'.$result['adress'].'</td></tr>
                        <tr><td class="b">'.$result['wilaya'].'</td></tr>';
                        if ($result['facebook'] != '') {
                            echo'<tr><td><img src="img/facebook.png" alt="facebook" width="20px"> '.$result['facebook'].'</td></tr>';
                        }
                        echo'<tr><td class="b"><img src="img/phone-call.png" alt="phone" width="20px"> '.$result['fonne'].'</td></tr>';
                        if ($result['prix'] != '0') {
                            echo'<tr><td class="b"><div class="price">'.$result['prix'].' DA</div></td></tr>';
                        }
                        $chec = $db->prepare("SELECT * FROM post_status WHERE user_id = :id AND poste_id = :p_id");
                        $chec->bindParam('id',$id);
                        $chec->bindParam('p_id',$result['id']);
                        $chec->execute();
                        if ($chec->rowCount()>0) {
                            $sel = $db->prepare("SELECT stat FROM post_status WHERE user_id = :id AND poste_id = :p_id");
                            $sel->bindParam('id',$id);
                            $sel->bindParam('p_id',$result['id']);
                            $sel->execute();
                            $stat = $sel->fetchObject();
                            if ($stat->stat == 0) {
                                echo'<tr><td><div class="heart" data-id="'.$result['id'].'"></div><span class="num_like">'.$result['n_like'].'</span>';
                            } else {
                                echo'<tr><td><div class="heart-n" data-id="'.$result['id'].'"></div><span class="num_like">'.$result['n_like'].'</span>';
                            }
                        }else {
                            echo'<tr><td><div class="heart" data-id="'.$result['id'].'"></div><span class="num_like">'.$result['n_like'].'</span>';
                        }
                        $che = $db->prepare("SELECT id FROM bookmark WHERE user_id = :id AND poste_id = :p_id");
                        $che->bindParam('id',$id);
                        $che->bindParam('p_id',$result['id']);
                        $che->execute();
                        if ($che->rowCount()>0) {
                            echo'<div class="n-bk" id="'.$result['id'].'" data-id="'.$result['id'].'"></div></td></tr>';
                        }else {
                            echo'<div class="bk" id="'.$result['id'].'" data-id="'.$result['id'].'"></div></td></tr>';
                        }
                        
                    echo'</table>
                ';

                echo'</form></div>';
            }
            if (isset($_POST['action'])) {
                $id = $_POST['action'];
                $del_l = $db->prepare("DELETE FROM post_status WHERE poste_id = :id");
                $del_l->bindParam('id',$id);
                $del_l->execute();
                $del = $db->prepare("DELETE FROM louer WHERE id = :id");
                $del->bindParam('id',$id);
                $del->execute();
            }
        }
        ?>
        </div> 
    </section>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click','#login',function(){
            var vis = document.getElementById('log').style.visibility;
            if (vis == "visible") {
                document.getElementById('log').style.visibility="hidden";
                document.getElementById('login').style.backgroundColor="#e4ffff";
                document.getElementById('h-over').style.display="none";
            }else{
                document.getElementById('log').style.visibility="visible";
                document.getElementById('login').style.backgroundColor="gainsboro";
                document.getElementById('h-over').style.display="block";
            }
        });
    });
    $(document).ready(function(){
        $(document).on('click','#h-over',function(){
            document.getElementById('log').style.visibility="hidden";
            document.getElementById('login').style.backgroundColor="#e4ffff";
            document.getElementById('h-over').style.display="none";
        });
    });
    $(document).ready(function(){
        $(document).on('click','.menu',function(){
            document.getElementById('log').style.visibility="hidden";
            document.getElementById('login').style.backgroundColor="#e4ffff";
            document.getElementById('h-over').style.display="none";
        });
    });
    $(document).ready(function(){
        $(document).on('click','.s-menu',function(){
            document.getElementById('c-menu').style.width="280px";
            document.getElementById('p-menu').style.width="280px";
            document.getElementById('m-over').style.display="block";
        });
    });
    $(document).ready(function(){
        $(document).on('click','.m-close',function(){
            document.getElementById('c-menu').style.width="0px";
            document.getElementById('p-menu').style.width="0px";
            document.getElementById('pr-menu').style.width="0px";
            document.getElementById('m-over').style.display="none";
        });
    });
    $(document).ready(function(){
        $(document).on('click','#m-over',function(){
            document.getElementById('c-menu').style.width="0px";
            document.getElementById('p-menu').style.width="0px";
            document.getElementById('pr-menu').style.width="0px";
            document.getElementById('m-over').style.display="none";
            document.getElementById('al').style.display="none";
        });
    });
    $(document).ready(function(){
        $(document).on('click','.del',function(){
            document.getElementById('m-over').style.display="block";
            document.getElementById('al').style.display="block";
        });
    });
    $(document).ready(function(){
        $(document).on('click','.cbtn',function(){
            document.getElementById('m-over').style.display="none";
            document.getElementById('al').style.display="none";
        });
    });
    $(document).ready(function(){
        $(document).on('click','.lg',function(){
            document.getElementById('m-over').style.display="none";
            document.getElementById('al').style.display="none";
        });
    });
    $(document).ready(function(){
        $(document).on('click','.del',function(){
            var action = $(this).data('id');
            $(document).on('click','.lg',function(){
                $.ajax({
                    url:"louer.php",
                    type:"post",
                    data:{action:action},
                    success:function(data){
                    }
                });
                location.reload();
            });
        });
    });
    $(document).ready(function(){
        $(document).on('click','.heart-n',function(){
            var action = $(this).data('id');
            $btn = $(this);
            $.ajax({
                url:"like conter.php",
                type:"post",
                data:{action:action},
                success:function(data){
                    $btn.siblings('span.num_like').text(data);
                }
            });
            $(this).toggleClass("heart-n-active");
        });
    });
    $(document).ready(function(){
        $(document).on('click','.heart',function(){
            var action = $(this).data('id');
            $btn = $(this);
            $.ajax({
                url:"like conter.php",
                type:"post",
                data:{action:action},
                success:function(data){
                    $btn.siblings('span.num_like').text(data);
                }
            });
            $(this).toggleClass("heart-active");
        });
    });
    const preview = ()=>{
    const images = document.querySelectorAll('#images img');
    const mymodel = document.querySelector('.model');
    const myimg = document.querySelector('#myimage');
    const close = document.querySelector('.close');
    const next = document.querySelector('.next');
    const back = document.querySelector('.back');
    console.log(images);
    images.forEach((img,index)=>{               
        img.addEventListener('click',()=>{
            mymodel.style.display='block';
            myimg.src = img.src;
        })
        close.addEventListener('click',()=>{
            mymodel.style.display='none';
        })
    })
    }
    preview();
    $(document).ready(function(){
        $(document).on('click','.bk',function(){
            var action = $(this).data('id');
            $.ajax({
                url:"bkm.php",
                type:"post",
                data:{action:action},
                success:function(data){
                }
            });
            $(this).toggleClass("active");
        });
    });
    $(document).ready(function(){
        $(document).on('click','.n-bk',function(){
            var action = $(this).data('id');
            $.ajax({
                url:"bkm.php",
                type:"post",
                data:{action:action},
                success:function(data){
                }
            });
            $(this).toggleClass("active");
        });
    });
</script>
</html>