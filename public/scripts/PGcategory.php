<?php
/*
 * PG Category Management - Server Side Script
 * This file can be used as an AJAX endpoint for DataTables
 */

error_reporting(0);
ini_set('display_errors', 0);

require('config.php');

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get total categories
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM tbl_pg_categories WHERE status != 3");
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Get active categories
    $stmt = $pdo->query("SELECT COUNT(*) as active FROM tbl_pg_categories WHERE status = 1");
    $active = $stmt->fetch(PDO::FETCH_ASSOC)['active'];
    
    // Get inactive categories
    $stmt = $pdo->query("SELECT COUNT(*) as inactive FROM tbl_pg_categories WHERE status = 2");
    $inactive = $stmt->fetch(PDO::FETCH_ASSOC)['inactive'];
    
    // Get today's additions
    $today = date('Y-m-d');
    $stmt = $pdo->prepare("SELECT COUNT(*) as today FROM tbl_pg_categories WHERE DATE(insertdatetime) = ? AND status != 3");
    $stmt->execute([$today]);
    $today_count = $stmt->fetch(PDO::FETCH_ASSOC)['today'];
    
    echo json_encode([
        'status' => 'success',
        'data' => [
            'total' => intval($total),
            'active' => intval($active),
            'inactive' => intval($inactive),
            'today' => intval($today_count)
        ]
    ]);
    
} catch(PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>