<?php
@include('/app/LocalSettings.php');

$wgLogo               = "";
$wgEmergencyContact = "hlpwikiadmin@agileventures.org";
$wgPasswordSender   = "hlpwikiadmin@agileventures.org";

if (getenv('MEDIAWIKI_DISABLE_ANONYMOUS_EDIT')) {
    $wgGroupPermissions['*']['edit'] = false;
}

$wgUsersNotifiedOnAllChanges = array('User', 'Tansaku');
$wgFooterIcons['poweredby']['myicon'] = array(
    "src" => "https://dl.dropbox.com/s/1kekg96rkndea64/customized-by-agileventures-176wide.png?dl=1",
    "url" => "http://nonprofits.agileventures.org/",
    "alt" => "Customized by AgileVentures."
);

// require_once "extensions/Moderation/Moderation.php";

$wgGroupPermissions['sysop']['moderation'] = true; # Allow sysops to use Special:Moderation
$wgGroupPermissions['sysop']['skip-moderation'] = true; # Allow sysops to skip moderation
$wgGroupPermissions['bot']['skip-moderation'] = true; # Allow bots to skip moderation
$wgGroupPermissions['checkuser']['moderation-checkuser'] = false; # Don't let checkusers see IPs on Special:Moderation

$wgAddGroups['sysop'][] = 'automoderated'; # Allow sysops to assign "automoderated" flag
$wgRemoveGroups['sysop'][] = 'automoderated'; # Allow sysops to remove "automoderated" flag

$wgModerationNotificationEnable = true;
$wgModerationNotificationNewOnly = false;
$wgModerationEmail = $wgEmergencyContact;
