<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: submissions.php
| Author: Nick Jones (Digitanium)
| Co-Author: Daywalker
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";
require_once INCLUDES."bbcode_include.php";
include INFUSIONS."fusion_tube/infusion_db.php";

if (!checkrights("VID") || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) redirect("../index.php");
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
    include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."fusion_tube/locale/English.php";
}
include LOCALE.LOCALESET."admin/submissions.php";
add_to_title($locale['global_200']." ".$locale['ft_091']."");
$links = ""; 
include INFUSIONS."fusion_tube/admin/admin_nav.php";
if (!isset($_GET['action']) || $_GET['action'] == "1") {
	if (isset($_GET['delete']) && isnum($_GET['delete'])) {
		$result = dbquery("SELECT video_submit_type, video_submit_criteria FROM ".DB_VIDEO_SUBMISSIONS." WHERE video_submit_id='".$_GET['delete']."'");
		if (dbrows($result)) {
			$data = dbarray($result);
		
			opentable($locale['400']);
			$result = dbquery("DELETE FROM ".DB_VIDEO_SUBMISSIONS." WHERE video_submit_id='".$_GET['delete']."'");
			echo "<br /><div style='text-align:center'>".$locale['ft_076']."<br /><br />\n";
			echo "<a href='".FUSION_SELF.$aidlink."'>".$locale['ft_077']."</a><br /><br />\n";
			echo "<a href='index.php".$aidlink."'>".$locale['ft_078']."</a></div><br />\n";
			closetable();
		} else {
			redirect(FUSION_SELF.$aidlink);
		}
	} else {
		$result = dbquery("SELECT video_submit_id, video_submit_criteria FROM ".DB_VIDEO_SUBMISSIONS." WHERE video_submit_type='video' ORDER BY video_submit_datestamp DESC");
		if (dbrows($result)) {
			while ($data = dbarray($result)) {
				$video_submit_criteria = unserialize($data['video_submit_criteria']);
				$links .= "<tr>\n<td class='tbl1'>".$video_submit_criteria['video_name']."</td>\n";
				$links .= "<td align='right' width='1%' class='tbl1' style='white-space:nowrap'><span class='small'><a href='".FUSION_SELF.$aidlink."&amp;action=2&amp;t=video&amp;video_submit_id=".$data['video_submit_id']."'>".$locale['ft_079']."</a></span> |\n";
				$links .= "<span class='small'><a href='".FUSION_SELF.$aidlink."&amp;delete=".$data['video_submit_id']."'>".$locale['ft_022']."</a></span></td>\n</tr>\n";
			}
		} else {
			$links = "<tr>\n<td colspan='2' class='tbl1'>".$locale['ft_080']."</td>\n</tr>\n";
		}
		opentable($locale['ft_081']);
		echo "<table cellpadding='0' cellspacing='1' width='400' class='tbl-border center'>\n<tr>\n";
		echo "<td colspan='2' class='tbl2'><a id='video_submissions' name='video_submissions'></a>\n".$locale['ft_082'].":</td>\n";
		echo "</tr>".$links."</table>\n";
		closetable();
	}
}
if ((isset($_GET['action']) && $_GET['action'] == "2")) {
	if (isset($_POST['add']) && (isset($_GET['video_submit_id']) && isnum($_GET['video_submit_id']))) {
		$video_name =      stripinput($_POST['video_name']);
		$video_description = addslash($_POST['video_description']);
	    $video_url = stripinput($_POST['video_url']);
			$result = dbquery(
			"SELECT ts.video_submit_criteria, ts.video_submit_datestamp, tu.user_id, tu.user_name, tu.user_status
			FROM ".DB_VIDEO_SUBMISSIONS." ts
			LEFT JOIN ".DB_USERS." tu ON ts.video_submit_user=tu.user_id
			WHERE video_submit_id='".$_GET['video_submit_id']."'"
		);
		
		if (dbrows($result)) {
			$data = dbarray($result);
		$result = dbquery("INSERT INTO ".DB_VIDEOS." (video_user, video_name, video_description, video_url, video_cat, video_datestamp) VALUES ('".$data['user_id']."', '".$video_name."', '".$video_description."', '".$video_url."', '".stripinput($_POST['video_cat'])."', '".time()."')");
		if (isset($_POST['add'])) {
		             global $userdata;
					 require_once INCLUDES."infusions_include.php";
		             $sender_id = $userdata['user_id'];
		             $reciever_id = $data['user_id'];
		             $subject = $locale['ft_110'];
		             $message = $locale['ft_111'];
		             send_pm($reciever_id, $sender_id, $subject, $message);
				   }
		$result = dbquery("DELETE FROM ".DB_VIDEO_SUBMISSIONS." WHERE video_submit_id='".$_GET['video_submit_id']."'");
	}
		opentable($locale['ft_083']);
		echo "<br /><div style='text-align:center'>".$locale['ft_084']."<br /><br />\n";
		echo "<a href='".FUSION_SELF.$aidlink."'>".$locale['ft_077']."</a><br /><br />\n";
		echo "<a href='index.php".$aidlink."'>".$locale['ft_078']."</a></div><br />\n";
		closetable();
	} else if (isset($_POST['delete']) && (isset($_GET['video_submit_id']) && isnum($_GET['video_submit_id']))) {
		opentable($locale['ft_085']);
		$result = dbquery("DELETE FROM ".DB_VIDEO_SUBMISSIONS." WHERE video_submit_id='".$_GET['video_submit_id']."'");
		echo "<br /><div style='text-align:center'>".$locale['ft_086']."<br /><br />\n";
		echo "<a href='".FUSION_SELF.$aidlink."'>".$locale['ft_077']."</a><br /><br />\n";
		echo "<a href='index.php".$aidlink."'>".$locale['ft_078']."</a></div><br />\n";
		closetable();
	} else {
		$result = dbquery(
			"SELECT ts.video_submit_criteria, ts.video_submit_datestamp, tu.user_id, tu.user_name, tu.user_status
			FROM ".DB_VIDEO_SUBMISSIONS." ts
			LEFT JOIN ".DB_USERS." tu ON ts.video_submit_user=tu.user_id
			WHERE video_submit_id='".$_GET['video_submit_id']."'"
		);
		
		if (dbrows($result)) {
			$data = dbarray($result);
			$opts = ""; $sel = "";
			$video_submit_criteria = unserialize($data['video_submit_criteria']);
			$posted = showdate("longdate", $data['video_submit_datestamp']);
			$result2 = dbquery("SELECT video_cat_id, video_cat_name FROM ".DB_VIDEO_CATS." ORDER BY video_cat_name");
			if (dbrows($result2) != 0) {
				while($data2 = dbarray($result2)) {
					if (isset($video_submit_criteria['video_cat'])) {
						$sel = ($video_submit_criteria['video_cat'] == $data2['video_cat_id'] ? " selected='selected'" : "");
					
					}
					$opts .= "<option value='".$data2['video_cat_id']."'$sel>".$data2['video_cat_name']."</option>\n";
				
				
				}
			} else {
				$opts .= "<option value='0'>".$locale['ft_087']."</option>\n";
			}
			
			opentable($locale['440']);
			
			echo "<form name='publish' method='post' action='".FUSION_SELF.$aidlink."&amp;action=2&amp;video_submit_id=".$_GET['video_submit_id']."'>\n";
			echo "<table cellpadding='0' cellspacing='0' class='center'>\n<tr>\n";
			echo "<td style='text-align:center;' class='tbl'>".$locale['ft_088']." ".profile_link($data['user_id'], $data['user_name'], $data['user_status'])." ".$locale['ft_060']." ".$posted."</td>\n";
			echo "</tr>\n<tr>";
			echo "<td style='text-align:center;' class='tbl'>".$video_submit_criteria['video_name']."<br /></td>\n";
			echo "</tr>\n</table>\n";
			echo "<table cellpadding='0' cellspacing='0' class='center'>\n<tr>\n";
			echo "<td class='tbl'>".$locale['ft_054']."</td>\n";
			echo "<td class='tbl'><select name='video_cat' class='textbox'>\n".$opts."</select></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td class='tbl'>".$locale['ft_006']."</td>\n";
			echo "<td class='tbl'><input type='text' name='video_name' value='".$video_submit_criteria['video_name']."' class='textbox' style='width:300px' /></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td class='tbl' style='vertical-align:top;'>".$locale['ft_008']."</td>\n";
            echo "<td class='tbl'><textarea name='video_description' cols='60' rows='5' class='textbox' style='width:300px;'>".$video_submit_criteria['video_description']."</textarea><br />\n";
            echo display_bbcodes("200px;", "video_description", "publish")."\n";
            echo "</td></tr>\n<tr>\n";
			echo "<td class='tbl'>".$locale['ft_012']."</td>\n";
			echo "<td class='tbl'><input type='text' name='video_url' value='".$video_submit_criteria['video_url']."' class='textbox' style='width:300px' /></td>\n";
			echo "</tr>\n</table>\n";
			echo "<div style='text-align:center'><br />\n";
			echo $locale['ft_089']."<br />\n";
			echo "<input type='submit' name='add' value='".$locale['ft_090']."' class='button' />\n";
			echo "<input type='submit' name='delete' value='".$locale['ft_022']."' class='button' /></div>\n";
			echo "</form>\n";
			closetable();
		} else {
			redirect(FUSION_SELF.$aidlink);
		}
	}
}

require_once THEMES."templates/footer.php";
?>