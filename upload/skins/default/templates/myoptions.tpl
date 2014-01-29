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

<form action="{$settings.dburl}/index.php?act=myoptions&amp;process" method="post">
<table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
  <tr class="sectionheader">
	<td width="100%" colspan="2">{#myoptions#}</td>
  </tr>
  <tr>
	<td width="50%">{#curpass#}:</td>
	<td width="50%">
	  <input type="password" size="40" name="current_password" />
  </tr>
  <tr>
	<td width="50%">{#email#}:</td>
	<td width="50%">
	  <input type="text" size="40" name="email" value="{$me.user_email}" />
	</td>
  </tr>
  <tr>
	<td width="50%">{#newpass#}:</td>
	<td width="50%">
		<input type="password" size="40" name="new_password" /><br />
		<span class="small">{#leave_pass_blank#}</span>
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
	   <input type="submit" value="{#savechanges#}" />
	 </td>
  </tr>
</table>
</form>