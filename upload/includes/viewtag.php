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

//Get the files in the category from the database

$sort = array('time', 'DESC');

//See if user sorting is on
if ($settings[0]['sort_override'] == 1) {
	//Sort options submitted, set cookie and current sort settings
	if (isset($_GET['sort'])) {
		$sort[0] = $_POST['sortby'];
		$sort[1] = $_POST['order'];
		setcookie('pafiledb_sort', $_POST['sortby'].'|'.$_POST['order'], time()+63072000);
	}
	//No options submitted, pull from existing cookie if it exists
	else if (isset($_COOKIE['pafiledb_sort'])) {
		$sort = explode('|', $_COOKIE['pafiledb_sort']);
	}
	//Prevent SQL injections and whatnot by making sure the user's sort optiosn only match what's allowed
	if (!in_array($sort[0], array('name', 'dls', 'time')) OR !in_array($sort[1], array('DESC', 'ASC'))) {
		$sort = explode('|', $category[0]['cat_sort']);
	}
	//If sort options were not submitted, and there's no cookie, then the $sort array
	//exploded from the category table will still be set from before
}

$files = $db->GetArray("SELECT * FROM ".$dbPrefix."files WHERE file_tags LIKE '% ".smart_slashes($_GET['tag'])." %' OR file_tags LIKE '".smart_slashes($_GET['tag'])." %' OR file_tags LIKE '% ".smart_slashes($_GET['tag'])."' ORDER BY file_pin DESC, file_".$sort[0]." ".$sort[1]);


if (!isset($_GET['start'])) { $start = 1; } else { $start = intval($_GET['start']); }

$smarty->assign('navbar', array(array('name' => $settings[0]['dbname'], 'url' => ''), array('name' => lang('view_tag').": ".$_GET['tag'], 'url' => '?act=viewall')));
$smarty->assign('title', $settings[0]['dbname']." &raquo; ".lang('view_tag').": ".$_GET['tag']);

foreach ($files as $k => $v) {
  $files[$k]['file_time'] = $files[$k]['file_time'] + ($settings[0]['timeoffset']*3600);
  if ($settings[0]['quickdl'] == 1) {
  	if ($files[$k]['file_license'] > 0) {
  		$files[$k]['qdl'] = $settings[0]['dburl'].'/index.php?act=license&id='.$files[$k]['file_id'];
  	} elseif (is_array(unserialize($files[$k]['file_mirrors']))) {
  		$files[$k]['qdl'] = $settings[0]['dburl'].'/index.php?act=mirror&id='.$files[$k]['file_id'];
  	} else {
  		$files[$k]['qdl'] = $settings[0]['dburl'].'/index.php?act=download&id='.$files[$k]['file_id'];
  	}
  }
}

//Split the data into pages and get the data for the page we're viewing
list($f, $pages) = paginate($files, $start, $settings[0]['perpage']);

//Assign stuff to Smarty
$smarty->assign('sort_val', array('name', 'dls', 'time'));
$smarty->assign('sort_name', array(lang('name'), lang('downloads'), lang('date_added')));
$smarty->assign('order_val', array('DESC', 'ASC'));
$smarty->assign('order_name', array(lang('descending'), lang('ascending')));
$smarty->assign('cursort', $sort[0]);
$smarty->assign('curorder', $sort[1]);
$smarty->assign('files', $f);
$smarty->assign('pages', $pages);
$smarty->assign('count', count($files));

?>