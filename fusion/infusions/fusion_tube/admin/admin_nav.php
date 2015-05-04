<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: admin_navigation.php
| Author: HobbyMan
| Edited for Video Infusion by: Fangree_Craig & DrunkeN
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once INFUSIONS."fusion_tube/infusion_db.php";

$sub_count = dbcount("(video_submit_id)", DB_VIDEO_SUBMISSIONS, "video_submit_type='video'");

    opentable($locale['ft_003']);
	echo "<div style='text-align:center;'><a href='".INFUSIONS."fusion_tube/admin/index.php".$aidlink."'>".$locale['ft_105']."</a> - 
	<a href='".INFUSIONS."fusion_tube/admin/videos_admin.php".$aidlink."'>".$locale['ft_070']."</a> - 
	<a href='".INFUSIONS."fusion_tube/admin/video_cats.php".$aidlink."'>".$locale['ft_071']."</a> -
	<a href='".INFUSIONS."fusion_tube/admin/settings.php".$aidlink."'>".$locale['ft_095']."</a> -";
	if ($sub_count) {
	echo "<a href='".INFUSIONS."fusion_tube/admin/submissions.php".$aidlink."'> ".sprintf("".$locale['ft_072']." %u ".$locale['ft_073']."", $sub_count);
    echo ($sub_count == 1 ? " ".$locale['ft_074']."" : " ".$locale['ft_075']."")."</a></strong>\n";
	} else { 
	echo " <a href='".INFUSIONS."fusion_tube/admin/submissions.php".$aidlink."'>".$locale['ft_081']."</a>";
	}
	echo "</div>\n";
	closetable();

?>