<?php
session_start();
require_once 'db.php';
if(isset($_SESSION['user'])){
    if (isset($_POST['action'])) {
        $id = $_SESSION['user']->id;
        $p_id = $_POST['action'];
        $che = $db->prepare("SELECT id FROM bookmark WHERE user_id = :id AND poste_id = :p_id");
        $che->bindParam('id',$id);
        $che->bindParam('p_id',$p_id);
        $che->execute();
        $n_id = $che->fetchObject();
        if ($che->rowCount()>0) {
            $del = $db->prepare("DELETE FROM bookmark WHERE id = :id");
            $del->bindParam('id',$n_id->id);
            $del->execute();
        }else {
            $add = $db->prepare("INSERT INTO bookmark(user_id,poste_id)
            VALUES(:id,:poste_id)");
            $add->bindParam('id',$id);
            $add->bindParam('poste_id',$p_id);
            $add->execute();
        }
    }
    if (isset($_POST['exit'])) {
        session_unset();
        session_destroy();
        header("location:http://localhost/maison/login fr.php");
    }
    if (isset($_POST['edit'])) {
        header("location:http://localhost/maison/account fr.php");
    }
}else{
    header("location:login fr.php",true);
}
?>
<!DOCTYPE html>
<html lang="fr">
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
            justify-content: center;
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
            box-shadow: -5px 5px 20px rgb(0,0,0,0.1);
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
    <title>Les archives</title>
</head>
<body>
    <header class="hed">
        <div class="menu">
            <div id="m-over"></div>
            <div id="c-menu">
                <span class="m-close">&times;</span>
                <div id="p-menu">Menu</div>
                <a href="maison fr.php">accueil</a>
                <a href="louer fr.php">Ma maison</a>
                <a href="bkm fr.php">Mes archives</a>
                <span id="pr-menu">Langue</span>
                <a href="bkm ar.php">العربية</a>
                <a href="bkm.php">English</a>
                <a href="bkm fr.php">Frencais</a>   
            </div>
            <a><img src="img/menu-burger.png" alt="" class="s-menu"></a>
            <a href="maison fr.php" class="n"><img src="img/home.png" alt=""></a>
            <a href="bkm fr.php" class="n"><img src="img/bookmark.png" alt="" class="bok"></a>
        </div>
        <div class="ri">
            <?php
                echo '<form action="" method="POST">
                <div id="h-over"></div>
                <h2 id="login">'.$_SESSION['user']->f_name.'</h2>
                    <div id="log">
                        <button type="submit" name="edit" id="btn">Modifier votre compte</button>
                        <button type="submit" name="exit" id="btn">Déconnexion</button>
                    </form>             
                ';                
            ?>        
        </div>
    </header>
    <section class="sec">
        <div class="Alerts"></div>
        <div class="model">
            <span class="close" >&times;</span>
            <!-- <img src="img/back.png" alt="" class="back"> -->
            <img src="" alt="" class="z_content" id="myimage">
            <!-- <img src="img/next.png" alt="" class="next"> -->
        </div>
        <div class="sec-con">
        <?php
         if(isset($_SESSION['user'])){
            $id = $_SESSION['user']->id;
            $bk = $db->prepare("SELECT poste_id FROM bookmark WHERE user_id = :id");
            $bk->bindParam('id',$id);
            $bk->execute();
            
            foreach ($bk as $np_id) {
                $nbk = $np_id['poste_id'];
                $show = $db->prepare("SELECT * FROM louer WHERE id = :id");
                $show->bindParam('id',$nbk);
                $show->execute();
                
                foreach ($show as $result) {
                    $imshow = $db->prepare("SELECT * FROM image WHERE louer_id = :id");
                    $imshow->bindParam('id',$np_id['poste_id']);
                    $imshow->execute();
    
                    echo'<div class="content"><form action="" method="POST">
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
                            $che->bindParam('p_id',$nbk);
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
                    console.log(data);
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
                    console.log(data);
                }
            });
            $(this).toggleClass("heart-active");
        });
    });
    $(document).ready(function(){
        $(document).on('click','.bk',function(){
            var action = $(this).data('id');
            $btn = $(this);
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
            $btn = $(this);
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
</script>
</html>