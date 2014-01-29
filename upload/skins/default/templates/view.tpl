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
{if !$isSafari}
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
		remove_linebreaks : true
	{rdelim});
</script>
{/if}
<script language="javascript" type="text/javascript" src="{$settings.dburl}/includes/js/ajax.js"></script>

<script language="javascript" type="text/javascript">
        function deletefconf(id, cat) {ldelim}
            if (confirm('{#delete_f_conf#}')) {ldelim}
                window.location.href= '{$settings.dburl}/admin.php?act=files&f=delete&id=' + id + '&cat=' + cat;
            {rdelim}
        {rdelim}
        
        var comment_emptyfield = '{#comment_emptyfield#}';
        var comment_wait = '{#comment_wait#}';
        var delete_comment_conf = '{#delete_comment_conf#}';
        var img_dir = '{#img_dir#}';
</script>


{if $userinfo.user_status > 3}
<table width="75%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>
     <a href="{$settings.dburl}/admin.php?act=files&f=edit&id={$file.file_id}"><img src="{#img_dir#}/edit_nobg.gif" border="0" alt="{#edit#}" /></a>&nbsp;
     <a href="javascript:deletefconf({$file.file_id},{$file.file_catid})"><img src="{#img_dir#}/delete_nobg.gif" border="0" alt="{#delete#}" /></a>
     </td>
  </tr>
</table>
{/if}
<table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
  <tr>
    <td width="75%" class="fileheader" valign="top" height="100%" colspan="2">
      <span class="largefilename">{$file.file_name}</span><br />
    </td>
  </tr>
  <tr>
    <td width="50%">{#date_added#}:</td>
    <td width="50%">{$file.file_time|date_format:$settings.date_format} {$file.file_time|date_format:$settings.time_format}</td>
  </tr>
  <tr>
    <td width="50%">{#description#}:</td>
    <td width="50%">{$file.file_longdesc}</td>
  </tr>
  {if $file.file_creator != ""}
    <tr>
      <td width="50%">{#creator#}:</td>
      <td width="50%">{$file.file_creator}</td>
    </tr>
  {/if}
  {if $file.file_version != ""}
    <tr>
      <td width="50%">{#version#}:</td>
      <td width="50%">{$file.file_version}</td>
    </tr>
  {/if}
  {if $file.file_ssurl != ""}
    <tr>
      <td width="50%">{#screenshot#}:</td>
      <td width="50%">
        {if $settings.showss == 1}
          <img src="{$file.file_ssurl}" alt="{#screenshot#}" />
        {else}
          <a href="{$file.file_ssurl}" target="_blank">{$file.file_ssurl}</a>
        {/if}
      </td>
    </tr>
  {/if}
  {if $file.file_docsurl != ""}
    <tr>
      <td width="50%">{#documentation#}:</td>
      <td width="50%"><a href="{$file.file_docsurl}" target="_blank">{$file.file_docsurl}</a></td>
    </tr>
  {/if}
  {foreach item=c from=$custom}
    <tr>
      <td width="50%">{$c.custom_name}:</td>
      <td width="50%">{$c.data}</td>
    </tr>
  {/foreach}
  <tr>
    <td width="50%">{#last_download#}:</td>
    <td width="50%">
      {if $file.file_last != "0"}{$file.file_last|date_format:$settings.date_format} {$file.file_last|date_format:$settings.time_format}
      {else}{#never#}{/if}
    </td>
  </tr>
  <tr>
    <td width="50%">{#downloads#}:</td>
    <td width="50%">{$file.file_dls}</td>
  </tr>
  <tr>
    <td width="50%">{#rating#}:</td>
    <td valign="top" width="50%">
    	<div id="fileRating">
    	{include file="view_rating.tpl}
    	</div>
    </td>
  </tr>
  {if $tags != ""}
  <tr>
    <td width="50%">{#tags#}:</td>
    <td valign="top" width="50%">
    	{$tags}
    </td>
  </tr>
  {/if}
</table>
{if $settings.enable_report == 1}
<table width="75%" border=0" align="center" cellpadding="1" cellspacing="0">
  <tr>
   <td align="right">
     <a href="{$settings.dburl}/index.php?act=report&amp;id={$file.file_id}">{#report_broken#}</a>
   </td>
  </tr>
</table>
{/if}
<p>&nbsp;</p>
<table width="75%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td width="100%" align="center">
      {if $file.file_license > 0}
        <a href="{$settings.dburl}/index.php?act=license&id={$file.file_id}"><img src="{#img_dir#}/download.gif" alt="{#download#}" border="0" /></a>
      {elseif $has_mirrors == true}
        <a href="{$settings.dburl}/index.php?act=mirror&id={$file.file_id}"><img src="{#img_dir#}/download.gif" alt="{#download#}" border="0" /></a>
      {else}
        <a href="{$settings.dburl}/index.php?act=download&id={$file.file_id}"><img src="{#img_dir#}/download.gif" alt="{#download#}" border="0" /></a>
      {/if}
        {if $settings.enable_email == 1}
            <a href="{$settings.dburl}/index.php?act=email&id={$file.file_id}"><img src="{#img_dir#}/emailfriend.gif" alt="{#emailfriend#}" border="0" /></a>
        {/if}
    </td>
  </tr>
</table>
<p />
<div id="commentTables">
{if $comments|@count > 0}
{foreach item=c from=$comments}
    {include file="comment.tpl"}
{/foreach}
{/if}
</div>
{if $ccount > $settings.perpage}
	<p />
	<div align="center">
	{section name=pages loop=$pages}
	<a href="{$settings.dburl}/index.php?act=view&amp;id={$file.file_id}&amp;start={$pages[pages].1}">{if $pages[pages].0 eq "back"}&laquo;&laquo;{elseif $pages[pages].0 eq "forward"}&raquo;&raquo;{else}{$pages[pages].0}{/if}</a>
	{/section}
	</div><p />
{/if}
{if $enablecomments}
	<p />
	<form action="{$settings.dburl}/index.php?act=comments&c=post&file={$file.file_id}" method="post">
	<table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
	  <tr class="sectionheader">
		<td width="100%" colspan="2">
		  {#post_comment#}
		</td>
	  </tr>
	  <tr>
		<td width="50%">{#subject#}:</td>
		<td width="50%"><input type="text" name="subject" id="subject" size="40" maxlength="150" /></td>
	  </tr>
	  <tr>
		<td align="center" colspan="2">
		  <textarea name="comment" id="comment" rows="12" style="width: 95%"></textarea>
		</td>
	  </tr>
	  <tr>
		<td align="center" colspan="2">
		  <input type="submit" value="{#post_comment#}" onclick="postComment({$file.file_id}); return false;" /><br />
		  <div id="status" style="font-weight: bold"></div>
		</td>
	  </tr>
	</table>
	</form>

{/if}