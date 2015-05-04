<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: videos_admin.php
| Version: 1.01
| Author: Fangree Productions
| Developers: Fangree_Craig & DrunkeN
| Site: http://www.fangree.com
+--------------------------------------------------------+
| Filename: copy of administration/weblinks.php
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
require_once INCLUDES."bbcode_include.php";
include INFUSIONS."fusion_tube/infusion_db.php";

if (!checkrights("VID") || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) redirect("../index.php");

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
// Load the locale file matching the current site locale setting.
include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
// Load the infusion's default locale file.
include INFUSIONS."fusion_tube/locale/English.php";
}
add_to_title($locale['global_200']." ".$locale['ft_003']." - ".$locale['ft_070']);
add_to_head("<link rel='stylesheet' href='".INFUSIONS."fusion_tube/inc/css/vid-css.css' type='text/css' media='screen' />");

if (isset($_GET['status']) && !isset($message)) {
	if ($_GET['status'] == "sn") {
		$message = $locale['ft_092'];
	} elseif ($_GET['status'] == "su") {
		$message = $locale['ft_093'];
	} elseif ($_GET['status'] == "del") {
		$message = $locale['ft_094'];
	}
	if ($message) {	echo "<div id='close-message'><div class='admin-message'>".$message."</div></div>\n"; }
}

include INFUSIONS."fusion_tube/admin/admin_nav.php";

$result = dbcount("(video_cat_id)", DB_VIDEO_CATS);
if (!empty($result)) {
	if ((isset($_GET['action']) && $_GET['action'] == "delete") && (isset($_GET['video_id']) && isnum($_GET['video_id']))) {
		$result = dbquery("DELETE FROM ".DB_VIDEOS." WHERE video_id='".$_GET['video_id']."'");
		redirect(FUSION_SELF.$aidlink."&video_cat_id=".$_GET['video_cat_id']."&amp;status=del");
	}
	if (isset($_POST['save_vid'])) {
		$video_name =      stripinput($_POST['video_name']);
		$video_description = addslash($_POST['video_description']);
	    $video_url = stripinput($_POST['video_url']);
		$video_cat = intval($_POST['video_cat']);
		if ($video_name) {
			if ((isset($_GET['action']) && $_GET['action'] == "edit") && (isset($_GET['video_id']) && isnum($_GET['video_id']))) {
				$result = dbquery("UPDATE ".DB_VIDEOS." SET video_euser='".$userdata['user_id']."', video_name='".$video_name."', video_description='".$video_description."', video_url='".$video_url."', video_cat='".$video_cat."' WHERE video_id='".$_GET['video_id']."'");
				redirect(FUSION_SELF.$aidlink."&video_cat_id=$video_cat&amp;status=su");
			} else {
				$result = dbquery("INSERT INTO ".DB_VIDEOS." (video_user, video_name, video_description, video_url, video_cat, video_datestamp) VALUES ('".$userdata['user_id']."', '".$video_name."', '".$video_description."', '".$video_url."', '".$video_cat."', '".time()."')");
				redirect(FUSION_SELF.$aidlink."&video_cat_id=$video_cat&amp;status=sn");
			}
		} else {
			redirect(FUSION_SELF.$aidlink);
		}
	}
	if ((isset($_GET['action']) && $_GET['action'] == "edit") && (isset($_GET['video_id']) && isnum($_GET['video_id']))) {
		$result = dbquery("SELECT video_name, video_description, video_url, video_cat FROM ".DB_VIDEOS." WHERE video_id='".$_GET['video_id']."'");
		if (dbrows($result)) {
			$data = dbarray($result);
			$video_name = $data['video_name'];
			$video_description = stripslashes($data['video_description']);
			$video_url = $data['video_url'];
			$video_cat = $data['video_cat'];
			$formaction = FUSION_SELF.$aidlink."&amp;action=edit&amp;video_id=".$_GET['video_id'];
			opentable($locale['ft_004']);
		} else {
			redirect(FUSION_SELF.$aidlink);
		}
	} else {
			$video_name = "";
			$video_description = "";
			$video_url = "";
			$video_cat = "";
		$formaction = FUSION_SELF.$aidlink;
		opentable($locale['ft_002']);
	}
	$editlist = ""; $sel = "";
	$result2 = dbquery("SELECT video_cat_id, video_cat_name FROM ".DB_VIDEO_CATS." ORDER BY video_cat_name");
	if (dbrows($result2) != 0) {
		while ($data2 = dbarray($result2)) {
			if (isset($_GET['action']) && $_GET['action'] == "edit") { $sel = ($video_cat == $data2['video_cat_id'] ? " selected='selected'" : ""); }
			$editlist .= "<option value='".$data2['video_cat_id']."'$sel>".$data2['video_cat_name']."</option>\n";
		}
	}
	echo "<form name='inputform' method='post' action='".$formaction."' onsubmit='return ValidateForm(this);'>\n";
	echo "<table align='center' width='90%' cellspacing='1' cellpadding='0' class='tbl-border center'>\n<tr>\n";
	echo "<td class='tbl'><span id='video-submit-tip' title='".$locale['ft_005']."'><img style='border: 0px; vertical-align:middle;' src='".INFUSIONS."fusion_tube/images/help.png' alt='".$locale['ft_169']."'/></span> ".$locale['ft_006']."</td>\n";
	echo "<td class='tbl'><input type='text' name='video_name' value='".$video_name."' class='textbox' style='width:300px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td style='vertical-align: top;' class='tbl'><span id='video-submit-tipb' title='".$locale['ft_007']."'><img style='border: 0px; vertical-align:middle;' src='".INFUSIONS."fusion_tube/images/help.png' alt='".$locale['ft_169']."'/></span> ".$locale['ft_008']."</td>\n";
	echo "<td class='tbl'><textarea name='video_description' cols='60' rows='5' class='textbox' style='width:300px;'>".$video_description."</textarea><br />\n";
    echo display_bbcodes("200px;", "video_description", "inputform")."\n";
    echo "</td>\n</tr>\n<tr>\n";
	echo "<td style='vertical-align: top;' class='tbl'><span id='video-submit-tipd' title='".$locale['ft_011']."'><img style='border: 0px; vertical-align:middle;' src='".INFUSIONS."fusion_tube/images/help.png' alt='".$locale['ft_169']."'/></span> ".$locale['ft_012']."</td>\n";
	echo "<td class='tbl'><input type='text' maxlength='15' name='video_url'  value='".$video_url."' class='textbox' style='width:300px;'><br />\n";
    echo "</td>\n</tr>\n<tr>\n";
	echo "<td  class='tbl'>".$locale['ft_013']."</td>\n";
	echo "<td class='tbl'><select name='video_cat' class='textbox' style='width:150px;'>\n".$editlist."</select></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td align='center' colspan='2' class='tbl'>";
	echo "<input type='submit' name='save_vid' value='".$locale['ft_015']."' class='button' /></td>\n";
	echo "</tr>\n</table>\n</form>\n";
	closetable();

	opentable($locale['ft_016']);
	echo "<table cellspacing='0' cellpadding='0' width='100%' class='center'>\n";
	$result = dbquery("SELECT video_cat_id, video_cat_name FROM ".DB_VIDEO_CATS." ORDER BY video_cat_name");
	if (dbrows($result)) {
		while ($data = dbarray($result)) {
		    echo "<table cellspacing='0' cellpadding='0' width='100%' class='center'>\n";
			echo "<tr>\n";
			echo "<td colspan='4' class='tbl2'><strong>".$data['video_cat_name']."</strong></td>\n";
			echo "</tr>";
			echo "<tr>\n";
		    echo "<td width='33%' class='tbl2'>".$locale['ft_017']."</td>\n";
		    echo "<td width='22%' class='tbl2'>".$locale['ft_018']."</td>\n";
		    echo "<td width='33%' class='tbl2'>".$locale['ft_019']."</td>\n";
		    echo "<td width='33%' class='tbl2'>".$locale['ft_020']."</td>\n";
		    echo "</tr>\n";
			if (!isset($_GET['video_cat_id']) || !isnum($_GET['video_cat_id']) && isset($_GET['cat_id']) && isNum($_GET['cat_id'])) { $_GET['video_cat_id'] = 0; }
			$result2 = dbquery("SELECT vi.*, u.user_id, u.user_name, u.user_status  FROM ".DB_VIDEOS." vi LEFT JOIN ".DB_USERS." u ON u.user_id=vi.video_user WHERE video_cat='".$data['video_cat_id']."' ORDER BY video_name");
			if (dbrows($result2)) {
				while ($data2 = dbarray($result2)) {
					echo "<tr>\n";
					echo "<td class='tbl1' style='white-space:nowrap'><a href='".INFUSIONS."fusion_tube/view.php?cat_id=".$data['video_cat_id']."&amp;video_id=".$data2['video_id']."'>".$data2['video_name']."</a></td>\n";
					echo "<td class='tbl1' style='white-space:nowrap'>".showdate("%B %d %Y", $data2['video_datestamp'])."</td>\n";
					echo "<td class='tbl1' style='white-space:nowrap'>".profile_link($data2['user_id'], $data2['user_name'], $data2['user_status'])."</td>\n";
					echo "<td class='tbl1' style='white-space:nowrap'><a href='".FUSION_SELF.$aidlink."&amp;action=edit&amp;video_cat_id=".$data['video_cat_id']."&amp;video_id=".$data2['video_id']."'>".$locale['ft_021']."</a> -\n";
					echo "<a href='".FUSION_SELF.$aidlink."&amp;action=delete&amp;video_cat_id=".$data['video_cat_id']."&amp;video_id=".$data2['video_id']."' onclick=\"return confirm('Delete this video');\">".$locale['ft_022']."</a></td>\n";
					echo "</tr>\n";
				}
			} else {
				echo "<tr>\n<td colspan='2'>\n";
				echo "<table width='100%' cellspacing='0' cellpadding='0'>\n<tr>\n";
				echo "<td class='tbl'>".$locale['ft_023']."</td>\n";
				echo "</tr>\n</table>\n</td>\n</tr>\n";
			}
		}
		echo "</table>\n";
	}
	closetable();
} else {
	opentable($locale['ft_024']);
	echo "<div style='text-align:center'>".$locale['ft_025']."<br />\n".$locale['ft_026']."<br />\n<br />\n";
	echo "<a href='video_cats.php".$aidlink."'>".$locale['ft_027']."</a> ".$locale['ft_028']."</div>\n";
	closetable();
}

 // Please do not remove copyright info
  include INFUSIONS."fusion_tube/inc/copyright_func.php";
echo showFTcopyright();

		add_to_footer("<script type='text/javascript'>
function ValidateForm(frm) {
	if(frm.video_name.value=='') {
		alert('".$locale['ft_029']."');
		return false;
	}
	if(frm.video_url.value=='') {
		alert('".$locale['ft_031']."');
		return false;
	}
	if(frm.video_description.value=='') {
		alert('".$locale['ft_032']."');
		return false;
	}
}
</script>

<script src='".BASEDIR."infusions/fusion_tube/inc/js/jquery.tipsy.js' type='text/javascript'></script>
<script type='text/javascript'>
    $(function() {
	  $('#video-submit-tip').tipsy({gravity: 'e'});  
	    $('#video-submit-tipb').tipsy({gravity: 'e'});    
		  $('#video-submit-tipd').tipsy({gravity: 'e'});  
    });
  </script>");
  
require_once THEMES."templates/footer.php";
?>