<?php
session_start();
require_once 'config/db.php'; 

if (isset($_POST['add_prod'])) {
    $st_per = $_POST['st_per'];
    $en_per  = $_POST['en_per'];
    
    if (isset($_SESSION['user_login'])) {
        $user_id = $_SESSION['user_login'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
   
        $stmt2 = $conn->prepare("INSERT INTO per (id, st_per, en_per) 
                                    VALUES (:id, :st_per, :en_per)");
        $stmt2->bindParam(":id", $user_id);
        $stmt2->bindParam(":st_per", $st_per);
        $stmt2->bindParam(":en_per", $en_per);
        $stmt2->execute();

        header("Location: setting1.html");
        exit();
    }
}
?>
