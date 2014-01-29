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
      <td> {#lost_password#}</td>
    </tr>
    <tr>
      <td>{#lost_password_checkemail#|replace:'%EMAIL%':$user.user_email}</td>
    </tr>
    </table>
{elseif $act == reset}
<form action="{$settings.dburl}/index.php?act=lostpw&amp;processreset&amp;userid={$user.user_userid}&key={$key}" method="post">
<table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
  <tr class="sectionheader">
	<td width="100%" colspan="2">{#lost_password#}</td>
  </tr>
  <tr>
    <td width="100%" colspan="2">{#enter_new_pass#}</td>
  </tr>
  <tr>
	<td width="50%">{#newpass#}:</td>
	<td width="50%">
		<input type="password" size="40" name="new_password" /><br />
	</td>
  </tr>
  <tr>
	<td width="50%">{#newpassconfirm#}:</td>
	<td width="50%">
		<input type="password" size="40" name="new_confirm" />
	</td>
  </tr>
  <tr>
	 <td width="100%" align="center" colspan="2">
	   <input type="submit" value="{#submit#}" />
	 </td>
  </tr>
</table>
</form>
{elseif $act == processreset}

{else}  
    <form action="{$settings.dburl}/index.php?act=lostpw&amp;process" method="post">
    <table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
    <tr class="sectionheader">
      <td colspan="2"> {#lost_password#} </td>
    </tr>
    <tr>
      <td colspan="2">{#lost_password_info#}</td>
    </tr>
    <tr>
      <td width="50%">{#username#}:</td>
      <td width="50%">
        <input type="text" name="username" size="40" maxlength="25" />
      </td>
    </tr>
    <tr>
      <td align="center" colspan="2"><input type="submit" value="{#submit#}" /></td>
    </tr>
    </table>
    </form>
{/if}