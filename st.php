<?php
session_start();
require_once 'config/db.php'; 

if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $farm_no = $row["farm"];

        if ($farm_no == 0) {

            header("Location: setting.html");
            exit();
        }
        else if ($farm_no == 1) {
            header("Location: setting1.html");
            exit();
        }
    }
}
?>
