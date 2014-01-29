<?php

/***************************************************************
* paFileDB 3.6                                                 *
*                                                              *
* Author: PHP Arena <http://www.phparena.net>                  *
* File Version 3.6                                             *
* Copyright ©2005-2007 PHP Arena. All Rights Reserved.         *
*                                                              *
* THIS FILE MAY NOT BE REDISTRIBUTED.                          *
* For more information, please see the PHP Arena license at:   *
* http://www.phparena.net/license.html                         *
***************************************************************/

if ($userinfo[0]['user_status'] > 4) {
	if (isset($_GET['deletenews'])) {
		$db->Execute("DELETE FROM ".$dbPrefix."adminnews WHERE date = ".intval($_GET['id']));
	}
	if (isset($_GET['redownload'])) {
		$db->Execute("DELETE FROM ".$dbPrefix."adminnews");
		$db->Execute("UPDATE ".$dbPrefix."settings SET newest_news = 0");
		$settings[0]['newest_news'] = 0;
	}
	$newestItem = file('http://feed.phparena.net/pafiledb/newestItem.txt');
	if ($newestItem[0] > $settings[0]['newest_news']) {
		define('MAGPIE_CACHE_ON', false);
		require('./includes/admin/rss/rss_fetch.inc');
		$rss = fetch_rss('http://feed.phparena.net/pafiledb/feed.xml');
		foreach($rss->items as $n) {
			if (intval($n['unixtime']) > $settings[0]['newest_news']) {
				$db->Execute("INSERT INTO ".$dbPrefix."adminnews (date, subject, text) VALUES (".$n['unixtime'].", '".smart_slashes($n['title'])."', '".smart_slashes($n['summary'])."')");
			}
		}
		$db->Execute("UPDATE ".$dbPrefix."settings SET newest_news = ".$rss->items[0]['unixtime']);
	}
	$news = $db->GetArray("SELECT * FROM ".$dbPrefix."adminnews ORDER BY date DESC");
	$smarty->assign('news', $news);
}
?>