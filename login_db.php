<?php
session_start();
require_once 'config/db.php'; 

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct
            $_SESSION['user_login'] = $user['id']; 
            $user_id = $_SESSION['user_login'];
            $stmt2 = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
            $stmt2->execute(['user_id' => $user_id]);
            $row = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $farm_no = $row["farm"];
                $urole = $row["urole"];
                if ($farm_no == 0 && $urole =='user') {
                    header("Location: st.php");
                    exit();
                }
                else if ($farm_no == 1 AND $urole =='user') {
                    header("Location: home.html");
                    exit();
                }
                else if ($urole =='admin') {
                    header("Location: admin.html");
                    exit();
                }
            }
            } 
            else {
            $_SESSION['error'] = "หรัสไม่ถูกต้อง";
            header("location: index.html"); 
        }
    } 
    else {
        $_SESSION['error'] = "ไม่พบชื่อผู้ใช้ในระบบ";
        header("location: index.html"); 
    }
}
?>
