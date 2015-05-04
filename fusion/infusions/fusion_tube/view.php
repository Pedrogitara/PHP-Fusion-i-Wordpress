<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: view.php
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
include INFUSIONS."fusion_tube/inc/search_func.php";
include INFUSIONS."fusion_tube/inc/ft_stats_func.php";
include INFUSIONS."fusion_tube/inc/nav_func.php";
include INFUSIONS."fusion_tube/inc/tags_func.php";

if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
    include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."fusion_tube/locale/English.php";
}

$ftsettings = dbarray(dbquery("SELECT * FROM ".DB_VIDEO_SETTINGS.""));

add_to_head("<link rel='stylesheet' href='".INFUSIONS."fusion_tube/inc/css/vid-css.css' type='text/css' media='screen' />");
if ($ftsettings['video_facebook_comments'] == "1") { 
add_to_head("<meta property='fb:admins' content='".$ftsettings['video_facebook_comments_userid']."'/>\n<meta property='fb:app_id' content='".$ftsettings['video_facebook_comments_appid']."'>"); 
echo "<script src='http://connect.facebook.net/en_GB/all.js#xfbml=1'></script>\n";
}


if ($ftsettings['vidsenable'] !== "1"  && !checkrights('VID')) { redirect("../../index.php"); }
if ($ftsettings['vidsenable'] !== "1" && iADMIN && checkrights('VID')) { 
echo "<div id='close-message'><div class='admin-message'>".$locale['ft_112']."</div></div>\n"; 
}

$res = 0;
if (isset($_GET['video_id']) && isnum($_GET['video_id']) && isset($_GET['cat_id']) && isNum($_GET['cat_id'])) {
	$result = dbquery("SELECT video_cat_id, video_cat_name, video_cat_sorting, video_cat_access FROM ".DB_VIDEO_CATS." WHERE video_cat_id='".$_GET['cat_id']."'");
	if (dbrows($result) != 0) {
		$cdata = dbarray($result);
		if (checkgroup($cdata['video_cat_access'])) {
			$rows = dbcount("(video_id)", DB_VIDEOS, "video_id='".$_GET['video_id']."'");
			if ($rows != 0) {
				$res = 1;
				$result = dbquery("SELECT vi.*, u.user_id, u.user_name, u.user_status FROM ".DB_VIDEOS." vi LEFT JOIN ".DB_USERS." u ON u.user_id=vi.video_user WHERE video_id='".$_GET['video_id']."' LIMIT 0,1");
				$resultb = dbquery("UPDATE ".DB_VIDEOS." SET video_views=video_views+1 WHERE video_id='".$_GET['video_id']."'");
				$data = dbarray($result);

				if ($data['video_datestamp']+604800 > time()+($settings['timeoffset']*3600)) {
					$new = " <span class='small' style='color:#ff0000;font-size:13;'>".$locale['ft_057']."</span>";
				 } else {	
					$new = "";
				}
				
                    add_to_title($locale['global_200']." ".$locale['ft_001']." &raquo; ".$cdata['video_cat_name']." &raquo; ".$data['video_name']);
                if ($ftsettings['video_nav'] == "1") { echo ftnav(); }
					opentable($data['video_name']);
					echo "<!--pre_video-->";
					echo "<table style='margin-bottom:15px;' width='100%' cellpadding='0' cellspacing='1' class='tbl-border'>\n";
					echo "<tr>\n<td colspan='2' class='tbl2'><a href='".INFUSIONS."fusion_tube/videos.php'>".$locale['ft_001']."</a> &raquo; <a href='".INFUSIONS."fusion_tube/videos.php?cat_id=".$cdata['video_cat_id']."'>".$cdata['video_cat_name']."</a> &raquo; ".$data['video_name'];
					echo "</td>\n</tr></table>\n";
					
				if(iMEMBER && $userdata['user_id'] == $data['user_id']) { 
					echo "<table style='margin-bottom:15px;' width='100%' cellpadding='0' cellspacing='1' class='tbl-border'>\n";
					echo "<tr>\n<td colspan='2' class='tbl2'><div class='vid-edit'>".$userdata['user_name'].", ".$locale['ft_142']." &nbsp;<a href='".INFUSIONS."fusion_tube/edit_video.php?action=edit&amp;video_id=".$data['video_id']."' title='".$locale['ft_004']."'>".$locale['ft_143']."</a></div></td></tr></table>"; 
					}
				
				if ($ftsettings['video_descimg_pos'] == "1"){
					echo "<table style='margin-bottom:15px;' width='100%' cellpadding='0' cellspacing='1' class='tbl-border'><tr>\n<td colspan='2' style='vertical-align:top;' width='30%' class='tbl1'><h3><div class='img'>".$locale['ft_010']."</div></h3>
					<div style='text-align: center;'><img src='http://i3.ytimg.com/vi/".stripslashes($data['video_url'])."/default.jpg' alt='".$data['video_name']."' class='vid-cat-image' style='border: 0px; width: 120px; height: 90px;' /></div></td>\n\n";
				if ($data['video_description'] != "") {
					echo "<td colspan='2' style='vertical-align:top;' class='tbl1'><h3><div class='desc'>".$locale['ft_008']."</div></h3>
					".nl2br(parsesmileys(parseubb(stripslashes($data['video_description']))))."</td></tr></table>\n"; 
					}
					}
			    if ($data['video_url'] != "") {
					echo "<table style='margin-bottom:15px;' width='100%' cellpadding='0' cellspacing='1' class='tbl-border'>\n";
					echo "<tr>\n<td colspan='2' class='tbl1'><h3><div class='name'>".$data['video_name']."  ".$new."</div></h3>
					<div style='padding-bottom: 15px; text-align:center;'>
					<iframe width='".stripslashes($ftsettings['video_width'])."' height='".stripslashes($ftsettings['video_height'])."' src='http://www.youtube.com/embed/".stripslashes($data['video_url'])."?rel=0&wmode=transparent' frameborder='0' allowfullscreen></iframe>	</div></td>\n</tr>\n"; 
					}
				    echo "</table>\n";
					
				if ($ftsettings['video_descimg_pos'] == "0"){
					echo "<table style='margin-bottom:15px;' width='100%' cellpadding='0' cellspacing='1' class='tbl-border'><tr>\n<td colspan='2' style='vertical-align:top;' width='30%' class='tbl1'><h3><div class='img'>".$locale['ft_010']."</div></h3>
					<div style='text-align: center;'><img src='http://i3.ytimg.com/vi/".stripslashes($data['video_url'])."/default.jpg' alt='".$data['video_name']."' class='vid-cat-image' style='border: 0px; width: 120px; height: 90px;' /></div></td>\n\n"; 
				if ($data['video_description'] != "") {
					echo "<td colspan='2' style='vertical-align:top;' class='tbl1'><h3><div class='desc'>".$locale['ft_008']."</div></h3>
					".nl2br(parsesmileys(parseubb(stripslashes($data['video_description']))))."</td></tr></table>\n"; 
					}
					}
					
				if ($ftsettings['video_comments'] == "1") { $video_comments = dbcount("(comment_id)", DB_COMMENTS, "comment_type='V' AND comment_hidden='0' AND comment_item_id='".$data['video_id']."'"); }
					echo "<table style='margin-bottom:15px;' width='100%' cellpadding='0' cellspacing='1' class='tbl-border'>\n";
					echo "<tr>\n<td colspan='2' class='tbl2'>";
				    echo "<div class='vid-added'>".$locale['ft_018']." ".$locale['ft_060']." ".showdate("%B %d %Y %H:%M", $data['video_datestamp'])." ".$locale['ft_019']." ".profile_link($data['user_id'], $data['user_name'], $data['user_status'])."  <br />\n";
                    if ($data['video_update_datestamp']) {
				    echo" <span class='small'>".$locale['ft_148'].": ".showdate("%B %d %Y %H:%M", $data['video_update_datestamp'])." </span>\n";
				   }
				    echo"</div>\n";
					echo "</td>\n</tr>";
                    echo "<tr>\n<td colspan='2' class='tbl2'>";
					echo"<div class='vid-views'>".$data['video_name'] ." ".$locale['ft_061']." ".$data['video_views']." ".$locale['ft_062'].".</div>";
					echo "</td>\n</tr>";
				if ($ftsettings['video_comments'] == "1") {
				    echo "<tr>\n<td colspan='2' class='tbl2'>";
					echo"<div class='vid-comments'>".$locale['ft_113']." ".$video_comments."</div>";
					echo "</td>\n</tr>";
					}
					
				if ($ftsettings['video_ratings'] == "1") {
					echo "<tr>\n<td colspan='2' class='tbl2'>";
					    $rate = dbquery("SELECT SUM(rating_vote) FROM ".DB_RATINGS." WHERE rating_type='V' AND rating_item_id='".$data['video_id']."'");
                        $info = dbresult($rate,0);
                        $num_rating = dbcount("(rating_vote)", DB_RATINGS, "rating_type='V' AND rating_item_id='".$data['video_id']."'");
                        $video_rating = ($num_rating ? $info / $num_rating : 0);
					echo"<div class='vid-rate'>".$locale['ft_124']."<img src='".INFUSIONS."fusion_tube/images/rate/".ceil($video_rating).".gif' width='64' height='12' alt='".ceil($video_rating)."' style='padding-right: 30px; vertical-align:middle;' title='".$locale['ft_124'].ceil($video_rating)."' /></div>";
					echo "</td>\n</tr>";
					}
					
				if ($ftsettings['video_social'] == "1") {
					echo "<tr>\n<td colspan='2' class='tbl2'>";
					echo"<div class='vid-share'><div class='addthis_toolbox addthis_default_style ' style='margin-top:6px;;  width:155px; height:24px; '> 
					<a class='addthis_button_facebook'></a>
					<a class='addthis_button_twitter'></a>
					<a class='addthis_button_email'></a>
				    <a class='addthis_button_compact'></a>
				    <a class='addthis_counter addthis_bubble_style'></a>
				    </div>\n</div>
				    <script type='text/javascript' src='http://s7.addthis.com/js/250/addthis_widget.js#pubid=fangree'></script>";
					echo "</td>\n</tr>";
					}
				if ($ftsettings['video_youtube_link'] == "1") {
					echo "<tr>\n<td colspan='2' class='tbl2'>";
					echo"<div class='name' style='vertical-align: middle;'><input type='text' readonly='readonly' style='width: 315px;' class='textbox' onclick=\"this.focus();this.select();\" value='http://www.youtube.com/watch?v=".stripslashes($data['video_url'])."' style='width:90%;' /></div>\n";
	                echo "</td>\n</tr>\n";
					}
					echo"</table>";
					echo "<!--sub_video-->";	
					
					closetable();

				if ($ftsettings['video_facebook_comments'] == "1") {
				    opentable($locale['ft_156']);
					global $settings;
					echo"<div style='text-align:center; margin-top:10px; margin-bottom: 5px;'>\n";
					echo"<div id='fb-root'></div>
					<fb:comments href='".$settings['siteurl']."infusions/fusion_tube/".FUSION_SELF."?cat_id=".$cdata['video_cat_id']."&amp;video_id=".$data['video_id']."' num_posts='".stripslashes($ftsettings['video_facebook_comments_numpost'])."' width='".stripslashes($ftsettings['video_facebook_comments_width'])."'></fb:comments></div>\n";
					closetable();
					}
					
				if ($ftsettings['video_comments'] == "1") {
				if (isset($_GET['video_id']) && isnum($_GET['video_id']) && isset($_GET['cat_id']) && isNum($_GET['cat_id'])) {
					include INCLUDES."comments_include.php"; 
					showcomments("V", DB_VIDEOS, "video_id", $_GET['video_id'], FUSION_SELF."?cat_id=".$data['video_cat']."&amp;video_id=".$_GET['video_id']); 
					}
					}
				if (isset($_GET['video_id']) && isnum($_GET['video_id']) && isset($_GET['cat_id']) && isNum($_GET['cat_id'])) {
				if ($ftsettings['video_ratings'] == "1"  && $settings['ratings_enabled'] == "1") {
					include INCLUDES."ratings_include.php"; 
					showratings("V", $_GET['video_id'], FUSION_SELF."?cat_id=".$_GET['cat_id']."&amp;video_id=".$_GET['video_id']);
					}
					}
				if ($ftsettings['video_stats'] == "1") { echo ft_stats(); }
				if ($ftsettings['video_tags'] == "1") { echo fttags(); }
					
			}
		}	
	}
}

if ($res == 0) { redirect(INFUSIONS."fusion_tube/videos.php"); }
	
require_once THEMES."templates/footer.php";
	
?>