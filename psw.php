<?php
session_start();
require_once 'config/db.php'; 

if (isset($_POST['psw']) && isset($_SESSION['user_login'])) {
    $psw = $_POST['psw'];
    $pHash = password_hash($psw, PASSWORD_DEFAULT);
    $user_id = $_SESSION['user_login'];
    $updateStmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :user_id");
    $updateStmt->bindParam(':password', $pHash, PDO::PARAM_STR);
    $updateStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    try {
        $updateStmt->execute();
        header("Location: st.php");
    } catch (PDOException $e) {
        echo '<script>alert("เกิดข้อผิดพลาด");</script>';
    }
} else {
    header("Location: index.html");
}
?>
