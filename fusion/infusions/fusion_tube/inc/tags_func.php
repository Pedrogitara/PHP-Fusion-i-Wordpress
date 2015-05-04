<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: tags_func.php
| Author: Fangree Productions
| Developers: Fangree_Craig
| Site: http://www.fangree.com
| Tags Code Based on code by: Philip Daly (HobbyMan)
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

if ($ftsettings['video_tags'] == "1") {
			      
function fttags() {
	
global $settings;
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
include INFUSIONS."fusion_tube/locale/English.php";
}	
include INFUSIONS."fusion_tube/infusion_db.php";


opentable($locale['ft_135']); 

$result= dbquery("SELECT vi.video_id, vi.video_name, vi.video_cat, 
				    vi.video_datestamp, vc.video_cat_id, vc.video_cat_access 
					FROM ".DB_VIDEOS." vi
					INNER JOIN ".DB_VIDEO_CATS." vc ON vi.video_cat=vc.video_cat_id
					".(iSUPERADMIN ? "" : " WHERE ".groupaccess('video_cat_access'))." 
					ORDER BY RAND() LIMIT 0,15");
                    
$video_tags_color = array(
							1 => "#6200CC",
							2 => "#04688D",
							3 => "#F6A504",
							4 => "#474747",
							5=> "#F8FF49",
							6=> "#1B8700",
							7=> "#070070"
);       
     
	 
if (dbrows($result)) {
          echo "<table width='100%' cellpadding='0' cellspacing='0' class='tbl'>\n";
          echo "<tr><th class='tbl'>\n</tr>\n";
          echo "<td class='tbl' align='center'>\n";

        while ($data = dbarray($result)) {
        $video_tagsize = rand(11,26);

if ($data['video_name']) {
				$video_tags = array_unique(explode(", ", $data['video_name']));
				foreach ($video_tags as $video_tag) {

				 echo "<a href='".BASEDIR."infusions/fusion_tube/view.php?cat_id=".$data['video_cat_id']."&amp;video_id=".$data['video_id']."' title='".$data['video_name']."' class='side'><span style='color:".$video_tags_color[rand(1,7)].";'>";
				 echo "<span style='font-size: ".$video_tagsize."px;'>".$video_tag."</span></span></a>\n";         
				   }
				 }
			   } 
				echo "</th></td>\n</tr>\n</table>\n";
			  } else { 
				echo "<div align='center'>".$locale['ft_023']."</div>\n";
		  }

closetable();

	}
	}

?>