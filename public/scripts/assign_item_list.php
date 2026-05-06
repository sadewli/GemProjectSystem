<?php
/*
 * DataTables server-side processing script for Assign Items
 */

// DB table to use
$table = 'tbl_assign_items_master';

// Table's primary key
$primaryKey = 'idtbl_assign_items_master';

// Array of database columns which should be read and sent back to DataTables.
$columns = array(
    array('db' => '`a`.`idtbl_assign_items_master`', 'dt' => 'idtbl_assign_items_master', 'field' => 'idtbl_assign_items_master'),
    array('db' => '`p`.`project_code`', 'dt' => 'project_code', 'field' => 'project_code'),
    array('db' => '`p`.`project_name`', 'dt' => 'project_name', 'field' => 'project_name'),
    array('db' => '`a`.`assign_date`', 'dt' => 'assign_date', 'field' => 'assign_date'),
    array('db' => '`a`.`total_items`', 'dt' => 'total_items', 'field' => 'total_items'),
    array('db' => '`a`.`description`', 'dt' => 'description', 'field' => 'description'),
    array('db' => '`pm`.`description`', 'dt' => 'planned_description', 'field' => 'planned_description'),
    array('db' => '`u`.`name`', 'dt' => 'created_by', 'field' => 'created_by'),
    array('db' => '`a`.`status`', 'dt' => 'status', 'field' => 'status')
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
$project_id = isset($_POST['project_id']) ? $_POST['project_id'] : '';
$user_id = isset($_POST['userID']) ? $_POST['userID'] : 0;

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

$joinQuery = "FROM `tbl_assign_items_master` AS `a` 
              JOIN `tbl_projects` AS `p` ON `p`.`idtbl_projects` = `a`.`tbl_projects_idtbl_projects`
              JOIN `tbl_planned_items_master` AS `pm` ON `pm`.`idtbl_planned_items_master` = `a`.`tbl_planned_items_master_idtbl_planned_items_master`
              LEFT JOIN `tbl_user` AS `u` ON `u`.`idtbl_user` = `a`.`insertuser`";

// Build extra where condition
$extraWhere = "`a`.`tbl_company_idtbl_company` = '$company_id' 
               AND `a`.`tbl_company_branch_idtbl_company_branch` = '$branch_id'
               AND `a`.`status` != 4";

// Add project filter if specified
if(!empty($project_id)) {
    $extraWhere .= " AND `a`.`tbl_projects_idtbl_projects` = '$project_id'";
}

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>