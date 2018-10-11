<?php
/**
 * ExtraLanguageLink extension, allowing arbitrary links to be added to the
 * "in other languages" sidebar section on a per-page basis
 *
 * Written by This, that and the other, 2014
 *
 * This code is released into the public domain. Anyone is allowed to use this
 * code for any purpose. (Needless to say, attribution is appreciated, although
 * not required.)
 *
 * For more information and documentation, see
 * https://www.mediawiki.org/wiki/Extension:ExtraLanguageLink
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'ExtraLanguageLink',
	'version'        => '1.0',
	'author'         => array( 'This, that and the other' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:ExtraLanguageLink',
	'descriptionmsg' => 'extralanguagelink-desc',
);

$dir = __DIR__ . '/';
$wgAutoloadClasses['ExtraLanguageLink'] = $dir . 'ExtraLanguageLink.class.php';
$wgMessagesDirs['ExtraLanguageLink'] = $dir . 'i18n';
$wgExtensionMessagesFiles['ExtraLanguageLinkMagic'] = $dir . 'ExtraLanguageLink.magic.php';

$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'ExtraLanguageLink::onSkinTemplateOutputPageBeforeExec';
$wgHooks['ParserFirstCallInit'][] = 'ExtraLanguageLink::onParserFirstCallInit';
$wgHooks['OutputPageParserOutput'][] = 'ExtraLanguageLink::onOutputPageParserOutput';

// Global configuration variables: (see the MediaWiki page for this extension
// for additional documentation and example configurations)

/**
 * Set this to an array of allowed interwiki prefixes to restrict the use of
 * this extension to certain interwiki prefixes. Set to false to allow all
 * prefixes.
 *
 * NOTE: Prefixes must be in lowercase only!
 *
 * For example: array( 'wikipedia', 'wiktionary', 'c2' )
 */
$wgExtraLanguageLinkAllowedPrefixes = false;

/**
 * Specify a list of page titles on the wiki where the {{extralanguagelink}}
 * parserfunction is allowed to be used. Set to false to allow use on all pages.
 *
 * NOTE: Use spaces, not underscores, in this array.
 *
 * For example: array( 'Main Page', 'Help:Contents' )
 */
$wgExtraLanguageLinkAllowedTitles = false;
