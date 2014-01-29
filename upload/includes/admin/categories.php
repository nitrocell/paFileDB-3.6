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


$smarty->assign('c', $_GET['c']);
if ($_GET['c'] == 'add'){
    if (isset($_GET['process'])) { //Add to DB
        
        //Make sure the input is valid
        if (!check_input($_POST, array('desc', 'order', 'parent'))) {
            smarty_error(lang('emptyfield'));
        }
        if (empty($_POST['order'])) { $_POST['order'] = 0; }
        $db->Execute("INSERT INTO ".$dbPrefix."cat (cat_name, cat_desc, cat_files, cat_sort, cat_parent, cat_order) VALUES ('".xhtml_convert($_POST['name'])."', '".xhtml_convert($_POST['desc'])."', 0, '".$_POST['sort']."|".$_POST['sorder']."', ".$_POST['parent'].", ".$_POST['order'].")");
        rebuildDrop();
        smarty_redirect(lang('acp_add_c_redir'), 'admin.php?act=categories&c');
    
    }
    $cat_id = array(); $cat_name = array();
	$cat_id[] = 0; $cat_name[] = lang('none');
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
	
	  $cat_id[] = $b['id'];
	  $cat_name[] = $level.$b['name'];
	}
	}
	$smarty->assign('cat_id', $cat_id);
	$smarty->assign('cat_name', $cat_name);
    $smarty->assign('sort_val', array('name', 'dls', 'time'));
    $smarty->assign('sort_name', array(lang('name'), lang('downloads'), lang('date_added')));
    $smarty->assign('order_val', array('DESC', 'ASC'));
    $smarty->assign('order_name', array(lang('descending'), lang('ascending')));

} elseif ($_GET['c'] == 'edit') { //Edit category
    if (isset($_GET['process'])) {
        if (!check_input($_POST, array('desc', 'order', 'parent'))) {
            smarty_error(lang('emptyfield'));
        }
        $name = xhtml_convert($_POST['name']);
        $desc = xhtml_convert($_POST['desc']);
        $db->Execute("UPDATE ".$dbPrefix."cat SET cat_name = '".$name."', cat_desc = '".$desc."', cat_sort = '".$_POST['sort']."|".$_POST['sorder']."', cat_parent = ".$_POST['parent'].", cat_order = ".$_POST['order']." WHERE cat_id = ".intval($_GET['id']));
        rebuildDrop();
        
        smarty_redirect(lang('acp_edit_c_redir'), 'admin.php?act=categories&c');
    } else {
        $category = $db->GetArray("SELECT * FROM ".$dbPrefix."cat WHERE cat_id = ".intval($_GET['id']));        $cat_id = array(); $cat_name = array();
        $cat_id[] = 0; $cat_name[] = lang('none');
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
			
				$cat_id[] = $b['id'];
				$cat_name[] = $level.$b['name'];
		  
		  }
		}
		$sortstuff = explode('|', $category[0]['cat_sort']);
        $smarty->assign('sort', $sortstuff[0]);
        $smarty->assign('order', $sortstuff[1]);
        $smarty->assign('sort_val', array('name', 'dls', 'time'));
        $smarty->assign('sort_name', array(lang('name'), lang('downloads'), lang('date_added')));
        $smarty->assign('order_val', array('DESC', 'ASC'));
        $smarty->assign('order_name', array(lang('descending'), lang('ascending')));
        $smarty->assign('cat_id', $cat_id);
        $smarty->assign('cat_name', $cat_name);
        $smarty->assign('target', $category[0]);
    }

} elseif ($_GET['c'] == 'delete') { //Delete category
    $cat = $db->GetArray("SELECT * FROM ".$dbPrefix."cat WHERE cat_id = ".intval($_GET['id']));
    if ($cat[0]['cat_parent'] > 0) {
        $db->Execute("UPDATE ".$dbPrefix."cat SET cat_files = cat_files - ".$cat[0]['cat_files']." WHERE cat_id = ".$cat[0]['cat_parent']);
    }
    $db->Execute("DELETE FROM ".$dbPrefix."cat WHERE cat_id = ".intval($_GET['id']));
    $db->Execute("UPDATE ".$dbPrefix."cat SET cat_parent = 0 WHERE cat_parent = ".intval($_GET['id']));
    $db->Execute("UPDATE ".$dbPrefix."files SET file_catid = 0 WHERE file_catid = ".intval($_GET['id']));
    rebuildDrop();
    smarty_redirect(lang('acp_del_c_redir'), 'admin.php?act=categories&c');
}
elseif ($_GET['c'] == 'reorder') {
	foreach ($_POST['order'] as $id => $order) {
		$db->Execute("UPDATE ".$dbPrefix."cat SET cat_order = ".intval($order)." WHERE cat_id = ".intval($id));
	}
	rebuildDrop();
	smarty_redirect(lang('acp_reorder_c_redir'), 'admin.php?act=categories&c');
} else {
    if ($_GET['c'] == 'recount') { //Recount, Florida style!
        $db->Execute("UPDATE ".$dbPrefix."cat SET cat_files = ".cat_filecount(intval($_GET['id']))." WHERE cat_id = ".intval($_GET['id']));
    }
    if ($_GET['c'] == 'recountall') {
    	$cats = $db->GetArray("SELECT cat_id FROM  ".$dbPrefix."cat");
    	foreach ($cats as $c) {
    		$db->Execute("UPDATE ".$dbPrefix."cat SET cat_files = ".cat_filecount($c['cat_id'])." WHERE cat_id = ".$c['cat_id']);
    	}
    }
    $categories = array();
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
		  $categories[] = array('cat_id' => $b['id'], 'cat_name' => $level.$b['name'], 'sub' => $b['sub'], 'cat_order' => $b['order'], 'level' => str_replace('-', "&nbsp;", $level));
		}
	}
    $smarty->assign('categories', $categories);
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