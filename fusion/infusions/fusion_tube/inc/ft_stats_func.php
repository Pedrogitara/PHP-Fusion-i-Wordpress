<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: ft_stats_func.php
| Version: 1.01
| Author: Fangree Productions
| Developers: Fangree_Craig, Discofan
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

$ftsettings = dbarray(dbquery("SELECT * FROM ".DB_VIDEO_SETTINGS.""));

if ($ftsettings['video_stats'] == "1") {

function ft_stats() {
	
global $settings;
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
include INFUSIONS."fusion_tube/locale/English.php";
}	
include INFUSIONS."fusion_tube/infusion_db.php";



	opentable($locale['ft_128']);
	echo "<table cellpadding='0'  cellspacing='0' width='100%'>\n<tr>\n";
	echo "<td style='vertical-align: middle;' width='2%' class='tbl2'>";
	echo"<img src='".INFUSIONS."fusion_tube/images/stats.png' alt='' style='border: 0px; vertical-align:middle;' /></td>";
	echo "<td style='vertical-align: top;' width='' class='tbl'>";
	echo THEME_BULLET." <span class='side-small'>".$locale['ft_129']." ".dbcount("(video_id)", DB_VIDEOS, "video_id");
	echo"</span><br />\n";
	echo THEME_BULLET." <span class='side-small'>".$locale['ft_130']." ".dbcount("(video_cat_id)", DB_VIDEO_CATS, "video_cat_id");
	echo"</span>\n";
	//echo THEME_BULLET." <span class='side-small'>Total Video Comments: ".dbcount("(comment_id)", DB_COMMENTS." WHERE comment_type='V'");
	//echo"</span>\n";
$result = dbquery(
			"SELECT vi.video_id, vi.video_name, vi.video_cat, vi.video_views,
				    vi.video_datestamp, vc.video_cat_id, vc.video_cat_access 
					FROM ".DB_VIDEOS." vi
					INNER JOIN ".DB_VIDEO_CATS." vc ON vi.video_cat=vc.video_cat_id
					".(iSUPERADMIN ? "" : " WHERE ".groupaccess('video_cat_access'))." 
					ORDER BY video_datestamp DESC LIMIT 0,1");

if (dbrows($result) != 0) {
	while ($data = dbarray($result)) {
		echo"<br />\n";
		
		echo THEME_BULLET." <span class='side-small'>".$locale['ft_168']."  <a href='".BASEDIR."infusions/fusion_tube/view.php?cat_id=".$data['video_cat_id']."&amp;video_id=".$data['video_id']."' class='side-small'>".trimlink($data['video_name'], 100)."</a></span>";
	}
}
echo"</td></tr></table>";
	closetable();
	}

	}
	
?>