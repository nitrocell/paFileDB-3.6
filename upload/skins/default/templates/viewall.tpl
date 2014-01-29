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

{if $count > 0}
    <table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
      <tr class="sectionheader">
        <td width="5%">&nbsp;</td>
        <td width="75%">{#file#}</td>
        <td width="10%">{#downloads#}</td>
        <td width="10%">{#date_added#}</td>
      </tr>



    {foreach key=row item=f from=$pinned}
      <tr class="{cycle values=row1,row2}">
        <td width="5%" align="center">
          <img src="{#img_dir#}/pin.gif" alt = "" />
        </td>
        <td width="75%">
          <a href="{$settings.dburl}/index.php?act=view&amp;id={$f.file_id}">{$f.file_name}</a><br />
          <span class="small">{$f.file_desc}</span>
        </td>
        <td width="10%" align="center">
          {$f.file_dls}
        </td>
        <td width="10%" align="center">
          {$f.file_time|date_format:$settings.date_format}
        </td>
      </tr>
    {/foreach}

    {foreach key=row item=f from=$files}
      <tr class="{cycle values=row1,row2}">
        <td width="5%" align="center">
          {if $f.file_pin == 1}
          	<img src="{#img_dir#}/pin.gif" alt="" />
          {elseif $f.file_posticon == ""}
            &nbsp;
          {else}
            <img src="{$settings.dburl}/posticons/{$f.file_posticon}" alt = "" />
          {/if}
        </td>
        <td width="65%">
         {if $settings.quickdl == 1} 
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="95%">
              	<a href="{$settings.dburl}/index.php?act=view&amp;id={$f.file_id}">{$f.file_name}</a><br />
                <span class="small">{$f.file_desc}</span>
               </td>
               <td width="5%" align="right">
                 <a href="{$f.qdl}"><img src="{#img_dir#}/quickdl.gif" alt="{#download#}" border="0" /></a>
               </td>
              </tr>
            </table>
           {else}
           	<a href="{$settings.dburl}/index.php?act=view&amp;id={$f.file_id}">{$f.file_name}</a><br />
            <span class="small">{$f.file_desc}</span>
           {/if}
        </td>
        <td width="10%" align="center">
          {$f.file_dls}
        </td>
        <td width="10%" align="center">
          {$f.file_time|date_format:$settings.date_format}
        </td>
      </tr>
    {/foreach}
    {if $settings.sort_override == 1}
      <tr>
        <td colspan="4" align="center">
          <form action="index.php?act=viewall&sort" method="post">
          {#sort_by#}: 
          <select name="sortby">
            {html_options values=$sort_val output=$sort_name selected=$cursort}
          </select> 
          {#order#}: 
          <select name="order">
            {html_options values=$order_val output=$order_name selected=$curorder}
          </select> 
          <input type="submit" value="{#sort#}" />
          </form>
        </td>
      </tr>
    {/if}
    </table>
{/if}
{if $count > $settings.perpage}
<p />
<div align="center">
{section name=pages loop=$pages}
<a href="{$settings.dburl}/index.php?act=viewall&amp;start={$pages[pages].1}">{if $pages[pages].0 eq "back"}&laquo;&laquo;{elseif $pages[pages].0 eq "forward"}&raquo;&raquo;{else}{$pages[pages].0}{/if}</a>
{/section}
</div><p />
{/if}