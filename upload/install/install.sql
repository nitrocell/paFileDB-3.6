CREATE TABLE `##PREFIX##adminnews` (
  `date` int(30) NOT NULL default '0',
  `subject` varchar(150) NOT NULL default '',
  `text` text NOT NULL,
  PRIMARY KEY  (`date`)
) TYPE=MyISAM;

CREATE TABLE `##PREFIX##cat` (
  `cat_id` int(5) NOT NULL auto_increment,
  `cat_name` varchar(75) default NULL,
  `cat_desc` varchar(150) default NULL,
  `cat_files` int(10) default NULL,
  `cat_parent` int(5) default NULL,
  `cat_order` int(5) default NULL,
  `cat_sort` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`cat_id`)
) TYPE=MyISAM;

CREATE TABLE `##PREFIX##comments` (
  `comment_id` int(10) NOT NULL auto_increment,
  `comment_userid` int(6) NOT NULL default '0',
  `comment_fileid` int(6) NOT NULL default '0',
  `comment_time` int(20) NOT NULL default '0',
  `comment_subject` varchar(150) NOT NULL default '',
  `comment_ip` varchar(15) NOT NULL default '',
  `comment_text` text NOT NULL,
  PRIMARY KEY  (`comment_id`)
) TYPE=MyISAM;

CREATE TABLE `##PREFIX##custom` (
  `custom_id` int(5) NOT NULL auto_increment,
  `custom_name` varchar(50) NOT NULL default '',
  `custom_description` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`custom_id`)
) TYPE=MyISAM;

CREATE TABLE `##PREFIX##customdata` (
  `customdata_file` int(5) NOT NULL default '0',
  `customdata_custom` int(5) NOT NULL default '0',
  `data` text NOT NULL
) TYPE=MyISAM;

CREATE TABLE `##PREFIX##emaillog` (
  `e_id` int(6) NOT NULL auto_increment,
  `e_date` int(20) NOT NULL default '0',
  `e_ip` varchar(15) NOT NULL default '',
  `e_fromname` text NOT NULL,
  `e_fromaddress` text NOT NULL,
  `e_toname` text NOT NULL,
  `e_toaddress` text NOT NULL,
  `e_headers` text NOT NULL,
  `e_subject` text NOT NULL,
  `e_message` text NOT NULL,
  PRIMARY KEY  (`e_id`)
) TYPE=MyISAM;

CREATE TABLE `##PREFIX##files` (
  `file_id` int(10) NOT NULL auto_increment,
  `file_name` varchar(150) default NULL,
  `file_desc` varchar(200) default NULL,
  `file_creator` varchar(100) default NULL,
  `file_version` varchar(20) default NULL,
  `file_longdesc` text,
  `file_ssurl` text,
  `file_dlurl` text,
  `file_mirrors` text NOT NULL,
  `file_time` int(50) default NULL,
  `file_catid` int(5) default NULL,
  `file_posticon` varchar(30) default NULL,
  `file_license` int(5) default NULL,
  `file_dls` int(10) default NULL,
  `file_last` int(50) default NULL,
  `file_pin` int(1) default NULL,
  `file_docsurl` text,
  `file_rating` int(10) NOT NULL default '0',
  `file_totalvotes` int(10) NOT NULL default '0',
  `file_tags` text NOT NULL,
  PRIMARY KEY  (`file_id`)
) TYPE=MyISAM;

CREATE TABLE `##PREFIX##license` (
  `license_id` int(5) NOT NULL auto_increment,
  `license_name` text,
  `license_text` text,
  PRIMARY KEY  (`license_id`)
) TYPE=MyISAM;

CREATE TABLE `##PREFIX##settings` (
  `id` int(1) NOT NULL auto_increment,
  `dbname` text NOT NULL,
  `dburl` text NOT NULL,
  `topnumber` int(5) NOT NULL default '0',
  `homeurl` text NOT NULL,
  `timeoffset` int(5) NOT NULL default '0',
  `timezone` varchar(100) NOT NULL default '',
  `skin` varchar(20) NOT NULL default '',
  `stats` int(1) NOT NULL default '0',
  `lang` varchar(20) NOT NULL default '',
  `viewall` int(1) NOT NULL default '0',
  `showss` int(1) NOT NULL default '0',
  `date_format` varchar(40) NOT NULL default '',
  `time_format` varchar(40) NOT NULL default '',
  `dropdown` text NOT NULL,
  `enable_email` int(1) NOT NULL default '0',
  `perpage` int(3) NOT NULL default '0',
  `enable_report` int(1) NOT NULL default '1',
  `sort_override` int(1) NOT NULL default '0',
  `quickdl` int(1) NOT NULL default '0',
  `dbstats` int(1) NOT NULL default '0',
  `fromemail` varchar(50) NOT NULL default '',
  `validateemail` int(1) NOT NULL default '0',
  `enable_comments` int(1) NOT NULL default '0',
  `guest_comments` int(1) NOT NULL default '0',
  `enable_registration` int(1) NOT NULL default '0',
  `comments_perpage` int(3) NOT NULL default '0',
  `require_registration` int(1) NOT NULL default '0',
  `newest_news` int(30) NOT NULL default '0',
  `display_tags` int(1) NOT NULL default '0',
  `tag_cloud` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `##PREFIX##users` (
  `user_userid` int(6) NOT NULL auto_increment,
  `user_username` varchar(25) NOT NULL default '',
  `user_password` varchar(32) NOT NULL default '',
  `user_email` varchar(50) NOT NULL default '',
  `user_status` int(1) NOT NULL default '0',
  `user_emailvalidation` varchar(32) NOT NULL default '',
  `user_passvalidation` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`user_userid`)
) TYPE=MyISAM;

INSERT INTO `##PREFIX##settings` (`id`, `dbname`, `dburl`, `topnumber`, `homeurl`, `timeoffset`, `timezone`, `skin`, `stats`, `lang`, `viewall`, `showss`, `date_format`, `time_format`, `dropdown`, `enable_email`, `perpage`, `enable_report`, `sort_override`, `quickdl`, `dbstats`, `fromemail`, `validateemail`, `enable_comments`, `guest_comments`, `enable_registration`, `comments_perpage`, `require_registration`, `newest_news`, `display_tags`, `tag_cloud`) VALUES (1, 'My Files', '', 10, 'http://www.mysite.com', 0, 'Central Time', 'default', 1, 'english', 1, 1, '%b %d&#44; %Y', '%I:%M %p', '', 1, 10, 1, 1, 1, 0, 'noreply@mysite.com', 1, 1, 0, 1, 10, 0, 0, 1, '');
