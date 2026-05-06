<?php
session_start();

$table = 'tbl_product_upgrade';
$primaryKey = 'idtbl_product_upgrade';

$columns = array(
    array('db' => '`u`.`idtbl_product_upgrade`', 'dt' => 'idtbl_product_upgrade', 'field' => 'idtbl_product_upgrade'),
    array('db' => '`u`.`product_name`', 'dt' => 'product_name', 'field' => 'product_name'),
    array(
        'db' => '(SELECT COUNT(*) FROM tbl_product_upgrade_serials WHERE tbl_product_upgrade_id = u.idtbl_product_upgrade)',
        'dt' => 'serial_count', 'field' => 'serial_count', 'as' => 'serial_count'
    ),
    array('db' => 'DATE(`u`.`upgrade_date`)', 'dt' => 'upgrade_date', 'field' => 'upgrade_date'),
    array(
        'db' => '(SELECT COUNT(*) FROM tbl_product_upgrade_items WHERE tbl_product_upgrade_id = u.idtbl_product_upgrade AND item_type = "REMOVE")',
        'dt' => 'remove_count', 'field' => 'remove_count', 'as' => 'remove_count'
    ),
    array(
        'db' => '(SELECT COUNT(*) FROM tbl_product_upgrade_items WHERE tbl_product_upgrade_id = u.idtbl_product_upgrade AND item_type = "ADD")',
        'dt' => 'add_count', 'field' => 'add_count', 'as' => 'add_count'
    ),
    array('db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status'),
);

require('config.php');
$sql_details = array('user' => $db_username, 'pass' => $db_password, 'db' => $db_name, 'host' => $db_host);
require('ssp.customized.class.php');

$company_id = isset($_POST['company_id']) ? $_POST['company_id'] : ($_SESSION['company_id'] ?? '');
$branch_id = isset($_POST['branch_id']) ? $_POST['branch_id'] : ($_SESSION['branch_id'] ?? '');

$joinQuery = "FROM `tbl_product_upgrade` AS `u`";
$extraWhere = "`u`.`status` != 4";
if (!empty($company_id)) $extraWhere .= " AND `u`.`tbl_company_idtbl_company` = '" . addslashes($company_id) . "'";
if (!empty($branch_id)) $extraWhere .= " AND `u`.`tbl_company_branch_idtbl_company_branch` = '" . addslashes($branch_id) . "'";

echo json_encode(SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere));
?>