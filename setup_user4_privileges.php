<?php
/**
 * User 4 Privilege Setup Script - Direct MySQL Connection
 * This script sets privileges for user ID 4 with Inventory and Sales items
 */

// Database configuration
$host = '127.0.0.1';
$db = 'erav_gemstonesystem';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $userId = 4;

    // Check if user exists
    $userStmt = $pdo->prepare("SELECT idtbl_user FROM tbl_user WHERE idtbl_user = ?");
    $userStmt->execute([$userId]);

    if (!$userStmt->fetch()) {
        echo "✗ ERROR: User with ID 4 does not exist in the database.\n";
        exit(1);
    }

    // Check if user already has privileges
    $checkStmt = $pdo->prepare("SELECT COUNT(*) as count FROM tbl_privilege WHERE tbl_user_idtbl_user = ?");
    $checkStmt->execute([$userId]);
    $result = $checkStmt->fetch();

    if ($result['count'] > 0) {
        echo "✓ User 4 already has " . $result['count'] . " privileges set.\n";
        exit(0);
    }

    // Menu IDs for Inventory and Sales
    $inventoryMenuIds = [5, 6, 7, 8, 9, 10, 11, 12, 13];
    $salesMenuIds = [14, 15, 16, 17, 18, 19, 20, 21];
    $allowedMenuIds = array_merge($inventoryMenuIds, $salesMenuIds);

    // Verify menus exist
    $placeholders = implode(',', array_fill(0, count($allowedMenuIds), '?'));
    $menuStmt = $pdo->prepare("SELECT COUNT(*) as count FROM tbl_menu_list WHERE idtbl_menu_list IN ($placeholders)");
    $menuStmt->execute($allowedMenuIds);
    $menuResult = $menuStmt->fetch();

    if ($menuResult['count'] !== count($allowedMenuIds)) {
        echo "✗ ERROR: Some menus don't exist. Found " . $menuResult['count'] . " of " . count($allowedMenuIds) . ".\n";
        exit(1);
    }

    // Insert privileges
    $insertStmt = $pdo->prepare("
        INSERT INTO tbl_privilege (
            can_add, can_edit, can_statuschange, can_remove, access_status, status,
            insertdatetime, tbl_user_idtbl_user, tbl_menu_list_idtbl_menu_list
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $inserted = 0;
    $now = date('Y-m-d H:i:s');

    foreach ($allowedMenuIds as $menuId) {
        $insertStmt->execute([1, 1, 1, 1, 1, 1, $now, $userId, $menuId]);
        $inserted++;
    }

    echo "\n✓ SUCCESS: User 4 privileges configured!\n";
    echo "├─ Inventory items: " . count($inventoryMenuIds) . "\n";
    echo "├─ Sales items: " . count($salesMenuIds) . "\n";
    echo "└─ Total: " . $inserted . " menu permissions added\n\n";
    echo "Menus assigned:\n";
    echo "  Inventory: My Inventory, Memo In, Memo Out, Archived, Inventory List,\n";
    echo "             Stock Take, Inventory Adjustment, Negative Inventory, Product Code\n";
    echo "  Sales: Invoice, Customer Memo, Quotation, Shipping Invoice, Transfer Docs,\n";
    echo "         Purchase Order, Supplier Memo,\n\n";

} catch (PDOException $e) {
    echo "✗ Database ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
