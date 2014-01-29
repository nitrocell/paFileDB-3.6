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
    <form action="{$settings.dburl}/admin.php?act=custom&amp;c=add&amp;process" method="post">
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
      <tr class="sectionheader">
        <td width="100%" colspan="2">{#add_cu#}</td>
      </tr>
      <tr>
        <td width="50%">{#name#}:</td>
        <td width="50%">
          <input type="text" size="40" name="name" maxlength="50" />
        </td>
      </tr>
      <tr>
        <td width="50%">{#description#}:</td>
        <td width="50%">
          <input type="text" size="40" name="desc" maxlength="150" />
      </tr>
      <tr>
         <td width="100%" align="center" colspan="2">
           <input type="submit" value="{#add_cu#}" />
         </td>
        </tr>
    </table>
    </form>
{elseif $c == "edit"}
        <form action="{$settings.dburl}/admin.php?act=custom&amp;c=edit&amp;id={$target.custom_id}&amp;process" method="post">
            <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
      <tr class="sectionheader">
        <td width="100%" colspan="2">{#edit_cu#}</td>
      </tr>
      <tr>
        <td width="50%">{#name#}:</td>
        <td width="50%">
          <input type="text" size="40" name="name" value="{$target.custom_name}" maxlength="50" />
        </td>
      </tr>
      <tr>
        <td width="50%">{#description#}:</td>
        <td width="50%">
          <input type="text" size="40" name="desc" value="{$target.custom_description}" maxlength="150" />
      </tr>
      <tr>
         <td width="100%" align="center" colspan="2">
           <input type="submit" value="{#edit_cu#}" />
         </td>
        </tr>
    </table>
    </form>
{else}
    <script language="javascript" type="text/javascript">
        function deleteconf(id) {ldelim}
            if (confirm('{#delete_cu_conf#}')) {ldelim}
                window.location.href= '{$settings.dburl}/admin.php?act=custom&c=delete&id=' + id;
            {rdelim}
        {rdelim}
        {if $c == "recount"}
            alert('{#recount_c_msg#}');
        {/if}
    </script>
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
    <tr class="sectionheader">
      <td colspan="2">{#manage_cu#}</td>
    </tr>
    <tr>
      <td colspan="2">
        {#manage_cu_info#}<br />&nbsp;<br />
        <img src="{#img_dir#}/pencil.gif" alt="{#edit#}" border="0" />&nbsp;{#manage_cu_info_edit#}<br />&nbsp;<br />
        <img src="{#img_dir#}/x.gif" alt="{#delete#}" border="0" />&nbsp;{#manage_cu_info_delete#}<br />
      </td>
    </tr>
    {foreach key=row item=f from=$fields}
    <tr class="{cycle values=row1,row2}">
      <td width="85%">
        {$f.custom_name}<br />
        <span class="small">{$f.custom_description}</span>
      </td>
      <td width="15%" align="center">
        <a href="{$settings.dburl}/admin.php?act=custom&amp;c=edit&amp;id={$f.custom_id}""><img src="{#img_dir#}/pencil.gif" alt="{#edit#}" border="0" /></a>&nbsp;
        <a href="javascript:deleteconf({$f.custom_id})""><img src="{#img_dir#}/x.gif" alt="{#delete#}" border="0" /></a>
      </td>
    </tr>
    {/foreach}    
    </table>
{/if}