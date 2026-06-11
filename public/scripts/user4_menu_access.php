<?php
/*
 * DataTables server-side processing script for User 4 Menu Access
 */

// DB table to use
$table = 'tbl_privilege';

// Table's primary key
$primaryKey = 'idtbl_privilege';

// Column definitions
$columns = array(
    array( 'db' => '`p`.`idtbl_privilege`', 'dt' => 'privilege_id', 'field' => 'privilege_id' ),
    array( 'db' => '`m`.`menu_name`', 'dt' => 'menu_name', 'field' => 'menu_name' ),
    array( 'db' => '`p`.`can_add`', 'dt' => 'can_add', 'field' => 'can_add' ),
    array( 'db' => '`p`.`can_edit`', 'dt' => 'can_edit', 'field' => 'can_edit' ),
    array( 'db' => '`p`.`can_statuschange`', 'dt' => 'can_statuschange', 'field' => 'can_statuschange' ),
    array( 'db' => '`p`.`can_remove`', 'dt' => 'can_remove', 'field' => 'can_remove' ),
    array( 'db' => '`p`.`status`', 'dt' => 'status', 'field' => 'status' )
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

$joinQuery = "FROM `tbl_privilege` AS `p` 
              JOIN `tbl_menu_list` AS `m` ON (`m`.`idtbl_menu_list` = `p`.`tbl_menu_list_idtbl_menu_list`)
              WHERE `p`.`tbl_user_idtbl_user` = 4 AND `p`.`access_status` = 1";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, "")
);
?>
