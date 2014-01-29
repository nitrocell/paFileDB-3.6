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

<script language="javascript" type="text/javascript">
tableNames = new Array('pafiledb', 'datetime', 'mainpage', 'category', 'file', 'comment', 'users');
tableState = new Array(true, true, true, true, true, true, true);

var collapseGif = '{#img_dir#}/collapse.gif';
var expandGif = '{#img_dir#}/expand.gif';
{literal}
function collapseAll(){
	for(x = 0; x < tableNames.length; x++) {
		tbl = document.getElementById(tableNames[x]);
	
		for(i=2 ; i< tbl.rows.length; i++){
			 tbl.rows[i].style.display = 'none';
		}
		document.getElementById(tableNames[x]+'_img').src = expandGif;
		tableState[x] = false;
		
	}
}
function expandAll(){
	for(x = 0; x < tableNames.length; x++) {
		tbl = document.getElementById(tableNames[x]);
	
		for(i=2 ; i< tbl.rows.length; i++){
			 tbl.rows[i].style.display = '';
		}
		document.getElementById(tableNames[x]+'_img').src = collapseGif;
		tableState[x] = true;

	}
}
function toggle(tableID) {
	tbl = document.getElementById(tableNames[tableID]);
	for (i=2; i < tbl.rows.length; i++) {
		if (tableState[tableID]) {
			tbl.rows[i].style.display = 'none';
		} else {
			tbl.rows[i].style.display = '';
		}
	}
	if (tableState[tableID]) {
		document.getElementById(tableNames[tableID]+'_img').src = expandGif;
		tableState[tableID] = false;
	} else {
		document.getElementById(tableNames[tableID]+'_img').src = collapseGif;
		tableState[tableID] = true;
	}
}
{/literal}
</script>
<form action="{$settings.dburl}/admin.php?act=settings&amp;process" method="post">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="border">
<tr align="left">
  <td><a href="javascript:expandAll()">{#expand_all#}</a> - <a href="javascript:collapseAll()">{#collapse_all#}</a></td>
</tr>
</table>

<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border" id="pafiledb">
<tr class="sectionheader">
  <td colspan="2">{#pafiledb_settings#}</td>
</tr>
<tr>
  <td colspan="2">
  <a href="javascript:toggle(0)"><img src="{#img_dir#}/collapse.gif" border="0" alt="" id="pafiledb_img"></a> {#pafiledb_settings_info#}</td>
</tr>
<tr>
  <td width="50%" valign="top">{#dbname#}:
  </td>
  <td width="50%" valign="top">
    <input name="dbname" type="text" size="40" value="{$settings.dbname}" />
  <br /><span class="small">{#dbname_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#dburl#}:
  </td>
  <td width="50%" valign="top">
    <input name="dburl" type="text" size="40" value="{$settings.dburl}" />
  <br /><span class="small">{#dburl_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#skin#}:
  </td>
  <td width="50%" valign="top">
    <select name="skin">
    {html_options values=$skins output=$skins selected=$settings.skin}
    </select>
  <br /><span class="small">{#skin_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#lang#}:
  </td>
  <td width="50%" valign="top">
    <select name="lang">
    {html_options values=$langs output=$langs selected=$settings.lang}
    </select>
  <br /><span class="small">{#lang_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#homeurl#}:
  </td>
  <td width="50%" valign="top">
    <input name="homeurl" type="text" size="40" value="{$settings.homeurl}" />
  <br /><span class="small">{#homeurl_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#from_email#}:
  </td>
  <td width="50%" valign="top">
    <input name="fromemail" maxlength="50" type="text" size="40" value="{$settings.fromemail}" />
  <br /><span class="small">{#from_email_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#topnumber#}:
  </td>
  <td width="50%" valign="top">
    <input name="topnumber" type="text" size="40" maxlength="5" value="{$settings.topnumber}" />
  <br /><span class="small">{#topnumber_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#debug#}:
  </td>
  <td width="50%" valign="top">
    <select name="stats">
    {html_options values=$zeroone output=$yesno selected=$settings.stats}
    </select>
  <br /><span class="small">{#debug_info#}</span>
  </td>
</tr>
</table>
<p />

<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border" id="datetime">
<tbody>
<tr class="sectionheader">
  <td colspan="2">{#date_time_settings#}</td>
</tr>
<tr>
  <td colspan="2"><a href="javascript:toggle(1)"><img src="{#img_dir#}/collapse.gif" border="0" alt="" id="datetime_img"></a> {#date_time_settings_info#}</td>
</tr>
<tr>
  <td width="50%" valign="top">{#timeoffset#}:
  </td>
  <td width="50%" valign="top">
    <input name="timeoffset" type="text" size="40" maxlength="5" value="{$settings.timeoffset}" />
  <br /><span class="small">{#timeoffset_info#} {$smarty.now|date_format:$settings.time_format}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#timezone#}:
  </td>
  <td width="50%" valign="top">
    <input name="timezone" type="text" size="40" maxlength="100" value="{$settings.timezone}" />
  <br /><span class="small">{#timezone_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#date_format#}:
  </td>
  <td width="50%" valign="top">
    <input name="date_format" type="text" size="40" maxlength="40" value="{$settings.date_format}" />
  <br /><span class="small">{#date_format_info#} {$smarty.now|date_format:$settings.date_format}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#time_format#}:
  </td>
  <td width="50%" valign="top">
    <input name="time_format" type="text" size="40" maxlength="40" value="{$settings.time_format}" />
  <br /><span class="small">{#time_format_info#} {$smarty.now|date_format:$settings.time_format}</span>
  </td>
</tr>
</tbody>
</table>
<p />

<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border" id="mainpage">
<tr class="sectionheader">
  <td colspan="2">{#main_page_settings#}</td>
</tr>
<tr>
  <td colspan="2"><a href="javascript:toggle(2)"><img src="{#img_dir#}/collapse.gif" border="0" alt="" id="mainpage_img"></a> {#main_page_settings_info#}</td>
</tr>
<tr>
  <td width="50%" valign="top">{#viewall#}:
  </td>
  <td width="50%" valign="top">
    <select name="viewall">
    {html_options values=$zeroone output=$yesno selected=$settings.viewall}
    </select>
  <br /><span class="small">{#viewall_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#enable_stats#}:
  </td>
  <td width="50%" valign="top">
    <select name="dbstats">
    {html_options values=$zeroone output=$yesno selected=$settings.dbstats}
    </select>
  <br /><span class="small">{#enable_stats_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#display_tags#}:
  </td>
  <td width="50%" valign="top">
    <select name="display_tags">
    {html_options values=$zeroone output=$yesno selected=$settings.display_tags}
    </select>
  <br /><span class="small">{#display_tags_info#}</span>
  </td>
</tr>
</table>
<p />

<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border" id="category">
<tr class="sectionheader">
  <td colspan="2">{#view_category_settings#}</td>
</tr>
<tr>
  <td colspan="2"><a href="javascript:toggle(3)"><img src="{#img_dir#}/collapse.gif" border="0" alt="" id="category_img"></a> {#view_category_settings_info#}</td>
</tr>
<tr>
  <td width="50%" valign="top">{#sort_override#}:
  </td>
  <td width="50%" valign="top">
    <select name="sort_override">
    {html_options values=$zeroone output=$yesno selected=$settings.sort_override}
    </select>
  <br /><span class="small">{#sort_override_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#quickdl#}:
  </td>
  <td width="50%" valign="top">
    <select name="quickdl">
    {html_options values=$zeroone output=$yesno selected=$settings.quickdl}
    </select>
  <br /><span class="small">{#quickdl_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#perpage#}:
  </td>
  <td width="50%" valign="top">
    <input name="perpage" type="text" size="40" value="{$settings.perpage}" />
  <br /><span class="small">{#perpage_info#}</span>
  </td>
</tr>
</table>
<p />

<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border" id="file">
<tr class="sectionheader">
  <td colspan="2">{#view_file_settings#}</td>
</tr>
<tr>
  <td colspan="2"><a href="javascript:toggle(4)"><img src="{#img_dir#}/collapse.gif" border="0" alt="" id="file_img"></a> {#view_file_settings_info#}</td>
</tr>
<tr>
  <td width="50%" valign="top">{#enable_email#}:
  </td>
  <td width="50%" valign="top">
    <select name="enable_email">
    {html_options values=$zeroone output=$yesno selected=$settings.enable_email}
    </select>
  <br /><span class="small">{#enable_email_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#enable_report#}:
  </td>
  <td width="50%" valign="top">
    <select name="enable_report">
    {html_options values=$zeroone output=$yesno selected=$settings.enable_report}
    </select>
  <br /><span class="small">{#enable_report_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#showss#}:
  </td>
  <td width="50%" valign="top">
    <select name="showss">
    {html_options values=$zeroone output=$yesno selected=$settings.showss}
    </select>
  <br /><span class="small">{#showss_info#}</span>
  </td>
</tr>
</table>
<p />

<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border" id="comment">
<tr class="sectionheader">
  <td colspan="2">{#comment_settings#}</td>
</tr>
<tr>
  <td colspan="2"><a href="javascript:toggle(5)"><img src="{#img_dir#}/collapse.gif" border="0" alt="" id="comment_img"></a> {#comment_settings_info#}</td>
</tr>
<tr>
  <td width="50%" valign="top">{#enable_comments#}:
  </td>
  <td width="50%" valign="top">
    <select name="enable_comments">
    {html_options values=$zeroone output=$yesno selected=$settings.enable_comments}
    </select>
  <br /><span class="small">{#enable_comments_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#guest_comments#}:
  </td>
  <td width="50%" valign="top">
    <select name="guest_comments">
    {html_options values=$zeroone output=$yesno selected=$settings.guest_comments}
    </select>
  <br /><span class="small">{#guest_comments_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#comments_perpage#}:
  </td>
  <td width="50%" valign="top">
    <input name="comments_perpage" type="text" size="40" value="{$settings.comments_perpage}" />
  <br /><span class="small">{#comments_perpage_info#}</span>
  </td>
</tr>
</table>
<p />

<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border" id="users">
<tr class="sectionheader">
  <td colspan="2">{#user_settings#}</td>
</tr>
<tr>
  <td colspan="2"><a href="javascript:toggle(6)"><img src="{#img_dir#}/collapse.gif" border="0" alt="" id="users_img"></a> {#user_settings_info#}</td>
</tr>
<tr>
  <td width="50%" valign="top">{#enable_registration#}:
  </td>
  <td width="50%" valign="top">
    <select name="enable_registration">
    {html_options values=$zeroone output=$yesno selected=$settings.enable_registration}
    </select>
  <br /><span class="small">{#enable_registration_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#validate_email#}:
  </td>
  <td width="50%" valign="top">
    <select name="validateemail">
    {html_options values=$zeroone output=$yesno selected=$settings.validateemail}
    </select>
  <br /><span class="small">{#validate_email_info#}</span>
  </td>
</tr>
<tr>
  <td width="50%" valign="top">{#require_registration#}:
  </td>
  <td width="50%" valign="top">
    <select name="require_registration">
    {html_options values=$reqs output=$regreq selected=$settings.require_registration}
    </select>
  <br /><span class="small">{#require_registration_info#}</span>
  </td>
</tr>
</table>
<p />

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
<tr>
  <td colspan="2" align="center"><input type="submit" value="{#edit_settings#}" /></td>
</tr> 
</table>
</form>
<script language="javascript" type="text/javascript">
collapseAll();
</script>