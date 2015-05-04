<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: latest_videos_center_panel.php
| Version: 1.01
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

	if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
		include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
	} else {
		include INFUSIONS."fusion_tube/locale/English.php";
	}
	
	include INFUSIONS."fusion_tube/infusion_db.php";
	
	if (!defined("IN_FUSION")) { die("Access Denied"); }

	
	opentable($locale['ft_109']);
	add_to_head("<link rel='stylesheet' href='".INFUSIONS."fusion_tube/inc/css/vid-css.css' type='text/css' media='screen' />");
	
	$result = dbquery(
			"SELECT vi.video_id, vi.video_name, vi.video_views, vi.video_cat, vi.video_url,
				    vi.video_datestamp,  vi.video_user, vu.user_id, vu.user_name, vu.user_status,
					vc.video_cat_id, vc.video_cat_access 
					FROM ".DB_VIDEOS." vi
					LEFT JOIN ".DB_USERS." vu ON vi.video_user=vu.user_id
					INNER JOIN ".DB_VIDEO_CATS." vc ON vi.video_cat=vc.video_cat_id
					".(iSUPERADMIN ? "" : " WHERE ".groupaccess('video_cat_access'))." 
					ORDER BY RAND() DESC LIMIT 0,1");

	if (dbrows($result)) {
		$i = 0;
	
		
		echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr>\n";
		echo "<td width='1%'  class='tbl2'>&nbsp;</td>\n";
		echo "<td width='30%' class='tbl2'><strong>".$locale['ft_017']."</strong></td>\n";
		echo "<td width='10%' class='tbl2' style='text-align:center;white-space:nowrap'><strong>".$locale['ft_046']."</strong></td>\n";
		echo "<td width='20%' class='tbl2' style='text-align:center;white-space:nowrap'><strong>".$locale['ft_059']."</strong></td>\n";
		echo "<td width='5%' class='tbl2' style='text-align:center;white-space:nowrap'><strong>".$locale['ft_108']."</strong></td>\n";
		echo "</tr>\n";
		while ($data = dbarray($result)) {
		
		$row_color = ($i % 2 == 0 ? "tbl1" : "tbl2");
			
		echo "<tr>\n<td class='".$row_color."'>";
		echo "<a href='".BASEDIR."infusions/fusion_tube/view.php?cat_id=".$data['video_cat_id']."&amp;video_id=".$data['video_id']."'><img src='http://i3.ytimg.com/vi/".stripslashes($data['video_url'])."/default.jpg' alt='".$data['video_name']."' class='vid-cat-image' style='border: 0px; width: 120px; height: 90px;' /></a>\n";
		echo "</td>\n";
		echo "<td width='' class='".$row_color."'><a href='".BASEDIR."infusions/fusion_tube/view.php?cat_id=".$data['video_cat_id']."&amp;video_id=".$data['video_id']."'>".trimlink($data['video_name'], 100)."</a></td>\n";
		echo "<td width='' class='".$row_color."' style='text-align:center;white-space:nowrap'>".showdate("shortdate", $data['video_datestamp'])."</td>\n";
		echo "<td width='' class='".$row_color."' style='text-align:center;white-space:nowrap'>".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</td>\n";
	echo "<td width='' class='".$row_color."' style='text-align:center;white-space:nowrap'>";
	if ($data['video_views'] > "0") { echo $data['video_views']; }else{ echo"0";}
	echo"</td>\n";
		echo "</tr>\n";
		
			$i++;
		}
		echo "</table>\n";
		
	   }else{
	   echo"<div style='text-align:center;'>".$locale['ft_023']."</div>\n";
		
	}
      closetable();
?>