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

//Thanks to MenthiX and markg85 from the PHP Arena forums for the rating exploit fix
if (isset($_GET['rate']) && ($_POST['rating'] > 0 && $_POST['rating'] <= 5 && intval($_POST['rating']) == true)) { //Rate file  
    
    /* So users can't rate files more than once, paFileDB sends them a cookie that
    keeps track of what files they rated. This code updates the cookie. */
    $rated_array = array();
    if (isset($_COOKIE['pafiledb_rate'])) {
        $rated_array = explode('|', $_COOKIE['pafiledb_rate']);
        if (in_array($_GET['id'], $rated_array)) {
            smarty_error(lang('rate_error'));
        }
    }
    
    /* Update the file with the new rating. A note on how ratings work:
    The rating system used by paFileDB may be different than other scripts.
    When a file is rated, the rating chosen (1-5) is added to the existing
    rating in the database. So lets say, 7 users rate the file, with ratings of
    1, 4, 2, 5, 4, 3, 5. A total is kept, and for this file, it would be 24.
    That number is then divided by the number of times the file was rated.
    24 / 7 is 3.42857, and is then rounded to 3.5 to display 3 and a half stars
    on the page. */
    $db->Execute("UPDATE ".$dbPrefix."files SET file_rating = file_rating + ".intval($_POST['rating']).", file_totalvotes = file_totalvotes + 1 WHERE file_id = ".intval($_GET['id']));
    
    $rated_array[] = $_GET['id'];
    setcookie('pafiledb_rate', implode('|', $rated_array), time()+63072000);
    smarty_redirect(lang('rate_redir'), 'index.php?act=view&amp;id='.$_GET['id']);

}

//Fetch the file info from the database
$file = $db->GetArray("SELECT * FROM ".$dbPrefix."files WHERE file_id = ".intval($_GET['id']));
if (count($file) == 0) {

    smarty_error(lang('file_exist'));
}
$file = $file[0];

//Fetch the category info from the database
// Generate the navbar. We're using the dropdown cache to save
// system resources.
$navbar = array();
$navbar[] = array('name' => $file['file_name'], 'url' => '');
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

/* Check to see if the user already rated the file, if
they didn't, we tell Smarty so it can show the rating dropdown menu */
$already_rated = false;
if (isset($_COOKIE['pafiledb_rate'])) {
    $rated_q = explode('|', $_COOKIE['pafiledb_rate']);
    if (in_array($_GET['id'], $rated_q)) {
      $already_rated = true;
    }
}

$file['file_time'] = $file['file_time']+($settings[0]['timeoffset']*3600);
if ($file['file_last'] > 0) {
    $file['file_last'] = $file['file_last']+($settings[0]['timeoffset']*3600);
}

/* Handle tags */
$tags = "";
$tagArray = array();
if (!empty($file['file_tags'])) {
	$fileTags = explode(" ", $file['file_tags']);
	foreach ($fileTags as $f) {
		$tagArray[] = '<a href="'.$settings[0]['dburl'].'/index.php?act=viewtag&tag='.$f.'">'.$f.'</a>';
	}
	$tags = implode(', ', $tagArray);
}
$smarty->assign('tags', $tags);
	

$mirrors = unserialize($file['file_mirrors']);
if (is_array($mirrors)) {
    $smarty->assign('has_mirrors', true);
} else {
    $smarty->assign('has_mirrors', false);
}
$custom = $db->GetArray("SELECT * FROM ".$dbPrefix."customdata LEFT JOIN ".$dbPrefix."custom ON ".$dbPrefix."customdata.customdata_custom = ".$dbPrefix."custom.custom_id WHERE customdata_file = ".intval($_GET['id'])." ORDER BY customdata_custom ASC");

if (!isset($_GET['start'])) { $start = 1; } else { $start = intval($_GET['start']); }
$comments = $db->GetArray("SELECT * FROM ".$dbPrefix."comments LEFT JOIN ".$dbPrefix."users ON ".$dbPrefix."comments.comment_userid = ".$dbPrefix."users.user_userid WHERE comment_fileid = ".intval($_GET['id'])." ORDER BY comment_time ASC");
list($c, $pages) = paginate($comments, $start, $settings[0]['comments_perpage']);

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

/* Apple, I love your products and company, which is proven by my 2 Macs, several iPods purchased
over the fact that I go around preaching the awesomeness of OSX. But your browser sucks and can't
decently support a WYSIWYG editor or AJAX for that matter. 

For those of you that want to get adventerous with this code or Safari's useragent switcher in
the debug menu, go right ahead, but you'll find both WYSIWYG and AJAX support to be VERY flaky.
Try again when Leopard comes around and maybe I'll remove this code 

Camino > *

*/
if(eregi("safari", $_SERVER['HTTP_USER_AGENT'])){
	$isSafari = true;
} else {
	$isSafari = false;
}
$smarty->assign('isSafari', $isSafari);
$smarty->assign('enablecomments', $enableComments);
$smarty->assign('custom', $custom);
$smarty->assign('file', $file);
$smarty->assign('stars', $stars);
$smarty->assign('already_rated', $already_rated);
$smarty->assign('comments', $c);
$smarty->assign('ccount', count($comments));
$smarty->assign('pages', $pages);
?>