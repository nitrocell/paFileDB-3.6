<?php

/***************************************************************
* paFileDB 3.6                                                 *
*                                                              *
* Author: PHP Arena <http://www.phparena.net>                  *
* File Version 3.6                                             *
* Copyright ©2005-2007 PHP Arena. All Rights Reserved.         *
*                                                              *
* THIS FILE MAY NOT BE REDISTRIBUTED.                          *
* For more information, please see the PHP Arena license at:   *
* http://www.phparena.net/license.html                         *
***************************************************************/

if (isset($_GET['img'])) {
	if ($_GET['img'] == "green") {
		header("Content-type: image/gif");
		header("Content-length: 396");
		echo base64_decode(
		'R0lGODlhDgAOANU/AP3+/bvsuxGmC8jpyEtrZE+zS1bATzOGMSe0GzfGIYaYnJC0kwmQCV'.
		'bTOh1kNWnEZJXWliF7Ki+bMb7vujW7Jm6adjtjVYHvVmHaQknKNczcz116fDmlNfn7+ULG'.
		'LPT/8QpqEixhSjxyUoXOhidbSt7y3nPlTpH+YOr36qfbqG3hSWR9gff4+L/IzNvo3U/ZL1'.
		'LQN1DZL97p4HDxQ2i4ZIDqXWuCgRdONZ7Xn33zUMbO0C5vQDFkTDR4R7LisP///yH5BAEA'.
		'AD8ALAAAAAAOAA4AAAapwJ9QU7EQCBabDiD8dRaHhavTkS0sCtYPAPV9AGDAxydSdDQOWm'.
		'BQQqFKg8njpquAOBDfYD/wQTggGzsMDAUjOCkpOCMFhCQRApEUBg8PBhSRAg6QAggUCR4e'.
		'CRQIkQ4HCJ4eMA0NMBmkCCQVEqANGCoqGA2iEhsaOxkvGCYXFyYYMRkhLQAKOxgzOScnOT'.
		'MYPWY/LAohBTXUNQU8WU0AOisWIiIWG81CQQA7');
	} elseif ($_GET['img'] == "grey") {
		header("Content-type: image/gif");
		header("Content-length: 409");
		echo base64_decode(
		'R0lGODlhDgAOANU/AJWVlYWFhdra2tHR0a6urmhoaKysrM3NzZycnJaWloCAgOvr66Kiou'.
		'Hh4Z6ent3d3Zqamnp6epCQkGZmZsnJyYyMjMPDw4iIiF1dXVlZWXh4eKWlpYqKin5+fnx8'.
		'fHNzc21tbWRkZFRUVGJiYv7+/vn5+W9vb/r6+vj4+PLy8rq6urGxsXBwcKampra2tvv7++'.
		'bm5k1NTfz8/N7e3sDAwL29vaioqIKCgqGhoYSEhHFxcWtra5OTk2NjY/39/f///yH5BAEA'.
		'AD8ALAAAAAAOAA4AAAa2wJ/wAdiZWJPLwCf8vVY6Aux0ghl6uNKPRNAdSj4SyYca7BwyQQ'.
		'YheCxSqcVMsIkNeKJObSBoNAQDNAoiCgU9IxUrFhQUFi4SIT0ZIzsFJjcJODgJOSwFOxkF'.
		'HzoRCjkXFzkKHqMZJhERORU8CQk8FQGwGAAaARwACAwMDgAVFxodAj0SABAbBAQtEAASGA'.
		'c+DBMILQQuLgQ2DjsILz8lOBgSBCoqKzwjCChNPgMBPSAgEwrXQkEAOw==');
	} elseif ($_GET['img'] == "red") {
	    header("Content-type: image/gif");
		header("Content-length: 402");
		echo base64_decode(
		'R0lGODlhDgAOANU/AP8lJf79/dMPD4Y2NuoDA/8xMYgkJJgdHfNnZ/9MTKmBgf/ExP8FBf'.
		'9dXcWJiatubtTAwP46OvsbG5xoaP+Xl/8LC//MzP709IsYGJYxMe/Z2f8VFfYyMtzJyZZd'.
		'Xf9CQvUBAf+Hh/r39/++vsk5Ob6Skq6IiOPPz/z7+//r6//e3v+zs/+jo+8KCvRRUbQDA4'.
		'1HR/+pqZgrK9O+vrKLi/Q/P9jFxfOwsP9YWPVERO4REfv5+fKqqvMQEP8AAP///yH5BAEA'.
		'AD8ALAAAAAAOAA4AAAavwJ/w9BjAYINJJyD87UoZh+Zy0TgGJtEvUJLxLoFw4HLLmFAnDG'.
		'K0UKVSKssIgbE9XhzKamGxLFYUES8eMgIENSEsMTEsITkEAgYHLQQgEh84OB8SIAQtGJMg'.
		'Pj4MFRUMoyCfMjqkGwCwABsVPj0GDwIMrwUREQWyDAIeHQYSEgUfCQkfBcYYMwE0BxwRCQ'.
		'0NCREcBwooPyImBiQu1y4kBgpaQgE2EwMZGQMeEEw/QQA7');
	}
	exit();
}
if (!isset($_GET['step'])) { $step = 0; } else { $step = $_GET['step']; }
$steps = array("Welcome", "Permissions Test", "Setup Database", "Initial Settings", "Admin Account", "Finish");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>paFileDB 3.6 Installer</title>
<link href="../skins/default/style.css" rel="stylesheet" type="text/css" />

<script language="javascript">
	function verify(form, mail) {
		for (i=0; i<form.elements.length; i++ ) {
			form.elements[i].focus();
			if ((form.elements[i].type=="text" || form.elements[i].type !== "textarea" || form.elements[i].type=="password") && form.elements[i].value == "") {
				alert("All fields are required. Please fill out all fields.");
				return;
			}
			if (mail == 1) {
				if (form.pass.value != form.cpass.value) {
					alert("The two passwords you entered did not match. Please go back and try again.");
					return;
				}
			}
		}

		everify(form, mail);

	}
	function everify(form, mail) {
		if (mail == 1) {
			if (form.email.value == "" || form.email.value.indexOf('@') == -1 || form.email.value.indexOf('.') == -1 || 			form.email.value.length<6) {
				alert("The e-mail address you entered is not valid. Please enter a valid e-mail address.");
				form.email.focus();
				return;
			}
		}

		form.submit();
	}
</script>
</head>

<body>
<table width="100%" cellpadding="0" cellspacing="5" border="0" align="center">
  <tr>
    <td width="15%" valign="top" align="left">       
		<table width="100%" align="left" cellpadding="3" cellspacing="0" border="0">
		  <?php
		  foreach ($steps as $k => $v) {
		  	?>
		  	<tr>
		  	  <td width="16">
		  	  	<?php
		  	  	if ($k < $step) {
		  	  		echo('<img src="index.php?img=green" alt="" />');
		  	  	} elseif ($k == $step) {
		  	  		echo('<img src="index.php?img=red" alt="" />');
		  	  	} else {
		  	  		echo('<img src="index.php?img=grey" alt="" />');
		  	  	}
		  	  	?>
		  	  </td>
		  	  <td><?php echo($v); ?></td>
		  	</tr>
		  	<?php
		  	}
		  	?>
		 </table>
	</td>
	<td width="85%" valign="top">
		<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
		  <tr class="sectionheader">
		    <td>paFileDB 3.6 Installer</td>
		  </tr>
		  <tr>
		    <td>
<?php
function contLink() {
	global $step;
	echo('<p /><div align="center"><a href="./index.php?step='.($step+1).'"><b>Continue &raquo;</b></a></div>');
}
include('../includes/adodb/adodb-errorhandler.inc.php'); 
include('../includes/adodb/adodb.inc.php');
require('../includes/config.php');
switch($step) {
	case 1:
		?>
		paFileDB is now testing file permissions. If no errors appear below,
		everything was a success! If there are errors, please visit
		<a href="http://www.phparena.net" target="_blank">PHP Arena</a> for more info
		or to open a support ticket.<p>&nbsp;</p>
		<?php
		$checkdirs = array("../skins/default/compile/");
		
		foreach ($checkdirs as $curdir)
		{
			$randfile = time() . "-" . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . ".txt";
			$ofile = fopen($curdir . $randfile, "w");
			fwrite($ofile, $curdir . $randfile);
			fclose($ofile);
			$ofile = file($curdir . $randfile);
			if ($ofile[0] != $curdir . $randfile)
			{
				echo "{$curdir} is not writable or your host is incompatible with paFileDB file commands!";
				exit;
			}
			unlink($curdir . $randfile);
		}
		
		?>
		Everything was a success! Please click Continue below to go onto the next step.
		<?php
		contLink();
		break;
	case 2:
		?>
		paFileDB is now setting up your mySQL database. If no errors appear below,
		everything was a success! If there are errors, please visit
		<a href="http://www.phparena.net" target="_blank">PHP Arena</a> for more info
		or to open a support ticket.<p>&nbsp;</p>
		<?php
		require("./read_dump.lib.php");
		$ofile = fopen("./install.sql", "r");
		$contents = fread($ofile, filesize("./install.sql"));
		fclose($ofile);
		$queries = array();
		PMA_splitSqlFile($queries, $contents, "thisdoesntmatter");
		foreach ($queries as $q) {
			$q['query'] =  str_replace("##PREFIX##", $dbPrefix, $q['query']);
			$db->Execute($q['query']);
		}
		?>
		Everything was a success! Please click Continue below to go onto the next step.
		<?php
		contLink();
		break;
	case 3:
		?>
		There is only one setting you need to change immediatley to get up and running,
		and that is the URL to where paFileDB is installed. Please enter the URL below and click
		Continue. paFileDB guessed at the installation location, however, you need to verify its
		accuracy to continue. Do not add a trailing slash at the end.<p />
		<?php
		$url = "http://{$_SERVER['HTTP_HOST']}:{$_SERVER['SERVER_PORT']}". $_SERVER['REQUEST_URI'];
		$url = str_replace(":80/", "/", $url);
		if (!(false === strpos($url, "/install/index.php")))
		{
			$url = substr($url, 0, strpos($url, "/install/index.php"));
		}
	
		?>
		<form action="index.php?step=4" method="post" name="form">
		<table width="60%" border="0" align="center" cellpadding="3" cellspacing="0">
		<tr><td width="50%">paFileDB URL:</td>
		<td width="50%">
		<input type="text" size="50" name="url" value="<?php echo $url; ?>" />
		</td></tr></table>
		<p /><div align="center"><input type="button" onclick="verify(this.form, 0);" value="Continue &raquo;" /></div>
		</form>
		<?php
		break;
	case 4:
		$_POST['url'] = preg_replace("/(\/*)$/", "", $_POST['url']);
		$db->Execute("UPDATE ".$dbPrefix."settings SET dburl = '".$_POST['url']."'");
		?>
		Now you need to create an administrator account. Please enter a username, password and e-mail address below
		to make your first admin account.<p />
		<form action="index.php?step=5" method="post" name="form">
		<table width="50%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
		<tr><td width="50%">Username:</td><td width="50%"> <input type="text" name="uname" size="50" /><br /></td></tr>
		<tr><td width="50%">Password:</td><td width="50%"> <input type="password" name="pass" size="50" /><br /></td></tr>
		<tr><td width="50%">Confirm Password:</td><td width="50%"> <input type="password" name="cpass" size="50" /><br /></td></tr>
		<tr><td width="50%">E-mail:</td><td width="50%"> <input type="text" name="email" size="50" /><br /></td></tr>
		</td></tr>
		</table>
		<p /><div align="center"><input type="button" value="Continue &raquo;" onclick="verify(this.form, 1);" /></div>
		</table>
		<?php
    	break;
    case 5:
    	$db->Execute("INSERT INTO ".$dbPrefix."users (user_username, user_password, user_email, user_status) VALUES ('".$_POST['uname']."', '".md5($_POST['pass'])."', '".$_POST['email']."', 6)");
		$time = time();
		$db->Execute("INSERT INTO ".$dbPrefix."adminnews (date, subject, text) VALUES (".$time.", 'Welcome to paFileDB 3.6!', 'Any important news regarding paFileDB will be displayed here whenever you login to your admin center. Be sure to login to your admin center every now and then to read the latest news and make sure paFileDB is up to date.')");
		$db->Execute("UPDATE ".$dbPrefix."settings SET newest_news = ".$time.", fromemail = '".$_POST['email']."'");
		?>
		You're finished installing paFileDB! In order to use paFileDB, <b>you must delete the "install" directory from your server!</b><p />
		<div align="center"><a href="../index.php">Your paFileDB Home</a> - <a href="../admin.php">Your paFileDB Admin Center</a><br />It is recommended that you login to your admin center ASAP and change paFileDB's settings to suit your needs.</div>
		<?php
    	break;
	default:
		?>
		Welcome to the paFileDB 3.6 Installer. This script will guide you through
		the setup process. Please make sure you have upload all files as outlined
		in install_guide.html, and modified config.php with your database settings. Once
		you have done all that, please click Continue below.
		<?php
		contLink();
}
?>
		    </td>
		</table>
    </td>
  </tr>
</table>
</body>
</html>