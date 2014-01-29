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

if (isset($_GET['process'])) {
    $smarty->assign('navbar', array(array('name' => $settings[0]['dbname'], 'url' => ''), array('name' => lang('search'), 'url' => '?act=search'), array('name' => lang('search_results').': '.$_POST['query'], 'url' => '?act=search')));
    $smarty->assign('title', $settings[0]['dbname'].' &raquo; '.lang('search').' &raquo; '.lang('search_results').': '.$_POST['query']);
    $smarty->assign('act', 'process');
    
    //Make sure the input is valid
    if (!check_input($_POST)) {
        smarty_error(lang('emptyfield'));
    }
    
	//To prevent things like SQL injections, specify which fields can be searched
    $allowed_fields = array("file_name", "file_desc", "file_creator", "file_version", "file_longdesc");
    
    //Build the WHERE clause for the query
    $searchin = array();
    foreach ($_POST['search_in'] as $s) {
    	if (in_array($s, $allowed_fields)) {
    		$searchin[] = $s." LIKE '%".xhtml_convert($_POST['query'])."%'";
    	}
    }
    $searchin = implode(' OR ', $searchin);
    
    //Run the query
    $results = $db->GetArray("SELECT * FROM ".$dbPrefix."files WHERE (".$searchin.") AND file_catid IN (".implode(',', $_POST['categories']).")");
    if (count($results) == 0) {
        smarty_error(str_replace('{keyword}', $_POST['query'], lang('no_results')));
    }
    $smarty->assign('results', $results);
} else {
	  
	  //Build the category select menu
	  $cats = $settings[0]['dropdown'];
	  $drop = '<select name="categories[]" multiple="multiple">'."\n";
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
		
		$drop .= '<option selected="selected" value="'.$b['id'].'">'.$level.''.$b['name']."</option>\n";
	  }
	  $drop .= '</select>';
	$smarty->assign('categories', $drop);
    $smarty->assign('navbar', array(array('name' => $settings[0]['dbname'], 'url' => ''), array('name' => lang('search'), 'url' => '?act=search')));
    $smarty->assign('title', $settings[0]['dbname'].' &raquo; '.lang('search'));
}

?>