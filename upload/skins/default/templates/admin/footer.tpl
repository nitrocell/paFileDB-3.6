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

{if $userloggedin == true && $act ne "news"}
    </td>
  </tr>
</table>
<!--End content, begin footer-->
{if $settings.stats}<div align="center">{$debug_info.0} Queries Used<br />{$debug_info.1} Seconds to execute</div>{/if}
<p />
{*Don't touch the copyright!*}
<div align="center">
  Powered by <a href="http://www.phparena.net/pafiledb" target="_blank">paFileDB {$version}</a><br />
  &copy;2005-2007 PHP Arena
</div>
{/if}
</body>
</html>
