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

{if !$hidediv}<p />
<div id="comment{$c.comment_id}">
{/if}
<table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
  <tr class="commentheader">
	<td width="100%">
	  <span class="small">{#posted_by#}: {if $c.user_userid > 0 }{$c.user_username} {else} {#guest#} {/if} 
	  {if $userinfo.user_status > 3}(<a class="edit" href="http://ws.arin.net/cgi-bin/whois.pl?queryinput={$c.comment_ip}">{$c.comment_ip}</a>){/if}
	  <br />
	  {#posted_on#}: {$c.comment_time|date_format:$settings.date_format} {$c.comment_time|date_format:$settings.time_format}</span>
	</td>
  </tr>
  <tr class="{cycle values=row1,row2}">
	<td>
	  <b>{$c.comment_subject}</b><br />
	  <hr class="comment" />
	  {$c.comment_text}
	  <div align="right">
	    {if ($userinfo.user_userid == $c.comment_userid && $userinfo.user_userid > 0) || $userinfo.user_status > 3}
	    	<a href="{$settings.dburl}/index.php?act=comments&c=edit&id={$c.comment_id}" onclick="editComment({$c.comment_id}); return false;">{#edit#}</a>{if $userinfo.user_status > 3} - <a href="{$settings.dburl}/index.php?act=comments&c=delete&id={$c.comment_id}" onclick="deleteComment({$c.comment_id}); return false;">{#delete#}</a>{/if}
	    {/if}
	  </div>
	</td>
  </tr>
</table>
{if !$hidediv}</div>{/if}