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

if (isset($_GET['view'])) { //Fetch from DB for detailed view
    $l = $db->GetArray("SELECT * FROM ".$dbPrefix."emaillog WHERE e_id = ".intval($_GET['id']));
    $smarty->assign('v', 1);
    $smarty->assign('l', $l[0]);
} elseif (isset($_GET['delete'])) { //Delete from DB
    $db->Execute("DELETE FROM ".$dbPrefix."emaillog WHERE e_id = ".intval($_GET['id']));
    smarty_redirect(lang('acp_del_e_redir'), 'admin.php?act=log');
} elseif (isset($_GET['clear'])) {
	$db->Execute("TRUNCATE ".$dbPrefix."emaillog");
	smarty_redirect(lang('acp_clr_e_redir'), 'admin.php?act=log');
} else { //Fetch from DB for list view
    $l = $db->GetArray("SELECT * FROM ".$dbPrefix."emaillog ORDER BY e_date DESC");
    $smarty->assign('logs', $l);
}
?>