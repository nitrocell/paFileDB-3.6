<?php
/**
 * @version V4.66 28 Sept 2005  (c) 2000-2005 John Lim (jlim@natsoft.com.my). All rights reserved.
 * Released under both BSD license and Lesser GPL library license.
 * Whenever there is any discrepancy between the two licenses,
 * the BSD license will take precedence.
 *
 * Set tabs to 4 for best viewing.
 *
 * Latest version is available at http://php.weblogs.com
 *
*/

// added Claudio Bustos  clbustos#entelchile.net
if (!defined('ADODB_ERROR_HANDLER_TYPE')) define('ADODB_ERROR_HANDLER_TYPE',E_USER_ERROR); 

if (!defined('ADODB_ERROR_HANDLER')) define('ADODB_ERROR_HANDLER','ADODB_Error_Handler');

/**
* Default Error Handler. This will be called with the following params
*
* @param $dbms		the RDBMS you are connecting to
* @param $fn		the name of the calling function (in uppercase)
* @param $errno		the native error number from the database
* @param $errmsg	the native error msg from the database
* @param $p1		$fn specific parameter - see below
* @param $p2		$fn specific parameter - see below
* @param $thisConn	$current connection object - can be false if no connection object created
*/

function ADODB_Error_Handler($dbms, $fn, $errno, $errmsg, $p1, $p2, &$thisConnection)
{

	switch($fn) {
		case 'EXECUTE':
			$sql = $p1;
			$inputparams = $p2;
			$s = "$dbms error: [$errno: $errmsg] in $fn(\"$sql\")\n";
			break;

		case 'PCONNECT':
		case 'CONNECT':
			$host = $p1;
			$database = $p2;
			$s = "$dbms error: [$errno: $errmsg] in $fn($host, '****', '****', $database)\n";
			break;

		default:
			$s = "$dbms error: [$errno: $errmsg] in $fn($p1, $p2)\n";
			break;
	}
	/*
	* Log connection error somewhere
	*	0 message is sent to PHP's system logger, using the Operating System's system
	*		logging mechanism or a file, depending on what the error_log configuration
	*		directive is set to.
	*	1 message is sent by email to the address in the destination parameter.
	*		This is the only message type where the fourth parameter, extra_headers is used.
	*		This message type uses the same internal function as mail() does.
	*	2 message is sent through the PHP debugging connection.
	*		This option is only available if remote debugging has been enabled.
	*		In this case, the destination parameter specifies the host name or IP address
	*		and optionally, port number, of the socket receiving the debug information.
	*	3 message is appended to the file destination
	*/
	if (defined('ADODB_ERROR_LOG_TYPE')) {
		$t = date('Y-m-d H:i:s');
		if (defined('ADODB_ERROR_LOG_DEST'))
			error_log("($t) $s", ADODB_ERROR_LOG_TYPE, ADODB_ERROR_LOG_DEST);
		else
			error_log("($t) $s", ADODB_ERROR_LOG_TYPE);
	}

	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>paFileDB - Error</title>
	<style type="text/css">
		body {
			font: 10px Verdana; 
			color:#000000;
		}
		a:link {
			color:#a30404;
			text-decoration:none;
			font-weight:none;
		}
		
		a:active {
			color:#a30404;
			text-decoration:none;
			font-weight:none;
		}
		
		a:visited {
			color:#a30404;
			text-decoration:none;
			font-weight:none;
		}
		
		a:hover {
		    color: #000000;
		}
	</style>
	</head>
  <body>
  <span style="font-size: 14px; font-weight: bold">paFileDB Error</span><p />
	paFIleDB encountered an error while running a database query and is unable to continue.<p />
	For technical assistance, please visit <a href="http://www.phparena.net/support.php">The PHP Arena support page</a>.<br />
	<b><?php echo($s); ?></b>
	</body>
	</html>
	<?php
	die();
}
?>
