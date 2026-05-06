<?php
/*
 * DataTables server-side processing script for Planned Items
 */

// DB table to use
$table = 'tbl_planned_items_master';

// Table's primary key
$primaryKey = 'idtbl_planned_items_master';

// Array of database columns which should be read and sent back to DataTables.
$columns = array(
    array('db' => '`m`.`idtbl_planned_items_master`', 'dt' => 'idtbl_planned_items_master', 'field' => 'idtbl_planned_items_master'),
    array('db' => '`p`.`project_code`', 'dt' => 'project_code', 'field' => 'project_code'),
    array('db' => '`p`.`project_name`', 'dt' => 'project_name', 'field' => 'project_name'),
    array('db' => '`m`.`planned_date`', 'dt' => 'planned_date', 'field' => 'planned_date'),
    array('db' => '`m`.`total_items`', 'dt' => 'total_items', 'field' => 'total_items'),
    array('db' => '`m`.`assign_status`', 'dt' => 'assign_status', 'field' => 'assign_status'),
    array('db' => '`m`.`status`', 'dt' => 'status', 'field' => 'status')
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

$joinQuery = "FROM `tbl_planned_items_master` AS `m` 
              JOIN `tbl_projects` AS `p` ON `p`.`idtbl_projects` = `m`.`tbl_projects_idtbl_projects`";

// Build extra where condition
$extraWhere = "`m`.`tbl_company_idtbl_company` = '$company_id' 
               AND `m`.`tbl_company_branch_idtbl_company_branch` = '$branch_id'
               AND `m`.`status` != 4";

// Add project filter if specified
if(!empty($project_id)) {
    $extraWhere .= " AND `m`.`tbl_projects_idtbl_projects` = '$project_id'";
}

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>