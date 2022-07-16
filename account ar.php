<?php
session_start();
require_once 'db.php';
if(isset($_SESSION['user'])){
    if (isset($_POST['exit'])) {
        session_unset();
        session_destroy();
        header("location:http://localhost/maison/login ar.php");
    }
    if(isset($_POST['btn'])){
        $db = new PDO("mysql:host=localhost; dbname=sign;", "root", "");
        $id = $_SESSION['user']->id;
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $pass = $_POST['pass'];
        $conf = $_POST['cpass'];
        if ($pass == $conf) {
            $ap = $db->prepare("UPDATE signup SET f_name = :f_name,l_name = :l_name,password = :pass WHERE id = :id");
            $ap->bindParam('id',$id);
            $ap->bindParam('f_name',$fname);
            $ap->bindParam('l_name',$lname);
            $ap->bindParam('pass',$pass);
            if ($ap->execute()) {
                echo'<div class="eror">تم التعديل بنجاح</div>';
            }

            $login = $db->prepare("SELECT * FROM signup WHERE id = :id");
            $login->bindParam('id',$id);
            $login->execute();
            $user = $login->fetchObject();

            session_unset();
            session_destroy();
            session_start();
            $_SESSION['user'] = $user;
        }else{
            echo'<div class="eror">يجب أن تكون كلمة المرور الخاصة بك وتأكيد كلمة المرور متطابقتين !!</div>';
        }
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
        #Login{
            font-weight: bold;
            font-size: 1rem;
            text-decoration: none;
            height: 30px;
            padding: 15px;
            color: rgba(0,0,0,.87)!important;
            margin: 0px;
            cursor: pointer;
            z-index: 10;
            display: block;
        }
        #Login:hover{
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
        .eror{
            top: 20%;
            left: 50%;
            position: absolute;
            transform: translate(-50%,-50%);
            background-color: #e4ffff;
            padding: 10px;
            border-radius: 5px;
            font-size: 20px;
        }
        .con{
            top: 55%;
            left: 50%;
            position: absolute;
            transform: translate(-50%,-50%);
            float: right;
            background-color: #e4ffff;
            padding: 10px;
            border-radius: 5px;
        }
        .name{
            border: none;
            margin: 5px 0px;
            padding: 5px 0px;
            height: 30px;
            background: none;
            font-size: 20px;
            border-bottom: 0.5px solid gainsboro;
            overflow: hidden;
            outline: none;
            margin-right: 400px;
            
        }
        #btn{
            width: 100%;
            height: 35px;
            margin-top: 5px;
            font-size: 20px;
            background: none;
            border: 2px solid #6C7336;
            border-radius: 5px;
        }
        #btn:hover{
            background-color: #ECF2BB;
        }
        a{
            color: #6C7336;
        }
        .text{
            margin: 5px 0px;
            padding: 5px 0px;
            height: 30px;
            font-size: 20px;
            padding-left: 100px;
        }
        @media screen and (max-width:650px){
            .text{
                margin: 5px 0px;
                padding: 5px 0px;
                height: 30px;
                font-size: 20px;
            }
            .name{
                border: none;
                margin: 5px 0px;
                height: 30px;
                background: none;
                font-size: 20px;
                border-bottom: 0.5px solid gainsboro;
                overflow: hidden;
                outline: none;                
            }
            .n{
                display: none;
            }
            .m-close{
                margin-left: 210px;
            }
        }
    </style>
    <title>louer des maisons</title>
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
                <a href="account ar.php">العربية</a>
                <a href="account.php">English</a>
                <a href="account fr.php">Frencais</a>   
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
        <?php
            echo'<div class="con">
                <form action="" method="POST">
                    <span class="text">الإسم:</span><input type="text" placeholder="'.$_SESSION['user']->f_name.'" class="name" name="fname"><br>
                    <span class="text">اللقب:</span><input type="text" placeholder="'.$_SESSION['user']->l_name.'" class="name" name="lname"><br>
                    <span class="text">كلمة المرور:</span><input type="password" placeholder="'.$_SESSION['user']->password.'" class="name" name="pass"><br>
                    <span class="text">تأكيد كلمة المرور:</span><input type="password" placeholder="'.$_SESSION['user']->password.'" class="name" name="cpass"><br>
                    <button type="submit" id="btn" name="btn">تعديل</button>
                </form>
            </div>';
        ?>
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
   </script>
</html>