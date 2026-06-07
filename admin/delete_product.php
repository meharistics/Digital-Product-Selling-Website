<?php
session_start();
// Bulletproof absolute directory routing paths
include dirname(__DIR__) . '/includes/db.php';

// 🔥 LOCKDOWN TRIGGER: Assert role validation AND verify the single-use access pass is active
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin' || !isset($_SESSION['admin_access_pass'])) {
    session_unset();
    session_destroy();
    header("Location: /digital-store/login.php"); 
    exit();
}

if(isset($_GET['id'])) {
    // Force ID integer mapping to shield against remote SQL injection attacks completely
    $product_id = intval($_GET['id']);
    
    // Capture the session user ID to ensure an admin cannot execute queries against another creator's products
    $current_admin_id = intval($_SESSION['user_id']);
    
    mysqli_query($conn, "DELETE FROM products WHERE id = $product_id AND user_id = $current_admin_id");
}

// Redirect back to the safe, isolated administrative list frame view
header("Location: /digital-store/admin/dashboard.php");
exit();
?>