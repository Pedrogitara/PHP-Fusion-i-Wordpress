<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: latest_videos_panel.php
| Author: Fangree Productions
| Developers: Fangree_Craig & DrunkeN
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
if (!defined("IN_FUSION")) { die("Access Denied"); }
include INFUSIONS."fusion_tube/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
// Load the locale file matching the current site locale setting.
include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
// Load the infusion's default locale file.
include INFUSIONS."fusion_tube/locale/English.php";
}

if (!defined("IN_FUSION")) { die("Access Denied"); }

openside($locale['ft_107']);
	$result = dbquery(
			"SELECT vi.video_id, vi.video_name, vi.video_cat, 
				    vi.video_datestamp, vc.video_cat_id, vc.video_cat_access 
					FROM ".DB_VIDEOS." vi
					INNER JOIN ".DB_VIDEO_CATS." vc ON vi.video_cat=vc.video_cat_id
					".(iSUPERADMIN ? "" : " WHERE ".groupaccess('video_cat_access'))." 
					ORDER BY video_datestamp DESC LIMIT 0,5");
if (dbrows($result)) {
	while($data = dbarray($result)) {
		$itemsubject = trimlink($data['video_name'], 21);
		echo THEME_BULLET." <a href='".BASEDIR."infusions/fusion_tube/view.php?cat_id=".$data['video_cat_id']."&amp;video_id=".$data['video_id']."' title='".$data['video_name']."' class='side'>$itemsubject</a><br />\n";
	}
} else {
	echo "<div style='text-align:center'>".$locale['ft_023']."</div>\n";
}
closeside();
?>