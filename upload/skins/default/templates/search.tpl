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

{if $act == process} 
    <table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
  <tr class="sectionheader">
    <td width="5%">&nbsp;</td>
    <td width="75%">{#file#}</td>
    <td width="10%">{#downloads#}</td>
    <td width="10%">{#date_added#}</td>
  </tr>
    {foreach key=row item=f from=$results}
  <tr class="{cycle values=row1,row2}">
    <td width="5%" align="center">
      {if $f.file_posticon == ""}
        &nbsp;
      {else}
        <img src="{$settings.dburl}/posticons/{$f.file_posticon}" alt = "" />
      {/if}
    </td>
    <td width="65%">
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
    </table>
{else}  
    <form action="{$settings.dburl}/index.php?act=search&amp;process" method="post">
    <table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
    <tr class="sectionheader">
      <td colspan="2"> {#search#} </td>
    </tr>
    <tr>
      <td width="50%">{#query#}:</td>
      <td width="50%">
        <input type="text" name="query" style="width: 75%" />
      </td>
    </tr>
    <tr>
      <td width="50%">{#search_in#}:</td>
      <td width="50%">
        <select name="search_in[]" multiple="multiple">
          <option value="file_name" selected="selected">{#file_name#}</option>
          <option value="file_desc" selected="selected">{#short_desc#}</option>
          <option value="file_longdesc" selected="selected">{#long_desc#}</option>
          <option value="file_creator" selected="selected">{#creator#}</option>
          <option value="file_version" selected="selected">{#version#}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="50%">{#category#}:</td>
      <td width="50%">
        {$categories}
      </td>
    </tr>
    <tr>
      <td align="center" colspan="2"><input type="submit" value="{#search#}" /></td>
    </tr>
    </table>
    </form>
{/if}