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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{#local_lang#}" lang="{#local_lang#}" dir="{#local_direction#}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={#local_charset#}" />
<title>{$title|default:"paFileDB"}</title>
<link href="{$settings.dburl}/skins/default/style.css" rel="stylesheet" type="text/css" />
<!--Thanks to kk5st on the DevShed forums for the vertical center code-->
<style type="text/css">
{literal}
html, body, table {
    min-height: 100%;
    width: 100%;
    height: 100%
}

body {
    margin: 0;
}

table {
    position: absolute;
    top: 0;
    left: 0;
}

td {
    height: 100%;
    text-align: center;
} /*for stupid MSIE */

p {
    font-size: 1em;
}

p+p {
    text-indent: 2em;
}

#container {
    position: relative;
    margin: 0 auto;
    width: 40%;
    border: 0px;
    text-align: center;
    padding: 3px;
}
{/literal}
</style>
</head>

<body>
<table><tr><td>
<div id="container">
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="border">
  <tr class="sectionheader">
    <td>{#error#}</td>
  </tr>
  <tr>
    <td align="center">{$message}</td>
  </tr>
</table>
</div>
</td></tr></table>

</body>
</html>
