<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: video_submissions_panel.php
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

	if (iADMIN && checkrights("VID")) {
require_once INFUSIONS."fusion_tube/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
// Load the locale file matching the current site locale setting.
include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
// Load the infusion's default locale file.
include INFUSIONS."fusion_tube/locale/English.php";
}

$sub_count = dbcount("(video_submit_id)", DB_VIDEO_SUBMISSIONS, "video_submit_type='video'");

 if ($sub_count) {
global $aidlink;
	echo "<div class='admin-message'><a href='".INFUSIONS."fusion_tube/admin/submissions.php".$aidlink."'> ".sprintf("".$locale['ft_072']." %u ".$locale['ft_073']."", $sub_count);
    echo ($sub_count == 1 ? " ".$locale['ft_074']."" : " ".$locale['ft_075']."")."</a></strong></div>\n";
	}
}
?>