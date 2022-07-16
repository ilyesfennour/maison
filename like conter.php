<?php
if ($_POST['action']){
    session_start();
    require_once 'db.php';
    $id = $_SESSION['user']->id;
    $p_id = $_POST['action'];
    $chec = $db->prepare("SELECT * FROM post_status WHERE user_id = :id AND poste_id = :p_id");
    $chec->bindParam('id',$id);
    $chec->bindParam('p_id',$p_id);
    $chec->execute();
    if ($chec->rowCount()>0) {
        $sel = $db->prepare("SELECT stat FROM post_status WHERE user_id = :id AND poste_id = :p_id");
        $sel->bindParam('id',$id);
        $sel->bindParam('p_id',$p_id);
        $sel->execute();
        $stat = $sel->fetchObject();
        if ($stat->stat == 0) {
            $s_like = $db->prepare("UPDATE post_status SET stat = 1 WHERE user_id = :id AND poste_id = :p_id");
            $s_like->bindParam('id',$id);
            $s_like->bindParam('p_id',$p_id);
            $s_like->execute();
    
            $c = $db->prepare("SELECT n_like FROM louer WHERE id = :p_id");
            $c->bindParam('p_id',$p_id);
            $c->execute();
            $contuer = $c->fetchObject();
            $contuer->n_like = $contuer->n_like + 1;
            
            $new_c = $db->prepare("UPDATE louer SET n_like = :n_l WHERE id = :p_id");
            $new_c->bindParam('p_id',$p_id);
            $new_c->bindParam('n_l',$contuer->n_like);
            $new_c->execute();

            print_r($contuer->n_like);
        } else {
            $s_like = $db->prepare("UPDATE post_status SET stat = 0 WHERE user_id = :id AND poste_id = :p_id");
            $s_like->bindParam('id',$id);
            $s_like->bindParam('p_id',$p_id);
            $s_like->execute();
    
            $c = $db->prepare("SELECT n_like FROM louer WHERE id = :p_id");
            $c->bindParam('p_id',$p_id);
            $c->execute();
            $contuer = $c->fetchObject();
            $contuer->n_like = $contuer->n_like - 1;
            
            $new_c = $db->prepare("UPDATE louer SET n_like = :n_l WHERE id = :p_id");
            $new_c->bindParam('p_id',$p_id);
            $new_c->bindParam('n_l',$contuer->n_like);
            $new_c->execute();
            
            print_r($contuer->n_like);
        }
    } else {
        $add = $db->prepare("INSERT INTO post_status(user_id,poste_id)
        VALUES(:id,:poste_id)");
        $add->bindParam('id',$id);
        $add->bindParam('poste_id',$p_id);
        $add->execute();
    
        $s_like = $db->prepare("UPDATE post_status SET stat = 1 WHERE user_id = :id AND poste_id = :p_id");
        $s_like->bindParam('id',$id);
        $s_like->bindParam('p_id',$p_id);
        $s_like->execute();
    
        $c = $db->prepare("SELECT n_like FROM louer WHERE id = :p_id");
        $c->bindParam('p_id',$p_id);
        $c->execute();
        $contuer = $c->fetchObject();
        $contuer->n_like = $contuer->n_like + 1;
        
        $new_c = $db->prepare("UPDATE louer SET n_like = :n_l WHERE id = :p_id");
        $new_c->bindParam('p_id',$p_id);
        $new_c->bindParam('n_l',$contuer->n_like);
        $new_c->execute();
        
        print_r($contuer->n_like);
    }
}
?>