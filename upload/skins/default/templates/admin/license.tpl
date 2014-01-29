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

{if ($l == "add" || $l == "edit") && !$isSafari}
<script language="javascript" type="text/javascript" src="{$settings.dburl}/includes/js/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({ldelim}
		mode : "textareas",
		theme : "advanced",
		plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,inlinepopups,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor,advsearchreplace",
		theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons3_add : "emotions,iespell,media,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		content_css : "example_full.css",
	    plugin_insertdate_dateFormat : "%Y-%m-%d",
	    plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
		external_link_list_url : "example_link_list.js",
		external_image_list_url : "example_image_list.js",
		flash_external_list_url : "example_flash_list.js",
		media_external_list_url : "example_media_list.js",
		theme_advanced_resize_horizontal : false,
		theme_advanced_resizing : true,
		nonbreaking_force_tab : true,
		apply_source_formatting : false,
		remove_linebreaks : true,
		oninit : "nl2br"
	{rdelim});
</script>
{/if}
{if $l == "add"}
    <form action="{$settings.dburl}/admin.php?act=license&amp;l=add&amp;process" method="post">
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
      <tr class="sectionheader">
        <td width="100%" colspan="2">{#add_l#}</td>
      </tr>
      <tr>
        <td width="50%">{#license_name#}:</td>
        <td width="50%">
          <input type="text" size="40" name="name" />
        </td>
      </tr>
      <tr>
        <td width="50%" colspan="2">
          <textarea name="text" rows="70" style="width: 100%" ></textarea>
        </td>
      </tr>
       <tr>
         <td width="100%" align="center" colspan="2">
           <input type="submit" value="{#add_l#}" />
         </td>
        </tr>
    </table>
    </form>
{elseif $l == "edit"}
        <form action="{$settings.dburl}/admin.php?act=license&amp;l=edit&amp;id={$target.license_id}&amp;process" method="post">
        <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
      <tr class="sectionheader">
        <td width="100%" colspan="2">{#edit_l#}</td>
      </tr>
      <tr>
        <td width="50%">{#license_name#}:</td>
        <td width="50%">
          <input type="text" size="40" name="name" value="{$target.license_name}" />
        </td>
      </tr>
      <tr>
        <td width="50%" colspan="2">
          <textarea name="text" rows="70" style="width: 100%" id="text">{$target.license_text}</textarea>
        </td>
      </tr>
       <tr>
         <td width="100%" align="center" colspan="2">
           <input type="submit" value="{#edit_l#}" />
         </td>
        </tr>
    </table>
    </form>
{else}
    <script language="javascript" type="text/javascript">
        function deleteconf(id, cat) {ldelim}
            if (confirm('{#delete_l_conf#}')) {ldelim}
                window.location.href= '{$settings.dburl}/admin.php?act=license&l=delete&id=' + id;
            {rdelim}
        {rdelim}
    </script>
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
    <tr class="sectionheader">
      <td colspan="2">{#manage_l#}</td>
    </tr>
    <tr>
      <td colspan="2">
       {#manage_l_info#}<br />&nbsp;<br />
       <img src="{#img_dir#}/pencil.gif" alt="{#edit#}" border="0" />&nbsp;{#manage_l_edit#}<br />&nbsp;<br />
       <img src="{#img_dir#}/x.gif" alt="{#delete#}" border="0" />&nbsp;{#manage_l_delete#}
      </td>
    </tr>
    {foreach key=row item=l from=$licenses}
    <tr class="{cycle values=row1,row2}">
      <td width="85%">
         {$l.license_name}
      </td>
        <td width="15%" align="center">
        <a href="{$settings.dburl}/admin.php?act=license&amp;l=edit&amp;id={$l.license_id}"><img src="{#img_dir#}/pencil.gif" alt="{#edit#}" border="0" /></a>
        <a href="javascript:deleteconf({$l.license_id})"><img src="{#img_dir#}/x.gif" alt="{#delete#}" border="0" /></a>
      </td>
    </tr>
    {/foreach}    
    </table>
{/if}
{if ($l == "add" || $l == "edit") && !$isSafari}
<script language="javascript" type="text/javascript">
	function nl2br() {ldelim}
		document.getElementById("text").value = document.getElementById("text").value.replace(/\n/g, "<br />");
		tinyMCE.updateContent("text");
	{rdelim}
</script>
{/if}