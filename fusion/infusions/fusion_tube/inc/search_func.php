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

function searchft() {
	
global $settings;
if (file_exists(INFUSIONS."fusion_tube/locale/".$settings['locale'].".php")) {
include INFUSIONS."fusion_tube/locale/".$settings['locale'].".php";
} else {
include INFUSIONS."fusion_tube/locale/English.php";
}	
include INFUSIONS."fusion_tube/infusion_db.php";


echo"<div style='text-align: right; padding-right: 10px; margin-bottom: 10px;'>\n";
echo "<form action='".INFUSIONS."fusion_tube/inc/search.php' method='get' name='searchform' id='searchform'>\n";
echo "<input type='text' name='words' id='words'  maxlength='75' value='".$locale['ft_115']."' onfocus=\"if(this.value == '".$locale['ft_115']."') { this.value = ''; }\" onblur=\"if(this.value == '') { this.value='".$locale['ft_115']."'; }\" style='width: 150px;' class='textbox' />\n";
echo "<input type='submit' name='search' id='search' value='".$locale['ft_116']."' class='button' />\n";
echo "</form>\n";
echo" </div>\n";

	}
	
?>