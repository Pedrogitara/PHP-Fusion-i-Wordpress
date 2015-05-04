<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| Developers: Nick Jones (Digitanium), Fangree_Craig & DrunkeN
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+-------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

include INFUSIONS."fusion_tube/infusion_db.php";

if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
    include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."fusion_tube/locale/English.php";
}

$inf_title = $locale['ft_001'];
$inf_version = "1.01";
$inf_developer = "Fangree Productions";
$inf_weburl = "http://www.fangree.com";
$inf_email = "admin@fangree.com";
$inf_folder = "fusion_tube";
$inf_description = "A infusion for adding youtube videos";

$inf_newtable[1] = DB_VIDEOS." (
  video_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  video_user MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  video_euser MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  video_name VARCHAR(50) NOT NULL DEFAULT '',
  video_description TEXT NOT NULL,
  video_url VARCHAR(15) NOT NULL DEFAULT '',
  video_datestamp int(10) UNSIGNED NOT NULL default '0',
  video_update_datestamp int(10) UNSIGNED NOT NULL default '0',
  video_cat mediumint(8) unsigned NOT NULL default '0',
  video_views VARCHAR(50) NOT NULL DEFAULT '',
  PRIMARY KEY  (video_id),
  KEY  (video_name)
) ENGINE = MyISAM;";

$inf_newtable[2] = DB_VIDEO_SETTINGS." (
  vidsenable TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  video_social TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  video_youtube_link TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  video_facebook_comments TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  video_comments TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  video_ratings TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  video_latest_center TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  video_tags TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  video_stats TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  video_nav TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  video_descimg_pos TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  video_width VARCHAR(5) NOT NULL DEFAULT '',
  video_height VARCHAR(5) NOT NULL DEFAULT '',
  video_facebook_comments_width VARCHAR(5) NOT NULL DEFAULT '',
  video_facebook_comments_userid VARCHAR(20) NOT NULL DEFAULT '',
  video_facebook_comments_appid VARCHAR(20) NOT NULL DEFAULT '',
  video_facebook_comments_numpost VARCHAR(5) NOT NULL DEFAULT '',
  videos_per_page  VARCHAR(2) NOT NULL DEFAULT '',
  PRIMARY KEY  (vidsenable),
  KEY  (video_youtube_link)
) ENGINE = MyISAM;";


$inf_newtable[3] = DB_VIDEO_CATS." (
  video_cat_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  video_cat_name VARCHAR(50) NOT NULL DEFAULT '',
  video_cat_description TEXT NOT NULL,
 video_cat_image varchar(100) NOT NULL default '',
  video_cat_sorting varchar(50) NOT NULL default 'function_item ASC',
  video_cat_access tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (video_cat_id),
  KEY (video_cat_name)
) ENGINE = MyISAM;";

$inf_newtable[4] = DB_VIDEO_SUBMISSIONS." (
  video_submit_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  video_submit_type CHAR(8) NOT NULL,
  video_submit_user MEDIUMINT(8) UNSIGNED DEFAULT '0' NOT NULL,
  video_submit_datestamp INT(10) UNSIGNED DEFAULT '0' NOT NULL,
  video_submit_criteria TEXT NOT NULL,
  PRIMARY KEY (video_submit_id)
) ENGINE = MYISAM;";




$inf_insertdbrow[1] = DB_VIDEO_SETTINGS." (vidsenable, video_social, video_youtube_link, video_facebook_comments, video_comments, video_ratings, video_latest_center, video_tags, video_stats, video_nav, video_descimg_pos, video_width, video_height, video_facebook_comments_width, video_facebook_comments_userid, video_facebook_comments_appid, video_facebook_comments_numpost, videos_per_page) VALUES ('1', '1', '1', '0', '1', '1', '1', '1', '1', '1', '0', '440', '305', '500', 'xxxxxxxxxx', 'xxxxxxxxxx', '5', '10')";

$inf_droptable[1] = DB_VIDEOS;
$inf_droptable[2] = DB_VIDEO_CATS;
$inf_droptable[3] = DB_VIDEO_SUBMISSIONS;

$inf_deldbrow[1] = DB_PANELS." WHERE panel_filename='$inf_folder'";

$inf_adminpanel[1] = array(
    "title" => $locale['ft_003'], 
    "image" => "image.gif",
    "panel" => "admin/index.php", 
    "rights" => "VID" 
);

$inf_sitelink[1] = array(
	"title" => $locale['ft_001'],
	"url" => "videos.php",
	"visibility" => "0"
);

$inf_sitelink[2] = array(
	"title" => $locale['ft_002'],
	"url" => "submit.php",
	"visibility" => "101"
);

?>