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
  <td>{#welcome#}</td>
</tr>
<tr>
  <td>{#acp_welcome#}
  {if $userinfo.user_status > 4}
  <p>&nbsp;</p>
  	{#pafiledb_news_info#}
  {/if}
  </td>
</tr>
</table>
{if $userinfo.user_status > 4}
<p />
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
<tr>
  <td>
    <iframe src="{$settings.dburl}/admin.php?act=news" width="100%" height="500" border="0" frameborder="0" style="border: 0px;"></iframe>
  </td>
</tr>
</table>
{/if}
