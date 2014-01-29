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
$steps = array("Database Backup", "Welcome", "Setup Database", "Finish");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>paFileDB 3.6 Upgrader</title>
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
		    <td>paFileDB 3.6 Upgrader</td>
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
require('../includes/functions.php');
switch($step) {
	case 1:
		?>
		Welcome to the paFileDB Upgrader. This script upgrade your installation of paFileDB to 3.6.
		Please make sure you have upload all files as outlined
		in upgrade_guide.html, and modified config.php with your database settings. Once
		you have done all that, please select the version of paFileDB you are upgrading from:
		<form action="index.php" method="get"><p />
		<div align="center">
		<input type="hidden" name="step" value="2" />
		<select name="version">
		  <option value="3.1">3.1</option>
		  <option value="3.5">3.5</option>
		  <option value="3.5.1">3.5.1</option>
		  <option value="3.5.1">3.5.2</option>
		  <option value="3.5.3" selected="selected">3.5.3</option>
		</select><p />
		<input type="submit" value="Continue &raquo;" />
		</div>
		</form>
		<?php
		break;
	case 2:
		?>
		paFileDB is now modifying your database. If no errors appear below,
		everything was a success! If there are errors, please visit
		<a href="http://www.phparena.net" target="_blank">PHP Arena</a> for more info
		or to open a support ticket.</a><p />
		<?php
		require("./read_dump.lib.php");
		$ofile = fopen("./".$_GET['version'].".sql", "r");
		$contents = fread($ofile, filesize("./".$_GET['version'].".sql"));
		fclose($ofile);
		$queries = array();
		PMA_splitSqlFile($queries, $contents, "thisdoesntmatter");
		foreach ($queries as $q) {
			$q['query'] =  str_replace("##PREFIX##", $dbPrefix, $q['query']);
			$db->Execute($q['query']);
		}
		if ($_GET['version'] == '3.1') {
			$db->Execute("UPDATE ".$dbPrefix."files SET file_rating = 0, file_totalvotes = 0");
			$db->Execute("UPDATE ".$dbPrefix."files SET file_posticon = '' WHERE file_posticon = 'none'");
		}
		if (version_compare($_GET['version'], '3.1', '>') && version_compare($_GET['version'], '3.6', '<')) {
			$license = $db->GetArray("SELECT * FROM ".$dbPrefix."license");
			foreach ($license as $l) {
				$db->Execute("UPDATE ".$dbPrefix."license SET license_text = '".addslashes(base64_decode($l['license_text']))."' WHERE license_id = ".$l['license_id']);
			}
		}
		if (version_compare($_GET['version'], '3.6', '<')) {
			$admins = $db->GetArray("SELECT * FROM ".$dbPrefix."admin");
			foreach ($admins as $a) {
				$db->Execute("INSERT INTO ".$dbPrefix."users (user_username, user_password, user_email, user_status) VALUES ('".$a['admin_username']."', '".$a['admin_password']."', '".$a['admin_email']."', ".($a['admin_status']+3).")");
			}
			$db->Execute("DROP TABLE ".$dbPrefix."admin");
			$time = time();
			$db->Execute("INSERT INTO ".$dbPrefix."adminnews (date, subject, text) VALUES (".$time.", 'Welcome to paFileDB 3.6!', 'Any important news regarding paFileDB will be displayed here whenever you login to your admin center. Be sure to login to your admin center every now and then to read the latest news and make sure paFileDB is up to date.')");
			$db->Execute("UPDATE ".$dbPrefix."settings SET comments_perpage = 20, newest_news = ".$time);
		}
		$db->Execute("UPDATE ".$dbPrefix."settings SET skin = 'default'");
		rebuildDrop();
		?>
		Everything was a success! Please click Continue below to go onto the next step.
		<?php
		contLink();
		break;
    case 3:
		?>
		You're finished upgrading paFileDB! In order to use paFileDB, <b>you must delete the "upgrade" directory from your server!</b><p />
		<div align="center"><a href="../index.php">Your paFileDB Home</a> - <a href="../admin.php">Your paFileDB Admin Center</a><br />It is recommended that you login to your admin center ASAP and change paFileDB's settings to suit your needs.</div>
		<?php
    	break;
	default:
		?>
		<B>WARNING!</b> The paFileDB upgrader has been thoroughly tested to make sure it works perfectly. However, things in the computing world go wrong for no reason at all, and the paFileDB upgrader is no different. To prevent any risk of data loss, it is a good idea to make a backup of your database before proceeding. The upgrader makes many changes to your existing paFileDB database, and if something were to go wrong in the middle of the upgrade process, you may be left with a corrupt, unrepairable database. Please note that the chance of anything bad actually happening is <b>extremely rare</b>, however, it's better to be safe than sorry. Everyone's best friend, Google, <a href="http://www.google.com/search?hl=en&lr=&q=creating+a+mysql+database+backup&btnG=Search" target="_blank">can tell you how to create a MySQL backup</a>. <a href="http://www.phpmyadmin.net" target="_blank">phpMyAdmin</a> can also make a backup of your database. It is highly recommended that you create a backup before proceeding with the ugprade process.<p />
		<div align="center"><a href="index.php?step=1"><b>By clicking on this link to procede with the upgrade process, I promise that I have read the above and have either made a backup or am willing to take the risk without a backup</b></a></div>
		<?php
}
?>
		    </td>
		</table>
    </td>
  </tr>
</table>
</body>
</html>