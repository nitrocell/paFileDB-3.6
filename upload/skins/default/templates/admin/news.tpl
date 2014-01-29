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

{if $news|@count > 0}
{foreach key=row item=n from=$news}
<p />
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
<tr class="fileheader">
  <td><span class="largefilename">{$n.subject}</a></td>
</tr>
<tr>
  <td>
    <b>{#posted_on#}: {$n.date|date_format:$settings.date_format} {$n.date|date_format:$settings.time_format}</b>
    <hr class="comment" />
    {$n.text}
    <div align="right">
      <a href="{$settings.dburl}/admin.php?act=news&deletenews&id={$n.date}"><b>{#delete#}</b></a>
    </div>
  </td>
</tr>
</table>
{/foreach}
{else}
<div align="center">
  <b>{#no_news#} <a href="{$settings.dburl}/admin.php?act=news&redownload">{#redownload_news#}</a></b>
</div>
{/if}