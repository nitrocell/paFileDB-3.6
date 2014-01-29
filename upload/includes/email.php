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

//E-mail feature is disabled. Naughty spammer!
if ($settings[0]['enable_email'] == 0) {
    smarty_error(lang('feature_disabled'));
}

//Get file info
$file = $db->GetArray("SELECT * FROM ".$dbPrefix."files WHERE file_id = ".intval($_GET['id']));
if (count($file) == 0) {
    smarty_error(lang('file_exist'));
}
$file = $file[0];
    
//Send the mail
if (isset($_GET['process'])) {
    if (!check_input($_POST)) {
        smarty_error(lang('emptyfield'));
    }
    
    //Make sure the "from" address is valid
        if (!eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$', $_POST['fromemail'])) {
            smarty_error(lang('emailinvalid'));
        }
        if (!eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$', $_POST['toemail'])) {
            smarty_error(lang('emailinvalid'));
        }
        $message = 'Dear '.$_POST['toname'].":\n\n";
        $message .= $_POST['fromname'].'('.$_POST['fromemail'].') sent this file to you from '.$settings[0]['dbname'].".\n\n";
        $message .= "File: ".$file['file_name']."\n";
        $message .= "Description: ".$file['file_desc']."\n";
        $message .= "Please visit this link to download the file:\n";
        $message .= $settings[0]['dburl'].'/index.php?act=view&id='.$_GET['id']."\n\n";
        $message .= $_POST['fromname']." has included this message:\n";
        $message .= $_POST['message']."\n\n";
        $message .= "Please note that ".$settings[0]['dbname']." cannot be held responsible for the contents of this message. To report abuse, please visit ".$settings[0]['dburl'];
        $to = array(array("name" => $_POST['toname'], "address" => $_POST['toemail']));
        pafiledb_mail($_POST['fromname'], $_POST['fromemail'], $to, $_POST['fromname'].' wants you to check out a file!', $message);
    
        smarty_redirect(lang('email_sent'), 'index.php?act=view&amp;id='.$_GET['id']);
}

$smarty->assign('id', $_GET['id']);
//Fetch the category info from the database
// Generate the navbar. We're using the dropdown cache to save
// system resources.
$navbar = array();
$navbar[] = array('name' => lang('emailfriend'), 'url' => '');
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

?>