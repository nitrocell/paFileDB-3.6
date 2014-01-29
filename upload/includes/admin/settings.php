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

if (isset($_GET['process'])) {
    if (!check_input($_POST, array('topnumber', 'timeoffset', 'viewall', 'showss', 'stats', 'enable_email', 'enable_report', 'sort_override', 'quickdl', 'dbstats', 'enable_comments', 'guest_comments', 'enable_registration', 'validateemail', 'display_tags', 'require_registration'))) {
        smarty_error(lang('emptyfield'));
    }
    
    $_POST['dburl'] = preg_replace("/(\/*)$/", "", $_POST['dburl']);
    
    //Update the DB
    $db->Execute("UPDATE ".$dbPrefix."settings SET
                  skin = '".$_POST['skin']."',
                  lang = '".$_POST['lang']."',
                  dbname = '".xhtml_convert($_POST['dbname'])."',
                  dburl = '".$_POST['dburl']."',
                  topnumber = ".intval($_POST['topnumber']).",
                  homeurl = '".$_POST['homeurl']."',
                  timeoffset = ".$_POST['timeoffset'].",
                  timezone = '".xhtml_convert($_POST['timezone'])."',
                  viewall = ".intval($_POST['viewall']).",
                  quickdl = ".intval($_POST['quickdl']).",
                  showss = ".intval($_POST['showss']).",
                  stats = ".intval($_POST['stats']).",
                  dbstats = ".intval($_POST['dbstats']).",
                  fromemail = '".xhtml_convert($_POST['fromemail'])."',
                  validateemail = ".intval($_POST['validateemail']).",
                  enable_comments = ".intval($_POST['enable_comments']).",
                  display_tags = ".intval($_POST['display_tags']).",
                  guest_comments = ".intval($_POST['guest_comments']).",
                  comments_perpage = ".intval($_POST['comments_perpage']).",
                  enable_registration = ".intval($_POST['enable_registration']).",
                  require_registration = ".intval($_POST['require_registration']).",
                  enable_email = ".intval($_POST['enable_email']).",
                  enable_report = ".intval($_POST['enable_report']).",
                  perpage = ".intval($_POST['perpage']).",
                  sort_override = ".intval($_POST['sort_override']).",
                  date_format = '".xhtml_convert($_POST['date_format'])."',
                  time_format = '".xhtml_convert($_POST['time_format'])."'");
    smarty_redirect(lang('acp_settings_redir'), 'admin.php?act=main');
} else {
    
    //Send stuff to Smarty
    $smarty->assign('skins', get_file_list('./skins', 'd'));
    $smarty->assign('langs', get_file_list('./lang', 'f', true));
    $smarty->assign('yesno', array(lang('yes'), lang('no')));
    $smarty->assign('zeroone', array(1, 0));
    $smarty->assign('regreq', array(lang('require_none'), lang('require_view'), lang('require_download')));
    $smarty->assign('reqs', array(0, 1, 2));

}

?>