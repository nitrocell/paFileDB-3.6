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

<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
<tr class="sectionheader">
  <td>{#version_check#}</td>
</tr>
<tr>
  <td>
    {#your_version#}: <b>{$version}</b><br />
    {#latest_version#}: <b>{$new_version}</b><br />&nbsp;<br />
    {if $version != $new_version}{#update_available#}{else}{#up_to_date#}{/if}
  </td>
</tr>
</table>
