<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: search.php
| Version: 1.01
| Author: Fangree Productions
| Developers: Fangree_Craig, Discofan
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
require_once THEMES."templates/header.php";
include INFUSIONS."fusion_tube/infusion_db.php";
include INFUSIONS."fusion_tube/inc/nav_func.php";
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
    include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."fusion_tube/locale/English.php";
}

     $ftsettings = dbarray(dbquery("SELECT * FROM ".DB_VIDEO_SETTINGS.""));
	 
	 if ($ftsettings['video_nav'] == "1") { echo ftnav(); }

     $results_per_page = 10;

opentable($locale['ft_114']);
echo"<a title='".$locale['ft_125']."' href='".INFUSIONS."fusion_tube/videos.php'><img src='".INFUSIONS."fusion_tube/images/back.png' style='padding: 10px; border: 0px; vertical-align:middle;' alt='".$locale['ft_125']."'/></a>\n";
echo"<div style='text-align: center;'>\n";
echo" <strong>".$locale['ft_114']."</strong><br />\n";
echo "<form action='".FUSION_SELF."' method='get' name='searchform' id='searchform'>\n";
echo "<input type='text' name='words' id='words'  maxlength='75' value='".$locale['ft_115']."' onfocus=\"if(this.value == '".$locale['ft_115']."') { this.value = ''; }\" onblur=\"if(this.value == '') { this.value='".$locale['ft_115']."'; }\" style='width: 220px;' class='textbox' />\n";
echo "<input type='submit' name='search' id='search' value='".$locale['ft_116']."' class='button' />\n";
echo "</form>\n";
echo" </div>\n";
closetable();

	
	if (isset($_GET['words'])) {

		if (!isset($_GET['rowstart']) || !isNum($_GET['rowstart'])) $_GET['rowstart'] = 0;

		$words = stripinput(trim($_GET['words']));
		if (!preg_match("/^[-0-9A-Z_@\s]+$/i", $words)) $words = "";

		if ($words != "") {

			$rows = dbcount("(video_id)", DB_VIDEOS, "video_name LIKE '%".$words."%'");
			$result = dbquery("SELECT
				vi.video_id, vi.video_name, vi.video_url, vi.video_description, vi.video_cat, vi.video_datestamp,
				vc.video_cat_id, vc.video_cat_access 
				FROM ".DB_VIDEOS." vi
				INNER JOIN ".DB_VIDEO_CATS." vc ON vi.video_cat=vc.video_cat_id
				".(iSUPERADMIN ? "" : " WHERE ".groupaccess('video_cat_access'))." AND video_name LIKE '%".$words."%' ORDER BY video_datestamp DESC LIMIT ".$_GET['rowstart'].",".$results_per_page."
			");

			if (dbrows($result) != 0) {
				opentable($locale['ft_117']);
				echo dbcount("(video_id)", DB_VIDEOS, "video_name LIKE '%".$words."%'");
				echo ($rows == 1 ? $locale['ft_118b'] : $locale['ft_118'])." &quot;".$words."&quot; <br /><br />";
				echo "<table class='tbl-border' width='100%'>";
				while ($data = dbarray($result)) {
					echo "<tr><td class='tbl1' width='10%'>";
						echo "<a href='".BASEDIR."infusions/fusion_tube/view.php?cat_id=".$data['video_cat_id']."&amp;video_id=".$data['video_id']."'><img src='http://i3.ytimg.com/vi/".stripslashes($data['video_url'])."/default.jpg' alt='".$data['video_name']."' class='vid-cat-image' style='border: 0px; width: 120px; height: 90px;' /></a> \n";
					echo "</td><td class='tbl1'>";
					echo "<a href='".BASEDIR."infusions/fusion_tube/view.php?cat_id=".$data['video_cat_id']."&amp;video_id=".$data['video_id']."' class='side'>".$data['video_name']."</a><br />\n";
					echo "</td></tr><tr>";
				}
				echo "</table>";
				if ($rows > $results_per_page) echo "<div align='center' style=';margin-top:5px;'>\n".makepagenav($_GET['rowstart'], $results_per_page, $rows, 3, FUSION_SELF."?words=".$words."&amp;")."\n</div>\n";
			} else {
				opentable($locale['ft_119']);
				echo "<div style='text-align:center;'>".$locale['ft_120']." &quot;".$words."&quot; ".$locale['ft_121']."</div>\n";
			}
		} else {
			opentable($locale['ft_122']);
			echo "<div style='text-align:center;'>".$locale['ft_123']."</div>\n";
		}
		closetable();
	}

require_once THEMES."templates/footer.php";

?>