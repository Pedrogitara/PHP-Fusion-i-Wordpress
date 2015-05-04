About

Created by NetriX @ PHPFusionMods.com
Version: 2.3.5
License: AGPL
PHP-FUsion: v7.02.xx

-------------------------------------------------

It has came to my attention that a file within the Facebook Connect infusion is being labeled as a phishing virus by ClamAV under the title of "{HEX}a2.brazilbank.phish.1.UNOFFICIAL". You can rest assured that this is a false positive located within the file "infusions/connect/index.php".

I will update the readme file along with a newer version of the infusion shortly. You have nothing to worry about at this time. Feel free to investigate the file for further assurance and ensure you ignore the warning.

Read more -> http://www.php-fusion.us/news.php?readmore=42

-------------------------------------------------

Installation

1. Upload all files to there respective directories.

2. Infuse Connect Infusion

3. Admin Panel >> Infusions >> Facebook Admin

3-2: Change settings according to your app.

4. (Optional) Install Facebook User Field

4-2: New in 2.3.0 is Facebook user fields, will show link and profile image to users Facebook. They have option to disable/enable in edit profile.

5. Navigate to Admin Panel -> User Admin -> User Fields

5-2: Under "Disabled User Fields" find "Show Facebook Information" and click 'Enable'.

-------------------------------------------------

Create Facebook Dev Account

1. Navigate to https://developers.facebook.com/setup/

--- Use your domain name!

2. Site Name: PHPFusionMods - Site URL: http://www.phpfusionmods.com/

3. Create APP.

4. Take note of information such as APP ID and Secret keys.

-------------------------------------------------

Troubleshooting

1. Around line 1413 (index.php), un-comment the following.

//echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
//die();

2. Copy and paste array information in a support forum.

3. Video Setup Example : http://phpfusionmods.com/infusions/video/video.php?id=2
-------------------------------------------------

Info and Acknowledgements

DJDanni - Iclandic translation.
HaYaLeT - Translation & detailed installation.
Septron - German translation.
MartinB - Bug Fix
kruizingaa - Additional Feature

Additional Support:

- http://phpfusionmods.com (Official Support - Report Bugs)
- http://www.php-fusion.co.uk/forum/viewthread.php?thread_id=29165 (English Support)
- http://www.phpfusionturkiye.com/forum/viewthread.php?thread_id=3824&rowstart=0 (Turkish Support)