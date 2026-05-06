<?php
/*
 * AJAX Handler for Product Upgrade List
 */

require('config.php');

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    
    $sql = "SELECT u.*, 
                   CONCAT(cre.first_name, ' ', cre.last_name) as requested_by,
                   CONCAT(app.first_name, ' ', app.last_name) as approved_by,
                   (SELECT COUNT(*) FROM tbl_product_upgrade_items WHERE upgrade_id = u.idtbl_product_upgrade AND item_type = 'REMOVE') as remove_count,
                   (SELECT COUNT(*) FROM tbl_product_upgrade_items WHERE upgrade_id = u.idtbl_product_upgrade AND item_type = 'ADD') as add_count
            FROM tbl_product_upgrade u
            LEFT JOIN tbl_user cre ON u.request_by = cre.idtbl_user
            LEFT JOIN tbl_user app ON u.approved_by = app.idtbl_user";
            
    if(!empty($status)) {
        $sql .= " WHERE u.status = :status";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':status' => $status]);
    } else {
        $sql .= " ORDER BY u.insertdatetime DESC";
        $stmt = $pdo->query($sql);
    }
    
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
    
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>