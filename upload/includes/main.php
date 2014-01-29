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

//Fetch the categories from the database and place them into an array
$categories = $db->GetArray("SELECT * FROM ".$dbPrefix."cat WHERE cat_parent = 0 ORDER BY cat_order ASC");

if ($settings[0]['dbstats'] == 1) {
	$stats = $db->GetArray("SELECT AVG(file_rating), AVG(file_totalvotes), COUNT(*), SUM(file_dls) FROM ".$dbPrefix."files");
	if ($stats[0][1] > 0) {
		$avgRating = round($stats[0][0] / $stats[0][1], 3);
	} else {
		$avgRating = 0;
	}
	$stats = str_replace(array('%RATING%', '%TOTALFILES%', '%TOTALDLS%'), array($avgRating, $stats[0][2], number_format($stats[0][3])), array(lang('stats_avgrating'), lang('stats_totalfiles'), lang('stats_totaldls')));
	$newest = $db->GetArray("SELECT file_id, file_name, file_time FROM ".$dbPrefix."files ORDER BY file_time DESC LIMIT 0,1");
	$smarty->assign('stats', $stats);
	$smarty->assign('newest', $newest[0]);
}

//Send the array and navbar to Smarty
$smarty->assign('categories', $categories);
$smarty->assign('navbar', array(array('url' => '', 'name' => $settings[0]['dbname'])));
$smarty->assign('title', $settings[0]['dbname']);


?>