<?php
session_start();
require('config.php');
require('ssp.customized.class.php');

$table = 'tbl_project_employee_assignments';
$primaryKey = 'idtbl_project_employee_assignments';

$columns = array(
    array('db' => '`a`.`assignment_ref`', 'dt' => 'assignment_ref', 'field' => 'assignment_ref'),
    array('db' => '`p`.`project_name`', 'dt' => 'project_name', 'field' => 'project_name'),
    array('db' => '`a`.`assignment_date`', 'dt' => 'assignment_date', 'field' => 'assignment_date'),
    array('db' => '`a`.`duration_days`', 'dt' => 'duration_days', 'field' => 'duration_days'),
    array('db' => '`a`.`total_employees`', 'dt' => 'total_employees', 'field' => 'total_employees'),
    array('db' => '`a`.`idtbl_project_employee_assignments`', 'dt' => 'id', 'field' => 'id')
);

$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);

$company_id = $_SESSION['company_id'];
$branch_id = $_SESSION['branch_id'];

$joinQuery = "
FROM `tbl_project_employee_assignments` AS `a`
LEFT JOIN `tbl_projects` AS `p` ON `p`.`idtbl_projects` = `a`.`tbl_projects_idtbl_projects`
";

$extraWhere = "`a`.`status` = 1 AND `a`.`tbl_company_idtbl_company` = '$company_id' AND `a`.`tbl_company_branch_idtbl_company_branch` = '$branch_id'";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>