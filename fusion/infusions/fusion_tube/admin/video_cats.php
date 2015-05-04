<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: video_cats.php
| Version: 1.01
| Author: Fangree Productions
| Developers: Fangree_Craig & DrunkeN
| Site: http://www.fangree.com
+--------------------------------------------------------+
| Filename: weblink_cats.php
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
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";
include INFUSIONS."fusion_tube/infusion_db.php";

if (!checkrights("VID") || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) redirect("../index.php");

if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
    include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."fusion_tube/locale/English.php";
}
add_to_title($locale['global_200']." ".$locale['ft_003']." ".$locale['global_200']." ".$locale['ft_071']."");
include INFUSIONS."fusion_tube/admin/admin_nav.php";

if (isset($_GET['status']) && !isset($message)) {
	if ($_GET['status'] == "sn") {
		$message = $locale['ft_036'];
	} elseif ($_GET['status'] == "su") {
		$message = $locale['ft_037'];
	} elseif ($_GET['status'] == "deln") {
		$message = "".$locale['ft_033']."<br />\n<span class='small'>".$locale['ft_034']."</span>";
	} elseif ($_GET['status'] == "dely") {
		$message = $locale['ft_035'];
	}
	if ($message) {	echo "<div id='close-message'><div class='admin-message'>".$message."</div></div>\n"; }
}

if ((isset($_GET['action']) && $_GET['action'] == "delete") && (isset($_GET['cat_id']) && isnum($_GET['cat_id']))) {
	$result = dbcount("(video_cat)", DB_VIDEOS, "video_cat='".$_GET['cat_id']."'");
	if (!empty($result)) {
		redirect(FUSION_SELF.$aidlink."&status=deln");
	} else {
		$result = dbquery("DELETE FROM ".DB_VIDEO_CATS." WHERE video_cat_id='".$_GET['cat_id']."'");
		redirect(FUSION_SELF.$aidlink."&status=dely");
	}
} else {
	if (isset($_POST['save_cat'])) {
		$video_cat_name = stripinput($_POST['video_cat_name']);
		$video_cat_image  = stripinput($_POST['video_cat_image']);
		$video_cat_description = stripinput($_POST['video_cat_description']);
		$video_cat_access = isnum($_POST['video_cat_access']) ? $_POST['video_cat_access'] : "0";
		if (isnum($_POST['cat_sort_by']) && $_POST['cat_sort_by'] == "1") {
			$video_cat_sorting = "video_id ".($_POST['cat_sort_order'] == "ASC" ? "ASC" : "DESC");
		} else if (isnum($_POST['cat_sort_by']) && $_POST['cat_sort_by'] == "2") {
			$video_cat_sorting = "video_name ".($_POST['cat_sort_order'] == "ASC" ? "ASC" : "DESC");
		} else if (isnum($_POST['cat_sort_by']) && $_POST['cat_sort_by'] == "3") {
			$video_cat_sorting = "video_datestamp ".($_POST['cat_sort_order'] == "ASC" ? "ASC" : "DESC");
		} else {
			$video_cat_sorting = "video_name ASC";
		}
		if ($video_cat_name) {
			if ((isset($_GET['action']) && $_GET['action'] == "edit") && (isset($_GET['cat_id']) && isnum($_GET['cat_id']))) {
				$result = dbquery("UPDATE ".DB_VIDEO_CATS." SET video_cat_name='$video_cat_name', video_cat_description='$video_cat_description', video_cat_image='$video_cat_image', video_cat_sorting='$video_cat_sorting', video_cat_access='$video_cat_access' WHERE video_cat_id='".$_GET['cat_id']."'");
				redirect(FUSION_SELF.$aidlink."&status=su");
			} else {
				$checkCat = dbcount("(video_cat_id)", DB_VIDEO_CATS, "video_cat_name='".$video_cat_name."'");
				if ($checkCat == 0) {
					$result = dbquery("INSERT INTO ".DB_VIDEO_CATS." (video_cat_name, video_cat_description, video_cat_image, video_cat_sorting, video_cat_access) VALUES ('$video_cat_name', '$video_cat_description', '$video_cat_image', '$video_cat_sorting', '$video_cat_access')");
					redirect(FUSION_SELF.$aidlink."&status=sn");
				} else {
					$error = 2;
				}
			}
		} else {
			$error = 1;
		}
	}
	if ((isset($_GET['action']) && $_GET['action'] == "edit") && (isset($_GET['cat_id']) && isnum($_GET['cat_id']))) {
		$result = dbquery("SELECT video_cat_name, video_cat_description, video_cat_image, video_cat_sorting, video_cat_access FROM ".DB_VIDEO_CATS." WHERE video_cat_id='".$_GET['cat_id']."'");
		if (dbrows($result)) {
			$data = dbarray($result);
			$video_cat_name = $data['video_cat_name'];
			$video_cat_image = stripinput($data['video_cat_image']);
			$video_cat_description = $data['video_cat_description'];
			$video_cat_sorting = explode(" ", $data['video_cat_sorting']);
			if ($video_cat_sorting[0] == "video_id") { $cat_sort_by = "1"; }
			elseif ($video_cat_sorting[0] == "video_name") { $cat_sort_by = "2"; }
			else { $cat_sort_by = "3"; }
			$cat_sort_order = $video_cat_sorting[1];
			$video_cat_access = $data['video_cat_access'];
			$formaction = FUSION_SELF.$aidlink."&amp;action=edit&amp;cat_id=".$_GET['cat_id'];
			$openTable = "Edit category".$video_cat_name;
		} else {
			redirect(FUSION_SELF.$aidlink);
		}
	} else {
		$video_cat_name = "";
		$video_cat_image = "";
		$video_cat_description = "";
		$cat_sort_by = "video_name";
		$cat_sort_order = "ASC";
		$video_cat_access = "";
		$formaction = FUSION_SELF.$aidlink;
		$openTable = $locale['ft_038'];
	}
	$user_groups = getusergroups(); $access_opts = ""; $sel = "";
	while(list($key, $user_group) = each($user_groups)){
		$sel = ($video_cat_access == $user_group['0'] ? " selected='selected'" : "");
		$access_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']."</option>\n";
	}

	if (isset($error) && isnum($error)) {
		if ($error == 1) {
			$errorMessage = $locale['ft_039'];
		} elseif ($error == 2) {
			$errorMessage = $locale['ft_040'];
		}
		if ($errorMessage) { echo "<div id='close-message'><div class='admin-message'>".$errorMessage."</div></div>\n"; }
	}

	$image_list = makefileopts(makefilelist(INFUSIONS."fusion_tube/images/cats/", ".|..|index.php|Thumbs.db"), $video_cat_image);
	
	opentable($openTable);
	echo "<form name='addcat' method='post' action='".$formaction."'>\n";
	echo "<table cellpadding='0' cellspacing='0' width='400' class='center'>\n<tr>\n";
	echo "<td width='1%' class='tbl' style='white-space:nowrap'>".$locale['ft_041']."</td>\n";
	echo "<td class='tbl'><input type='text' name='video_cat_name' value='".$video_cat_name."' class='textbox' style='width:200px;' /></td>\n";
	echo "</tr>\n<tr>\n";


	echo "<td width='1%' class='tbl' style='white-space:nowrap'>".$locale['ft_042']."</td>\n";
	echo "<td class='tbl'><input type='text' name='video_cat_description' value='".$video_cat_description."' class='textbox' style='width:250px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='1%' class='tbl' style='white-space:nowrap'>".$locale['ft_043']."</td>\n";
	echo "<td class='tbl'><select name='cat_sort_by' class='textbox'>\n";
	echo "<option value='1'".($cat_sort_by == "1" ? " selected='selected'" : "").">".$locale['ft_044']."</option>\n";
	echo "<option value='2'".($cat_sort_by == "2" ? " selected='selected'" : "").">".$locale['ft_045']."</option>\n";
	echo "<option value='3'".($cat_sort_by == "3" ? " selected='selected'" : "").">".$locale['ft_046']."</option>\n";
	echo "</select> - <select name='cat_sort_order' class='textbox'>\n";
	echo "<option value='ASC'".($cat_sort_order == "ASC" ? " selected='selected'" : "").">".$locale['ft_047']."</option>\n";
	echo "<option value='DESC'".($cat_sort_order == "DESC" ? " selected='selected'" : "").">".$locale['ft_048']."</option>\n";
	echo "</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='1%' class='tbl' style='white-space:nowrap'>".$locale['ft_049']."</td>\n";
	echo "<td class='tbl'><select name='video_cat_image' class='textbox' style='width:150px;'>\n".$image_list."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='1%' class='tbl' style='white-space:nowrap'>".$locale['ft_050']."</td>\n";
	echo "<td class='tbl'><select name='video_cat_access' class='textbox' style='width:150px;'>\n".$access_opts."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td align='center' colspan='2' class='tbl'>\n";
	echo "<input type='submit' name='save_cat' value='".$locale['ft_051']."' class='button' /></td>\n";
	echo "</tr>\n</table>\n</form>\n";
	closetable();

	opentable($locale['ft_052']);
	echo "<table cellpadding='0' cellspacing='1' width='400' class='tbl-border center'>\n";
	$result = dbquery("SELECT video_cat_id, video_cat_name, video_cat_image, video_cat_description, video_cat_access FROM ".DB_VIDEO_CATS." ORDER BY video_cat_name");
	if (dbrows($result) != 0) {
		$i = 0;
		echo "<tr>\n";
		echo "<td class='tbl2'>".$locale['ft_053']."</td>\n";
		echo "<td class='tbl2'>".$locale['ft_054']."</td>\n";
		echo "<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>".$locale['ft_055']."</td>\n";
		echo "<td align='center' width='1%' class='tbl2' style='white-space:nowrap'>".$locale['ft_020']."</td>\n";
		echo "</tr>\n";
		while ($data = dbarray($result)) {
			$cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2");
			echo "<tr>\n";
			echo"<td class='$cell_color'><img class='vid-cat-image' src='".INFUSIONS."fusion_tube/images/cats/".$data['video_cat_image']."' style='border: 0px; ;' alt=''/></td>\n";
			echo "<td class='$cell_color' width='50%'>".$data['video_cat_name']."\n";
			echo ($data['video_cat_description'] ? "<br />\n<span class='small'>".trimlink($data['video_cat_description'], 45)."</span>" : "")."</td>\n";
			echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'>".getgroupname($data['video_cat_access'])."</td>\n";
			echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'><a href='".FUSION_SELF.$aidlink."&amp;action=edit&amp;cat_id=".$data['video_cat_id']."'>".$locale['ft_021']."</a> -\n";
			echo "<a href='".FUSION_SELF.$aidlink."&amp;action=delete&amp;cat_id=".$data['video_cat_id']."' onclick=\"return confirm('Delete this category?');\">".$locale['ft_022']."</a></td>\n";
			echo "</tr>\n";
			$i++;
		}
		echo "</table>\n";
	} else {
		echo "<tr><td align='center' class='tbl1'>".$locale['ft_056']."</td></tr>\n</table>\n";
	}
	closetable();
}
 // Please do not remove copyright info
  include INFUSIONS."fusion_tube/inc/copyright_func.php";
echo showFTcopyright();
require_once THEMES."templates/footer.php";
?>