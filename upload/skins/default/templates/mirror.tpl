{******************************************************************* paFileDB 3.6                                                    **                                                                 ** Author: PHP Arena <http://www.phparena.net>                     ** File Version 3.6                                                ** Copyright ©2005-2007 PHP Arena. All Rights Reserved.            **                                                                 ** THIS FILE MAY NOT BE REDISTRIBUTED.                             ** For more information, please see the PHP Arena license at:      ** http://www.phparena.net/license.html                            **                                                                 ** The paFileDB templates are made for the Smarty template system  ** For more information on the syntax used in these files please   ** visit the official Smarty website at:                           ** http://smarty.phparena.net                                      *******************************************************************}<table width="25%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">  <tr>    <td width="100%" class="sectionheader" valign="top" height="100%" colspan="2">
      {#select_mirror#}
    </td>
  </tr>
  <tr>
    <td width="100%">
      <div align="center">
      {#select_mirror_info#}<br />
      <a href="{$settings.dburl}/index.php?act=download&id={$file.file_id}">{#main_server#}</a><br />
      {foreach key=row item=mirror from=$mirrors}
        <a href="{$settings.dburl}/index.php?act=download&id={$file.file_id}&mirror={$row}">{$mirror.name}</a><br />
      {/foreach}
      </div>
    </td>
  </tr></table>
