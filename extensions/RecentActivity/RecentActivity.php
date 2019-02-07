<?php
/**
 * RecentActivity extension - Adds parser functions for listing recently created and edited articles
 *
 * See http://www.mediawiki.org/wiki/Extension:RecentActivity for installation and usage details
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author [http://www.mediawiki.org/wiki/User:Nad User:Nad]
 * @copyright © 2007 [http://www.mediawiki.org/wiki/User:Nad User:Nad]
 * @licence GNU General Public Licence 2.0 or later
 */
if( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' );

define( 'RECENTACTIVITY_VERSION', '1.1.1, 2012-05-25' );

$wgRecentActivityMagic         = 'RecentActivity';
$wgRecentActivityExclusionsCat = 'Excluded from RecentActivity';
$wgExtensionFunctions[]        = 'efSetupRecentActivity';
$wgHooks['LanguageGetMagic'][] = 'efRecentActivityLanguageGetMagic';
 
$wgExtensionCredits['parserhook'][] = array(
	'name'        => 'RecentActivity',
	'author'      => '[http://www.mediawiki.org/wiki/User:Nad User:Nad]',
	'description' => 'Adds parser functions for listing recently created and edited articles',
	'url'         => 'http://www.mediawiki.org/wiki/Extension:RecentActivity',
	'version'     => RECENTACTIVITY_VERSION
);

class RecentActivity {

	function __construct() {
		global $wgParser, $wgRecentActivityMagic;
 		$wgParser->setFunctionHook( $wgRecentActivityMagic, array( $this, 'expandMagic' ), SFH_NO_HASH );
	}

	function expandMagic( &$parser ) {
		global $wgRecentActivityExclusionsCat;
		$dbr = wfGetDB( DB_SLAVE );
		$rev = $dbr->tableName( 'revision' );
		$cl  = $dbr->tableName( 'categorylinks' );

		// Populate $argv with both named and numeric parameters
		$argv = array();
		foreach( func_get_args() as $arg) if( !is_object( $arg ) ) {
			if( preg_match( '/^(.+?)\\s*=\\s*(.+)$/', $arg, $match ) ) $argv[$match[1]] = $match[2]; else $argv[] = $arg;
		}
		$type   = isset( $argv['type'] )   ? strtolower( $argv['type'] ) : '';
		$user   = isset( $argv['user'] )   ? $argv['user']   : false;
		$count  = isset( $argv['count'] )  ? $argv['count']  : 5;
		$format = isset( $argv['format'] ) ? $argv['format'] : '*';

		// Build an SQL condition for the exclusions category
		$conds = array( "rev_minor_edit = 0" );
		$cat = $dbr->addQuotes( Title::newFromText( $wgRecentActivityExclusionsCat, NS_CATEGORY )->getDBkey() );
		$res = $dbr->select( $cl, 'cl_from', "cl_to = $cat", __METHOD__, array( 'ORDER BY' => 'cl_sortkey' ) );
		while( $row = $dbr->fetchRow( $res ) ) $conds[] = "rev_page != $row[0]";

		// Build the list
		$items = array();
		switch( $type ) {

			case 'edits':
				if( $user ) $conds[] = 'rev_user_text = ' . $dbr->addQuotes( $user );
				$res = $dbr->select(
					$rev,
					'distinct rev_page',
					$conds,
					__METHOD__,
					array( 'ORDER BY' => 'rev_timestamp DESC', 'LIMIT' => $count )
				);
				while( $row = $dbr->fetchRow( $res ) ) {
					$title = Title::newFromId( $row['rev_page'] );
					if( is_object( $title ) ) {
						$page = $title->getPrefixedText();
						$anchor = $title->getText();
						$items[] = $format . "[[:$page|$anchor]]";
					}
				}
				$dbr->freeResult( $res );
			break;

			case 'new':
				$tbl = $dbr->tableName( 'revision' );
				if( $user ) $conds[] = 'rev_user_text = ' . $dbr->addQuotes( $user );
				$res = $dbr->select(
					$rev,
					'rev_page, MIN(rev_id) as minid',
					$conds,
					__METHOD__,
					array( 'GROUP BY' => 'rev_page', 'ORDER BY' => 'minid DESC', 'LIMIT' => $count )
				);
				while( $row = $dbr->fetchRow( $res ) ) {
					$title = Title::newFromId( $row['rev_page'] );
					if( is_object( $title ) ) {
						$page = $title->getPrefixedText();
						$anchor = $title->getText();
						$items[] = $format . "[[:$page|$anchor]]";
					}
				}
				$dbr->freeResult( $res );
			break;

			default: $items[] = 'Bad activity type specified!';
		}

		return join( "\n", $items );
	}
}

/**
 * Called from $wgExtensionFunctions array when initialising extensions
 */
function efSetupRecentActivity() {
	global $wgRecentActivity;
	$wgRecentActivity = new RecentActivity();
}

/**
 * Register magic words
 */
function efRecentActivityLanguageGetMagic(&$magicWords, $langCode = 0) {
	global $wgRecentActivityMagic;
	$magicWords[$wgRecentActivityMagic]   = array( 0, $wgRecentActivityMagic );
	return true;
}
