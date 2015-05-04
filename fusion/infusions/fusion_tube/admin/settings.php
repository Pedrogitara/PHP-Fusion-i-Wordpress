<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: settings.php
| Version: 1.01
| Author: Fangree Productions
| Developers: Fangree_Craig
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
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";
include LOCALE.LOCALESET."admin/settings.php";
include INFUSIONS."fusion_tube/infusion_db.php";

if (!checkrights("VID") || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) redirect("../index.php");

if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
	include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."fusion_tube/locale/English.php";
}

add_to_title($locale['global_200']." ".$locale['ft_095']);

add_to_head("<link rel='stylesheet' href='".INFUSIONS."fusion_tube/inc/css/vid-css.css' type='text/css' media='screen' />");

if (isset($_GET['error']) && isnum($_GET['error']) && !isset($message)) {
	if ($_GET['error'] == 0) {
		$message = $locale['900'];
	} elseif ($_GET['error'] == 1) {
		$message = $locale['901'];
	}
if (isset($message)) {
		echo "<div id='close-message'><div class='admin-message'>".$message."</div></div>\n"; 
	}
}

   $ftsettings = dbarray(dbquery("SELECT * FROM ".DB_VIDEO_SETTINGS.""));
    $error = 0;

	$vidsenable=(isset($_POST['vidsenable']) && isNum($_POST['vidsenable'])) ? $_POST['vidsenable'] : "0";
	$video_social=(isset($_POST['video_social']) && isNum($_POST['video_social'])) ? $_POST['video_social'] : "0";
	$video_youtube_link=(isset($_POST['video_youtube_link']) && isNum($_POST['video_youtube_link'])) ? $_POST['video_youtube_link'] : "0";
	$video_facebook_comments=(isset($_POST['video_facebook_comments']) && isNum($_POST['video_facebook_comments'])) ? $_POST['video_facebook_comments'] : "0";
	$video_facebook_comments_width = stripinput($ftsettings['video_facebook_comments_width']);
	$video_facebook_comments_numpost = stripinput($ftsettings['video_facebook_comments_numpost']);
	$video_facebook_comments_userid = stripinput($ftsettings['video_facebook_comments_userid']);
	$video_facebook_comments_appid	= stripinput($ftsettings['video_facebook_comments_appid']);
	$video_comments=(isset($_POST['video_comments']) && isNum($_POST['video_comments'])) ? $_POST['video_comments'] : "0";
	$video_ratings=(isset($_POST['video_ratings']) && isNum($_POST['video_ratings'])) ? $_POST['video_ratings'] : "0";
	$video_latest_center=(isset($_POST['video_latest_center']) && isNum($_POST['video_latest_center'])) ? $_POST['video_latest_center'] : "0";
	$video_tags=(isset($_POST['video_tags']) && isNum($_POST['video_tags'])) ? $_POST['video_tags'] : "0";
	$video_stats=(isset($_POST['video_stats']) && isNum($_POST['video_stats'])) ? $_POST['video_stats'] : "0";
	$video_nav=(isset($_POST['video_nav']) && isNum($_POST['video_nav'])) ? $_POST['video_nav'] : "0";
	$video_descimg_pos=(isset($_POST['video_descimg_pos']) && isNum($_POST['video_descimg_pos'])) ? $_POST['video_descimg_pos'] : "0";
    $video_width = stripinput($ftsettings['video_width']);
	$video_height = stripinput($ftsettings['video_height']);
	$videos_per_page = stripinput($ftsettings['videos_per_page']);
	
if (isset($_POST['savesettings'])) {
    $result = dbquery("UPDATE ".DB_VIDEO_SETTINGS." SET vidsenable='$vidsenable', video_social='$video_social', video_youtube_link='$video_youtube_link', 
	video_facebook_comments='$video_facebook_comments', video_comments='$video_comments', video_ratings='$video_ratings', video_latest_center='$video_latest_center', 
	video_tags='$video_tags', video_stats='$video_stats', video_nav='$video_nav', video_descimg_pos='$video_descimg_pos', video_width='".addslashes($_POST['video_width'])."', 
	video_height='".addslashes($_POST['video_height'])."', video_facebook_comments_width='".addslashes($_POST['video_facebook_comments_width'])."', 
	video_facebook_comments_numpost='".addslashes($_POST['video_facebook_comments_numpost'])."', video_facebook_comments_userid='".addslashes($_POST['video_facebook_comments_userid'])."', 
	video_facebook_comments_appid='".addslashes($_POST['video_facebook_comments_appid'])."', videos_per_page='".addslashes($_POST['videos_per_page'])."'");
	if (!$result) { $error = 1; }

	redirect(FUSION_SELF.$aidlink."&error=".$error);
}

include INFUSIONS."fusion_tube/admin/admin_nav.php";

	opentable($locale['ft_095']);

	echo "<form name='settingsform' method='post' action='".FUSION_SELF.$aidlink."' onsubmit='return ValidateForm(this)'>\n";
    echo "<table cellpadding='0' cellspacing='0' width='60%' class='tbl-border' align='center'>\n<tr>\n";
	echo "<td class='tbl' >".$locale['ft_099']."</td>\n";
	echo "<td class='tbl' ><select name='vidsenable' class='textbox'>\n";
	echo "<option value='1'".($ftsettings['vidsenable'] == "1" ? " selected='selected'" : "").">".$locale['518']."</option>\n";
	echo "<option value='0'".($ftsettings['vidsenable'] == "0" ? " selected='selected'" : "").">".$locale['519']."</option>\n";
	echo "</select></td>\n</tr><tr>\n";
	echo "<td class='tbl'>".$locale['ft_100']."</td>\n";
	echo "<td class='tbl'><input type='text' maxlength='3' name='video_width'  value='".$ftsettings['video_width']."' class='textbox' style='width:50px;'><br />\n";
    echo "</td>\n</tr>\n<tr>\n";
	echo "<td class='tbl'>".$locale['ft_101']."</td>\n";
	echo "<td class='tbl'><input type='text' maxlength='3' name='video_height'  value='".$ftsettings['video_height']."' class='textbox' style='width:50px;'><br />\n";
    echo "</td>\n</tr><tr>\n";
	echo "<td class='tbl'>".$locale['ft_126']."</td>\n";
    echo "<td class='tbl'><input type='text' maxlength='2' name='videos_per_page'  value='".$ftsettings['videos_per_page']."' class='textbox' style='width:50px;'><br />\n";
	echo "</select></td>\n</tr><tr>\n";
	echo "<td class='tbl' >".$locale['ft_152']."</td>\n";
	echo "<td class='tbl' ><select name='video_descimg_pos' class='textbox'>\n";
	echo "<option value='1'".($ftsettings['video_descimg_pos'] == "1" ? " selected='selected'" : "").">".$locale['ft_153']."</option>\n";
	echo "<option value='0'".($ftsettings['video_descimg_pos'] == "0" ? " selected='selected'" : "").">".$locale['ft_154']."</option>\n";
	echo "</select></td>\n<tr>\n";
	echo "<td class='tbl' >".$locale['ft_102']."</td>\n";
	echo "<td class='tbl' ><select name='video_social' class='textbox'>\n";
	echo "<option value='1'".($ftsettings['video_social'] == "1" ? " selected='selected'" : "").">".$locale['518']."</option>\n";
	echo "<option value='0'".($ftsettings['video_social'] == "0" ? " selected='selected'" : "").">".$locale['519']."</option>\n";
	echo "</select></td>\n</tr><tr>\n";
	echo "<td class='tbl' >".$locale['ft_155']."</td>\n";
	echo "<td class='tbl' ><select name='video_youtube_link' class='textbox'>\n";
	echo "<option value='1'".($ftsettings['video_youtube_link'] == "1" ? " selected='selected'" : "").">".$locale['518']."</option>\n";
	echo "<option value='0'".($ftsettings['video_youtube_link'] == "0" ? " selected='selected'" : "").">".$locale['519']."</option>\n";
	echo "</select></td>\n</tr><tr>\n";
	echo "<td class='tbl' >".$locale['ft_157']."</td>\n";
	echo "<td class='tbl' ><select name='video_facebook_comments' class='textbox'>\n";
	echo "<option value='1'".($ftsettings['video_facebook_comments'] == "1" ? " selected='selected'" : "").">".$locale['518']."</option>\n";
	echo "<option value='0'".($ftsettings['video_facebook_comments'] == "0" ? " selected='selected'" : "").">".$locale['519']."</option>\n";
	echo "</select></td>\n</tr><tr>\n";
	echo "<td class='tbl'>".$locale['ft_158']."</td>\n";
	echo "<td class='tbl'><input type='text' maxlength='20' name='video_facebook_comments_userid'  value='".$ftsettings['video_facebook_comments_userid']."' class='textbox' style='width:120px;'><br />\n";
    echo "</td>\n</tr>\n<tr>\n";
	echo "<td class='tbl'>".$locale['ft_159']."</td>\n";
	echo "<td class='tbl'><input type='text' maxlength='30' name='video_facebook_comments_appid'  value='".$ftsettings['video_facebook_comments_appid']."' class='textbox' style='width:120px;'><br />\n";
    echo "</td>\n</tr>\n<tr>\n";
	echo "<td class='tbl'>".$locale['ft_160']."</td>\n";
	echo "<td class='tbl'><input type='text' maxlength='3' name='video_facebook_comments_width'  value='".$ftsettings['video_facebook_comments_width']."' class='textbox' style='width:50px;'><br />\n";
    echo "</td>\n</tr>\n<tr>\n";
	echo "<td class='tbl'>".$locale['ft_161'] ."</td>\n";
	echo "<td class='tbl'><input type='text' maxlength='2' name='video_facebook_comments_numpost'  value='".$ftsettings['video_facebook_comments_numpost']."' class='textbox' style='width:50px;'><br />\n";
    echo "</td>\n</tr><tr>\n";
	echo "<td class='tbl' >".$locale['ft_103']."</td>\n";
	echo "<td class='tbl' ><select name='video_comments' class='textbox'>\n";
	echo "<option value='1'".($ftsettings['video_comments'] == "1" ? " selected='selected'" : "").">".$locale['518']."</option>\n";
	echo "<option value='0'".($ftsettings['video_comments'] == "0" ? " selected='selected'" : "").">".$locale['519']."</option>\n";
	echo "</select></td>\n</tr><tr>\n";
	echo "<td class='tbl' >".$locale['ft_104']."</td>\n";
	if ($settings['ratings_enabled'] == "1") {
	echo "<td class='tbl' ><select name='video_ratings' class='textbox'>\n";
	echo "<option value='1'".($ftsettings['video_ratings'] == "1" ? " selected='selected'" : "").">".$locale['518']."</option>\n";
	echo "<option value='0'".($ftsettings['video_ratings'] == "0" ? " selected='selected'" : "").">".$locale['519']."</option>\n";
	echo "</select></td>\n</tr>";
	}else{
	echo "<td class='tbl' >\n";
	echo "<span style='color: #ff0000;'>".$locale['ft_166']."</span> <span id='video-ratings-tip' title='".$locale['ft_167']."'><img style='border: 0px; vertical-align:middle;' src='".INFUSIONS."fusion_tube/images/help.png' alt='".$locale['ft_169']."'/></span>\n";
	echo "</td>\n</tr>";
	}
	echo"<tr>\n";
	echo "<td class='tbl' >".$locale['ft_138']."</td>\n";
	echo "<td class='tbl' ><select name='video_nav' class='textbox'>\n";
	echo "<option value='1'".($ftsettings['video_nav'] == "1" ? " selected='selected'" : "").">".$locale['518']."</option>\n";
	echo "<option value='0'".($ftsettings['video_nav'] == "0" ? " selected='selected'" : "").">".$locale['519']."</option>\n";
	echo "</select></td>\n<tr>\n";
	echo "<td class='tbl' >".$locale['ft_106']."</td>\n";
	echo "<td class='tbl' ><select name='video_latest_center' class='textbox'>\n";
	echo "<option value='1'".($ftsettings['video_latest_center'] == "1" ? " selected='selected'" : "").">".$locale['518']."</option>\n";
	echo "<option value='0'".($ftsettings['video_latest_center'] == "0" ? " selected='selected'" : "").">".$locale['519']."</option>\n";
	echo "</select></td>\n<tr>\n";
	echo "<td class='tbl' >".$locale['ft_136']."</td>\n";
	echo "<td class='tbl' ><select name='video_tags' class='textbox'>\n";
	echo "<option value='1'".($ftsettings['video_tags'] == "1" ? " selected='selected'" : "").">".$locale['518']."</option>\n";
	echo "<option value='0'".($ftsettings['video_tags'] == "0" ? " selected='selected'" : "").">".$locale['519']."</option>\n";
	echo "</select></td>\n<tr>\n";
	echo "<td class='tbl' >".$locale['ft_137']."</td>\n";
	echo "<td class='tbl' ><select name='video_stats' class='textbox'>\n";
	echo "<option value='1'".($ftsettings['video_stats'] == "1" ? " selected='selected'" : "").">".$locale['518']."</option>\n";
	echo "<option value='0'".($ftsettings['video_stats'] == "0" ? " selected='selected'" : "").">".$locale['519']."</option>\n";
	echo "</select></td>\n<tr>\n";
	echo "<td class='tbl' >".$locale['ft_up001'].":</td>\n";
	echo "<td class='tbl' ><select onchange='window.location.href=this.value' class='textbox'>
	<option value='#' style='font-style:italic;' selected='selected' >".$locale['ft_up008']."</option>
	<option value='".INFUSIONS."fusion_tube/admin/fusiontube_upgrade.php".$aidlink."'>".$locale['ft_up005']."</option></select>\n";
	echo "</td>\n</tr>\n";
	echo "</table>\n";
	echo "<div width='60%' class='tbl' align='center'>\n";
	echo "<input type='submit' name='savesettings' value='".$locale['ft_015']."' class='button' />\n";
	echo"</div>\n";
	echo "</form>\n";
	
		add_to_head("<script type='text/javascript'>
function ValidateForm(frm) {

	if(isNaN(frm.video_width.value)) {
		alert('".$locale['ft_096']."');
		return false;
	}
	if(isNaN(frm.video_height.value)) {
		alert('".$locale['ft_096']."');
		return false;
	}
	if(isNaN(frm.videos_per_page.value)) {
		alert('".$locale['ft_096']."');
		return false;
	}
	if(isNaN(frm.video_facebook_comments_width.value)) {
		alert('".$locale['ft_162']."');
		return false;
	}
	if(isNaN(frm.video_facebook_comments_numpost.value)) {
		alert('".$locale['ft_163'] ."');
		return false;
	}
	if(frm.video_width.value=='') {
		alert('".$locale['ft_097']."');
		return false;
	}
		if(frm.video_height.value=='') {
		alert('".$locale['ft_098']."');
		return false;
	}
			if(frm.videos_per_page.value=='') {
		alert('".$locale['ft_127']."');
		return false;
	}
	if(frm.video_facebook_comments_width.value=='') {
		alert('".$locale['ft_164']."');
		return false;
	}
		if(frm.video_facebook_comments_numpost.value=='') {
		alert('".$locale['ft_165']."');
		return false;
	}
}
</script>
<script src='".BASEDIR."infusions/fusion_tube/inc/js/jquery.tipsy.js' type='text/javascript'></script>
<script type='text/javascript'>
    $(function() {
	  $('#video-ratings-tip').tipsy({gravity: 'w'});  
    });
  </script>
");
    closetable();
	 // Please do not remove copyright info
  include INFUSIONS."fusion_tube/inc/copyright_func.php";
echo showFTcopyright();
require_once THEMES."templates/footer.php";
?>