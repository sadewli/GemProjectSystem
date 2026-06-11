<?php
/**
 * Add Full Privileges to User 4
 * CRM, Production, System Users, Master Data
 */

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

    // All menu IDs for CRM, Production, System Users, Master Data
    $newMenuIds = [
        // CRM (22-23)
        22, 23,
        // Production (24-29)
        24, 25, 26, 27, 28, 29,
        // System Users (2-4)
        2, 3, 4,
        // Master Data (30-37, 40-43)
        30, 31, 32, 33, 34, 35, 36, 37,
        40, 41, 42, 43
    ];

    // Check existing privileges
    $checkStmt = $pdo->prepare("SELECT tbl_menu_list_idtbl_menu_list FROM tbl_privilege WHERE tbl_user_idtbl_user = ?");
    $checkStmt->execute([$userId]);
    $existingMenus = array_column($checkStmt->fetchAll(), 'tbl_menu_list_idtbl_menu_list');

    // Find which ones to add
    $menusToAdd = array_diff($newMenuIds, $existingMenus);

    if (empty($menusToAdd)) {
        echo "✓ User 4 already has all privileges!\n";
        exit(0);
    }

    // Insert new privileges
    $insertStmt = $pdo->prepare("
        INSERT INTO tbl_privilege (
            can_add, can_edit, can_statuschange, can_remove, access_status, status,
            insertdatetime, tbl_user_idtbl_user, tbl_menu_list_idtbl_menu_list
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $inserted = 0;
    $now = date('Y-m-d H:i:s');

    foreach ($menusToAdd as $menuId) {
        $insertStmt->execute([1, 1, 1, 1, 1, 1, $now, $userId, $menuId]);
        $inserted++;
    }

    // Get menu names for summary
    $menuStmt = $pdo->prepare("SELECT idtbl_menu_list, menu_name FROM tbl_menu_list WHERE idtbl_menu_list IN (" . implode(',', $menusToAdd) . ")");
    $menuStmt->execute();
    $menus = $menuStmt->fetchAll();

    echo "\n✓ SUCCESS: Added " . $inserted . " new privileges to User 4!\n\n";
    echo "New menus added:\n";
    foreach ($menus as $menu) {
        echo "  ✓ " . $menu['menu_name'] . " (ID: " . $menu['idtbl_menu_list'] . ")\n";
    }
    echo "\n";

    // Count total privileges
    $totalStmt = $pdo->prepare("SELECT COUNT(*) as count FROM tbl_privilege WHERE tbl_user_idtbl_user = ?");
    $totalStmt->execute([$userId]);
    $total = $totalStmt->fetch()['count'];
    echo "Total privileges for User 4: " . $total . "\n\n";

} catch (PDOException $e) {
    echo "✗ Database ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
