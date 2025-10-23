<?php
require_once 'youth_controller.php';

if (isset($_GET['id'])) {
    $controller = new YouthController();
    $id = $_GET['id'];
    
    // Check if youth exists
    $youth = $controller->getYouth($id);
    
    if ($youth) {
        try {
            $success = $controller->deleteYouth($id);
            if ($success) {
                header("Location: youth_list.php?message=Youth+profile+deleted+successfully");
                exit;
            }
        } catch(PDOException $e) {
            header("Location: youth_list.php?message=Error+deleting+profile:" . urlencode($e->getMessage()));
            exit;
        }
    } else {
        header("Location: youth_list.php?message=Youth+profile+not+found");
        exit;
    }
} else {
    header("Location: youth_list.php");
    exit;
}
?>