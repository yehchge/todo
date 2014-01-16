<?php 

// Turn on Error Reporting

$environment = "dev";

switch($environment) {
	case "dev":
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		break;
	case "live":
		error_reporting(0);
		ini_set('display_errors', 0);
		break;
}