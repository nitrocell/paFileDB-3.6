ALTER TABLE `##PREFIX##settings` ADD `sort_override` INT( 1 ) NOT NULL ;
ALTER TABLE `##PREFIX##settings` ADD `quickdl` INT( 1 ) NOT NULL ;
ALTER TABLE `##PREFIX##settings` ADD `dbstats` INT( 1 ) NOT NULL ;
ALTER TABLE `##PREFIX##settings` ADD `fromemail` VARCHAR( 50 ) NOT NULL ;
ALTER TABLE `##PREFIX##settings` ADD `validateemail` INT( 1 ) NOT NULL ;
ALTER TABLE `##PREFIX##settings` ADD `enable_comments` INT( 1 ) NOT NULL ;
ALTER TABLE `##PREFIX##settings` ADD `guest_comments` INT( 1 ) NOT NULL ;
ALTER TABLE `##PREFIX##settings` ADD `enable_registration` INT( 1 ) NOT NULL ;
ALTER TABLE `##PREFIX##settings` ADD `comments_perpage` INT( 3 ) NOT NULL ;
ALTER TABLE `##PREFIX##settings` ADD `require_registration` INT( 1 ) NOT NULL ;
ALTER TABLE `##PREFIX##settings` ADD `newest_news` INT( 30 ) NOT NULL ;
ALTER TABLE `##PREFIX##files` ADD `file_tags` TEXT NOT NULL ;
ALTER TABLE `##PREFIX##settings` ADD `display_tags` INT( 1 ) NOT NULL ;
ALTER TABLE `##PREFIX##settings` ADD `tag_cloud` TEXT NOT NULL ;

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

CREATE TABLE `##PREFIX##adminnews` (
  `date` int(30) NOT NULL default '0',
  `subject` varchar(150) NOT NULL default '',
  `text` text NOT NULL,
  PRIMARY KEY  (`date`)
) TYPE=MyISAM;