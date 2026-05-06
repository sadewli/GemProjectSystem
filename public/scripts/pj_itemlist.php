<?php
/*
 * DataTables server-side processing script for Item Master
 * Without Company/Branch filters
 */

// DB table to use
$table = 'tbl_item_master';

// Table's primary key
$primaryKey = 'idtbl_item_master';

// Array of database columns which should be read and sent back to DataTables.
$columns = array(
    array('db' => '`i`.`idtbl_item_master`', 'dt' => 'idtbl_item_master', 'field' => 'idtbl_item_master'),
    array('db' => '`i`.`item_name`', 'dt' => 'item_name', 'field' => 'item_name'),
    array('db' => '`i`.`serial_no`', 'dt' => 'serial_no', 'field' => 'serial_no'),
    array('db' => '`c`.`category_name`', 'dt' => 'category_name', 'field' => 'category_name'),
    array('db' => '`i`.`status`', 'dt' => 'status', 'field' => 'status')
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

$joinQuery = "FROM `tbl_item_master` AS `i` 
              LEFT JOIN `tbl_item_category` AS `c` ON `i`.`category_id` = `c`.`idtbl_item_category`";

// Build extra where condition - show all records
// You can add filters here if needed
$extraWhere = "`i`.`status` != 3"; // Exclude deleted items

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>