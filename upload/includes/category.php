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


//Get the category info; we need the category name for page title and navbar
$category = $db->GetArray("SELECT * FROM ".$dbPrefix."cat WHERE cat_id = ".intval($_GET['id']));
if (count($category) == 0) {
    smarty_error(lang('category_exist'));
}

$sort = explode('|', $category[0]['cat_sort']); //set default sort options

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

$files = $db->GetArray("SELECT * FROM ".$dbPrefix."files WHERE file_catid = ".intval($_GET['id'])." ORDER BY file_pin DESC, file_".$sort[0]." ".$sort[1]);


if (!isset($_GET['start'])) { $start = 1; } else { $start = intval($_GET['start']); }


//Subcategory stuff. PITA!
$subs = $db->GetArray("SELECT * FROM ".$dbPrefix."cat WHERE cat_parent = ".intval($_GET['id'])." ORDER BY cat_order ASC");
$smarty->assign('hassubs', count($subs) > 0 ? true : false);
$smarty->assign('subs', $subs);
$smarty->assign('subcats', $subs);

// Generate the navbar. We're using the dropdown cache to save
// system resources.
$navbar = array();
$allcats = unserialize($settings[0]['dropdown']);
$tempcat = $category[0]['cat_id'];
$templvl = -1; // 0 = start. We need to identify that this hasn't been set so -1 works :)
for($x = count($allcats)-1; $x >= 0; $x--)
{
 // Step #1 - Determine the level of the current category
 // and then work our way down.
 if ($templvl == -1 && $allcats[$x]['id'] == $tempcat)
 {
  $navbar[] = array('name' => $allcats[$x]['name'], 'url' => '?act=category&amp;id='.$allcats[$x]['id']);
  $templvl = $allcats[$x]['sub']-1;
 }
 else if ($templvl != -1 && $allcats[$x]['sub'] == $templvl)
 {
  $navbar[] = array('name' => $allcats[$x]['name'], 'url' => '?act=category&amp;id='.$allcats[$x]['id']);
  $templvl--;
  if ($templvl == -1)
  {
   break;
  }
 }
}
$navbar[] = array('name' => $settings[0]['dbname'], 'url' => '');

// And then we reverse it for paFileDB
$navbar = array_reverse($navbar);
$smarty->assign('navbar', $navbar);

// We already handled the recursion so let's cheat and use it like a cache for the titlebar.
$title = array();
foreach ($navbar as $c)
{
  $title[] = $c['name'];
}
$smarty->assign('title', implode(' &raquo; ', $title));

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
$smarty->assign('id', $_GET['id']);
$smarty->assign('count', count($files));

?>