<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: fusiontube_upgrade.php
| Author: Nick Jones (Digitanium)
| Modified for FusionTube by Fangree Productions
| Site: http://www.fangree.com
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";
include INFUSIONS."fusion_tube/infusion_db.php";

if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
    include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."fusion_tube/locale/English.php";
}
add_to_title($locale['global_200'].$locale['ft_up001']);
if (!checkrights("VID") || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) redirect("../index.php");

include INFUSIONS."fusion_tube/admin/admin_nav.php";

opentable($locale['ft_up001']);
echo "<div style='text-align:center'><br />\n";
echo "<form name='upgradeform' method='post' action='".FUSION_SELF.$aidlink."'>\n";

$data_version = dbarray(dbquery("SELECT inf_version FROM ".DB_INFUSIONS." WHERE inf_folder = 'fusion_tube'"));	
$version = $data_version['inf_version'];

if (str_replace(".", "", $version) < "101") {
	if (!isset($_POST['stage'])) {
		echo sprintf("A %s ".$locale['ft_up002']."", "".$locale['ft_up003']."")."<br />\n".$locale['ft_up004']."<br /><br />\n";
		echo "<input type='hidden' name='stage' value='2'>\n";
		echo "<input type='submit' name='tube_upgrade' value='".$locale['ft_up005']."' class='button'><br /><br />\n";
	} elseif (isset($_POST['tube_upgrade']) && isset($_POST['stage']) && $_POST['stage'] == 2) {
	$result = dbquery("ALTER TABLE ".DB_VIDEOS."
					  DROP video_image,
					  DROP vidsenable,
					  DROP video_social,
					  DROP video_youtube_link,
					  DROP video_facebook_comments,
					  DROP video_comments,
					  DROP video_ratings,
					  DROP video_latest_center,
					  DROP video_tags,
					  DROP video_stats,
					  DROP video_nav,
					  DROP video_descimg_pos,
					  DROP video_width,
					  DROP video_height,
					  DROP video_facebook_comments_width,
					  DROP video_facebook_comments_userid,
					  DROP video_facebook_comments_appid,
					  DROP video_facebook_comments_numpost,
					  DROP videos_per_page");
					  
					  
    $result = dbquery("CREATE TABLE ".DB_VIDEO_SETTINGS." (
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
					  KEY  (video_social) ) ENGINE=MYISAM;");
  	
	$result = dbquery("INSERT INTO ".DB_VIDEO_SETTINGS." (vidsenable, video_social, video_youtube_link, video_facebook_comments, video_comments, video_ratings, video_latest_center, video_tags, video_stats, video_nav, video_descimg_pos, video_width, video_height, video_facebook_comments_width, video_facebook_comments_userid, video_facebook_comments_appid, video_facebook_comments_numpost, videos_per_page) VALUES ('1', '1', '1', '0', '1', '1', '1', '1', '1', '1', '0', '440', '305', '500', 'xxxxxxxxxx', 'xxxxxxxxxx', '5', '10')");
	
	$result = dbquery("UPDATE ".DB_INFUSIONS." SET inf_version='1.01' WHERE inf_folder='fusion_tube'");

	echo "".$locale['ft_up006']."<br /><br />\n";
	}
} 
else {
	echo "".$locale['ft_up007']."<br /><br />\n";
}
echo "</form>\n</div>\n";
closetable();
// Please do not remove copyright info
  include INFUSIONS."fusion_tube/inc/copyright_func.php";
echo showFTcopyright();
require_once THEMES."templates/footer.php";
?>