<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: search_func.php
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
if (!defined("IN_FUSION")) { die("Access Denied"); }
include INFUSIONS."fusion_tube/infusion_db.php";

$ftsettings = dbarray(dbquery("SELECT * FROM ".DB_VIDEO_SETTINGS.""));
	 
	 if ($ftsettings['video_nav'] == "1") { 
function ftnav() {
global $settings;
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
include INFUSIONS."fusion_tube/locale/English.php";
}	
include INFUSIONS."fusion_tube/infusion_db.php";

add_to_head("<style type='text/css'>
.pre-nav { margin-top: 0px; margin-bottom: 10px; line-height: 20px; height:20px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size : 12px; text-align:left; font-weight:bold; color : #f1f1f1; background-color: #336699; -webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;  box-shadow: inset 0px -25px 25px #5B8CB7; -moz-box-shadow: inset 0px -25px 25px #5B8CB7; -webkit-box-shadow: inset 0px -25px 25px #5B8CB7; padding-left: 7px; padding-right:7px; padding-top:7px; padding-bottom:8px;  }
.user-ft {
	background:#709DD1; padding:4px 6px 6px; 
	text-decoration:none; 
	font-weight:bold;
	color:#fff;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;
    padding: 5px;

}
.user-ft:hover {
	background:#336699;  
	box-shadow: inset 0px -25px 25px #7198C4; 
	-moz-box-shadow: inset 0px -25px 25px #7198C4; 
	-webkit-box-shadow: inset 0px -25px 25px #7198C4; 
    padding: 5px;
	text-decoration:none; 
	font-weight:bold;
	color:#fff;

}
.user-ft2 {
	background: #709DD1; 
	padding:4px 6px 6px; 
	text-decoration:none;
	 font-weight:bold;
	color:#fff;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;
}

.user-ft2:hover {
	background: #380000; 
	box-shadow: inset 0px -25px 25px #C43131; 
	-moz-box-shadow: inset 0px -25px 25px #C43131; 
	-webkit-box-shadow: inset 0px -25px 25px #C43131; 
	padding:4px 6px 6px; 
	text-decoration:none;
	 font-weight:bold;
	color:#fff;
}

		</style>");


	 echo "<div class='pre-nav' >\n";
     echo"<a class='user-ft' href='".INFUSIONS."fusion_tube/videos.php'>".$locale['ft_134']."</a>&nbsp;&nbsp;";
     if (iMEMBER) {
	 echo"<a class='user-ft' href='".INFUSIONS."fusion_tube/my_videos.php'>".$locale['ft_132']."</a>&nbsp;&nbsp;";
	 echo"<a class='user-ft'  href='".INFUSIONS."fusion_tube/submit.php'>".$locale['ft_002']."</a>&nbsp;&nbsp;";
	 }
	  echo"<a class='user-ft' href='".INFUSIONS."fusion_tube/latest_updated_videos.php'>".$locale['ft_147']."</a>&nbsp;&nbsp;";
     echo"<a class='user-ft'  href='".INFUSIONS."fusion_tube/inc/search.php'>".$locale['ft_114']."</a>";

echo"</div>\n";


	}
}
?>