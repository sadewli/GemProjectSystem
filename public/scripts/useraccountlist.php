<?php
/*
 * DataTables server-side processing script for User Account
 */

// DB table to use
$table = 'tbl_user';

// Table's primary key
$primaryKey = 'idtbl_user';

// Array of database columns which should be read and sent back to DataTables.
$columns = array(
    array('db' => '`u`.`idtbl_user`', 'dt' => 'idtbl_user', 'field' => 'idtbl_user'),
    array('db' => '`u`.`name`', 'dt' => 'name', 'field' => 'name'),
    array('db' => '`u`.`username`', 'dt' => 'username', 'field' => 'username'),
    array('db' => '`ut`.`usertype`', 'dt' => 'usertype', 'field' => 'usertype'), 
    array('db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status')
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

$joinQuery = "
FROM `tbl_user` AS `u`
LEFT JOIN `tbl_user_type` AS `ut`
ON (`ut`.`idtbl_user_type` = `u`.`tbl_user_type_idtbl_user_type`)
";

if($_POST['userID'] == 1){
    $extraWhere = "`u`.`status` IN (1, 2)";
} else {
    $extraWhere = "`u`.`status` IN (1, 2) AND `u`.`idtbl_user` > 1";
}

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>