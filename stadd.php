<?php
session_start();
require_once 'config/db.php'; 

if (isset($_POST['stadd'])) {
    $farm_name = $_POST['farm_name'];
    $area = $_POST['area'];
    $garden = $_POST['garden'];
    $avg_dl = $_POST['avg_dl'];
    
    if (isset($_SESSION['user_login'])) {
        $user_id = $_SESSION['user_login'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $farm = $row['farm'];

        if ($farm == 0) {
            $updateStmt = $conn->prepare("UPDATE users SET farm = 1 WHERE id = :user_id");
            $updateStmt->execute(['user_id' => $user_id]);

            $stmt2 = $conn->prepare("INSERT INTO farm (id, farm_name, area, garden, avg_dl) 
                                    VALUES (:id, :farm_name, :area, :garden, :avg_dl)");
            $stmt2->bindParam(":id", $user_id);
            $stmt2->bindParam(":farm_name", $farm_name);
            $stmt2->bindParam(":area", $area);
            $stmt2->bindParam(":garden", $garden);
            $stmt2->bindParam(":avg_dl", $avg_dl);
            $stmt2->execute();

            header("Location: setting1.html");
            exit();
        } 
        else {
            header("Location: setting1_add.html");
            exit();
        }
    }
}
?>
