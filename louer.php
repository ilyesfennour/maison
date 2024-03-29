<?php
    session_start();
    require_once 'db.php';
    if (isset($_POST['action'])) {
        $id = $_POST['action'];
        $del_i = $db->prepare("DELETE FROM image WHERE louer_id = :id");
        $del_i->bindParam('id',$id);
        $del_i->execute();
        $del_b= $db->prepare("DELETE FROM bookmark WHERE poste_id = :id");
        $del_b->bindParam('id',$id);
        $del_b->execute();
        $del_l = $db->prepare("DELETE FROM post_status WHERE poste_id = :id");
        $del_l->bindParam('id',$id);
        $del_l->execute();
        $del = $db->prepare("DELETE FROM louer WHERE id = :id");
        $del->bindParam('id',$id);
        $del->execute();
    }
    if(isset($_SESSION['user'])){
        if (isset($_POST['add'])) {
            header("location:add louer.php",true);
        }
        if (isset($_POST['exit'])) {
            session_unset();
            session_destroy();
            header("location:http://localhost/maison/login.php");
        }
        if (isset($_POST['edit'])) {
            header("location:http://localhost/maison/account.php");
        }
    }else{
        header("location:login.php",true);
    }
?>
<!DOCTYPE html>
<html lang="en">
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
            left: 0px;
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
            left: 0px;
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
            margin-top: 18px;
            font-size: 30px;
            color: rgba(0,0,0,.6)!important;
            cursor: pointer;
            font-weight: bold;
            margin-left: 237px;
            position: absolute;
            padding: 0px 8.5px;
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
            float: left;
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
            float: left;
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
            margin-left: 30%;
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
            float: right;
        }
        #login{
            height: 30px;
            padding: 15px;
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
            right: 0px;
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
            margin-left: 10%;
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
            float: left;
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
            float: left;
            display: none;
            cursor: pointer;
            background-color: whitesmoke;
        }
        .del{
            width: 25px;
            position: absolute;
            opacity: 50%;
            float: right;
            margin-left: 275px;
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
            float: left;
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
            float: right;
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
        }
        .heart-n{
            cursor: pointer;
            background: url("img/img.png") no-repeat;
            background-position: right;
            background-size: 2900%;
            height: 20px;
            width: 75px;
            position: absolute;
            animation: animate .8s steps(28) 1;
        }
        .heart-n.heart-n-active{
            background-position: left;
        }
        .heart{
            cursor: pointer;
            background: url("img/img.png") no-repeat;
            background-position: left;
            background-size: 2900%;
            height: 20px;
            width: 75px;
            position: absolute;
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
            float: right;
            padding-top: 4px;
            margin-right: 1px;
            cursor: pointer;
            background: url("img/bookmark.png") no-repeat;
            background-size: contain;
        }
        .bk.active{
            width: 20px;
            height: 15px;
            float: right;
            padding-top: 4px;
            margin-right: 1px;
            cursor: pointer;
            background: url("img/bkm.png") no-repeat;
            background-size: cover;
        }
        .n-bk{
            width: 20px;
            height: 15px;
            float: right;
            padding-top: 4px;
            margin-right: 1px;
            cursor: pointer;
            background: url("img/bkm.png") no-repeat;
            background-size: cover;
        }
        .n-bk.active{
            width: 20px;
            height: 15px;
            float: right;
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
    <title>Rent homes</title>
</head>
<body>
    <header class="hed">
        <div class="menu">
            <div id="m-over"></div>
            <div id="c-menu">
                <span class="m-close">&times;</span>
                <div id="p-menu">Menu</div>
                <a href="index.php">Home</a>
                <a href="louer.php">My home</a>
                <a href="bkm.php">My archives</a>
                <span id="pr-menu">Language</span>
                <a href="louer ar.php">العربية</a>
                <a href="louer.php">English</a>
                <a href="louer fr.php">Frencais</a>   
                <span id="pr-menu">Properties</span>
                <form action="" method="post"><select name="wilaya" id="wilaya">
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
                    <option value="M'Sila">28 M'Sila</option>
                    <option value="Mascara">29 Mascara</option>
                    <option value="d'Ouargla">30 d'Ouargla</option>
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
                    <option value="El M'Ghair">57 El M'Ghair</option>
                    <option value="El Meniaa">58 El Meniaa</option>
                </select>
                <button type="submit" name="sr" class="sr">Search</button></form>
            </div>
            <a><img src="img/menu-burger.png" alt="" class="s-menu"></a>
            <a href="index.php" class="n"><img src="img/home.png" alt=""></a>
            <a href="bkm.php" class="n"><img src="img/bookmark.png" alt="" class="bok"></a>
        </div>
        <div class="ri">
            
            <?php
                if(isset($_SESSION['user'])){
                    echo '<form action="" method="POST">
                    <div id="h-over"></div>
                    <h2 id="login">'.$_SESSION['user']->f_name.'</h2>
                        <div id="log">
                            <button type="submit" name="edit" id="btn">Edit your account</button>
                            <button type="submit" name="exit" id="btn">Sign out</button>
                        </form>             
                    ';                
                }
            ?>        
        </div>
    </header>
    <section class="sec">
        <div class="add"><a href="add louer.php">Add home</a></div>
        <div class="Alerts"></div>
        <div class="model">
            <span class="close" >&times;</span>
            <!-- <img src="img/back.png" alt="" class="back"> -->
            <img src="" alt="" class="z_content" id="myimage">
            <!-- <img src="img/next.png" alt="" class="next"> -->
        </div>
        <div class="sec-con">
            <div id="al">
                <p>Are you sure you want to delete?</p>
                <a class="cbtn">Cancel</a>
                <div class="dl"><button class="lg" type="submit" name="d">Delete</button></div>
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
                <div class="ed"><a href="edit.php?id='.$result['id'].'"><img src="img/editing.png" alt="" class="edi"></a></div>
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