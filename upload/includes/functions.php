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


/**
  * The init_smarty() function sets up the Smarty template
  * class by setting the variables required.
  *
  * Parameters:
  *  $smarty_skin: The current skin in use
  */ 
function init_smarty($smarty_skin)
{
    global $smarty;
    $smarty->template_dir = './skins/'.$smarty_skin.'/templates';
    $smarty->compile_dir = './skins/'.$smarty_skin.'/compile';
    $smarty->cache_dir = './skins/'.$smarty_skin.'/cache';
    $smarty->config_dir = array('./lang/', './skins/'.$smarty_skin.'/configs');
}


/**
  * smarty_error() will display an error using the skin's error
  * template. Then, it will exit execution of paFileDB.
  *
  * Parameters:
  *  $message: The error message to display
  */
function smarty_error($message)
{
    global $smarty;
    $smarty->assign('message', $message);
    $smarty->display('error.tpl');
    die();
}

/**
  * smarty_redirect() will display a message and then redirect
  * the user to the url after a few seconds.
  *
  * Parameters:
  *  $message: The message to show the user
  *  $url: The URL to redirect to. If blank, will redir to index.php
  *  $ext: set to true if the link is an external link. If false
  *   the paFileDB URL from the settings will be added to the URL,
  *   since the script will usually just pass in 'index.php?blah'
  *   as the URL. However, if the URL passed in is
  *   http://www.blah.com, you don't want the paFileDB URL added
  *   before it, so set $ext to true.
  */
function smarty_redirect($message, $url='index.php', $ext=false) {
    global $smarty, $settings;
    $smarty->assign('message', $message);
    if ($ext) {
        $smarty->assign('url', $url);
    } else {
        $smarty->assign('url', $settings[0]['dburl'].'/'.$url);
    }
    $smarty->display('redirect.tpl');
    exit();
}

/**
  * pafiledb_mail() will send an e-mail using the proper headers since
  * PHP's mail() does not use the right headers, sometimes causing
  * spam blockers to block the e-mail. The function will return true
  * or false depending if sending the mail was a success. Additonally,
  * it will add an entry to paFileDB's e-mail log containing the details
  * of the e-mail that was sent.
  *
  * This function taken from the php.net documentation comments for mail().
  * Thanks to whoever wrote it.
  *
  * Parameters:
  *  $fromname: Name of the sender
  *  $fromaddress: E-mail address of the sender
  *  $to: Recipients of the e-mail in a 2D array: 
       Ex: $to = array(array("name" => "foo", "address" => "foo@foobar.com"),
                       array("name" => "bar", "address" => "bar@foobar.com"));
  *  $subject: The subject of the e-mail
  *  $message: The body of the e-mail
  */
function pafiledb_mail($fromname, $fromaddress, $to, $subject, $message)
{
    global $db, $dbPrefix;
    //Copyright 2005 ECRIA LLC, http://www.ECRIA.com
    //Please use or modify for any purpose but leave this notice unchanged.
    $headers  = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/plain; charset=".lang('local_charset')."\n";
    $headers .= "X-Priority: 3\n";
    $headers .= "X-MSMail-Priority: Normal\n";
    $headers .= "X-Mailer: php\n";
    $headers .= "From: \"".$fromname."\" <".$fromaddress.">\n";
    $toaddress = "";
    foreach ($to as $recip) {
        $toaddress .= $recip['name']." <".$recip['address'].">, ";
    }
    $toaddress = substr($toaddress, 0, strlen($toaddress)-2);

    $db->Execute("INSERT INTO ".$dbPrefix."emaillog (e_ip, e_fromname, e_fromaddress, e_toaddress, e_headers, e_subject, e_date, e_message) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".xhtml_convert($fromname)."', '".xhtml_convert($fromaddress)."', '".xhtml_convert($toaddress)."', '".xhtml_convert($headers)."', '".xhtml_convert($subject)."', ".time().", '".xhtml_convert($message)."')");
    return mail($toaddress, $subject, $message, $headers);
}

/**
  * dropDown() will build HTML for the category dropdown menu.
  * 
  * Parameters:
  *  $cats: The category cache from the settings
  *  $onlyid: If true, the option values will be the cat ID. If false,
  *           be the URL to the category.
  */
function dropDown($cats, $onlyid = false) {
  global $smarty;
  $drop = '<select name="menu1" onchange="MM_jumpMenu(\'parent\',this,0)">'."\n";
  $drop .= '<option value="'.substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '?')+1).xhtml_convert(substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '?')+1)).'">'.lang('categories').'</option>';

  if (empty($cats)) {
    $drop .= '</select>';
    $smarty->assign('drop', $drop);
    return;
  }
  $a = unserialize($cats);
  
  foreach ($a as $b) {
    $level = '';
    for($x = 0; $x < $b['sub']; $x++)
    {
      $level .= ' ';
    }
    if (strlen($level) > 0)
    {
      $level = str_replace(' ', '&nbsp;', $level);
    }

    $cat_id[] = $b['id'];
    $cat_name[] = $level.$b['name'];
    
    $drop .= '<option value="index.php?act=category&amp;id='.$b['id'].'">'.$level.'--'.$b['name']."</option>\n";
  }
  $drop .= '</select>';
  $smarty->assign('drop', $drop);
}


/**
  * rebuildDrop() will rebuild the category cache in the DB.
  * Takes no parameters and returns nothing. Simple, eh?
  * 
  */
function rebuildDrop($parent = 0, $level = 0, $drop = array()) {
  global $db, $dbPrefix;

  if (!is_array($drop))
  {
    $drop = array();
  }

  $results = $db->GetArray("SELECT * FROM ".$dbPrefix."cat WHERE cat_parent = ".$parent." ORDER BY cat_order ASC");
  foreach ($results as $k => $c)
  {
    $drop[] = array('name' => $c['cat_name'], 'id' => $c['cat_id'], 'sub' => $level, 'order' => $c['cat_order']);
    $drop = rebuildDrop($c['cat_id'], $level+1, $drop);
  }

  if ($level == 0)
  {
    // If a category is edited later, some cats can disappear!
    // So, what we need to do is figure out which ones disappeared, if any
    $used = array();
    foreach ($drop as $c)
    {
      $used[] = $c['id'];
    }
    $dontexist = array();
    $results = $db->GetArray("SELECT cat_id FROM ".$dbPrefix."cat ORDER BY cat_order ASC");
    foreach ($results as $a)
    {
      if (!in_array($a['cat_id'], $used))
      {
        $dontexist[] = $a['cat_id'];
      }
    }
    // We lost something!
    if (count($dontexist) > 0)
    {
   	  foreach ($dontexist as $d) {
   	  	$in = $d.',';
   	  }
   	  $in = substr($in, 0, strlen($in)-1);
      $db->Execute("UPDATE ".$dbPrefix."cat SET cat_parent = 0 WHERE cat_id IN (".$in.")");
      rebuildDrop();
    }
    else
    {
      $db->Execute("UPDATE ".$dbPrefix."settings SET dropdown = '".serialize($drop)."' WHERE id = 1");
    }
  }
  else
  {
    return $drop;
  }
}

/**
  * rebuild_tags() will rebuild the tag cloud and store it in the DB.
  * Rebuilding the cloud can take up a large amount of times if there
  * are a lot of files and tags, so the cloud is not built on-the-fly each time
  * a page is loaded, instead, the HTML is generated anytime a file is added,
  * edited or deleted (possibly changing the tags being used), and stored in the 
  * database
  * The comma is also converted to help prevent SQL injections.
  * Function written by Andrew
  *
  * Parameters:
  *  None! Yay!
  */
function rebuild_tags() {
	global $db, $dbPrefix;
	require("./includes/tagCloud.class.php");
	$fileTags = $db->GetArray("SELECT file_tags FROM ".$dbPrefix."files");
	$tags = array();
	foreach ($fileTags as $t) {
		$ftags = explode(" ", $t['file_tags']);
		if (!empty($ftags[0])) {
			$tags = array_merge($tags, $ftags);
		}
	}
	$tags = array_count_values($tags);
	ksort($tags);
	$tagCloud = new tagCloud($tags);
	$tagCloud->CreateHtmlCode();
	$db->Execute("UPDATE ".$dbPrefix."settings SET tag_cloud = '".trim(smart_slashes($tagCloud->HtmlStr))."'");
}
  
/**
  * xhtml_convert() converts a string into an XHTML-compliant form.

  * The comma is also converted to help prevent SQL injections.
  * Function written by Andrew
  *
  * Parameters:
  *  $text: The text to convert
  */
function xhtml_convert($text) {
    if (lang('local_charset_htmlent') != 'bypass')

    {
        $text = htmlentities($text, ENT_QUOTES, lang('local_charset_htmlent'));
    }
    $text = str_replace(',', '&#44;', $text);

    $text = str_replace("\r", '', $text);

    $text = str_replace("\n", '<br />', $text);



    // Fix a small glitch in some versions of PHP

    if (htmlentities('&') == '&amp;amp;')

    {

        $text = str_replace('&amp;amp;', '&amp;', $text);

    }



    return $text;
}

/**
  * lang() will return a value from the language file.
  * This function does the same as $smarty->get_config_vars(),
  * but the PHP Arena developers are lazy and would rather type
  * 4 letters instead of 24.
  *
  * Parameters:
  *  $term: The term we want to get from the lang file
  */
function lang($term) {
    global $smarty;
    return $smarty->get_config_vars($term);
}

/**
  * check_input() will return false if one of the items in
  * the array passed into it (typically $_POST) is empty.
  *
  * Parameters:
  * $a: The array of values to check
  * $excep: Array of any exceptions to the empty 
  *  requirement. Function will not return false if one of these
  *  is empty. The values for this array are the keys, so if you
  *  pass in $_POST, and the form field 'url' can be empty, put 'url'
  *  in the $excep array. However, if there is a field in the exception
  *  that is empty, but another field that is empty and not in the
  *  exception, function will still return false.
  */
function check_input($a, $excep=array()) {
    foreach($a as $key => $val) {
        if (!is_int($val) && !is_array($val)) {
            $val = trim($val);
            if (empty($val) && !in_array($key, $excep)) { return false; }
        }
    }
    return true;
}

/**
  * smart_slashes() will add slashes only if magic_quotes is off
  * Returns a query-friendly string.
  *
  * Parameters:
  * $s: The string to escape quote on
  */
function smart_slashes($s) {
	if (get_magic_quotes_gpc()) {
		stripslashes($s);
	} 
	return addslashes($s);
}

/**
  * get_file_list() will read the specified directory and return an
  * array of the files and folders in the directory.
  *
  * Parameters:
  *  $dir: The directory to search
  *  $mode: a (default): Return files and directories in the list
  *         f: Only return files in the list
  *         d: Only return directories in the list
  *  $ext: If true, function will strip file extensions
  */
function get_file_list($dir, $mode='a', $ext=true) {
    if ($handle = opendir($dir)) {
        $listing = array();
        while (false !== ($file = readdir($handle))) {
            if ($mode == 'a') {
                if ($file != '.' && $file != '..' && $file != '.DS_Store' && $file != 'index.html') {
                    if (is_file($dir.'/'.$file) && $ext) {
                        $fext = strrchr($file, '.');
                        if ($fext != false) {
                            $file = substr($file, 0, -strlen($fext));
                        }
                    }
                    $listing[] = $file;
                }
            }
            if ($mode == 'f') {
                if ($file != '.' && $file != '..' && is_file($dir.'/'.$file) && $file != '.DS_Store' && $file != 'index.html') {
                    if ($ext) {
                        $fext = strrchr($file, '.');
                        if ($fext != false) {
                            $file = substr($file, 0, -strlen($fext));
                        }
                    }
                    $listing[] = $file;
                }
            }
            if ($mode == 'd') {
                if ($file != '.' && $file != '..' && is_dir($dir.'/'.$file) && $file != '.DS_Store' && $file != 'index.html') {
                    $listing[] = $file;
                }
            }
        }
        closedir($handle);
    }
    return $listing;
} 

/**
  * xhtml_reverse() will undo xhtml_convert. This is used for
  * editing stuff, as textboxes don't like the & codes.
  *
  * Parameters:
  *  $text: The text to convert
  */
function xhtml_reverse($text) {
    $text = str_replace("<br />", "\n", $text);

    $text = str_replace('&#44;', ',', $text);

    if (lang('local_charset_htmlent') != 'bypass')

    {
        $text = html_entity_decode($text, ENT_QUOTES, lang('local_charset_htmlent'));
    }
    return $text;
}

/**
  * This function sperates given data into pages. Written by
  * Andrew, if you have any further questions, bother him ;)
  */ 
function paginate($data=array(), $start=1, $perpage=10, $groupby=5) {
    $start = intval($start) > 0 ? intval($start) : 1;
    $pages = ceil(count($data) / $perpage);
    $start = ($start >= $pages) ? $pages-1 : $start-1;
    $start = intval($start * $perpage);
    $stop = ($start + $perpage) >= count($data) ? count($data) : ($start + ($perpage-1));
    
    $newdata = array();

    for($x=0; $x < count($data); $x++)
    {
        if ($x < $start || $x > $stop) {}
        else
        {
            $newdata[] = $data[$x];
        }
    }
    $data = $newdata;
    unset($newdata);

    $groupby = ((1&$groupby) && ($groupby > 2)) ? $groupby : 3;
    $groupstart = ((($start / $perpage)+1) - (($groupby-1)/2));

    if ($groupstart < 2)
    {
        $groupstart = 2;
    }
    $groupstop = $groupstart + $groupby;

    if ($groupstop > ($pages-1))
    {
        $groupstop = ($pages-1);

    }

    if (($groupstop - $groupstart) <= $groupby)
    {
        $groupstart = $groupstop - $groupby;
    }

    if ($groupstart < 2)
    {
        $groupstart = 2;
    }

    $newpages = array();

    if (($start / $perpage) > 0)
    {
        $newpages[] = array('back', ($start / $perpage));
    }

    if (1 == (($start / $perpage)+1))
    {
        $newpages[] = array('[ 1 ]', 1);
    }
    else
    {
        $newpages[] = array(1, 1);
    }

    for($x = $groupstart; $x <= $groupstop; $x++)
    {
        if ($x == (($start / $perpage)+1))
        {
            $newpages[] = array('[ '.$x.' ]', $x);
        }
        else
        {
            $newpages[] = array($x, $x);
        }
    }

    if ($pages > 1)
    {
        if ($pages == (($start / $perpage)+1))
        {
            $newpages[] = array('[ '.$pages.' ]', $pages);
        }
        else
        {
            $newpages[] = array($pages, $pages);
        }
    }
    if (($start / $perpage)+1 < $pages) {
        $newpages[] = array('forward', ($start / $perpage)+2);
    }
    return array($data, $newpages);
}

?>