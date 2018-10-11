<?php

error_reporting( -1 );
ini_set( 'display_errors', 1 );

@include('/app/LocalSettings.php');

$wgShowExceptionDetails = true;
$wgDebugToolbar = true;
$wgShowDebug = true;
$wgDevelopmentWarnings = true;

$wgLogo               = "";
$wgEmergencyContact = "hlpwikiadmin@agileventures.org";
$wgPasswordSender   = "hlpwikiadmin@agileventures.org";

if (getenv('MEDIAWIKI_DISABLE_ANONYMOUS_EDIT')) {
    $wgGroupPermissions['*']['edit'] = false;
}
$wgGroupPermissions['moderator']['editinterface'] = true;
$wgGroupPermissions['user']['editinterface'] = true;
$wgDisableUploads = false;
$wgUsersNotifiedOnAllChanges = array('User', 'Tansaku');
$wgFooterIcons['poweredby']['myicon'] = array(
    "src" => "https://dl.dropbox.com/s/1kekg96rkndea64/customized-by-agileventures-176wide.png?dl=1",
    "url" => "http://nonprofits.agileventures.org/",
    "alt" => "Customized by AgileVentures."
);

$wgGroupPermissions['sysop']['moderation'] = true; # Allow sysops to use Special:Moderation
$wgGroupPermissions['sysop']['skip-moderation'] = true; # Allow sysops to skip moderation
$wgGroupPermissions['bot']['skip-moderation'] = true; # Allow bots to skip moderation
$wgGroupPermissions['checkuser']['moderation-checkuser'] = false; # Don't let checkusers see IPs on Special:Moderation

$wgAddGroups['sysop'][] = 'automoderated'; # Allow sysops to assign "automoderated" flag
$wgRemoveGroups['sysop'][] = 'automoderated'; # Allow sysops to remove "automoderated" flag


require_once "/var/www/html/extensions/mediawiki-shoogletweet/ShoogleTweet.php";

$SHOOGLE_TWEET_CONSUMER_KEY = getenv('SHOOGLE_TWEET_CONSUMER_KEY');
$SHOOGLE_TWEET_CONSUMER_KEY_SECRET = getenv('SHOOGLE_TWEET_CONSUMER_KEY_SECRET');

$wgShoogleTweetConsumerKey = "$SHOOGLE_TWEET_CONSUMER_KEY";
$wgShoogleTweetConsumerKeySecret = "$SHOOGLE_TWEET_CONSUMER_KEY_SECRET";

wfLoadExtension( 'EmbedVideo' );
wfLoadExtension( 'Moderation' );

$wgModerationNotificationEnable = true;
$wgModerationNotificationNewOnly = false;
$wgModerationEmail = $wgEmergencyContact;

