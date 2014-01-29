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

{if $u == "add"}
    <form action="{$settings.dburl}/admin.php?act=users&amp;u=add&amp;process" method="post">
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
      <tr class="sectionheader">
        <td width="100%" colspan="2">{#add_u#}</td>
      </tr>
      <tr>
        <td width="50%">{#username#}:</td>
        <td width="50%">
          <input type="text" size="40" name="uname" maxlength="25" />
        </td>
      </tr>
      <tr>
        <td width="50%">{#password#}:</td>
        <td width="50%">
          <input type="text" size="40" name="password" />
      </tr>
      <tr>
        <td width="50%">{#email#}:</td>
        <td width="50%">
          <input type="text" size="40" name="email" maxlength="50" />
        </td>
      </tr>
      <tr>
        <td width="50%">{#user_status#}:</td>
        <td width="50%">
          <select name="status">
          {html_options output=$stat_name values=$stat_id selected=3}
          </select>
          <br />
          <span class="small">{#user_status_info#}</span>
        </td>
      </tr>
      <tr>
         <td width="100%" align="center" colspan="2">
           <input type="submit" value="{#add_u#}" />
         </td>
      </tr>
    </table>
    </form>
{elseif $u == "edit"}
        <form action="{$settings.dburl}/admin.php?act=users&amp;u=edit&amp;id={$target.user_userid}&amp;process" method="post">
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
      <tr class="sectionheader">
        <td width="100%" colspan="2">{#edit_u#}</td>
      </tr>
      <tr>
        <td width="50%">{#username#}:</td>
        <td width="50%">
          <input type="text" size="40" name="uname" value="{$target.user_username}" maxlength="25" />
        </td>
      </tr>
      <tr>
        <td width="50%">{#password#}:</td>
        <td width="50%">
          <input type="text" size="40" name="password" />
          <br /><span style="small">{#leave_pass_blank#}</span>
      </tr>
      <tr>
        <td width="50%">{#email#}:</td>
        <td width="50%">
          <input type="text" size="40" name="email" value="{$target.user_email}" maxlength="50" />
        </td>
      </tr>
      <tr>
        <td width="50%">{#user_status#}:</td>
        <td width="50%">
          <select name="status">
          {html_options output=$stat_name values=$stat_id selected=$target.user_status}
          </select>
          <br />
          <span class="small">{#user_status_info#}</span>
        </td>
      </tr>
      <tr>
         <td width="100%" align="center" colspan="2">
           <input type="submit" value="{#edit_u#}" />
         </td>
      </tr>
    </table>
    <input type="hidden" name="oldname" value="{$target.user_username}" />
    </form>
{else}
    <script language="javascript" type="text/javascript">
        function deleteconf(id) {ldelim}
            if (confirm('{#delete_u_conf#}')) {ldelim}
                window.location.href= '{$settings.dburl}/admin.php?act=users&u=delete&id=' + id;
            {rdelim}
        {rdelim}
    </script>
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
    <tr class="sectionheader">
      <td colspan="3">{#manage_u#}</td>
    </tr>
    <tr>
      <td colspan="3">
        {#manage_u_info#}<br />&nbsp;<br />
        <img src="{#img_dir#}/pencil.gif" alt="{#edit#}" border="0" />&nbsp;{#manage_u_info_edit#}<br />&nbsp;<br />
       <img src="{#img_dir#}/x.gif" alt="{#delete#}" border="0" />&nbsp;{#manage_u_info_delete#}
      </td>
    </tr>
    {foreach key=row item=u from=$users}
    {if $userinfo.user_userid != $u.user_userid}
    <tr>
      <td width="75%">
        {$u.user_username}
      </td>
      <td width="15%" align="center">
        {if $u.user_status == 1}
          {#banned#}
        {elseif $u.user_status == 2}
          {#awaiting_validation#}
        {elseif $u.user_status == 3}
          {#regular_user#}
        {elseif $u.user_status == 4}
          {#moderator#}
        {elseif $u.user_status == 5}
          {#administrator#}
        {elseif $u.user_status == 6}
          {#super_administrator#}
        {/if}
        <td width="10%" align="center">
        <a href="{$settings.dburl}/admin.php?act=users&amp;u=edit&amp;id={$u.user_userid}"><img src="{#img_dir#}/pencil.gif" alt="{#edit#}" border="0" /></a>&nbsp;&nbsp;<a href="javascript:deleteconf({$u.user_userid})"><img src="{#img_dir#}/x.gif" alt="{#delete#}" border="0" /></a>
      </td>
    </tr>
    {/if}
    {/foreach} 
    </table>
{/if}