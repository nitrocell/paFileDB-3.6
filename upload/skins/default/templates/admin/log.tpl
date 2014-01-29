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

{if $v == 1}
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
    <tr class="sectionheader">
      <td>{#email_log#}</td>
    </tr>
    <tr>
      <td>
        <b>{#from#}:</b><br />
        {$l.e_fromname} &lt;{$l.e_fromaddress}&gt;<hr /><br />
        <b>{#to#}:</b><br />
        {$l.e_toaddress}<hr /><br />
        <b>{#subject#}:</b><br />
        {$l.e_subject}<hr /><br />
        <b>{#headers#}:</b><br />
        {$l.e_headers}<hr /><br />
        <b>{#date_sent#}:</b><br />
        {$l.e_date|date_format:"%B %e, %Y %I:%M %p"}<hr /><br />
        <b>{#ip#}:</b><br />
        {$l.e_ip}<hr /><br />
        <b>{#message#}:</b><br />
        {$l.e_message}<hr /><br />
      </td>
    </tr>
    </table>
{else}
    <script language="javascript" type="text/javascript">
        function deleteconf(id) {ldelim}
            if (confirm('{#delete_log_conf#}')) {ldelim}
                window.location.href= '{$settings.dburl}/admin.php?act=log&delete&id=' + id;
            {rdelim}
        {rdelim}
        function clearconf() {ldelim}
            if (confirm('{#clearlog_conf#}')) {ldelim}
                window.location.href= '{$settings.dburl}/admin.php?act=log&clear';
            {rdelim}
        {rdelim}
    </script>
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
    <tr class="sectionheader">
      <td>
      {#email_log#}</td>
    </tr>
    <tr><td>{#email_log_info#}
    <br><b><a href="javascript:clearconf()">{#clearlog#}</a></b>
    </td></tr>
    {foreach key=row item=l from=$logs}
    <tr class="{cycle values=row1,row2}">
      <td>
        <b>{#from#}:</b> {$l.e_fromname} &lt;{$l.e_fromaddress}&gt;<br />
        <b>{#to#}:</b> {$l.e_toaddress}<br />
        <b>{#subject#}:</b> {$l.e_subject}<br />
        <b>{#date_sent#}:</b> {$l.e_date|date_format:"%B %e, %Y %I:%M %p"}<br />
        <b>{#message#}:</b> {$l.e_message|truncate:120:"...":true|strip_tags}<br />
        <a href="{$settings.dburl}/admin.php?act=log&amp;view&amp;id={$l.e_id}"><img src="{#img_dir#}/info.gif" border="0" alt="{#detailed_info#}" /></a>&nbsp;
        <a href="javascript:deleteconf({$l.e_id})" style="font-size: 9px;"><img src="{#img_dir#}/x.gif" border="0" alt="{#delete#}" /></a>
      </td>
    </tr>
    {/foreach}    
    </table>
{/if}