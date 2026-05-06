<?php
/*
 * DataTables server-side processing script for Project Management
 * Location: /scripts/projectlist.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB table to use
$table = 'tbl_projects';

// Table's primary key
$primaryKey = 'idtbl_projects';

// Array of database columns which should be read and sent back to DataTables.
$columns = array(
    array('db' => '`p`.`idtbl_projects`', 'dt' => 'idtbl_projects', 'field' => 'idtbl_projects'),
    array('db' => '`p`.`project_code`', 'dt' => 'project_code', 'field' => 'project_code'),
    array('db' => '`p`.`project_name`', 'dt' => 'project_name', 'field' => 'project_name'),
    array('db' => '`p`.`customer_name`', 'dt' => 'customer_name', 'field' => 'customer_name'),
    array('db' => '`p`.`start_date`', 'dt' => 'start_date', 'field' => 'start_date'),
    array('db' => '`p`.`end_date`', 'dt' => 'end_date', 'field' => 'end_date'),
    array('db' => '`p`.`estimated_cost`', 'dt' => 'estimated_cost', 'field' => 'estimated_cost'),
    array('db' => '`p`.`approved`', 'dt' => 'approved', 'field' => 'approved'),
    array('db' => '`p`.`status`', 'dt' => 'status', 'field' => 'status'),
    array('db' => '`p`.`dispatch_status`', 'dt' => 'dispatch_status', 'field' => 'dispatch_status')
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

$joinQuery = "FROM `tbl_projects` AS `p`";

// Get company_id and branch_id from POST
$company_id = isset($_POST['company_id']) ? intval($_POST['company_id']) : 0;
$branch_id = isset($_POST['branch_id']) ? intval($_POST['branch_id']) : 0;

// Build extra where condition - filter by company and branch
$extraWhere = "1=1";

if($company_id > 0) {
    $extraWhere .= " AND `p`.`tbl_company_idtbl_company` = " . $company_id;
}

if($branch_id > 0) {
    $extraWhere .= " AND `p`.`tbl_company_branch_idtbl_company_branch` = " . $branch_id;
}

// Get the response
$response = SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere);

// Return JSON response
echo json_encode($response);
?>