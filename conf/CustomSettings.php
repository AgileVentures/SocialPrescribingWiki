<?php

error_reporting( -1 );
ini_set( 'display_errors', 1 );

@include('/app/LocalSettings.php');

$wgShowExceptionDetails = true;
$wgDebugToolbar = true;
$wgShowDebug = true;
$wgDevelopmentWarnings = true;

$wgSitename      = "Mediawiki official Social Prescribing and Self Care Wiki";
$wgMetaNamespace = "Mediawiki official Social Prescribing and Self Care Wiki";

$wgEnableUserEmail     = true;
$wgEnotifWatchlist     = true; # UPO
$wgEmailAuthentication = true;

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
$SENDGRID_API_KEY_PASSWORD = getenv('SENDGRID_API_KEY_PASSWORD');

$wgSMTP = [
    'host'     => 'ssl://smtp.sendgrid.net',
    'IDHost'   => 'sendgrid.net',
    'port'     => '465',
    'auth'     => true,
    'username' => 'apikey',
    'password' => $SENDGRID_API_KEY_PASSWORD,
];

$wgDefaultUserOptions['enotifwatchlistpages'] = true;

$wgFooterIcons['poweredby']['myicon'] = array(
    "src" => "https://dl.dropbox.com/s/1kekg96rkndea64/customized-by-agileventures-176wide.png?dl=1",
    "url" => "http://nonprofits.agileventures.org/",
    "alt" => "Customized by AgileVentures."
);


$wgAddGroups['sysop'][] = 'automoderated'; # Allow sysops to assign "automoderated" flag
$wgRemoveGroups['sysop'][] = 'automoderated'; # Allow sysops to remove "automoderated" flag

## Twitter extension
require_once "/var/www/html/extensions/mediawiki-shoogletweet/ShoogleTweet.php";

$SHOOGLE_TWEET_CONSUMER_KEY = getenv('SHOOGLE_TWEET_CONSUMER_KEY');
$SHOOGLE_TWEET_CONSUMER_KEY_SECRET = getenv('SHOOGLE_TWEET_CONSUMER_KEY_SECRET');

$wgShoogleTweetConsumerKey = "$SHOOGLE_TWEET_CONSUMER_KEY";
$wgShoogleTweetConsumerKeySecret = "$SHOOGLE_TWEET_CONSUMER_KEY_SECRET";

## Extra Language Settings

require_once "/var/www/html/extensions/ExtraLanguageLink/ExtraLanguageLink.php";

## Video embed

wfLoadExtension( 'EmbedVideo' );

## ConfirmEdit
$RECAPTCHA_SITE_KEY = getenv('RECAPTCHA_SITE_KEY');
$RECAPTCHA_SECRET_KEY = getenv('RECAPTCHA_SECRET_KEY');

wfLoadExtension( 'ConfirmEdit' );

wfLoadExtensions([ 'ConfirmEdit', 'ConfirmEdit/ReCaptchaNoCaptcha' ]);
$wgCaptchaClass = 'ReCaptchaNoCaptcha';
$wgReCaptchaSiteKey = "$RECAPTCHA_SITE_KEY";
$wgReCaptchaSecretKey = "$RECAPTCHA_SECRET_KEY";

$wgCaptchaTriggers['edit'] = false;
$wgCaptchaTriggers['create'] = false;
$wgCaptchaTriggers['addurl'] = false;
$wgCaptchaTriggers['createaccount'] = true;
$wgCaptchaTriggers['badlogin'] = true;

## Load WikiEditor

wfLoadExtension('WikiEditor');

# Enables use of WikiEditor by default but still allows users to disable it in preferences
$wgDefaultUserOptions['usebetatoolbar'] = 1;

# Enables link and table wizards by default but still allows users to disable them in preferences
$wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;

# Displays the Preview and Changes tabs
$wgDefaultUserOptions['wikieditor-preview'] = 1;

# Displays the Publish and Cancel buttons on the top right side
$wgDefaultUserOptions['wikieditor-publish'] = 1;

## ImageMap

wfLoadExtension( 'ImageMap' );

## Cite Extension

wfLoadExtension( 'Cite' );

## Wiki SEO

wfLoadExtension( 'WikiSEO' );

## Moderation Extension

wfLoadExtension( 'Moderation' );

$wgGroupPermissions['sysop']['moderation'] = true; # Allow sysops to use Special:Moderation
$wgGroupPermissions['sysop']['skip-moderation'] = true; # Allow sysops to skip moderation
$wgGroupPermissions['bot']['skip-moderation'] = true; # Allow bots to skip moderation
$wgGroupPermissions['checkuser']['moderation-checkuser'] = false; # Don't let checkusers see IPs on Special:Moderation
$wgModerationNotificationEnable = true;
$wgModerationNotificationNewOnly = false;
$wgModerationEmail = $wgEmergencyContact;

