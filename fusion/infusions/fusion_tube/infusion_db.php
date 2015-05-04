<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion_db.php
| Author: Nick Jones (Digitanium)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+-------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

if (!defined("DB_VIDEOS")) {
    define("DB_VIDEOS", DB_PREFIX."videos");
}

if (!defined("DB_VIDEO_SETTINGS")) {
    define("DB_VIDEO_SETTINGS", DB_PREFIX."video_settings");
}

if (!defined("DB_VIDEO_CATS")) {
    define("DB_VIDEO_CATS", DB_PREFIX."video_cats");
}


if (!defined("DB_VIDEO_SUBMISSIONS")) {
    define("DB_VIDEO_SUBMISSIONS", DB_PREFIX."video_submissions");
}

?>