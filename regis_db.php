<?php
    session_start();
    require_once 'config/db.php';

    if(isset($_POST['regis'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $urole = 'user';
    }
    try {
        $check_email = $conn->prepare("SELECT email, username FROM users WHERE email = :email OR username = :username");
        $check_email->bindParam(":email", $email);
        $check_email->bindParam(":username", $username);
        $check_email->execute();
        $row = $check_email->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            if ($row['email'] == $email) {
                $_SESSION['error'] = "มีอีเมลนี้อยู่ในระบบแล้ว";
            }
            if ($row['username'] == $username) {
                $_SESSION['error'] = "มีชื่อผู้ใช้นี้อยู่ในระบบแล้ว";
            }
            header("location: index.html");
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, urole) VALUES (:username, :password, :email, :urole)");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $passwordHash);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":urole", $urole);
            $stmt->execute();
            $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว";
            header("location: index.html");
        }
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
   
?>
