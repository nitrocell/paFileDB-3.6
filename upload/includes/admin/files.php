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


$smarty->assign('f', $_GET['f']);
if ($_GET['f'] == 'add'){
    if (isset($_GET['process'])) {
        
        //Check...........
        if (!check_input($_POST, array('creator', 'version', 'ss', 'documentation', 'upfile', 'posticon', 'license', 'pin', 'mirrors', 'tags'))) {
            smarty_error(lang('emptyfield'));
        }
        
        if (!empty($_FILES['upfile']['name'])) {
        	$file_ext = explode('.', $_FILES['upfile']['name']);
        	if (in_array($file_ext[count($file_ext)-1], explode(" ", $disallowedExtensions))) {
        		smarty_error(lang('file_type_error'));
        	}
            if (!move_uploaded_file($_FILES['upfile']['tmp_name'], 'uploads/'.$_FILES['upfile']['name'])) {
                smarty_error(lang('upload_err').' <b>PHP Error Code: '.$_FILES['upfile']['error'].'</b>');
            } else {
                @chmod('uploads/'.$_FILES['upfile']['name'], 0666);
                $_POST['dlurl'] = $settings[0]['dburl'].'/uploads/'.$_FILES['upfile']['name'];
            }
        }
        if (!empty($_FILES['ssfile']['name'])) {
        	$file_ext = explode('.', $_FILES['ssfile']['name']);
        	if (in_array($file_ext[count($file_ext)-1], explode(" ", $disallowedExtensions))) {
        		smarty_error(lang('file_type_error'));
        	}
            if (!move_uploaded_file($_FILES['ssfile']['tmp_name'], 'uploads/'.$_FILES['ssfile']['name'])) {
                smarty_error(lang('upload_err').' <b>PHP Error Code: '.$_FILES['ssfile']['error'].'</b>');
            } else {
                @chmod('uploads/'.$_FILES['ssfile']['name'], 0666);
                $_POST['ss'] = $settings[0]['dburl'].'/uploads/'.$_FILES['ssfile']['name'];
            }
        }
        $_POST['mirrors'] = trim($_POST['mirrors']);
        if (!empty($_POST['mirrors'])) {
            $mirror_array = array();
            $mirrors = str_replace("\r", "", $_POST['mirrors']);
            $mirrors = explode("\n", $mirrors);
            foreach ($mirrors as $m) {
                $mirror = explode("|", $m);
                $mirror_array[] = array("name" => xhtml_convert($mirror[0]), "url" => $mirror[1]);
            }
        } else {
            $mirror_array = "";
        }
        
       /*$newID = $db->insert('files', array(array('file_name', xhtml_convert($_POST['name'])),
                                  array('file_desc', xhtml_convert($_POST['sdesc'])),
                                  array('file_creator', xhtml_convert($_POST['creator'])),
                                  array('file_version', ',,force_as_string,,'.xhtml_convert($_POST['version'])),
                                  array('file_longdesc', xhtml_convert($_POST['ldesc'])),
                                  array('file_ssurl', $_POST['ss']),
                                  array('file_dlurl', $_POST['dlurl']),
                                  array('file_time', time()),
                                  array('file_mirrors', serialize($mirror_array)),
                                  array('file_catid', $_POST['cat']),
                                  array('file_posticon', $_POST['posticon']),
                                  array('file_license', $_POST['license']),
                                  array('file_dls', 0),
                                  array('file_last', ''),
                                  array('file_pin', $_POST['pin']),
                                  array('file_docsurl', $_POST['documentation']),
                                  array('file_rating', 0),
                                  array('file_totalvotes', 0))); */
        $db->Execute("INSERT INTO ".$dbPrefix."files (file_name, file_desc, file_creator, file_version, file_tags, file_longdesc, file_ssurl, file_dlurl, file_time, file_mirrors, file_catid, file_posticon, file_license, file_dls, file_last, file_pin, file_docsurl, file_rating, file_totalvotes) VALUES ('".xhtml_convert($_POST['name'])."', 
                                              '".smart_slashes($_POST['sdesc'])."', 
                                              '".smart_slashes($_POST['creator'])."',
                                              '".xhtml_convert($_POST['version'])."',
                                              '".smart_slashes($_POST['tags'])."',
                                              '".smart_slashes(nl2br($_POST['ldesc']))."',
                                              '".$_POST['ss']."',
                                              '".$_POST['dlurl']."',
                                               ".time().",
                                              '".serialize($mirror_array)."',
                                               ".intval($_POST['cat']).",
                                              '".$_POST['posticon']."',
                                               ".intval($_POST['license']).",
                                               0,
                                               NULL,
                                               ".intval($_POST['pin']).",
                                              '".$_POST['documentation']."',
                                               0,
                                               0)");
        $newID = $db->Insert_Id();
		$tempcat = $_POST['cat'];
		while ($tempcat != 0)
		{
		  $db->Execute("UPDATE ".$dbPrefix."cat SET cat_files = ".cat_filecount($tempcat)." WHERE cat_id = ".$tempcat);
		  $parent = $db->GetArray("SELECT cat_parent FROM ".$dbPrefix."cat WHERE cat_id = ".$tempcat);
		  $tempcat = $parent[0]['cat_parent'];
		}
        rebuild_tags();
        foreach ($_POST['custom'] as $k => $v) {
            $v = trim($v);
            if (!empty($v)) {
                $db->Execute("INSERT INTO ".$dbPrefix."customdata (customdata_file, customdata_custom, data) VALUES (".$newID.", ".$k.", '".smart_slashes($v)."')");
            }
        }
        
        smarty_redirect(lang('acp_add_f_redir'), 'admin.php?act=files&f');
    
    } else{
        
        //Setup the category selection menu
		$c_id = array(); $c_name = array();
		if (!empty($settings[0]['dropdown'])) {
		  $a = unserialize($settings[0]['dropdown']);
		  foreach ($a as $b) {
			$level = '';
			for($x = 0; $x < $b['sub']; $x++)
			{
			  $level .= ' ';
			}
			if (strlen($level) > 0)
			{
			  $level .= '- ';
			  $level = str_replace(' ', '&nbsp;', $level);
			}
	
			$c_id[] = $b['id'];
			$c_name[] = $level.$b['name'];
		  }
		}
        
        if (count($c_id) == 0) {
            smarty_error(lang('no_cat'));
        }
        $smarty->assign('c_id', $c_id);
        $smarty->assign('c_name', $c_name);
        $icons = get_file_list('posticons', 'f', false);
        $icon_name = array(); $icon_img = array();
        $icon_name[] = "";
        $icon_img[] = lang('none');
        foreach ($icons as $i) {
            $icon_name[] = $i;
            $icon_img[] = '<img src="posticons/'.$i.'" alt="" />';
        }
        $smarty->assign('i_name', $icon_name);
        $smarty->assign('i_img', $icon_img);
        
        $license = $db->GetArray("SELECT * FROM ".$dbPrefix."license");
        $l_id = array(); $l_id = array();
        $l_id[] = 0; $l_name[] = lang('none');
        foreach ($license as $l) {
            $l_id[] = $l['license_id']; $l_name[] = $l['license_name'];
        }
        $fields = $db->GetArray("SELECT * FROM ".$dbPrefix."custom");
        $smarty->assign('fields', $fields);
        $smarty->assign('l_id', $l_id);
        $smarty->assign('l_name', $l_name);
        $smarty->assign('yesno', array(lang('yes'), lang('no')));
        $smarty->assign('zeroone', array(1, 0));
    
    }
} elseif ($_GET['f'] == 'edit') {
    if (isset($_GET['process'])) {
        
        //Check again...........
        if (!check_input($_POST, array('creator', 'version', 'ss', 'documentation', 'upfile', 'posticon', 'license', 'pin', 'reset_downloads', 'reset_rating', 'reset_date', 'oldcat', 'mirrors', 'tags'))) {
            smarty_error(lang('emptyfield'));
        }
        
        if (!empty($_FILES['upfile']['name'])) {
        	$file_ext = explode('.', $_FILES['upfile']['name']);
        	if (in_array($file_ext[count($file_ext)-1], explode(" ", $disallowedExtensions))) {
        		smarty_error(lang('file_type_error'));
        	}
            if (!move_uploaded_file($_FILES['upfile']['tmp_name'], 'uploads/'.$_FILES['upfile']['name'])) {
                smarty_error(lang('upload_err').' <b>PHP Error Code: '.$_FILES['upfile']['error'].'</b>');
            } else {
                @chmod('uploads/'.$_FILES['upfile']['name'], 0666);
                $_POST['dlurl'] = $settings[0]['dburl'].'/uploads/'.$_FILES['upfile']['name'];
            }
        }
        if (!empty($_FILES['ssfile']['name'])) {
        	$file_ext = explode('.', $_FILES['ssfile']['name']);
        	if (in_array($file_ext[count($file_ext)-1], explode(" ", $disallowedExtensions))) {
        		smarty_error(lang('file_type_error'));
        	}
            if (!move_uploaded_file($_FILES['ssfile']['tmp_name'], 'uploads/'.$_FILES['ssfile']['name'])) {
                smarty_error(lang('upload_err').' <b>PHP Error Code: '.$_FILES['ssfile']['error'].'</b>');
            } else {
                @chmod('uploads/'.$_FILES['ssfile']['name'], 0666);
                $_POST['ss'] = $settings[0]['dburl'].'/uploads/'.$_FILES['ssfile']['name'];
            }
        }
        $_POST['mirrors'] = trim($_POST['mirrors']);
        if (!empty($_POST['mirrors'])) {
            $mirror_array = array();
            $mirrors = str_replace("\r", "", $_POST['mirrors']);
            $mirrors = explode("\n", $mirrors);
            foreach ($mirrors as $m) {
                $mirror = explode("|", $m);
                $mirror_array[] = array("name" => xhtml_convert($mirror[0]), "url" => $mirror[1]);
            }
        } else {
            $mirror_array = "";
        }
        if ($_POST['reset_downloads'] == 1) {
            $dlsUpdate = " file_dls = 0, ";
        } else {
        	$dlsUpdate = "";
        }
        if ($_POST['reset_date'] == 1) {
            $dateUpdate = " file_time = ".time().", file_last = ".time().", ";
        } else {
        	$dateUpdate = "";
        }
        if ($_POST['reset_rating'] == 1) {
            $ratingUpdate = " file_rating = 0, file_totalvotes = 0, ";
        } else {
        	$ratingUpdate = "";
        }
        $db->Execute("UPDATE ".$dbPrefix."files SET 
                      file_name = '".xhtml_convert($_POST['name'])."',
                      file_desc = '".smart_slashes($_POST['sdesc'])."',
                      file_creator = '".smart_slashes($_POST['creator'])."',
                      file_version = '".xhtml_convert($_POST['version'])."',
                      file_longdesc = '".smart_slashes(str_replace("\n", "<br />", $_POST['ldesc']))."', 
                      file_ssurl = '".$_POST['ss']."',
                      file_dlurl = '".$_POST['dlurl']."',
                      file_catid = ".intval($_POST['cat']).",
                      file_mirrors = '".serialize($mirror_array)."', 
                      file_posticon = '".$_POST['posticon']."',
                      file_license = ".intval($_POST['license']).",
                      file_pin = ".intval($_POST['pin']).",
                      file_tags = '".smart_slashes($_POST['tags'])."',
                      ".$dlsUpdate.$dateUpdate.$ratingUpdate."
                      file_docsurl = '".$_POST['documentation']."'
                      WHERE file_id = ".intval($_GET['id']));
        if ($_POST['cat'] != $_POST['oldcat']) {
			// Recount the old category.
			$tempcat = $_POST['oldcat'];
			while ($tempcat != 0)
			{
				$db->Execute("UPDATE ".$dbPrefix."cat SET cat_files = ".cat_filecount($tempcat)." WHERE cat_id = ".$tempcat);
				$parent = $db->GetArray("SELECT cat_parent FROM ".$dbPrefix."cat WHERE cat_id = ".$tempcat);
				$tempcat = $parent[0]['cat_parent'];
			}
			
			// Recount the new category.
			$tempcat = $_POST['cat'];
			while ($tempcat != 0)
			{
				$db->Execute("UPDATE ".$dbPrefix."cat SET cat_files = ".cat_filecount($tempcat)." WHERE cat_id = ".$tempcat);
				$parent = $db->GetArray("SELECT cat_parent FROM ".$dbPrefix."cat WHERE cat_id = ".$tempcat);
				$tempcat = $parent[0]['cat_parent'];
			}
		}
        rebuild_tags();
        $db->Execute("DELETE FROM ".$dbPrefix."customdata WHERE customdata_file = ".intval($_GET['id']));
        foreach ($_POST['custom'] as $k => $v) {
            $v = trim($v);
            if (!empty($v)) {
                $db->Execute("INSERT INTO ".$dbPrefix."customdata (customdata_file, customdata_custom, data) VALUES (".intval($_GET['id']).", ".$k.", '".smart_slashes($v)."')");
            }
        }
        
        smarty_redirect(lang('acp_edit_f_redir'), 'admin.php?act=files&f');
    } else {
    
        //Setup category menu and other template junk
        $file = $db->GetArray("SELECT * FROM ".$dbPrefix."files WHERE file_id = ".intval($_GET['id']));
        $c_id = array(); $c_name = array();
		if (!empty($settings[0]['dropdown'])) {
		  $a = unserialize($settings[0]['dropdown']);
		  foreach ($a as $b) {
			$level = '';
			for($x = 0; $x < $b['sub']; $x++)
			{
			  $level .= ' ';
			}
			if (strlen($level) > 0)
			{
			  $level .= '- ';
			  $level = str_replace(' ', '&nbsp;', $level);
			}
	
			$c_id[] = $b['id'];
			$c_name[] = $level.$b['name'];
		  }
		}
		$file[0]['file_longdesc'] = str_replace("<br />", "\n", $file[0]['file_longdesc']);
        $smarty->assign('c_id', $c_id);
        $smarty->assign('c_name', $c_name);
        $smarty->assign('target', $file[0]);
        $icons = get_file_list('posticons', 'f', false);
        $icon_name = array(); $icon_img = array();
        $icon_name[] = "";
        $icon_img[] = lang('none');
        foreach ($icons as $i) {
            $icon_name[] = $i;
            $icon_img[] = '<img src="posticons/'.$i.'" alt="" />';
        }
        $smarty->assign('i_name', $icon_name);
        $smarty->assign('i_img', $icon_img);
        
        $license = $db->GetArray("SELECT * FROM ".$dbPrefix."license");
        $l_id = array(); $l_id = array();
        $l_id[] = 0; $l_name[] = lang('none');
        foreach ($license as $l) {
            $l_id[] = $l['license_id']; $l_name[] = $l['license_name'];
        }
        $fields = $db->GetArray("SELECT * FROM ".$dbPrefix."custom");
        foreach($fields as $k => $v) {
            $data = $db->GetArray("SELECT * FROM ".$dbPrefix."customdata WHERE customdata_custom = ".$fields[$k]['custom_id']." AND customdata_file = ".intval($_GET['id']));
            @$fields[$k]['data'] = $data[0]['data'];
        }
        $mirrors = unserialize($file[0]['file_mirrors']);
        $mirror_list = "";
        if (is_array($mirrors)) {
            foreach ($mirrors as $m) {
                if (!empty($m['name'])) {
                    $mirror_list .= $m['name']."|".$m['url']."\r\n";
                }
            }
        }
        $smarty->assign('mirror_list', $mirror_list);
        $smarty->assign('fields', $fields);
        $smarty->assign('l_id', $l_id);
        $smarty->assign('l_name', $l_name);
        $smarty->assign('yesno', array(lang('yes'), lang('no')));
        $smarty->assign('zeroone', array(1, 0));
    }

} elseif ($_GET['f'] == 'delete') {
		$db->Execute("DELETE FROM ".$dbPrefix."files WHERE file_id = ".intval($_GET['id']));
		$db->Execute("DELETE FROM ".$dbPrefix."customdata WHERE customdata_file = ".intval($_GET['id']));
		
		// Recount the new category.
		$tempcat = $_GET['cat'];
		while ($tempcat != 0)
		{
			$db->Execute("UPDATE ".$dbPrefix."cat SET cat_files = ".cat_filecount($tempcat)." WHERE cat_id = ".$tempcat);
			$parent = $db->GetArray("SELECT cat_parent FROM ".$dbPrefix."cat WHERE cat_id = ".$tempcat);
			$tempcat = $parent[0]['cat_parent'];
		}
		rebuild_tags();
		smarty_redirect(lang('acp_del_f_redir'), 'admin.php?act=files&f');
} else {
    
    
    if (!isset($_GET['start'])) { $start = 0; } else { $start = intval($_GET['start']); }
    $files = $db->GetArray("SELECT * FROM ".$dbPrefix."files");
    list($f, $pages) = paginate($files, $start, 20);
    $smarty->assign('files', $f);
    $smarty->assign('count', count($files));
    $smarty->assign('pages', $pages);
}

function cat_filecount($catid = 0, $total = 0)
{
  global $db, $dbPrefix;

  $files = $db->GetArray("SELECT * FROM ".$dbPrefix."files WHERE file_catid = ".$catid);
  $total += count($files);

  $results = $db->GetArray("SELECT * FROM ".$dbPrefix."cat WHERE cat_parent = ".$catid." ORDER BY cat_order ASC");
  foreach ($results as $k => $c)
  {
    $total = cat_filecount($c['cat_id'], $total);
  }

  return $total;
}
?>