<?php
session_start();
require_once 'config/db.php'; 

if (isset($_POST['add_exp'])) {
    if (isset($_SESSION['user_login'])) {
        $user_id = $_SESSION['user_login'];

        $stmt = $conn->prepare("SELECT * FROM farm WHERE id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $id = $user_id;
            $farm_name = $row['farm_name'];
            $atv_date = $_POST['atv_date'];
            $money = $_POST['money'];
            $detail = $_POST['detail'];
            $add_type = $_POST['add_type'];

            $insertStmt = $conn->prepare("INSERT INTO activity (id,farm_name, atv_date, money, detail, add_type) VALUES (:id, :farm_name, :atv_date, :money, :detail, :add_type)");
            $insertStmt->execute(['id' => $id,'farm_name' => $farm_name, 'atv_date' => $atv_date, 'money' => $money, 'detail' => $detail, 'add_type' => $add_type]);


            header('Location: activity.html');
            exit();
        } else {
            echo "User does not have a farm record.";
        }
    } else {
        echo "User is not logged in.";
    }
}
?>
