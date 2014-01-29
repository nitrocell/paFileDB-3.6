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

<table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
  <tr>
    <td width="100%" class="sectionheader" valign="top" height="100%">
      {#stats#}<br />
    </td>
  </tr>
  <tr>
    <td>
      {$stats.0}<br />
      {$stats.1}<br />
      {$stats.2}<br />
      {#stats_newest#} <a href="{$settings.dburl}/index.php?act=view&id={$newest.file_id}">{$newest.file_name}</a><br />
      {$stats.3}<br />
      {$stats.4}<br />
      {$stats.5}<br />
      {$stats.6}<br />
      {$stats.7}
    </td>
   </tr>
</table>