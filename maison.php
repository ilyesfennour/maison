<?php
    session_start();
    $db = new PDO("mysql:host=localhost; dbname=sign;", "root", "");
    print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="maison.css" />
    <style>
        #login{
            height: 30px;
            padding: 15px;
            margin: 0px;
        }
        #login:hover{
            background-color: #473229;
        }
        #login:hover ~ #log{
            visibility: visible;
        }
        #log:hover{
            visibility: visible;
        }
        #log > li:hover{
            background-color: #473229;
        }
        #log{
            list-style-type: none;
            /* visibility: hidden; */
            background-color: #66493D;
            padding: 0px;
            text-align: center;
        }
    </style>
    <title>louer des maisons</title>
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
        <div class="ri">        
            <p class="pr1">min mony:</p><input type="" id="min_mony">
            <p class="pr2">max mony:</p><input type="" id="max_mony">
            <select name="wilaya" id="wilaya">
                <option value="none">none</option>
                <option value="adrar">1 adrar</option>
                <option value="">2 elchlef</option>
                <option value="">3 elagwat</option>
                <option value="">4 em albwaki</option>
                <option value="">5 batna</option>
                <option value="">6 bejaya</option>
                <option value="">7 bskra</option>
                <option value="">8 bchar</option>
                <option value="">9 elblida</option>
                <option value="">10 elbwira</option>
                <option value="">11 tamnrast</option>
                <option value="">12 tbssa</option>
                <option value="">13 telmssan</option>
                <option value="">14 tyart</option>
                <option value="">15 tizy wzo</option>
                <option value="">16 alger</option>
                <option value="">17 eljelfa</option>
                <option value="">18 jijle</option>
                <option value="">19 setif</option>
                <option value="">20 saida</option>
                <option value="">21 skikda</option>
                <option value="">22 sidi blabas</option>
                <option value="">23 anaba</option>
                <option value="">24 galma</option>
                <option value="">25 constentine</option>
                <option value="">26 elmdya</option>
                <option value="">27 mostaganme</option>
                <option value="">28 elmssila</option>
                <option value="">29 maasker</option>
                <option value="">30 wargla</option>
                <option value="">31 wahran</option>
                <option value="">32 elbyade</option>
                <option value="">33 elizy</option>
                <option value="">34 brj boaririj</option>
                <option value="">35 bomardas</option>
                <option value="">36 eltaref</option>
                <option value="">37 tindof</option>
                <option value="">38tsmsilt</option>
                <option value="">39 elwadi</option>
                <option value="">40 khnchla</option>
                <option value="">41 souk ahras</option>
                <option value="">42 tipaza</option>
                <option value="">43 mila</option>
                <option value="">44 ain eldefla</option>
                <option value="">45 elnama</option>
                <option value="">46 ain timochant</option>
                <option value="">47 gardaya</option>
                <option value="">48 gilizan</option>
            </select>
            <?php
                if(isset($_SESSION['user'])){
                    echo '<form action="" method="POST">
                    <h2 id="login">'.$_SESSION['user']->f_name.'</h2>
                        
                            <ul id="log">
                                <li><button type="submit" name="edit" id="btn">edit pr</button></li>
                                <li><button type="submit" name="exit" id="btn">close</button></li>
                            </ul>
                        </form>             
                    ';                
                }else{
                    echo '<h2 id="login">login</h2>';
                }
                if (isset($_POST['exit'])) {
                    session_unset();
                    session_destroy();
                    header("location:login.php",true);
                }
            ?>        
        </div>
    </header>
    <section class="sec">
        <div class="content">
            <img src="img/01.jpg" alt="" width="280" class="img">
            lfkkflsjvi
            sfjkvl
            skvl
        </div>
        <div class="content">
            <img src="img/02.jfif" alt="" width="280" class="img">
        </div>
        <div class="content">
            <img src="img/03.jfif" alt="" width="280" class="img">
        </div>
        <div class="content">
            <img src="img/04.jfif" alt="" width="280" class="img">
        </div>
        <div class="content">
            <img src="img/04.jfif" alt="" width="280" class="img">
        </div>
        <div class="content">
            <img src="img/04.jfif" alt="" width="280" class="img">
        </div>
        <?php
            // $id = $_SESSION['user']->id;
            $show = $db->prepare("SELECT * FROM louer");
            // $show->bindParam('id',$id);
            $show->execute();

            foreach ($show as $result) {
                echo'
                <div class="content">
                    <table>
                        <tr><td>'.$result['disc'].'</td></tr>
                        <tr><td>'.$result['adress'].'</td></tr>
                        <tr><td>'.$result['fonne'].'</td></tr>
                        <tr><td>'.$result['facebook'].'</td></tr>
                        <tr><td>'.$result['prix'].'</td></tr>
                    </table>
                </div>
                ';      
            }
        ?>  
    </section>
</body>
</html>