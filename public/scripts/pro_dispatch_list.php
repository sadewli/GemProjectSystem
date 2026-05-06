<?php
/*
 * DataTables server-side processing script for Project Dispatch
 */

// Database connection
require('config.php');

$table = 'tbl_pro_dispatch_master';
$primaryKey = 'idtbl_pro_dispatch_master';

// Get parameters from POST
$company_id = isset($_POST['company_id']) ? intval($_POST['company_id']) : 0;
$branch_id = isset($_POST['branch_id']) ? intval($_POST['branch_id']) : 0;

// Build query
$sql = "SELECT 
            d.idtbl_pro_dispatch_master,
            d.dispatch_no,
            DATE_FORMAT(d.dispatch_date, '%Y-%m-%d') as dispatch_date,
            CASE 
                WHEN d.dispatch_type = 'single' THEN '<span class=\"badge badge-info\">Single Project</span>'
                ELSE '<span class=\"badge badge-warning\">Multiple Projects</span>'
            END as dispatch_type,
            COALESCE(d.vehicle_no, 'N/A') as vehicle_no,
            d.total_items,
            d.total_serials,
            (SELECT COUNT(*) FROM tbl_pro_dispatch_assigned_employees e WHERE e.tbl_pro_dispatch_master_id = d.idtbl_pro_dispatch_master) as total_employees,
            CASE 
                WHEN d.status = 1 THEN '<span class=\"badge badge-secondary\">Draft</span>'
                WHEN d.status = 2 THEN '<span class=\"badge badge-primary\">Dispatched</span>'
                WHEN d.status = 3 THEN '<span class=\"badge badge-success\">Delivered</span>'
                WHEN d.status = 4 THEN '<span class=\"badge badge-danger\">Cancelled</span>'
                ELSE '<span class=\"badge badge-secondary\">Unknown</span>'
            END as status,
            CASE 
                WHEN d.received_status = 0 THEN '<span class=\"badge badge-secondary\">Not Received</span>'
                WHEN d.received_status = 1 THEN '<span class=\"badge badge-warning\">Partially Received</span>'
                WHEN d.received_status = 2 THEN '<span class=\"badge badge-success\">Fully Received</span>'
                ELSE '<span class=\"badge badge-secondary\">Unknown</span>'
            END as receive_status,
            COALESCE(DATE_FORMAT(d.received_date, '%Y-%m-%d %H:%i'), '-') as received_date,
            DATE_FORMAT(d.insertdatetime, '%Y-%m-%d') as insertdatetime
        FROM tbl_pro_dispatch_master d
        WHERE d.tbl_company_idtbl_company = $company_id 
        AND d.tbl_company_branch_idtbl_company_branch = $branch_id
        AND d.status IN (1, 2, 3, 4)
        ORDER BY d.idtbl_pro_dispatch_master DESC";

$result = mysqli_query($con, $sql);
$data = array();

while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode(['data' => $data]);
?>