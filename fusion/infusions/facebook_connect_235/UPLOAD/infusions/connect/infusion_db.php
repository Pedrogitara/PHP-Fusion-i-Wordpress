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
| Do not remove the copyright footer without the developers
| consent. You may request the consent of removal by contacting
| me at the following email address: netrix@phpfusionmods.com
|
| Thank You,
| Brandon (NetriX)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION"))
{
    die("Access Denied");
}

if (!defined("DB_FACEBOOK"))
{
    define("DB_FACEBOOK", DB_PREFIX . "facebook");
}

if (file_exists(INFUSIONS . "connect/locale/" . $settings['locale'] . ".php"))
{
    include INFUSIONS . "connect/locale/English.php";
    include INFUSIONS . "connect/locale/" . $settings['locale'] . ".php";
} else
{
    include INFUSIONS . "connect/locale/English.php";
}

$check = @dbquery("SELECT user_oauth_uid FROM " . DB_USERS . " LIMIT 0,1");

if (!$check)
{
    dbquery("ALTER TABLE " . DB_USERS . " ADD user_oauth_uid VARCHAR( 50 ) NOT NULL DEFAULT '0'");
}

?>