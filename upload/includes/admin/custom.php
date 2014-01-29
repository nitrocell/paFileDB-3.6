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

checkaccess(5);

$smarty->assign('c', $_GET['c']);
if ($_GET['c'] == 'add'){
    if (isset($_GET['process'])) { //Add to DB
        
        //Make sure the input is valid
        if (!check_input($_POST)) {
            smarty_error(lang('emptyfield'));
        }
        $db->Execute("INSERT INTO ".$dbPrefix."custom (custom_name, custom_description) VALUES ('".xhtml_convert($_POST['name'])."', '".xhtml_convert($_POST['desc'])."')");
        smarty_redirect(lang('acp_add_cu_redir'), 'admin.php?act=custom&c');
    
    }

} elseif ($_GET['c'] == 'edit') { //Edit field
    if (isset($_GET['process'])) {
        if (!check_input($_POST)) {
            smarty_error(lang('emptyfield'));
        } 
        
        $db->Execute("UPDATE ".$dbPrefix."custom SET custom_name = '".xhtml_convert($_POST['name'])."', custom_description = '".xhtml_convert($_POST['desc'])."' WHERE custom_id = ".intval($_GET['id']));
        smarty_redirect(lang('acp_edit_cu_redir'), 'admin.php?act=custom&c');
    } else {
        $field = $db->GetArray("SELECT * FROM ".$dbPrefix."custom WHERE custom_id = ".intval($_GET['id']));
        $smarty->assign('target', $field[0]);
    }

} elseif ($_GET['c'] == 'delete') { //Delete field

    $db->Execute("DELETE FROM ".$dbPrefix."custom WHERE custom_id = ".intval($_GET['id']));
    $db->Execute("DELETE FROM ".$dbPrefix."customdata WHERE customdata_custom = ".intval($_GET['id']));
    smarty_redirect(lang('acp_delete_cu_redir'), 'admin.php?act=custom&c');
} else {
    $fields = $db->GetArray("SELECT * FROM ".$dbPrefix."custom");
    $smarty->assign('fields', $fields);
}
?>