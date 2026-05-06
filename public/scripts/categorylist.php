<?php
/*
 * DataTables server-side processing script for Category Management
 */

// Error reporting (disable in production)
error_reporting(0);
ini_set('display_errors', 0);

// DB table to use
$table = 'tbl_categories';

// Table's primary key
$primaryKey = 'idtbl_categories';

// Array of database columns which should be read and sent back to DataTables.
$columns = array(
    array('db' => '`c`.`idtbl_categories`', 'dt' => 0, 'field' => 'idtbl_categories'),
    array('db' => '`c`.`category_name`', 'dt' => 1, 'field' => 'category_name'),
    array('db' => '`c`.`description`', 'dt' => 2, 'field' => 'description'),
    array('db' => '`c`.`status`', 'dt' => 3, 'field' => 'status')
);

// SQL server connection information
require('config.php');
$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);

require('ssp.customized.class.php');

$joinQuery = "FROM `tbl_categories` AS `c`";

// Show only active and inactive categories (not permanently deleted)
$extraWhere = "`c`.`status` IN (1, 2)";

// Get userID from POST
$userID = isset($_POST['userID']) ? intval($_POST['userID']) : 0;

// Optional: Add user-specific filtering here if needed
if($userID > 0) {
    // Add any user-specific conditions
}

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>