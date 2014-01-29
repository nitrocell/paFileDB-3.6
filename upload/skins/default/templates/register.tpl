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

{if $act == regvalidate} 
	<table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
    <tr class="sectionheader">
      <td> {#register#} </td>
    </tr>
    <tr>
      <td>{#validation_message#}</td>
    </tr>
    </table>
{else}  
    <form action="{$settings.dburl}/index.php?act=register&amp;process" method="post">
    <table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
    <tr class="sectionheader">
      <td colspan="2"> {#register#} </td>
    </tr>
    <tr>
      <td width="50%">{#username#}:</td>
      <td width="50%">
        <input type="text" name="username" size="40" maxlength="25" />
      </td>
    </tr>
    <tr>
      <td width="50%">{#password#}:</td>
      <td width="50%">
        <input type="password" name="password" size="40" />
      </td>
    </tr>
    <tr>
      <td width="50%">{#confirm_pass#}:</td>
      <td width="50%">
        <input type="password" name="conf" size="40" />
      </td>
    </tr>
    <tr>
      <td width="50%">{#email#}:</td>
      <td width="50%">
        <input type="text" name="email" size="40" maxlength="50" />
      </td>
    </tr>
    <tr>
      <td align="center" colspan="2"><input type="submit" value="{#register#}" /></td>
    </tr>
    </table>
    </form>
{/if}