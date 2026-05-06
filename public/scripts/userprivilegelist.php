<?php
/*
 * DataTables server-side processing script for User Privilege
 */

// DB table to use
$table = 'tbl_privilege';

// Table's primary key
$primaryKey = 'idtbl_privilege';

// Column definitions
$columns = array(
    array( 'db' => '`u`.`idtbl_privilege`', 'dt' => 'idtbl_privilege', 'field' => 'idtbl_privilege' ),
    array( 'db' => '`ua`.`name`', 'dt' => 'name', 'field' => 'name' ),
    array( 'db' => '`ub`.`menu_name`', 'dt' => 'menu_name', 'field' => 'menu_name' ),
    array( 'db' => '`u`.`can_add`', 'dt' => 'can_add', 'field' => 'can_add' ),
    array( 'db' => '`u`.`can_edit`', 'dt' => 'can_edit', 'field' => 'can_edit' ),
    array( 'db' => '`u`.`can_statuschange`', 'dt' => 'can_statuschange', 'field' => 'can_statuschange' ),
    array( 'db' => '`u`.`can_remove`', 'dt' => 'can_remove', 'field' => 'can_remove' ),
    array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' )
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

$joinQuery = "FROM `tbl_privilege` AS `u` 
              JOIN `tbl_user` AS `ua` ON (`ua`.`idtbl_user` = `u`.`tbl_user_idtbl_user`) 
              JOIN `tbl_menu_list` AS `ub` ON (`ub`.`idtbl_menu_list` = `u`.`tbl_menu_list_idtbl_menu_list`)";

if($_POST['userID'] == 1){
    $extraWhere = "`u`.`status` IN (1, 2)";
} else {
    $extraWhere = "`u`.`status` IN (1, 2) AND `ua`.`idtbl_user` != 1";
}

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>