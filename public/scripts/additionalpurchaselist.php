<?php
/*
 * DataTables server-side processing script for Additional Purchases
 */

// Start session to get company/branch info
session_start();

// DB table to use
$table = 'tbl_additional_purchases';

// Table's primary key
$primaryKey = 'idtbl_additional_purchases';

// Array of database columns which should be read and sent back to DataTables.
$columns = array(
    array('db' => '`ap`.`idtbl_additional_purchases`', 'dt' => 'idtbl_additional_purchases', 'field' => 'idtbl_additional_purchases'),
    array('db' => '`ap`.`item_name`', 'dt' => 'item_name', 'field' => 'item_name'),
    array('db' => '`ap`.`quantity`', 'dt' => 'quantity', 'field' => 'quantity'),
    array('db' => '`ap`.`unit`', 'dt' => 'unit', 'field' => 'unit'),
    array('db' => '`ap`.`rate`', 'dt' => 'rate', 'field' => 'rate'),
    array('db' => '`ap`.`total_amount`', 'dt' => 'total_amount', 'field' => 'total_amount'),
    array('db' => 'DATE(`ap`.`insertdatetime`)', 'dt' => 'insertdatetime', 'field' => 'insertdatetime'),
    array('db' => '`p`.`project_name`', 'dt' => 'project_name', 'field' => 'project_name'),
    array('db' => '`ap`.`status`', 'dt' => 'status', 'field' => 'status')
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

// Get company and branch from POST
$company_id = isset($_POST['company_id']) ? $_POST['company_id'] : (isset($_SESSION['company_id']) ? $_SESSION['company_id'] : '');
$branch_id = isset($_POST['branch_id']) ? $_POST['branch_id'] : (isset($_SESSION['branch_id']) ? $_SESSION['branch_id'] : '');

$joinQuery = "
FROM `tbl_additional_purchases` AS `ap`
LEFT JOIN `tbl_projects` AS `p` ON `p`.`idtbl_projects` = `ap`.`tbl_projects_idtbl_projects`
";

$extraWhere = "`ap`.`status` IN (1, 2)";

if(!empty($company_id)) {
    $extraWhere .= " AND `ap`.`tbl_company_idtbl_company` = '$company_id'";
}

if(!empty($branch_id)) {
    $extraWhere .= " AND `ap`.`tbl_company_branch_idtbl_company_branch` = '$branch_id'";
}

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>