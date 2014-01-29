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

<form action="{$settings.dburl}/index.php?act=view&amp;id={$file.file_id}&amp;rate" method="post">
      {foreach item=star from=$stars}
        <img src="{#img_dir#}/{$star}" />
      {/foreach} <span class="small">({$file.file_totalvotes} {#ratings#})</span>&nbsp;
      {if $already_rated == false}
          <select name="rating" id="rating">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3" selected="selected">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
         </select> 
         <span id="submitButton"><input type="submit" name="Submit" onclick="rateFile({$file.file_id},document.getElementById('rating').value);return false;" value="{#rate_oneword#}" /></div>
       
    {/if}
</form>