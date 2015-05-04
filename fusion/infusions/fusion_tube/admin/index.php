<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: index.php
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
include INFUSIONS."fusion_tube/infusion_db.php";

if (!checkrights("VID") || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) redirect("../index.php");

if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
    include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
    include INFUSIONS."fusion_tube/locale/English.php";
}
add_to_title($locale['global_200'].$locale['ft_105']);

include INFUSIONS."fusion_tube/admin/admin_nav.php";

opentable($locale['ft_003']);
	echo"<table style='width: 60%;' border='0' class='center'>\n<tr>\n";
	echo"<td style='text-align: center;'><a href='".INFUSIONS."fusion_tube/admin/videos_admin.php".$aidlink."' class='side'><img style='border: 0px;' src='".INFUSIONS."fusion_tube/admin/images/add_vid.gif' alt='".$locale['ft_070']."'/></a>\n<br />\n";
	echo"<a href='".INFUSIONS."fusion_tube/admin/videos_admin.php".$aidlink."' class='side'>".$locale['ft_070']."</a></td>\n";
	echo"<td style='text-align: center;'><a href='".INFUSIONS."fusion_tube/admin/video_cats.php".$aidlink."' class='side'><img style='border: 0px;' src='".INFUSIONS."fusion_tube/admin/images/edit_vcat.gif' alt='".$locale['ft_071']."'/></a>\n<br />\n";
	echo"<a href='".INFUSIONS."fusion_tube/admin/video_cats.php".$aidlink."' class='side'>".$locale['ft_071']."</a></td>\n";
	echo"</tr>\n";
	echo"<tr>\n";
	echo"<td style='text-align: center;'><a href='".INFUSIONS."fusion_tube/admin/settings.php".$aidlink."' class='side'><img style='border: 0px;' src='".INFUSIONS."fusion_tube/admin/images/vid_settings.gif' alt='".$locale['ft_095']."'/></a>\n<br />\n";
	echo"<a href='".INFUSIONS."fusion_tube/admin/settings.php".$aidlink."' class='side'>".$locale['ft_095']."</a></td>\n";
	echo"<td style='text-align: center;'><a href='".INFUSIONS."fusion_tube/admin/submissions.php".$aidlink."' class='side'><img style='border: 0px;' src='".INFUSIONS."fusion_tube/admin/images/infusion_panel.gif' alt='".$locale['ft_091']."'/></a>\n<br />\n";
	echo"<a href='".INFUSIONS."fusion_tube/admin/submissions.php".$aidlink."' class='side'>".$locale['ft_091']."</a></td>\n";
	echo"</tr>\n</table>\n";

closetable();
	if ($sub_count) {
	opentable($locale['ft_075']);
if ($sub_count) {
	echo "<a href='".INFUSIONS."fusion_tube/admin/submissions.php".$aidlink."'> ".sprintf("".$locale['ft_072']." %u ".$locale['ft_073']."", $sub_count);
    echo ($sub_count == 1 ? " ".$locale['ft_074']."" : " ".$locale['ft_075']."")."</a></strong>\n";
	} else { 
	echo  sprintf("".$locale['ft_072']." %u ".$locale['ft_073']."", $sub_count);
    echo ($sub_count == 1 ? " ".$locale['ft_074']."" : " ".$locale['ft_075']."")."</strong>\n";
	}
closetable();
}
 // Please do not remove copyright info
  include INFUSIONS."fusion_tube/inc/copyright_func.php";
echo showFTcopyright();

require_once THEMES."templates/footer.php";
?>