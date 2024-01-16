<?php
session_start();
require_once 'config/db.php'; 

if (isset($_SESSION['user_login'])) {
    $area = $_POST['area'];
    $garden = $_POST['garden'];
    $avg_dl = $_POST['avg_dl'];
    $user_id = $_SESSION['user_login'];

    $updateStmt = $conn->prepare("UPDATE farm SET area = :area, garden = :garden, avg_dl = :avg_dl WHERE id = :user_id");
    $updateStmt->bindParam(':area', $area, PDO::PARAM_INT);
    $updateStmt->bindParam(':garden', $garden, PDO::PARAM_INT);
    $updateStmt->bindParam(':avg_dl', $avg_dl, PDO::PARAM_STR); 
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
