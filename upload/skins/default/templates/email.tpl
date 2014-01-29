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

  <form action="{$settings.dburl}/index.php?act=email&amp;id={$id}&amp;email&amp;process" method="post">
  <table width="75%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
  <tr>
    <td width="100%" colspan="2" class="sectionheader" valign="top" height="100%">
      <b>{#emailfriend#}</b>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      {#emailforminfo#}
    </td>
  </tr>
  <tr>
    <td width="50%">{#your_name#}:</td>
    <td width="50%"><input type="text" name="fromname" size="40" /></td>
  </tr>
  <tr>
    <td width="50%">{#your_email#}:</td>
    <td width="50%"><input type="text" name="fromemail" size="40" /></td>
  </tr>
  <tr>
    <td width="50%">{#friend_name#}:</td>
    <td width="50%"><input type="text" name="toname" size="40" /></td>
  </tr>
  <tr>
    <td width="50%">{#friend_email#}:</td>
    <td width="50%"><input type="text" name="toemail" size="40" /></td>
  </tr>
  <tr>
    <td width="50%">{#message#}:</td>
    <td width="50%"><textarea name="message" rows="16" cols="120" style="width: 95%; height: 200px;"></textarea></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" value="{#send#}" /></td>
  </tr>
</table>
</form>