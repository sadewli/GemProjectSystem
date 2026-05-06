<?php
/*
 * DataTables server-side processing script for Delivery Notes
 */

// DB table to use
$table = 'tbl_delivery_notes';

// Table's primary key
$primaryKey = 'idtbl_delivery_notes';

// Array of database columns
$columns = array(
    array('db' => '`d`.`idtbl_delivery_notes`', 'dt' => 'idtbl_delivery_notes', 'field' => 'idtbl_delivery_notes'),
    array('db' => '`d`.`item_name`', 'dt' => 'item_name', 'field' => 'item_name'),
    array('db' => '`d`.`quantity`', 'dt' => 'quantity', 'field' => 'quantity'),
    array('db' => '`d`.`received_quantity`', 'dt' => 'received_quantity', 'field' => 'received_quantity'),
    array('db' => '`d`.`reason`', 'dt' => 'reason', 'field' => 'reason'),
    array('db' => '`d`.`insertdatetime`', 'dt' => 'insertdatetime', 'field' => 'insertdatetime'),
    array('db' => '`d`.`status`', 'dt' => 'status', 'field' => 'status'),
    array('db' => '`d`.`received_status`', 'dt' => 'received_status', 'field' => 'received_status'),
    array('db' => '`d`.`received_date`', 'dt' => 'received_date', 'field' => 'received_date')
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

$joinQuery = "FROM `tbl_delivery_notes` AS `d`";

// Build extra where condition
$extraWhere = "`d`.`tbl_company_idtbl_company` = '$company_id' 
               AND `d`.`tbl_company_branch_idtbl_company_branch` = '$branch_id'
               AND `d`.`status` != 3";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>