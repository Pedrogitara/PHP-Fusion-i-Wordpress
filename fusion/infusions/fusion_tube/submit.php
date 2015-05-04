<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: submit.php
| Version: 1.01
| Author: Fangree Productions
| Developers: Fangree_Craig & DrunkeN
| Site: http://www.fangree.com
+--------------------------------------------------------+
| Based on PHP-Fusion Submissions Form
| Filename: submit.php
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
require_once "../../maincore.php";
require_once THEMES."templates/header_mce.php";
require_once INCLUDES."bbcode_include.php";
include INFUSIONS."fusion_tube/infusion_db.php";
include INFUSIONS."fusion_tube/inc/nav_func.php";
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
    include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."fusion_tube/locale/English.php";
}
include LOCALE.LOCALESET."submit.php";

if (!iMEMBER) { redirect("index.php"); }

$ftsettings = dbarray(dbquery("SELECT * FROM ".DB_VIDEO_SETTINGS.""));

if ($ftsettings['vidsenable'] !== "1"  && !checkrights('VID')) { redirect("../../index.php"); }
if ($ftsettings['vidsenable'] !== "1" && iADMIN && checkrights('VID')) { 
echo "<div id='close-message'><div class='admin-message'>".$locale['ft_112']."</div></div>\n"; 
}

add_to_head("<link rel='stylesheet' href='".INFUSIONS."fusion_tube/inc/css/vid-css.css' type='text/css' media='screen' />");
add_to_title($locale['global_200']." ".$locale['ft_063']."");
  if ($ftsettings['video_nav'] == "1") { echo ftnav(); }
$video_submit_info = array();

	if (isset($_POST['video_submit_link'])) {
		if ($_POST['video_name'] != "" && $_POST['video_description'] != "" && $_POST['video_url'] != "") {
			$video_submit_info['video_cat'] = stripinput($_POST['video_cat']);
			$video_submit_info['video_name'] = stripinput($_POST['video_name']);
			$video_submit_info['video_url'] = stripinput($_POST['video_url']);
			$video_submit_info['video_description'] = addslash($_POST['video_description']);
			$result = dbquery("INSERT INTO ".DB_VIDEO_SUBMISSIONS." (video_submit_type, video_submit_user, video_submit_datestamp, video_submit_criteria) VALUES ('video', '".$userdata['user_id']."', '".time()."', '".addslashes(serialize($video_submit_info))."')");
			opentable($locale['ft_063']);
			echo "<div style='text-align:center'><br />\n".$locale['ft_064']."<br /><br />\n";
			echo "<a href='".BASEDIR."infusions/fusion_tube/submit.php'>".$locale['ft_065']."</a><br /><br />\n";
			echo "<a href='".BASEDIR."index.php'>".$locale['ft_066']." ".$settings['sitename']."</a><br /><br />\n</div>\n";
			closetable();
		 }else{
  opentable($locale['ft_144']);
  echo $locale['ft_145'];
  closetable();
  }
	} else {
		$opts = "";
		opentable($locale['ft_063']);
		$result = dbquery("SELECT video_cat_id, video_cat_name FROM ".DB_VIDEO_CATS." WHERE ".groupaccess('video_cat_access')." ORDER BY video_cat_name");
		if (dbrows($result)) {
			while ($data = dbarray($result)) {
				$opts .= "<option value='".$data['video_cat_id']."'>".$data['video_cat_name']."</option>\n";
			}
			echo $locale['ft_067']."<br /><br />\n";
			echo "<form name='video_submit_form' method='post' action='".FUSION_SELF."?stype=video' onsubmit='return ValidateForm(this);'>\n";
			echo "<table align='center' width='90%' cellspacing='1' cellpadding='0' class='tbl-border'>\n<tr>\n";
	        echo "<td class='tbl'><span id='video-submit-tip' title='".$locale['ft_005']."'><img style='border: 0px; vertical-align:middle;' src='".INFUSIONS."fusion_tube/images/help.png' alt='".$locale['ft_169']."'/></span> ".$locale['ft_006']."</td>\n";
	        echo "<td class='tbl'><input type='text' name='video_name' maxlength='50' class='textbox' style='width:300px;' /></td>\n";
	        echo "</tr>\n<tr>\n";
	        echo "<td style='vertical-align: top;' class='tbl'><span id='video-submit-tipb' title='".$locale['ft_007']."'><img style='border: 0px; vertical-align:middle;' src='".INFUSIONS."fusion_tube/images/help.png' alt='".$locale['ft_169']."'/></span> ".$locale['ft_008']."</td>\n";
	        echo "<td class='tbl'><textarea name='video_description' cols='60' rows='5' class='textbox' style='width:300px;'></textarea><br />\n";
            echo display_bbcodes("350px;", "video_description", "video_submit_form")."\n";
            echo "</td>\n</tr>\n<tr>\n";
	        echo "<td style='vertical-align: top;' class='tbl'><span id='video-submit-tipd' title='".$locale['ft_011']."'><img style='border: 0px; vertical-align:middle;' src='".INFUSIONS."fusion_tube/images/help.png' alt='".$locale['ft_169']."'/></span> ".$locale['ft_012']."</td>\n";
	        echo "<td class='tbl'><input type='text' maxlength='15' name='video_url'  value='' class='textbox' style='width:300px;'><br />\n";
            echo "</td>\n</tr>\n<tr>\n";
	        echo "<td class='tbl'>".$locale['ft_054']."</td>\n";
	        echo "<td class='tbl'><select name='video_cat' class='textbox' style='width:150px;'>\n".$opts."</select></td>\n";
	        echo "</tr>\n<tr>\n";
			echo "<td align='center' colspan='2' class='tbl'><br />\n";
			echo "<input type='submit' name='video_submit_link' value='".$locale['ft_068']."' class='button' />\n</td>\n";
			echo "</tr>\n</table>\n</form>\n";
		} else {
			echo "<div style='text-align:center'><br />\n".$locale['ft_069']."<br /><br />\n</div>\n";
		}
		closetable();
	}
		add_to_head("<script type='text/javascript'>
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