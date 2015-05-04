<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: edit_video.php
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
require_once INCLUDES."comments_include.php";
require_once INCLUDES."bbcode_include.php";
include INFUSIONS."fusion_tube/infusion_db.php";
include INFUSIONS."fusion_tube/inc/nav_func.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
// Load the locale file matching the current site locale setting.
    include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
    } else {
// Load the infusion's default locale file.
    include INFUSIONS."fusion_tube/locale/English.php";
}

if (!iMEMBER) { redirect("index.php"); }

add_to_title($locale['global_200']." ".$locale['ft_138b']);
	add_to_head("<link rel='stylesheet' href='".INFUSIONS."fusion_tube/inc/css/vid-css.css' type='text/css' media='screen' />");
    $video_id = (isset($_GET['video_id']) AND isnum($_GET['video_id'])) ? $_GET['video_id'] : "";

if (isset($_POST['do'])) { 
		if ($_POST['video_name'] != "" && $_POST['video_description'] != ""  && $_POST['video_url'] != "") {
            $video_name = stripinput($_POST['video_name']);
			$video_url = stripinput($_POST['video_url']);
			$video_description = addslash($_POST['video_description']);
			
if (isset($_GET['action']) && $_GET['action'] == "edit") {
           $result = dbquery("UPDATE ".DB_VIDEOS." SET video_name='".$video_name."', video_url='".$video_url."', video_description='".$video_description."' ,video_update_datestamp='".time()."' WHERE video_id='".$video_id."'");
           $ftsettings = dbarray(dbquery("SELECT * FROM ".DB_VIDEO_SETTINGS.""));
		   if ($ftsettings['video_nav'] == "1") { echo ftnav(); }
            opentable($locale['ft_093']);
			echo "<div style='text-align:center'><br />\n".$locale['ft_139']." ".$data['video_name']." ".$locale['ft_140']."<br /><br />\n";
			echo "<a href='".BASEDIR."infusions/fusion_tube/videos.php'>".$locale['ft_141']."</a><br /><br />\n";
			echo "<a href='".BASEDIR."index.php'>".$locale['ft_066']." ".$settings['sitename']."</a><br /><br />\n</div>\n";
			closetable();
  }
  }else{
  opentable($locale['ft_144']);
  echo $locale['ft_145'];
  closetable();
  }
}else{
   	
            $result = dbquery("SELECT vi.*, u.user_id, u.user_name, u.user_status FROM ".DB_VIDEOS." vi LEFT JOIN ".DB_USERS." u ON u.user_id=vi.video_user WHERE video_id='".$video_id."'");
            $ftsettings = dbarray(dbquery("SELECT * FROM ".DB_VIDEO_SETTINGS.""));
            $data = dbarray($result);
            $video_name = stripinput($data['video_name']);
			$video_url = stripinput($data['video_url']);
			$video_description = stripslashes($data['video_description']);
		    $video_update_datestamp = isset($_POST['video_update_datestamp']) ? ", video_update_datestamp='".time()."'" : "";
	        $video_action = FUSION_SELF."?action=edit&amp;video_id=".$video_id;
	
	if($userdata['user_id'] != $data['user_id']) { redirect(BASEDIR."index.php"); }
	
	if ($ftsettings['video_nav'] == "1") { echo ftnav(); }
    opentable($locale['ft_138b']." - <span style='border-bottom: 1px solid #008B00;'>".$data['video_name']."</span>");
           require_once INCLUDES."bbcode_include.php";
            echo "<form name='video_edit_form' method='post' action='".$video_action."' onsubmit='return ValidateForm(this);'>\n";
            echo "<table align='center' width='90%' cellspacing='1' cellpadding='0' class='tbl-border'>\n<tr>\n";
	        echo "<td class='tbl'><span id='video-submit-tip' title='".$locale['ft_005']."'><img style='border: 0px; vertical-align:middle;' src='".INFUSIONS."fusion_tube/images/help.png' alt='".$locale['ft_169']."'/></span> ".$locale['ft_006']."</td>\n";
	        echo "<td class='tbl'><input type='text' name='video_name' maxlength='50' value='".$video_name."' class='textbox' style='width:300px;' /></td>\n";
	        echo "</tr>\n<tr>\n";
	        echo "<td style='vertical-align: top;' class='tbl'><span id='video-submit-tipb' title='".$locale['ft_007']."'><img style='border: 0px; vertical-align:middle;' src='".INFUSIONS."fusion_tube/images/help.png' alt='".$locale['ft_169']."'/></span> ".$locale['ft_008']."</td>\n";
	        echo "<td class='tbl'><textarea name='video_description' cols='60' rows='5'  class='textbox' style='width:300px;'>".$video_description."</textarea><br />\n";
            echo display_bbcodes("350px;", "video_description", "video_edit_form")."\n";
            echo "</td>\n</tr>\n<tr>\n";
	        echo "<td style='vertical-align: top;' class='tbl'><span id='video-submit-tipd' title='".$locale['ft_011']."'><img style='border: 0px; vertical-align:middle;' src='".INFUSIONS."fusion_tube/images/help.png' alt='".$locale['ft_169']."'/></span> ".$locale['ft_012']."</td>\n";
	        echo "<td class='tbl'><input type='text' maxlength='15' name='video_url'  value='".$video_url."' class='textbox' style='width:300px;'><br />\n";
            echo "</td>\n</tr>\n<tr>\n";
	        echo "<td align='center' colspan='2' class='tbl'>";
	if (isset($_GET['action']) && $_GET['action'] == "edit") {
	        echo "<input type='submit' name='do' value='".$locale['ft_138b']."' class='button' style='align:center;' />\n";
	      }
            echo "</tr>\n</table>\n</form>\n";
closetable();
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
}
require_once THEMES."templates/footer.php";
?>