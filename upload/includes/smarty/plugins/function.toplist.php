<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {toplist} function plugin
 *
 * Type:     function<br>
 * Name:     toplist<br>
 * Purpose:  make a toplist on a paFileDB template
 * @author   Todd (http://www.phparena.net)
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_toplist($params, &$smarty)
{
    global $db, $dbPrefix, $settings;
    $config = $settings[0];
    $template = "<b>{number}.</b> <a href=\"{filelink}\">{filename} ({info})</a><br />"; //Template for each line.
    if ($params['type'] == "newest") {
        $result = $db->GetArray("SELECT * FROM ".$dbPrefix."files ORDER BY file_time DESC");
		$info = "Added on {date}";
    } elseif ($params['type'] == "downloads") {
        $result = $db->GetArray("SELECT * FROM ".$dbPrefix."files ORDER BY file_dls DESC");
		$info = "{downloads} Downloads";
    } else {
        return("You didn't select the type of list to show!");
    }
    $i=1;
    foreach($result as $file) {
	    if ($i-1 == $config['topnumber']) { break; }
        $line = str_replace("{number}", $i, $template);
        $line = str_replace("{filelink}", $config['dburl']."/index.php?act=view&id=".$file['file_id'], $line);
        $line = str_replace("{filename}", $file['file_name'], $line);
        if ($params['type'] == "newest") {  $infoline = str_replace("{date}", date("n/j/y", $file['file_time']), $info); }
        if ($params['type'] == "downloads") {$infoline = str_replace("{downloads}", $file['file_dls'] , $info); }
        $line = str_replace("{info}", $infoline, $line);
        $retval .= $line;
        $i++;
    }
    
    return $retval;
}


?>
