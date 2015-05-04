<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Developer: Brandon Davis (NetriX)
| Website: PHPFusionMods.com
|  _   _      _        ___  __
| | \ | | ___| |_ _ __(_) \/ /
| |  \| |/ _ \ __| '__| |\  / 
| | |\  |  __/ |_| |  | |/  \ 
| |_| \_|\___|\__|_|  |_/_/\_\
|
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

// Display user field input
if ($profile_method == "input") {
	//$user_facebook = isset($_POST['user_facebook']) && $_POST['user_facebook'] == 1 ? 1 : 0;
    $user_facebook = $user_data['user_facebook'];
	if ($this->isError()) { $user_facebook = 0; }
	
	echo "<tr>\n";
	echo "<td class='tbl".$this->getErrorClass("user_facebook")."'><label for='user_facebook'>".$locale['user_facebook'].$required."</label></td>\n";
	echo "<td class='tbl".$this->getErrorClass("user_facebook")."'>";
	echo "<label><input type='radio' name='user_facebook' value='0'".($user_facebook == "0"?" checked='checked'":"")." />{$locale['no']}</label>\n";
    echo "<label><input type='radio' name='user_facebook' value='1'".($user_facebook == "1"?" checked='checked'":"")." />{$locale['yes']}</label>\n";
    echo "</td>\n</tr>\n";

	if ($required) { $this->setRequiredJavaScript("user_facebook", $locale['user_facebook_error']); }
	
// Display in profile
} elseif ($profile_method == "display") {
	if ($user_data['user_facebook']) {
		echo "<tr>\n";
		echo "<td class='tbl1'>{$locale['profile_show_facebook']}</td>\n";
		echo "<td align='right' class='tbl1'>";
        if (isset($userdata['user_oauth_uid']) && $userdata['user_facebook'] == 1) {
            echo "<a href='https://www.facebook.com/profile.php?id={$user_data['user_oauth_uid']}'><img src='https://graph.facebook.com/{$user_data['user_oauth_uid']}/picture?type=small' alt='{$locale['profile_show_facebook']}' /></a>";
        }
        echo "</td>\n";
		echo "</tr>\n";
	}
	
// Insert or update
} elseif ($profile_method == "validate_insert"  || $profile_method == "validate_update") {
	// Get input data
	if (isset($_POST['user_facebook']) && ($_POST['user_facebook'] != "" || $this->_isNotRequired("user_facebook"))) {
		// Set update or insert user data
		$this->_setDBValue("user_facebook", $_POST['user_facebook'] == 1 ? 1 : 0);
	} else {
		$this->_setError("user_facebook", $locale['user_facebook_error'], true);	
	}
}
?>