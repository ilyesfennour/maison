<?php
    if (isset($_GET['code'])) {
        $db = new PDO("mysql:host=localhost; dbname=sign;", "root", "");
        $chec = $db->prepare("SELECT code FROM signup WHERE code = :code");
        $chec->bindParam('code',$_GET['code']);
        $chec->execute();
        if ($chec->rowCount()>0) {    
            $update = $db->prepare("UPDATE signup SET code = :newcode, active = true WHERE code = :code");
            $code = md5(date("h:i:s"));
            $update->bindParam('code',$_GET['code']);
            $update->bindParam('newcode',$code);
        
            if ($update->execute()) {
                echo'تم التحقق من حسابك بنجاح';
            }
        }else {
            echo'هذا الكود لم يعد صالح';
        }
    }
?>