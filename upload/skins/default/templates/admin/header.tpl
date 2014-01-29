{******************************************************************
* paFileDB 3.6                                                    *
*                                                                 *
* Author: PHP Arena <http://www.phparena.net>                     *
* File Version 3.6                                                *
* Copyright ©2005-2007 PHP Arena. All Rights Reserved.            *
*                                                                 *
* THIS FILE MAY NOT BE REDISTRIBUTED.                             *
* For more information, please see the PHP Arena license at:      *
* http://www.phparena.net/license.html                            *
*                                                                 *
* The paFileDB templates are made for the Smarty template system  *
* For more information on the syntax used in these files please   *
* visit the official Smarty website at:                           *
* http://smarty.phparena.net                                      *
******************************************************************}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{#local_lang#}" lang="{#local_lang#}" dir="{#local_direction#}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={#local_charset#}" />
<title>{$title|default:"paFileDB Admin Center"}</title>
<link href="{$settings.dburl}/skins/default/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p />

{if $userloggedin == true && $act ne "news"}
<table width="90%" cellpadding="0" cellspacing="5" border="0" align="center">
  <tr>
    <td width="15%" valign="top">
       {include file="admin/menu.tpl"}
    </td>
    <td width="85%" valign="top">
    
{/if}
<!--End header, begin content-->