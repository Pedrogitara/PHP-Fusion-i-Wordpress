<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: latest_videos_ticker_panel.php
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

	
	openside($locale['ft_107']);
		add_to_head("<style type='text/css'>
        .ticker {
		display: none;
		list-style-type: none;
		padding: 3px;
		margin-bottom: 2px;
		height:110px;
	}
		</style>");
    add_to_head("<link rel='stylesheet' href='".INFUSIONS."fusion_tube/inc/css/vid-css.css' type='text/css' media='screen' />");
	add_to_head("<script language='JavaScript' type='text/javascript' src='".INFUSIONS."fusion_tube/inc/js/ticker.js'></script>");
echo "<script type='text/javascript'>
	$(document).ready(
		function() {
			$('#ftticker').newsTicker('7000');
			$('#ftticker').show('slow');
		}
	);
	</script>";
	
	$result = dbquery(
			"SELECT vi.video_id, vi.video_name, vi.video_views, vi.video_cat, vi.video_url,
				    vi.video_datestamp,  vi.video_user, vu.user_id, vu.user_name, vu.user_status,
					vc.video_cat_id, vc.video_cat_access 
					FROM ".DB_VIDEOS." vi
					LEFT JOIN ".DB_USERS." vu ON vi.video_user=vu.user_id
					INNER JOIN ".DB_VIDEO_CATS." vc ON vi.video_cat=vc.video_cat_id
					".(iSUPERADMIN ? "" : " WHERE ".groupaccess('video_cat_access'))." 
					ORDER BY video_datestamp DESC LIMIT 0,10");
echo"<div style='height: 110px;'>\n";
echo "<ul id='ftticker' class='ticker'>";
	if (dbrows($result)) {
	
		$i = 0;
	
			while ($data = dbarray($result)) {
			echo "<li>";
			
       
	echo"<div style='text-align: center;'>\n";
		echo "<a href='".BASEDIR."infusions/fusion_tube/view.php?cat_id=".$data['video_cat_id']."&amp;video_id=".$data['video_id']."'><img src='http://i3.ytimg.com/vi/".stripslashes($data['video_url'])."/default.jpg' alt='".$data['video_name']."' class='vid-cat-image' style='border: 0px; width: 120px; height: 90px;' /></a>\n";
echo"</div>\n";
	echo"<div style='padding-top: 12px; text-align: center;'>";
     echo "<a href='".BASEDIR."infusions/fusion_tube/view.php?cat_id=".$data['video_cat_id']."&amp;video_id=".$data['video_id']."' class='side small'>".trimlink($data['video_name'], 23)."</a>\n";
	 echo "<br /><span class='side small'><strong>".$locale['ft_092']."</strong> ".showdate("%d/%m/%Y", $data['video_datestamp'])."\n";
     echo"<br /><strong>".$locale['ft_019']."</strong> ".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</span>\n"; 
echo"</div>";

		}
	
			echo "</li>\n";
	   }else{
	   echo"<div style='text-align:center;'>".$locale['ft_023']."</div>\n";
		
	}
	echo "</ul>";
echo"</div>\n";
      closeside();
?>