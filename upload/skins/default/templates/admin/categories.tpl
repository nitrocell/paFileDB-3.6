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

{if $c == "add"}
    <form action="{$settings.dburl}/admin.php?act=categories&amp;c=add&amp;process" method="post">
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
      <tr class="sectionheader">
        <td width="100%" colspan="2">{#add_c#}</td>
      </tr>
      <tr>
        <td width="50%">{#name#}:</td>
        <td width="50%">
          <input type="text" size="40" name="name" maxlength="75" />
        </td>
      </tr>
      <tr>
        <td width="50%">{#description#}:</td>
        <td width="50%">
          <input type="text" size="40" name="desc" maxlength="150" />
      </tr>
      <tr>
        <td width="50%">{#display_order#}:</td>
        <td width="50%">
          <input type="text" size="4" name="order" maxlength="5" />
      </tr>
      <tr>
        <td width="50%">{#parent#}:</td>
        <td width="50%">
          <select name="parent">
            {html_options values=$cat_id output=$cat_name selected=0}
          </select>
      </tr>
      <tr>
        <td width="50%">{#default_sort_order#}:</td>
        <td width="50%">
          <select name="sort">
            {html_options values=$sort_val output=$sort_name}
          </select>&nbsp;
          <select name="sorder">
            {html_options values=$order_val output=$order_name}
          </select>
      </tr>
      <tr>
         <td width="100%" align="center" colspan="2">
           <input type="submit" value="{#add_c#}" />
         </td>
        </tr>
    </table>
    </form>
{elseif $c == "edit"}
        <form action="{$settings.dburl}/admin.php?act=categories&amp;c=edit&amp;id={$target.cat_id}&amp;process" method="post">
        <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
      <tr class="sectionheader">
        <td width="100%" colspan="2">{#edit_c#}</td>
      </tr>
      <tr>
        <td width="50%">{#name#}:</td>
        <td width="50%">
          <input type="text" size="40" name="name" value="{$target.cat_name}" maxlength="75" />
        </td>
      </tr>
      <tr>
        <td width="50%">{#description#}:</td>
        <td width="50%">
          <input type="text" size="40" name="desc" value="{$target.cat_desc}"  maxlength="150" />
      </tr>
      <tr>
        <td width="50%">{#display_order#}:</td>
        <td width="50%">
          <input type="text" size="4" name="order" value="{$target.cat_order}" maxlength="5" />
      </tr>
      <tr>
        <td width="50%">{#parent#}:</td>
        <td width="50%">
          <select name="parent">
            {html_options values=$cat_id output=$cat_name selected=$target.cat_parent}
          </select>
      </tr>
      <tr>
        <td width="50%">{#default_sort_order#}:</td>
        <td width="50%">
          <select name="sort">
            {html_options values=$sort_val output=$sort_name selected=$sort}
          </select>&nbsp;
          <select name="sorder">
            {html_options values=$order_val output=$order_name selected=$order}
          </select>
      </tr>
      <tr>
         <td width="100%" align="center" colspan="2">
           <input type="submit" value="{#edit_c#}" />
         </td>
        </tr>
    </table>    </form>
{else}
    <script language="javascript" type="text/javascript">
        function deleteconf(id, cat) {ldelim}
            if (confirm('{#delete_c_conf#}')) {ldelim}
                window.location.href= '{$settings.dburl}/admin.php?act=categories&c=delete&id=' + id;
            {rdelim}
        {rdelim}
        {if $c == "recount"}
            alert('{#recount_c_msg#}');
        {/if}
    </script>
    <form action="{$settings.dburl}/admin.php?act=categories&c=reorder" method="post">
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
    <tr class="sectionheader">
      <td colspan="4">{#manage_c#}</td>
    </tr>
    <tr>
      <td colspan="4">
        {#manage_c_info#}<br />&nbsp;<br />
        <img src="{#img_dir#}/pencil.gif" alt="{#edit#}" border="0" />&nbsp;{#manage_c_info_edit#}<br />&nbsp;<br />
        <img src="{#img_dir#}/x.gif" alt="{#delete#}" border="0" />&nbsp;{#manage_c_info_delete#}<br />&nbsp;<br />
        <img src="{#img_dir#}/recount.gif" alt="{#recount#}" border="0" />&nbsp;{#manage_c_info_recount#} <a href="{$settings.dburl}/admin.php?act=categories&c=recountall"><b>{#recount_all#}</b></a><p />
        {#reorder_info#}
      </td>
    </tr>
    {foreach key=row item=c from=$categories}
    <tr class="{cycle values=row1,row2}">
     <td width="75%" colspan="2">
      {$c.cat_name}<br />
      <span class="small">{$c.cat_desc}</span>
     </td>
     <td width="15%" align="center">
      {$c.level}<input type="text" size="2" value="{$c.cat_order}" name="order[{$c.cat_id}]" />
     </td>
     <td width="10%" align="center">
      <a href="{$settings.dburl}/admin.php?act=categories&amp;c=edit&amp;id={$c.cat_id}""><img src="{#img_dir#}/pencil.gif" alt="{#edit#}" border="0" /></a>&nbsp;
      <a href="javascript:deleteconf({$c.cat_id})""><img src="{#img_dir#}/x.gif" alt="{#delete#}" border="0" /></a>&nbsp;
      <a href="{$settings.dburl}/admin.php?act=categories&amp;c=recount&amp;id={$c.cat_id}"><img src="{#img_dir#}/recount.gif" alt="{#recount#}" border="0" /></a>
     </td>
    </tr>
    {/foreach}    
    </table>
    <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
      <td align="center">
        <input type="submit" value="{#reorder_categories#}" />
      </td>
    </tr>
    </table>
    </form>
{/if}