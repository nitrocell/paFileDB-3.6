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

if ($settings[0]['dbstats'] == 0) {
	smarty_error(lang('stats_disabled'));
}

$stats = $db->GetArray("SELECT AVG(file_rating), AVG(file_totalvotes), COUNT(*), SUM(file_dls) FROM ".$dbPrefix."files");


if ($stats[0][1] > 0) {
	$avgRating = round($stats[0][0] / $stats[0][1], 3);
} else {
	$avgRating = 0;
}
$stats = str_replace(array('%RATING%', '%TOTALFILES%', '%TOTALDLS%'), array($avgRating, $stats[0][2], number_format($stats[0][3])), array(lang('stats_avgrating'), lang('stats_totalfiles'), lang('stats_totaldls')));
$newest = $db->GetArray("SELECT file_id, file_name, file_time FROM ".$dbPrefix."files ORDER BY file_time DESC LIMIT 0,1");


/*stats_highestrated = The highest rated file is %LINK% with a rating of %RATING% out of 5 stars
stats_lowestrated = The lowest rated file is %LINK% with a rating of %RATING% out of 5 stars
stats_mostdownloaded = The most downloaded file is %LINK% with %DOWNLOADS% downloads
stats_leastdownloaded = The least downloaded file is %LINK% with %DOWNLOADS% downloads
stats_avgdls = The average number of downloads each file has is %DOWNLOADS%*/

$highest = $db->GetArray("SELECT file_id, file_name, file_rating, file_totalvotes FROM ".$dbPrefix."files WHERE file_totalvotes > 0 ORDER BY file_rating/file_totalvotes DESC LIMIT 0,1");
if (count($highest) > 0) {
	$stats[] = str_replace(array('%LINK%', '%RATING%'), array('<a href="'.$settings[0]['dburl'].'/index.php?act=view&id='.$highest[0]['file_id'].'">'.$highest[0]['file_name'].'</a>', round($highest[0]['file_rating'] / $highest[0]['file_totalvotes'],3)), lang('stats_highestrated'));
}

//The WHERE file_totalvotes > 0 is neccesary to prevent a divide by zero. It leaves out files with zero votes,
//and we probably only care about files that have been rated.
$lowest = $db->GetArray("SELECT file_id, file_name, file_rating, file_totalvotes FROM ".$dbPrefix."files WHERE file_totalvotes > 0 ORDER BY file_rating/file_totalvotes ASC LIMIT 0,1");

if (count($lowest) > 0) {
	$stats[] = str_replace(array('%LINK%', '%RATING%'), array('<a href="'.$settings[0]['dburl'].'/index.php?act=view&id='.$lowest[0]['file_id'].'">'.$lowest[0]['file_name'].'</a>', round($lowest[0]['file_rating'] / $lowest[0]['file_totalvotes'],3)), lang('stats_lowestrated'));
}

$mostdl = $db->GetArray("SELECT file_id, file_name, file_dls FROM ".$dbPrefix."files ORDER BY file_dls DESC LIMIT 0,1");
$stats[] = str_replace(array('%LINK%', '%DOWNLOADS%'), array('<a href="'.$settings[0]['dburl'].'/index.php?act=view&id='.$mostdl[0]['file_id'].'">'.$mostdl[0]['file_name'].'</a>', number_format($mostdl[0]['file_dls'])), lang('stats_mostdownloaded'));

$leastdl = $db->GetArray("SELECT file_id, file_name, file_dls FROM ".$dbPrefix."files ORDER BY file_dls ASC LIMIT 0,1");
$stats[] = str_replace(array('%LINK%', '%DOWNLOADS%'), array('<a href="'.$settings[0]['dburl'].'/index.php?act=view&id='.$leastdl[0]['file_id'].'">'.$leastdl[0]['file_name'].'</a>', number_format($leastdl[0]['file_dls'])), lang('stats_leastdownloaded'));

$avgdls = $db->GetArray("SELECT AVG(file_dls) FROM ".$dbPrefix."files");
$stats[] = str_replace('%DOWNLOADS%', number_format($avgdls[0][0], 3), lang('stats_avgdls'));


$smarty->assign('navbar', array(array('name' => $settings[0]['dbname'], 'url' => ''), array('name' => lang('stats'), 'url' => '?act=stats')));
$smarty->assign('title', $settings[0]['dbname']." &raquo; ".lang('stats'));
$smarty->assign('stats', $stats);
$smarty->assign('newest', $newest[0]);

?>