<?php
/*
 * DataTables server-side processing script for User Type
 */

// DB table to use
$table = 'tbl_user_type';

// Table's primary key
$primaryKey = 'idtbl_user_type';

// Array of database columns
$columns = array(
	array( 'db' => '`u`.`idtbl_user_type`', 'dt' => 'idtbl_user_type', 'field' => 'idtbl_user_type' ),
	array( 'db' => '`u`.`usertype`', 'dt' => 'usertype', 'field' => 'usertype' ),
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

$joinQuery = "FROM `tbl_user_type` AS `u`";

if($_POST['userID'] == 1){
    $extraWhere = "`u`.`status` IN (1, 2)";
} else {
    $extraWhere = "`u`.`status` IN (1, 2) AND `u`.`idtbl_user_type` > 1";
}

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>