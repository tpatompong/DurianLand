<?php
session_start();
require_once 'config/db.php'; 

if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
    $d_name = $_POST['d_name'];
    $grade = $_POST['grade'];
    $mar1 = $_POST['mar1'];
    $mar2 = $_POST['mar2'];

    $updateStmt = $conn->prepare("UPDATE market SET mar1 = :mar1, mar2 = :mar2 WHERE d_name = :d_name AND grade = :grade");
    $updateStmt->bindParam(':mar1', $mar1, PDO::PARAM_INT);
    $updateStmt->bindParam(':mar2', $mar2, PDO::PARAM_INT);
    $updateStmt->bindParam(':d_name', $d_name, PDO::PARAM_STR);
    $updateStmt->bindParam(':grade', $grade, PDO::PARAM_STR);

    try {
        $updateStmt->execute();
        header("Location: admin.html");
    } catch (PDOException $e) {
        echo '<script>alert("เกิดข้อผิดพลาด");</script>';
    }
} else {
    header("Location: index.html");
}
?>
