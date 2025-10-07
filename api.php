<?php
include "db.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        echo json_encode(['status'=>'success','data'=>$result]);
    } else {
        $result = $conn->query("SELECT * FROM users ORDER BY id DESC");
        $rows = [];
        while($r = $result->fetch_assoc()) $rows[] = $r;
        echo json_encode(['status'=>'success','data'=>$rows]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if($action === 'delete' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        echo json_encode(['status'=>'success','message'=>"User with ID $id deleted"]);
        exit;
    }

    if($action === 'edit' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $birthday = $_POST['birthday'];

        $stmt = $conn->prepare("UPDATE users SET fullname=?, email=?, username=?, birthday=? WHERE id=?");
        $stmt->bind_param("ssssi",$fullname,$email,$username,$birthday,$id);
        $stmt->execute();
        echo json_encode(['status'=>'success','message'=>"User with ID $id updated"]);
        exit;
    }
}
?>
