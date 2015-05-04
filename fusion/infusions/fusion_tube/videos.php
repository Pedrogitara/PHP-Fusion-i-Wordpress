<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: videos.php
| Version: 1.01
| Author: Fangree Productions
| Developers: Fangree_Craig & DrunkeN
| Site: http://www.fangree.com
+--------------------------------------------------------+
| Based on code from PHP-Fusion Weblinks
| Filename: weblinks.php
| Author: Nick Jones (Digitanium)
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
include INFUSIONS."fusion_tube/inc/ft_stats_func.php";
include INFUSIONS."fusion_tube/inc/nav_func.php";
include INFUSIONS."fusion_tube/inc/tags_func.php";
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
    include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."fusion_tube/locale/English.php";
}
add_to_head("<link rel='stylesheet' href='".INFUSIONS."fusion_tube/inc/css/vid-css.css' type='text/css' media='screen' />");

$ftsettings = dbarray(dbquery("SELECT * FROM ".DB_VIDEO_SETTINGS.""));

if ($ftsettings['vidsenable'] !== "1"  && !checkrights('VID')) { redirect("../../index.php"); }
if ($ftsettings['vidsenable'] !== "1" && iADMIN && checkrights('VID')) { 
echo "<div id='close-message'><div class='admin-message'>".$locale['ft_112']."</div></div>\n"; 
}

if (!isset($_GET['cat_id']) || !isnum($_GET['cat_id'])) {
add_to_title($locale['global_200']." ".$locale['ft_001']."");
  if ($ftsettings['video_nav'] == "1") { echo ftnav(); }
if ($ftsettings['video_latest_center'] == "1") { 
include INFUSIONS."fusion_tube/inc/latest_videos_center_panel.php";
}

	opentable($locale['ft_001']);
	echo "<!--pre_video_idx-->";
	echo searchft();
	
	$result = dbquery("SELECT video_cat_id, video_cat_name, video_cat_image, video_cat_description FROM ".DB_VIDEO_CATS." WHERE ".groupaccess('video_cat_access')." ORDER BY video_cat_name");
	$rows = dbrows($result);
	if ($rows != 0) {
		$counter = 0; $columns = 2; 
		echo "<table cellpadding='0'  cellspacing='0' width='100%'>\n<tr>\n";
		while ($data = dbarray($result)) {
			if ($counter != 0 && ($counter % $columns == 0)) { echo "</tr>\n<tr>\n"; }
			$num = dbcount("(video_cat)", DB_VIDEOS, "video_cat='".$data['video_cat_id']."'");
			echo "<td style='vertical-align: middle;' width='10%' class='tbl'>";
			if ($data['video_cat_image'] !=="") {
			echo"<a href='".FUSION_SELF."?cat_id=".$data['video_cat_id']."'><img class='vid-cat-image' src='".INFUSIONS."fusion_tube/images/cats/".$data['video_cat_image']."' alt='".$data['video_cat_name']."' /></a>";
			}else{
			echo"<a href='".FUSION_SELF."?cat_id=".$data['video_cat_id']."'><img class='vid-cat-image' src='".INFUSIONS."fusion_tube/images/cats/default.gif' alt='".$data['video_cat_name']."' /></a>\n";
			}
			echo"</td>\n";
			echo "<td style='vertical-align: middle;' width='50%' class='tbl'><a href='".FUSION_SELF."?cat_id=".$data['video_cat_id']."'>".$data['video_cat_name']."</a> <span class='small2'>($num)</span>";
			if ($data['video_cat_description'] != "") { echo "<br />\n<span class='small'>".$data['video_cat_description']."</span>"; }
			
			echo "</td>\n";
			$counter++;
		}
		echo "</tr>\n</table>\n";
	} else {
		echo "<div style='text-align:center'><br />\n".$locale['ft_056']." <br /><br />\n</div>\n";
	}
	echo "<!--sub_video_idx-->";
	closetable();
	
	if ($ftsettings['video_stats'] == "1") { echo ft_stats(); }
	
	 if ($ftsettings['video_tags'] == "1") { echo fttags(); }
	 
} else {

  if ($ftsettings['video_nav'] == "1") { echo ftnav(); }

$ftsettings = dbarray(dbquery("SELECT * FROM ".DB_VIDEO_SETTINGS.""));
	$res = 0;
	$result = dbquery("SELECT video_cat_name, video_cat_sorting, video_cat_access FROM ".DB_VIDEO_CATS." WHERE video_cat_id='".$_GET['cat_id']."'");
	if (dbrows($result) != 0) {
		$cdata = dbarray($result);
		if (checkgroup($cdata['video_cat_access'])) {
			$res = 1;
			opentable($locale['ft_001']." &raquo; ".$cdata['video_cat_name']);
			echo "<!--pre_video_cat-->";
				add_to_title($locale['global_200']." ".$locale['ft_001']." &raquo; ".$cdata['video_cat_name']);
				 echo "<table  width='100%' cellpadding='0' cellspacing='1'  style='margin-bottom: 10px;' class='tbl-border'>\n";
	             echo "<tr>\n<td colspan='2' class='tbl2'><a href='".INFUSIONS."fusion_tube/videos.php'>".$locale['ft_001']."</a> &raquo; ".$cdata['video_cat_name'];
	             echo "</td>\n</tr></table>\n";
			$rows = dbcount("(video_id)", DB_VIDEOS, "video_cat='".$_GET['cat_id']."'");
			if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) { $_GET['rowstart'] = 0; }
			if ($rows != 0) {
				$result = dbquery("SELECT vi.*, u.user_id, u.user_name, u.user_status FROM ".DB_VIDEOS." vi LEFT JOIN ".DB_USERS." u ON u.user_id=vi.video_user WHERE video_cat='".$_GET['cat_id']."' ORDER BY ".$cdata['video_cat_sorting']." LIMIT ".$_GET['rowstart'].",".$ftsettings['videos_per_page']."");
				$numrows = dbrows($result); $i = 1;
				$counter = 0; $columns = 2; 
				echo "<table cellpadding='0' cellspacing='0' width='100%' style='vertical-align:top;' class='tbl-border'>\n";
				while ($data = dbarray($result)) {
				if ($counter != 0 && ($counter % $columns == 0)) { echo "</tr>\n<tr>\n"; }
					if ($data['video_datestamp']+604800 > time()+($settings['timeoffset']*3600)) {  $new = " <span class='small' style='color:#ff0000;'>".$locale['ft_057']."</span>"; } else { $new = ""; }
			
				echo "<td width='20%' class='tbl2'><a href='".INFUSIONS."fusion_tube/view.php?cat_id=".$_GET['cat_id']."&amp;video_id=".$data['video_id']."'><img src='http://i3.ytimg.com/vi/".stripslashes($data['video_url'])."/default.jpg' alt='".$data['video_name']."' class='vid-cat-image' style='border: 0px; width: 120px; height: 90px;' /></a></td>";
				echo "<td  width='' class='tbl2'>";
				echo"<a title='".$data['video_name']."' href='".INFUSIONS."fusion_tube/view.php?cat_id=".$_GET['cat_id']."&amp;video_id=".$data['video_id']."'>".trimlink($data['video_name'], 23)."</a>";
				echo $new; 
				echo "<br /><span class='small'>".$locale['ft_059']." ".profile_link($data['user_id'], $data['user_name'], $data['user_status'])." ".$locale['ft_060']." ".showdate("%d.%m.%Y", $data['video_datestamp'])."</span>"; 
		   $rate = dbquery("SELECT SUM(rating_vote) FROM ".DB_RATINGS." WHERE rating_type='V' AND rating_item_id='".$data['video_id']."'");
           $info = dbresult($rate,0);
           $num_rating = dbcount("(rating_vote)", DB_RATINGS, "rating_type='V' AND rating_item_id='".$data['video_id']."'");
           $video_rating = ($num_rating ? $info / $num_rating : 0);
			$video_comments = dbcount("(comment_id)", DB_COMMENTS, "comment_type='V' AND comment_hidden='0' AND comment_item_id='".$data['video_id']."'");
            if ($ftsettings['video_comments'] == "1") {
						echo"<br /><span class='small'>".$locale['ft_113']." ".$video_comments."</span>";
						}
			if ($ftsettings['video_ratings'] == "1") {
	              echo"<br /><span class='small'>".$locale['ft_151']."</span><img src='".INFUSIONS."fusion_tube/images/rate/".ceil($video_rating).".gif' width='64' height='12' alt='".ceil($video_rating)."' style='padding-right: 30px; vertical-align:middle;' title='".$locale['ft_124'].ceil($video_rating)."' />";
	            }
				echo"</td>\n";
				$counter++;
				if ($i != $numrows) {  $i++; }
				}
				echo "</tr>\n</table><br />\n";
					echo searchft();
					echo "<!--sub_video_cat-->";
				closetable();
				
			
				if ($rows > $ftsettings['videos_per_page']) { echo "<div align='center' style='margin-top:5px;'>\n".makepagenav($_GET['rowstart'], $ftsettings['videos_per_page'], $rows, 3, FUSION_SELF."?cat_id=".$_GET['cat_id']."&amp;")."\n</div>\n"; }
			} else {
				echo $locale['ft_023'];
					echo "<!--sub_video_cat-->";
				closetable();
				
			}
		if ($ftsettings['video_stats'] == "1") { echo ft_stats(); }
		if ($ftsettings['video_tags'] == "1") { echo fttags(); }
		}
	}
	if ($res == 0) { redirect(FUSION_SELF); }
}

require_once THEMES."templates/footer.php";
?>