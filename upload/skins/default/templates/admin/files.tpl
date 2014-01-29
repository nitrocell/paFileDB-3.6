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

{if $f == "add"}
    <form enctype="multipart/form-data" action="{$settings.dburl}/admin.php?act=files&amp;f=add&amp;process" method="post">
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
      <tr class="sectionheader">
        <td width="100%" colspan="2">{#add_f#}</td>
      </tr>
      <tr>
        <td width="50%">{#file_name#}:</td>
        <td width="50%">
          <input type="text" size="40" name="name" maxlength="150" /><br />
          <span class="small">{#file_name_info#}</span>
        </td>
      </tr>
      <tr>
        <td width="50%">{#short_desc#}:</td>
        <td width="50%">
          <input type="text" size="40" name="sdesc" maxlength="200" /><br />
          <span class="small">{#short_desc_info#}</span>
        </td>
      </tr>
      <tr>
        <td width="50%">{#long_desc#}:</td>
        <td width="50%">
          <textarea name="ldesc" cols="40" rows="5"></textarea><br />
          <span class="small">{#long_desc_info#}</span>
        </td>
      </tr>
      <tr>
        <td width="50%">{#category#}:</td>
        <td width="50%">
          <select name="cat">
            {html_options values=$c_id output=$c_name}
          </select><br />
          <span class="small">{#category_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#creator#}:</td>
        <td width="50%">
          <input type="text" size="40" name="creator" maxlength="100" /><br />
          <span class="small">{#creator_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#version#}:</td>
        <td width="50%">
          <input type="text" size="40" name="version" maxlength="20" /><br />
          <span class="small">{#version_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#screenshot_url#}:</td>
        <td width="50%">
          <input type="text" size="40" name="ss" /><br />
          <span class="small">{#screenshot_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#upload_ss#}:</td>
        <td width="50%">
          <input type="file" name="ssfile" size="40" /><br />
          <span class="small">{#upload_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#documentation_url#}:</td>
        <td width="50%">
          <input type="text" size="40" name="documentation" /><br />
          <span class="small">{#documentation_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#download_url#}:</td>
        <td width="50%">
          <input type="text" size="40" name="dlurl" value="{$settings.dburl}" /><br />
          <span class="small">{#download_url_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#upload#}:</td>
        <td width="50%">
          <input type="file" name="upfile" size="40" /><br />
          <span class="small">{#upload_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#file_mirrors#}:</td>
        <td width="50%">
          <textarea name="mirrors" cols="40" rows="5"></textarea><br />
          <span class="small">{#file_mirrors_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#posticon#}:</td>
        <td width="50%">
          {html_radios name="posticon" values=$i_name output=$i_img separator=" "}
          <br />
          <span class="small">{#posticon_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#license#}:</td>
        <td width="50%">
          <select name="license">
             {html_options values=$l_id output = $l_name}
          </select>
          <br />
          <span class="small">{#license_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#pin#}:</td>
        <td width="50%">
          <select name="pin">
            {html_options values=$zeroone output=$yesno selected=0}
          </select><br />
          <span class="small">{#pin_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#tags#}:</td>
        <td width="50%">
          <textarea name="tags" cols="40" rows="5"></textarea><br />
          <span class="small">{#tags_info#}</span>
        </td>
      </tr>
       {foreach key=row item=f from=$fields}
         <tr>
           <td width="50%">{$f.custom_name}:</td>
           <td width="50%"><input type="text" size="40" name="custom[{$f.custom_id}]" /><br />
          <span class="small">{$f.custom_description}</span></td>
        </tr>
       {/foreach}
       <tr>
         <td width="100%" align="center" colspan="2">
           <input type="submit" value="{#add_f#}" />
         </td>
        </tr>
    </table>
    </form>
{elseif $f == "edit"}
        <form enctype="multipart/form-data" action="{$settings.dburl}/admin.php?act=files&amp;f=edit&amp;id={$target.file_id}&amp;process" method="post">
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
      <tr class="sectionheader">
        <td width="100%" colspan="2">{#edit_f#}</td>
      </tr>
      <tr>
        <td width="50%">{#file_name#}:</td>
        <td width="50%">
          <input type="text" size="40" name="name" value="{$target.file_name}" maxlength="150" /><br />
          <span class="small">{#file_name_info#}</span>
        </td>
      </tr>
      <tr>
        <td width="50%">{#short_desc#}:</td>
        <td width="50%">
          <input type="text" size="40" name="sdesc" value="{$target.file_desc|escape:'html'}" maxlength="200" /><br />
          <span class="small">{#short_desc_info#}</span>
        </td>
      </tr>
      <tr>
        <td width="50%">{#long_desc#}:</td>
        <td width="50%">
          <textarea name="ldesc" cols="40" rows="5">{$target.file_longdesc|escape:'html'}</textarea><br />
          <span class="small">{#long_desc_info#}</span>
        </td>
      </tr>
      <tr>
        <td width="50%">{#category#}:</td>
        <td width="50%">
          <select name="cat">
            {html_options values=$c_id output=$c_name selected=$target.file_catid}
          </select><br />
          <span class="small">{#category_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#creator#}:</td>
        <td width="50%">
          <input type="text" size="40" name="creator" value="{$target.file_creator|escape:'html'}" maxlength="100" /><br />
          <span class="small">{#creator_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#version#}:</td>
        <td width="50%">
          <input type="text" size="40" name="version" value="{$target.file_version}" maxlength="20" /><br />
          <span class="small">{#version_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#screenshot_url#}:</td>
        <td width="50%">
          <input type="text" size="40" name="ss" value="{$target.file_ssurl}" /><br />
          <span class="small">{#screenshot_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#upload_ss#}:</td>
        <td width="50%">
          <input type="file" name="ssfile" size="40" /><br />
          <span class="small">{#upload_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#documentation_url#}:</td>
        <td width="50%">
          <input type="text" size="40" name="documentation" value="{$target.file_docsurl}" /><br />
          <span class="small">{#documentation_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#download_url#}:</td>
        <td width="50%">
          <input type="text" size="40" name="dlurl" value="{$target.file_dlurl}" /><br />
          <span class="small">{#download_url_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#upload#}:</td>
        <td width="50%">
          <input type="file" name="upfile" size="40" /><br />
          <span class="small">{#upload_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#file_mirrors#}:</td>
        <td width="50%">
          <textarea name="mirrors" cols="40" rows="5">{$mirror_list}</textarea><br />
          <span class="small">{#file_mirrors_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#posticon#}:</td>
        <td width="50%">
          {html_radios name="posticon" values=$i_name output=$i_img separator=" " selected=$target.file_posticon}
          <br />
          <span class="small">{#posticon_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#license#}:</td>
        <td width="50%">
          <select name="license">
             {html_options values=$l_id output = $l_name selected=$target.file_license}
          </select>
          <br />
          <span class="small">{#license_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#pin#}:</td>
        <td width="50%">
          <select name="pin">
            {html_options values=$zeroone output=$yesno selected=$target.file_pin}
          </select><br />
          <span class="small">{#pin_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#tags#}:</td>
        <td width="50%">
          <textarea name="tags" cols="40" rows="5">{$target.file_tags}</textarea><br />
          <span class="small">{#tags_info#}</span>
        </td>
      </tr>
       {foreach key=row item=f from=$fields}
         <tr>
           <td width="50%">{$f.custom_name}:</td>
           <td width="50%"><input type="text" size="40" name="custom[{$f.custom_id}]" value="{$f.data|escape:'html'}" /><br />
          <span class="small">{$f.custom_description}</span></td>
        </tr>
       {/foreach}
       <tr>
        <td width="50%">{#reset_rating#}:</td>
        <td width="50%">
          <select name="reset_rating">
            {html_options values=$zeroone output=$yesno selected=0}
          </select><br />
          <span class="small">{#reset_rating_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#reset_downloads#}:</td>
        <td width="50%">
          <select name="reset_downloads">
            {html_options values=$zeroone output=$yesno selected=0}
          </select><br />
          <span class="small">{#reset_downloads_info#}</span>
        </td>
       </tr>
       <tr>
        <td width="50%">{#reset_date#}:</td>
        <td width="50%">
          <select name="reset_date">
            {html_options values=$zeroone output=$yesno selected=0}
          </select><br />
          <span class="small">{#reset_date_info#}</span>
        </td>
       </tr>
       <tr>
         <td width="100%" align="center" colspan="2">
           <input type="submit" value="{#edit_f#}" />
         </td>
        </tr>
    </table>
    <input type="hidden" name="oldcat" value="{$target.file_catid}" />
    </form>
{else}
    <script language="javascript" type="text/javascript">
        function deleteconf(id, cat) {ldelim}
            if (confirm('{#delete_f_conf#}')) {ldelim}
                window.location.href= '{$settings.dburl}/admin.php?act=files&f=delete&id=' + id + '&cat=' + cat;
            {rdelim}
        {rdelim}
    </script>
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
    <tr class="sectionheader">
      <td colspan="2">{#manage_f#}</td>
    </tr>
    <tr>
      <td colspan="2">
       {#manage_f_info#}<br />&nbsp;<br />
       <img src="{#img_dir#}/pencil.gif" alt="{#edit#}" border="0" />&nbsp;{#manage_info_edit#}<br />&nbsp;<br />
       <img src="{#img_dir#}/x.gif" alt="{#delete#}" border="0" />&nbsp;{#manage_info_delete#}
      </td>
    </tr>
    {foreach key=row item=f from=$files}
    <tr class="{cycle values=row1,row2}">
      <td width="85%">
         {if $f.file_catid == 0}
            <b>{$f.file_name}</b>
         {else}
            {$f.file_name}
         {/if}
        <br />
        <span class="small">{$f.file_desc}</span></td>
        <td width="15%" align="center">
        <a href="{$settings.dburl}/admin.php?act=files&amp;f=edit&amp;id={$f.file_id}"><img src="{#img_dir#}/pencil.gif" alt="{#edit#}" border="0" /></a>
        <a href="javascript:deleteconf({$f.file_id},{$f.file_catid})"><img src="{#img_dir#}/x.gif" alt="{#delete#}" border="0" /></a>
      </td>
    </tr>
    {/foreach}    
    </table>
         {if $count > 20}
        <p />
        <div align="center">
        {section name=pages loop=$pages}
        <a href="{$settings.dburl}/admin.php?act=files&amp;start={$pages[pages].1}&amp;f">{if $pages[pages].0 eq "back"}&laquo;&laquo;{elseif $pages[pages].0 eq "forward"}&raquo;&raquo;{else}{$pages[pages].0}{/if}</a>
        {/section}
        </div><p />
        {/if}
{/if}