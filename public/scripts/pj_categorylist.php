<?php
/*
 * DataTables server-side processing script for Item Category Management
 * Without Company/Branch filters
 */

// DB table to use
$table = 'tbl_item_category';

// Table's primary key
$primaryKey = 'idtbl_item_category';

// Array of database columns which should be read and sent back to DataTables.
$columns = array(
    array('db' => '`c`.`idtbl_item_category`', 'dt' => 'idtbl_item_category', 'field' => 'idtbl_item_category'),
    array('db' => '`c`.`category_name`', 'dt' => 'category_name', 'field' => 'category_name'),
    array('db' => '`c`.`description`', 'dt' => 'description', 'field' => 'description'),
    array('db' => '`c`.`status`', 'dt' => 'status', 'field' => 'status')
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

$joinQuery = "FROM `tbl_item_category` AS `c`";

// Build extra where condition - show all except deleted (status = 3)
$extraWhere = "`c`.`status` != 3";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>