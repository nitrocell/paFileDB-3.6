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

if ($settings[0]['require_registration'] == 2 && $userinfo[0]['user_userid'] == 0) {
	$logreg = '<br /><br /><a href="'.$settings[0]['dburl'].'/index.php?act=login&qs='.urlencode($_SERVER['QUERY_STRING']).'">'.lang('login').'</a> - <a href="'.$settings[0]['dburl'].'/index.php?act=register">'.lang('register').'</a>';
	smarty_error(lang('login_download').$logreg);
} 

//Fetch the file info from the database
$file = $db->GetArray("SELECT * FROM ".$dbPrefix."files WHERE file_id = ".intval($_GET['id']));
if (count($file) == 0) {

    smarty_error(lang('file_exist'));
}
$file = $file[0];

$license = $db->GetArray("SELECT * FROM ".$dbPrefix."license WHERE license_id = ".$file['file_license']);

//Fetch the category info from the database
// Generate the navbar. We're using the dropdown cache to save
// system resources.
$navbar = array();
$navbar[] = array('name' => lang('license_a'), 'url' => '');
$navbar[] = array('name' => $file['file_name'], 'url' => '?act=view&amp;id='.intval($_GET['id']));
$allcats = unserialize($settings[0]['dropdown']);
$tempcat = $file['file_catid'];
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

$mirrors = unserialize($file['file_mirrors']);
if (is_array($mirrors)) {
    $smarty->assign('has_mirrors', true);
} else {
    $smarty->assign('has_mirrors', false);
}
$smarty->assign('file', $file);
$smarty->assign('license', $license[0]);


?>