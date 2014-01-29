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


//Require the important files so paFileDB isn't paUselessScript
require('./includes/smarty/Smarty.class.php');
require('./includes/functions.php');
include('./includes/adodb/adodb-errorhandler.inc.php'); 
include('./includes/adodb/adodb.inc.php');
require('./includes/config.php');

//Load paFileDB settings into $settings array
$settings = $db->GetArray("SELECT * FROM ".$dbPrefix."settings");

//This stops any l33t h4x0ring of paFileDB. Just an extra security measure
$allowed_acts = array('rate', 'postcomment', 'deletecomment', 'editcomment', 'savecomment');
$act = $_GET['act'];
if (!in_array($act, $allowed_acts))
{
    die("Invalid Action!");
}
//Get Smarty set up and load the right language file
$smarty = new Smarty();
$smarty->config_booleanize = false;
init_smarty($settings[0]['skin']);
$smarty->config_load('english.conf');
if ($settings[0]['lang'] != "english") { $smarty->config_load($settings[0]['lang'].'.conf'); }
$smarty->config_load('config.conf');
$smarty->assign('settings', $settings[0]);
require('./includes/auth.php');

if ($act == "rate") {
	if (!isset($_GET['file']) OR !isset($_GET['rating'])) { die("Invalid"); }
	if ($_GET['rating'] > 0 && $_GET['rating'] <= 5 && intval($_GET['rating']) == true) {
		$rated_array = array();
    	if (isset($_COOKIE['pafiledb_rate'])) {
        	$rated_array = explode('|', $_COOKIE['pafiledb_rate']);
        	if (in_array($_GET['file'], $rated_array)) {
            	//die("Already rated");
        	}
    	}
    	$db->Execute("UPDATE ".$dbPrefix."files SET file_rating = file_rating + ".intval($_GET['rating']).", file_totalvotes = file_totalvotes + 1 WHERE file_id = ".intval($_GET['file']));
    
    	$rated_array[] = $_GET['file'];
    	setcookie('pafiledb_rate', implode('|', $rated_array), time()+63072000);
    	$file = $db->GetArray("SELECT * FROM ".$dbPrefix."files WHERE file_id = ".intval($_GET['file']));
		$file = $file[0];
    	/* Calculate the file rating and round it off. The if/else
		statement prevents a divide by zero. If the number of ratings 
		is zero, no work has to be done, since obviously, the file's
		rating is zero. */
		if($file['file_totalvotes'] > 0)
		{
			$f_rating = $file['file_rating'] / $file['file_totalvotes'];
			$rating_round_half = round($f_rating / 0.5) * 0.5;
			$remainder = fmod($rating_round_half, 1);
			$whole_rating = (int) $rating_round_half - $remainder; //Rating rounded to whole number
			$half_star = $remainder == 0.5; //True if the rating needs a half star
		} else {
			$whole_rating = (int) 0;
			$half_star = false;
		}
		
		/* The rating is displayed using whole and half stars. So if the
		rating is 2.5, it shows 2 full stars, 1 half star, and then 2
		grey stars at the end (just to make it look pretty). This code
		sets up an array with the file names of the star gifs to use */
		$stars = array();
		
		//Add X amount of stars (where X is whole number of the rating)
		for ($i=0; $i<$whole_rating; $i++)
		{
			$stars[] = 'star_full.gif';
		}
		
		//If a half star is needed, add it to the array
		if ($half_star) {
			$stars[] = 'star_half.gif';
		}
		
		//Fill in the remaining grey stars
		$remaining = 5 - count($stars);
		for ($j=0; $j<$remaining; $j++)
		{
			$stars[] = 'star_grey.gif';
		}
		
		$smarty->assign('file', $file);
		$smarty->assign('stars', $stars);
		$smarty->assign('already_rated', true);
    	$smarty->display('view_rating.tpl');
    }
} else if ($act == "postcomment") {
	
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
	
	//Strip out bad HTML
	$commentText = strip_tags($_POST['comment'], "<p><strong><b><em><i><strike><u><font><ul><li><ol><blockquote><a><img><sub><sup>");
	include('./includes/class.inputfilter.php');
	$htmlFilter = new InputFilter(array(), array(), 1, 1);
	$commentText = $htmlFilter->process($commentText);
	if ($_POST['tMCEused'] == 0) {
		$commentText = str_replace("\n", "<br />", $commentText);
	}
	
	//Insert into DB
	$db->Execute("INSERT INTO ".$dbPrefix."comments (comment_userid, comment_fileid, comment_time, comment_subject, comment_ip, comment_text) VALUES (".$userinfo[0]['user_userid'].", ".intval($_GET['file']).", ".time().",  '".xhtml_convert($_POST['subject'])."', '".$_SERVER['REMOTE_ADDR']."', '".smart_slashes($commentText)."')");
	$newID = $db->Insert_ID();
	
	//Get the new comment from the DB and display the comment template and javascript will handle the rest
	$comments = $db->GetArray("SELECT * FROM ".$dbPrefix."comments LEFT JOIN ".$dbPrefix."users ON ".$dbPrefix."comments.comment_userid = ".$dbPrefix."users.user_userid WHERE comment_id = ".$newID);
	$smarty->assign('c', $comments[0]);
	$smarty->display('comment.tpl');

} else if ($act == "deletecomment") {
	
	//Must be >=mod to delete, check that
	if ($userinfo[0]['user_status'] < 4) {
		exit();
	}
	$db->Execute("DELETE FROM ".$dbPrefix."comments WHERE comment_id = ".intval($_GET['comment']));
	
	//We're echoing out the comment ID to Javascript so it knows which DIV to hide
	echo $_GET['comment'];

} else if ($act == "editcomment") {

	//Get the comment info to fill in the form fields
	$comment = $db->GetArray("SELECT * FROM ".$dbPrefix."comments LEFT JOIN ".$dbPrefix."users ON ".$dbPrefix."comments.comment_userid = ".$dbPrefix."users.user_userid WHERE comment_id = ".intval($_GET['comment']));
	
	//Figure out if we're allowed to edit or not
	if (($userinfo[0]['user_userid'] != $comment[0]['user_userid'] && $userinfo[0]['user_status'] < 4) || $userinfo[0]['user_userid'] == 0) {
		smarty_error(lang('perm_denied'));
	}
	if ($_GET['tMCEused'] == 0) {
		$comment[0]['comment_text'] = str_replace("<br />", "\n", $comment[0]['comment_text']);
		
	}
	//Smarty stuff
	$smarty->assign('comment', $comment[0]);
	$smarty->assign('c', 'ajaxedit');
	$smarty->display('comments.tpl');
	
} else if ($act == "savecomment") {
	
	//Check to see if we're allowed to edit
	$comment = $db->GetArray("SELECT * FROM ".$dbPrefix."comments LEFT JOIN ".$dbPrefix."users ON ".$dbPrefix."comments.comment_userid = ".$dbPrefix."users.user_userid WHERE comment_id = ".intval($_GET['id']));
	if (($userinfo[0]['user_userid'] != $comment[0]['user_userid'] && $userinfo[0]['user_status'] < 4) || $userinfo[0]['user_userid'] == 0) {
		smarty_error(lang('perm_denied'));
	}
	
	
	//Strip out bad HTML
	$commentText = strip_tags($_POST['comment'], "<p><br><strong><b><em><i><strike><u><font><ul><li><ol><blockquote><a><img><sub><sup>");
	if ($_POST['tMCEused'] == 0) {
		$commentText = str_replace("\n", "<br />", $commentText);
	}
	include('./includes/class.inputfilter.php');
	$htmlFilter = new InputFilter(array(), array(), 1, 1);
	$commentText = $htmlFilter->process($commentText);
	
	//Update, and echo out updated comment so JS can display it
	$db->Execute("UPDATE ".$dbPrefix."comments SET comment_subject = '".xhtml_convert($_POST['subject'])."', comment_text = '".smart_slashes($commentText)."' WHERE comment_id = ".intval($_GET['id']));
	$comment[0]['comment_subject'] = xhtml_convert($_POST['subject']);
	$comment[0]['comment_text'] = $commentText;
	$smarty->assign('c', $comment[0]);
	$smarty->assign('hidediv', true);
	$smarty->display('comment.tpl');
}
?>