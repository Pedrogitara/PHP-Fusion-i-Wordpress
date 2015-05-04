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
if (file_exists(INFUSIONS . "connect/locale/" . $settings['locale'] . ".php"))
{
    include INFUSIONS . "connect/locale/English.php";
    include INFUSIONS . "connect/locale/" . $settings['locale'] . ".php";
} else
{
    include INFUSIONS . "connect/locale/English.php";
}
?>