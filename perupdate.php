<?php
session_start();
require_once 'config/db.php';

if (isset($_POST['sel_per'])) {
    if (isset($_SESSION['user_login'])) {
        $user_id = $_SESSION['user_login'];
        $list = $_POST['list'];

        $updateStmt = $conn->prepare("UPDATE per SET cur_per = 1 WHERE id = :user_id AND list = :list");
        $updateStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $updateStmt->bindParam(':list', $list, PDO::PARAM_INT);
        $updateStmt->execute(); 

        $updateStmt->closeCursor();

        $updateStmt2 = $conn->prepare("UPDATE per SET cur_per = 0 WHERE id = :user_id AND list != :list");
        $updateStmt2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $updateStmt2->bindParam(':list', $list, PDO::PARAM_INT);

        try {
            $updateStmt2->execute();

            header("Location: setting1.html");
            exit();
        } catch (PDOException $e) {
            echo "Error updating database: " . $e->getMessage();
        }
    }
}
?>
