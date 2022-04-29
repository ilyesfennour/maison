<?php
    session_start();
    $db = new PDO("mysql:host=localhost; dbname=sign;", "root", "");
    print_r($_SESSION);
    if(isset($_SESSION['user'])){
        if (isset($_POST['add'])) {
            header("location:add louer.php",true);
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
    <link rel="stylesheet" href="louer.css">
    <style>
        header{
            background-color: #66493D;
            margin: 0px;
            padding: 0px;
            height: 60px;
            width: 100%;
            display: block ruby;
            position: absolute;
            position: -webkit-sticky;
            z-index: 2;
        }
        #menu{
            padding: 0px;
            margin: 0px;
            list-style-type: none;
            height: 60px;
            position: relative;
            width: 500px;
        }
        .btn{
            margin: 3px;
            margin-top: 70;
            width: 800px;
            height: 25px;
            position: relative;
            left: 50%;
            transform: translate(-50%);
        }
        .content{
            /* height: 150px; */
            width: 300px;
            background-color: white;
            margin: 10px;
            float: left;
            font: 1em sans-serif;

        }
        /* .content > table{
            border: 2px solid #6C7336;
        } */
    </style>
    <title>louer</title>
</head>
<body>
    <header>
        <img class="logo" src="connected-home.jpg" alt="">
        <ul id="menu">
            <li ><a href="maison.php">home</a></li>
            <li ><a href="">favorit</a></li>
            <li><a href="louer.php">louer</a></li>
            <li ><a class="lang" href="">language</a>
                <ul id="lga" class="lang">
                    <li><a href="">arab</a></li>
                    <li><a href="">englais</a></li>
                    <li><a href="">frencais</a></li>
                </ul>            
            </li>
            <li ><a href="">help</a></li>
        </ul>    
    </header>
    <section>
        <form action="" method="post">
            <button class="btn" name="add">add</button>
        </form>
        <?php
            $id = $_SESSION['user']->id;
            $show = $db->prepare("SELECT * FROM louer WHERE user_id = :id");
            $show->bindParam('id',$id);
            $show->execute();

            foreach ($show as $result) {
                $imgshow = 'data:'.$result['type'].';base64,'.base64_encode($result['image']);
                echo'
                <div class="content">
                    <table>
                        '// <tr><td><img src='.$imgshow.' alt="" width="150" class="img"></td></tr>
                        .'<tr><td>deskr:</td><td>'.$result['disc'].'</td></tr>
                        <tr><td>adress:</td><td>'.$result['adress'].'</td></tr>
                        <tr><td>phone number:</td><td>'.$result['fonne'].'</td></tr>
                        <tr><td>'.$result['facebook'].'</td></tr>
                        <tr><td>prix:</td><td>'.$result['prix'].'</td></tr>
                    </table>
                </div>
                ';      
            }
        ?>  
    </section>
</body>
</html>