<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: copyright_func.php
| Author: Fangee Productions
| Developers: Fangree_Craig
| Sites: http://www.fangree.com
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

// Please do not remove copyright info

function showFTcopyright() {
	
global $settings;
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
include INFUSIONS."fusion_tube/locale/English.php";
}	
include INFUSIONS."fusion_tube/infusion_db.php";

$title = $locale['ft_001'];
   
$data_version = dbarray(dbquery("SELECT inf_version FROM ".DB_INFUSIONS." WHERE inf_folder = 'fusion_tube'"));	
$version = $data_version['inf_version'];
 
          
opentable($title." v".$version);
echo"<div class='small' style='text-align:center;'>".$title." v".$version."  ".$locale['copyrightFT1']." ".date("Y")."<br />
".$locale['copyrightFT2']."</div>\n";
closetable();

	}
	
//Copyright Function By Fangree Productions
// Please DO NOT remove or EDIT copyright info



?>