<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: last_updated_videos.php
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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
include INFUSIONS."fusion_tube/infusion_db.php";
include INFUSIONS."fusion_tube/inc/search_func.php";
include INFUSIONS."fusion_tube/inc/nav_func.php";
include INFUSIONS."fusion_tube/inc/ft_stats_func.php";
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
    include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."fusion_tube/locale/English.php";
}
	
 add_to_title($locale['global_200']." ".$locale['ft_147']);

    $ftsettings = dbarray(dbquery("SELECT * FROM ".DB_VIDEO_SETTINGS.""));
	  
	if ($ftsettings['video_nav'] == "1") { echo ftnav(); }
	opentable($locale['ft_147']);
	
	echo"<a title='".$locale['ft_125']."' href='".INFUSIONS."fusion_tube/videos.php'><img src='".INFUSIONS."fusion_tube/images/back.png' style='padding: 10px; border: 0px; vertical-align:middle;' alt='".$locale['ft_125']."'/></a>\n";
	
	$rows = number_format(dbcount("(video_id)", DB_VIDEOS, "video_update_datestamp !=''"));
	
	if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) { $_GET['rowstart'] = 0; }
	$result = dbquery("SELECT vi.video_id, vi.video_name, vi.video_url, vi.video_views, vi.video_cat, 
						vi.video_datestamp,  vi.video_update_datestamp, vi.video_user, vu.user_id, vu.user_name, vu.user_status,
						vc.video_cat_id, vc.video_cat_access 
						FROM ".DB_VIDEOS." vi
						LEFT JOIN ".DB_USERS." vu ON vi.video_user=vu.user_id
						INNER JOIN ".DB_VIDEO_CATS." vc ON vi.video_cat=vc.video_cat_id
						".(iSUPERADMIN ? "" : " WHERE ".groupaccess('video_cat_access'))." 
						AND video_update_datestamp ORDER BY video_update_datestamp DESC LIMIT ".stripinput($_GET['rowstart']).",".$ftsettings['videos_per_page']);

                $numrows = dbrows($result); $i = 1;
				$counter = 0; $columns = 1; 
	if (dbrows($result)) {
	
		        $i = 0;
	echo "<table cellpadding='0' cellspacing='0' width='100%' style='vertical-align:top;' class='tbl-border'>\n";
	
			while ($data = dbarray($result)) {
				if ($counter != 0 && ($counter % $columns == 0)) { echo "</tr>\n<tr>\n"; }
				if ($data['video_datestamp']+604800 > time()+($settings['timeoffset']*3600)) {  $new = " <span class='small' style='color:#ff0000;'>".$locale['ft_057']."</span>"; } else { $new = ""; }
				echo "<td width='20%' class='tbl2'><a href='".INFUSIONS."fusion_tube/view.php?cat_id=".$data['video_cat_id']."&amp;video_id=".$data['video_id']."'><img src='http://i3.ytimg.com/vi/".stripslashes($data['video_url'])."/default.jpg' alt='".$data['video_name']."' class='vid-cat-image' style='border: 0px; width: 120px; height: 90px;' /></a></td>";
				echo "<td  width='' class='tbl2'>";
				echo"<a title='".$data['video_name']."' href='".INFUSIONS."fusion_tube/view.php?cat_id=".$data['video_cat_id']."&amp;video_id=".$data['video_id']."'>".trimlink($data['video_name'], 23)."</a>";
				echo $new; 
		  	    echo" <br /><span class='small'>".$locale['ft_148'].": ".showdate("%B %d %Y %H:%M", $data['video_update_datestamp'])." ".$locale['ft_149']." ".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."</span>\n";
			    echo"</td>\n";
				$counter++;
				if ($i != $numrows) {  $i++; }
				}
				echo "</tr>\n</table>\n";
	
	if ($rows > $ftsettings['videos_per_page']) echo "<div style='margin-top:5px; text-align: center;'>\n".makepagenav($_GET['rowstart'],$ftsettings['videos_per_page'],$rows,3)."\n</div><br />\n";
	    }else{
	        echo"<div style='text-align:center;'>".$locale['ft_147b']."</div>\n";
	     }
	
	
      closetable();

require_once THEMES."templates/footer.php";
?>