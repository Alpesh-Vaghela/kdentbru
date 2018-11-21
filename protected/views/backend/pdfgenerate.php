<?php
//$getid = $link->hrefquery ();
if (isset($_REQUEST['report_type']))
//echo $getid;
//include ("assets/MPDF56/mpdf.php");
include SERVER_ROOT.'/protected/library/MPDF/mpdf.php';


$mpdf = new mPDF('c', 'A3', 8);

$mpdf->SetDisplayMode ( 'fullpage' );

$mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first
                                    // level of a list
//$getempname= $db->get_row("employees", array("employee_id"=>$getid[1]));
$get_filename=$_REQUEST['report_type'];
$filename = SERVER_ROOT . '/uploads/pdf/' . $get_filename . ".html";
$mpdf->WriteHTML ( file_get_contents ( $filename ) );

$mpdf->Output ( $get_filename. '.pdf', 'D' );
// $mpdf->Output ();
//$session->redirect ( "viewslip_table?empid=" . $getid [1] );
exit ();
// ==============================================================
// ==============================================================
// ==============================================================
?>