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

if ($_GET['c'] == "post") {
	//Figure out if we're allowed to post comments or not
	if ($settings[0]['enable_comments'] == 0) {
		$enableComments = false;
	} else if ($settings[0]['enable_comments'] == 1 && $settings[0]['guest_comments'] == 1) {
		$enableComments = true;
	} else if ($settings[0]['enable_comments'] == 1 && $settings[0]['guest_comments'] == 0) {
		if ($userinfo[0]['user_status'] > 2) {
			$enableComments = true;
		} else {
			$enableComments = false;
		}
	}
	if (!$enableComments) { exit(); }
	if (!check_input($_POST)) {
		smarty_error(lang('emptyfield'));
    }
    
    //Strip out bad HTML
    $commentText = strip_tags($_POST['comment'], "<p><strong><b><em><i><strike><u><font><ul><li><ol><blockquote><a><img><sub><sup>");
	include('./includes/class.inputfilter.php');
	$htmlFilter = new InputFilter(array(), array(), 1, 1);
	$commentText = $htmlFilter->process($commentText);
    
    //Insert and redirect
    $db->Execute("INSERT INTO ".$dbPrefix."comments (comment_userid, comment_fileid, comment_time, comment_subject, comment_ip, comment_text) VALUES (".$userinfo[0]['user_userid'].", ".intval($_GET['file']).", ".time().",  '".xhtml_convert($_POST['subject'])."', '".$_SERVER['REMOTE_ADDR']."', '".smart_slashes(str_replace("\n", "<br />", $commentText))."')");
    smarty_redirect(lang('post_comment_redir'), 'index.php?act=view&id='.$_GET['file']);

} else if ($_GET['c'] == "delete") {
	
	//Only mods or greater can delete, check that
	if ($userinfo[0]['user_status'] < 4) {
		smarty_error(lang('perm_denied'));
	}
	
	//Delete and redirect
	if (isset($_GET['process'])) {
		$db->Execute("DELETE FROM ".$dbPrefix."comments WHERE comment_id = ".intval($_GET['id']));
		smarty_redirect(lang('delete_comment_redir'), 'index.php?act=view&id='.$_GET['file']);
	}
	
	//Grab comment info to display on confirmation page
	$comments = $db->GetArray("SELECT * FROM ".$dbPrefix."comments LEFT JOIN ".$dbPrefix."users ON ".$dbPrefix."comments.comment_userid = ".$dbPrefix."users.user_userid WHERE comment_id = ".intval($_GET['id']));
	$smarty->assign('comment', $comments[0]);

} else if ($_GET['c'] == "edit") {
	
	//Grab comment info
	$comment = $db->GetArray("SELECT * FROM ".$dbPrefix."comments LEFT JOIN ".$dbPrefix."users ON ".$dbPrefix."comments.comment_userid = ".$dbPrefix."users.user_userid WHERE comment_id = ".intval($_GET['id']));
	
	//To edit, the user either has to be a mod or higher, or be the one who posted, check that...
	if (($userinfo[0]['user_userid'] != $comment[0]['user_userid'] && $userinfo[0]['user_status'] < 4) || $userinfo[0]['user_userid'] == 0) {
		smarty_error(lang('perm_denied'));
	}
	if (isset($_GET['process'])) {
	
		//Strip out HTML
		$commentText = strip_tags($_POST['comment'], "<p><strong><b><em><i><strike><u><font><ul><li><ol><blockquote><a><img><sub><sup>");
		include('./includes/class.inputfilter.php');
		$htmlFilter = new InputFilter(array(), array(), 1, 1);
		$commentText = $htmlFilter->process($commentText);
		$db->Execute("UPDATE ".$dbPrefix."comments SET comment_subject = '".xhtml_convert($_POST['subject'])."', comment_text = '".smart_slashes(str_replace("\n", "<br />", $commentText))."' WHERE comment_id = ".intval($_GET['id']));
		smarty_redirect(lang('edit_comment_redir'), 'index.php?act=view&id='.$comment[0]['comment_fileid']);
	}
	
	//Replace <br /> tags with newlines so it displays in the textarea properly
	$comment[0]['comment_text'] = str_replace("<br />", "\n", $comment[0]['comment_text']);
	$smarty->assign('comment', $comment[0]);
}
if(eregi("safari", $_SERVER['HTTP_USER_AGENT'])){
	$isSafari = true;
} else {
	$isSafari = false;
}
$smarty->assign('isSafari', $isSafari);
$smarty->assign('c', $_GET['c']);
$smarty->assign('navbar', array(array('name' => $settings[0]['dbname'], 'url' => ''), array('name' => lang('comments'), 'url' => '?act=register')));
$smarty->assign('title', $settings[0]['dbname'].' &raquo; '.lang('comments'));
?>