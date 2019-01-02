<?php

error_reporting( -1 );
ini_set( 'display_errors', 1 );

@include('/app/LocalSettings.php');

$wgArticlePath = "/$1";

// $wgShowExceptionDetails = true;
// $wgDebugToolbar = true;
// $wgShowDebug = true;
// $wgDevelopmentWarnings = true;

$wgUseSiteCss = true;
$wgAllowSiteCSSOnRestrictedPages = true;

$wgSitename      = "Social Prescribing and Self Care Wiki";
$wgMetaNamespace = "Social Prescribing and Self Care Wiki";

$wgEnableUserEmail     = true;
$wgEnotifWatchlist     = true; # UPO
$wgEmailAuthentication = true;

$wgUploadDirectory  = "/storage/images"; 
$wgLogo             = "";
$wgEmergencyContact = "hlpwikiadmin@agileventures.org";
$wgPasswordSender   = "hlpwikiadmin@agileventures.org";
$wgEnableUploads    = true;
$wgFileExtensions[] = 'pdf';

$wgUsersNotifiedOnAllChanges = array('User', 'Tansaku');
$SENDGRID_API_KEY_PASSWORD = getenv('SENDGRID_API_KEY_PASSWORD');

$wgSMTP = [
    'host'     => 'ssl://smtp.sendgrid.net',
    'IDHost'   => 'sendgrid.net',
    'port'     => '465',
    'auth'     => true,
    'username' => 'apikey',
    'password' => "$SENDGRID_API_KEY_PASSWORD",
];

$wgDefaultUserOptions['enotifwatchlistpages'] = true;

$wgFooterIcons['poweredby']['myicon'] = array(
    "src" => "https://dl.dropbox.com/s/1kekg96rkndea64/customized-by-agileventures-176wide.png?dl=1",
    "url" => "http://nonprofits.agileventures.org/",
    "alt" => "Customized by AgileVentures."
);

# InstantCommons allows wiki to use images from http://commons.wikimedia.org
$wgUseInstantCommons  = true;

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

## Visual Editor

wfLoadExtension( 'VisualEditor' );

// Enable by default for everybody
$wgDefaultUserOptions['visualeditor-enable'] = 1;

// Optional: Set VisualEditor as the default for anonymous users
// otherwise they will have to switch to VE
// $wgDefaultUserOptions['visualeditor-editor'] = "visualeditor";

// Don't allow users to disable it
$wgHiddenPrefs[] = 'visualeditor-enable';

// OPTIONAL: Enable VisualEditor's experimental code features
#$wgDefaultUserOptions['visualeditor-enable-experimental'] = 1;

## Parsoid service for Visual Editor
$MEDIAWIKI_SITE_SERVER = getenv('MEDIAWIKI_SITE_SERVER');
$wgVirtualRestConfig['modules']['parsoid'] = array(
        // URL to the Parsoid instance
        // Use port 8142 if you use the Debian package
        'url' => $MEDIAWIKI_SITE_SERVER . ':8142',
        // Parsoid "domain", see below (optional)
        // 'domain' => 'localhost',
        //Parsoid "prefix", see below (optional)
);

## ImageMap

wfLoadExtension( 'ImageMap' );
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

## Cite Extension

wfLoadExtension( 'Cite' );

## WikiSEO

wfLoadExtension( 'WikiSEO' );

## CookieWarning extension

wfLoadExtension( 'CookieWarning' );
$wgCookieWarningEnabled = true; 
$wgCookieWarningMoreUrl = "/Cookies_Policy";

## PdfHandler extension

wfLoadExtension( 'PdfHandler' );
$wgPdfProcessor = '/usr/bin/gs'; 
$wgPdfPostProcessor = $wgImageMagickConvertCommand; // if defined via ImageMagick
$wgPdfInfo = '/usr/bin/pdfinfo'; 
$wgPdftoText = '/usr/bin/pdftotext';

## MsUpload Extension 

wfLoadExtension( 'MsUpload' );
$wgDefaultUserOptions['usebetatoolbar'] = 1;


## FeaturedFeeds Extension
wfLoadExtension( 'FeaturedFeeds' );

## Moderation Extension

wfLoadExtension( 'Moderation' );

$wgGroupPermissions['*']['edit'] = false;
$wgGroupPermissions['*']['createpage'] = false;
$wgGroupPermissions['moderator']['editinterface'] = true;
$wgGroupPermissions['sysop']['moderation'] = true; # Allow sysops to use Special:Moderation
$wgGroupPermissions['sysop']['skip-moderation'] = true; # Allow sysops to skip moderation
$wgGroupPermissions['bot']['skip-moderation'] = true; # Allow bots to skip moderation
$wgGroupPermissions['checkuser']['moderation-checkuser'] = false; # Don't let checkusers see IPs on Special:Moderation
$wgModerationNotificationEnable = true;
$wgModerationNotificationNewOnly = false;
$wgModerationEmail = $wgEmergencyContact;

## Semantic Extension
enableSemantics( 'healthylondon.org' );

