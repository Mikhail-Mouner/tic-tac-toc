<?php
//// start session //////
if (!isset($_SESSION)) {
	session_start();
//  ini_set('session.gc_maxlifetime',87000);
}




//// application name ////
$application_name='Tic Tac Toc';
//// end application name ////



////// defining the server ////
$server='http://localhost/tic_toc/';
////// end define the server ////

//$hostname_website = "localhost";
//$database_website = "tic_toc";
//$username_website = "root";
//$password_website = "";

//online
$hostname_website = "sql113.epizy.com";
$database_website = "epiz_22864846_tic_toc";
$username_website = "epiz_22864846";
$password_website = "Merogooda2";
$website = mysqli_connect($hostname_website, $username_website, $password_website) or trigger_error(mysqli_error($website),E_USER_ERROR);

mysqli_query($website , "SET NAMES utf8");
mysqli_query($website , "SET SESSION SQL_BIG_SELECTS=1;");


mysqli_select_db ( $website, $database_website );
// mysqli_free_result($current_employee);
?>
