<?php
/*
 * DataTables server-side processing script for ADE Tile Cutting
 */

// DB table to use
$table = 'ADE_cutting_master';

// Table's primary key
$primaryKey = 'cutting_id';

// Array of database columns
$columns = array(
    array('db' => '`c`.`cutting_no`', 'dt' => 'cutting_no', 'field' => 'cutting_no'),
    array('db' => '`c`.`cutting_date`', 'dt' => 'cutting_date', 'field' => 'cutting_date'),
    array('db' => '`c`.`item_name`', 'dt' => 'item_name', 'field' => 'item_name'),
    array('db' => '`c`.`total_original_qty`', 'dt' => 'total_original_qty', 'field' => 'total_original_qty'),
    array('db' => '`c`.`total_cut_qty`', 'dt' => 'total_cut_qty', 'field' => 'total_cut_qty'),
    array('db' => '`c`.`total_issued_qty`', 'dt' => 'total_issued_qty', 'field' => 'total_issued_qty'),
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

// Get session values from POST
$company_id = isset($_POST['company_id']) ? $_POST['company_id'] : 0;
$branch_id = isset($_POST['branch_id']) ? $_POST['branch_id'] : 0;

// If no company/branch ID, return empty result
if($company_id == 0 || $branch_id == 0) {
    echo json_encode(array(
        "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => array()
    ));
    exit;
}

$joinQuery = "FROM `ADE_cutting_master` AS `c`";

// Build extra where condition
$extraWhere = "`c`.`tbl_company_idtbl_company` = '$company_id' 
               AND `c`.`tbl_company_branch_idtbl_company_branch` = '$branch_id'
               AND `c`.`status` != 3";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>