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

{if $c == "edit" && !$isSafari}
<script language="javascript" type="text/javascript" src="{$settings.dburl}/includes/js/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({ldelim}
		theme : "advanced",
		mode : "textareas",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,fontselect,fontsizeselect,forecolor",
		theme_advanced_buttons2 : "bullist,numlist,separator,outdent,indent,separator,undo,redo,separator,link,unlink,anchor,image,emotions,separator,cleanup,removeformat,visualaid,separator,sub,sup,separator,charmap,,separator,preview",
		theme_advanced_buttons3 : "",
		plugins: "emotions,inlinepopups,preview",
		theme_advanced_toolbar_location : "top",
		apply_source_formatting : false,
		remove_linebreaks : true,
		oninit : "nl2br"
	{rdelim});
</script>
{/if}
{if $c == delete}
<table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
  <tr class="sectionheader">
	<td width="100%">
	  {#delete_comment#}
	</td>
  </tr>
  <tr>
	<td>
	  <b>{#delete_comment_conf#}</b><p />
	  {#posted_by#}: {if $comment.user_userid > 0 }{$comment.user_username} {else} {#guest#} {/if}<br />
	  {#posted_on#}: {$comment.comment_time|date_format:$settings.date_format} {$comment.comment_time|date_format:$settings.time_format}
	  <hr class="comment" />
	  {$comment.comment_text}
	  <hr class="comment" />
	  <div align="center" style="font-weight: bold">
	  <a href="{$settings.dburl}/index.php?act=comments&c=delete&id={$comment.comment_id}&file={$comment.comment_fileid}&process">{#delete#}</a> - 
	  <a href="{$settings.dburl}/index.php?act=view&id={$comment.comment_fileid}">{#back#}</a></div>
	</td>
  </tr>
</table>
{elseif $c == edit}
	<form action="{$settings.dburl}/index.php?act=comments&c=edit&id={$comment.comment_id}&process" method="post">
	<table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
	  <tr class="sectionheader">
		<td width="100%" colspan="2">
		  {#edit_comment#}
		</td>
	  </tr>
	  <tr>
		<td width="50%">{#subject#}:</td>
		<td width="50%"><input type="text" name="subject" id="subject" size="40" value="{$comment.comment_subject}" maxlength="150" /></td>
	  </tr>
	  <tr>
		<td align="center" colspan="2">
		  <textarea name="comment" id="comment" rows="12" style="width: 95%">{$comment.comment_text}</textarea>
		</td>
	  </tr>
	  <tr>
		<td align="center" colspan="2">
		  <input type="submit" value="{#edit_comment#}" /><br />
		</td>
	  </tr>
	</table>
	</form>
{elseif $c == ajaxedit}
	<table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
	  <tr class="sectionheader">
		<td width="100%" colspan="2">
		  {#edit_comment#}
		</td>
	  </tr>
	  <tr>
		<td width="50%">{#subject#}:</td>
		<td width="50%"><input type="text" name="subject" id="subject{$comment.comment_id}" size="40" value="{$comment.comment_subject}"  maxlength="150" /></td>
	  </tr>
	  <tr>
		<td align="center" colspan="2">
		  <textarea name="comment" id="commenttext{$comment.comment_id}" rows="12" style="width: 95%">{$comment.comment_text}</textarea>
		</td>
	  </tr>
	  <tr>
		<td align="center" colspan="2">
		  <input type="button" onclick="saveComment({$comment.comment_id})" value="{#edit_comment#}" /> <input type="button" onclick="cancelEdit()" value="{#cancel#}" /><br />
		</td>
	  </tr>
	</table>
{/if}
{if $c == "edit" && !$isSafari}
<script language="javascript" type="text/javascript">
	function nl2br() {ldelim}
		document.getElementById("comment").value = document.getElementById("comment").value.replace(/\n/g, "<br />");
		tinyMCE.updateContent("comment");
	{rdelim}
</script>
{/if}