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

{if $logact ne "process"}
    <form action="{$settings.dburl}/index.php?act=login&amp;process" method="post">
    <input type="hidden" name="qs" value="{$qs}" />
    <table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
      <tr>
        <td colspan="2" class="sectionheader">{#login#}</td>
      </tr>
      <tr>
        <td width="50%">{#username#}:</td>
        <td width="50%"><input type="text" name="username" size="40" maxlength="25" /></td>
      </tr>
      <tr>
        <td width="50%">{#password#}:</td>
        <td width="50%"><input type="password" name="password" size="40" /> 
        <a href="{$settings.dburl}/index.php?act=lostpw">{#lost_password#}?</a>
      </td>
      </tr>
      <tr>
        <td align="center" width="100%" colspan="2"><input type="submit" value="{#login#}" /></td>
      </tr>
    </table>
    </form>
{/if}