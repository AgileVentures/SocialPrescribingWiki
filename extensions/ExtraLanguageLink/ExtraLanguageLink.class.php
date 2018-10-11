<?php
class ExtraLanguageLink {
	/**
	 * Transfer the extra language link data from the OutputPage object to the
	 * QuickTemplate (skin-specific output) object.
	 * @param $sk SkinTemplate
	 * @param $tpl QuickTemplate
	 */
	public static function onSkinTemplateOutputPageBeforeExec( SkinTemplate &$sk, QuickTemplate &$tpl ) {
		$data = $sk->getOutput()->getProperty( 'extralanguagelinks' );
		if ( $data ) {
			$language_urls = $tpl->get( 'language_urls' );
			if ( $language_urls === false ) {
				$language_urls = $data;
			} else {
				$language_urls = array_merge( $language_urls, $data );
			}
			$tpl->set( 'language_urls', $language_urls );
		}
	}

	/**
	 * Register the parser function.
	 * @param $parser Parser
	 * @return bool
	 */
	public static function onParserFirstCallInit( Parser &$parser ) {
		$parser->setFunctionHook( 'MAG_EXTRALANGUAGELINK', 'ExtraLanguageLink::handleParserFunction', Parser::SFH_NO_HASH );
		return true;
	}

	/**
	 * Transfer the extra language link data from the ParserOutput object to the
	 * OutputPage object.
	 * @param $out OutputPage
	 * @param $pout ParserOutput
	 * @return bool
	 */
	public static function onOutputPageParserOutput( OutputPage &$out, ParserOutput $pout ) {
		$prop = $pout->getProperty( 'extralanguagelinks' );
		if ( is_string( $prop ) ) {
			$out->setProperty( 'extralanguagelinks', unserialize( $prop ) );
		}
		return true;
	}

	/**
	 * Implements the {{extralanguagelink}} parser function.
	 * @param $parser Parser
	 * @param $link string Link target
	 * @param $text string Text of the link
	 * @return string
	*/
	public static function handleParserFunction( Parser &$parser, $link, $text /* ... */ ) {
		global $wgExtraLanguageLinkAllowedPrefixes, $wgExtraLanguageLinkAllowedTitles;

		// $link is a required parameter
		if ( empty( $link ) ) {
			return '';
		}

		// is the current page allowed to use this parser function?
		$title = $parser->getTitle();
		if (
			is_array( $wgExtraLanguageLinkAllowedTitles ) &&
			!in_array( $title->getPrefixedText(), $wgExtraLanguageLinkAllowedTitles )
		) {
			return '';
		}

		// $link is a crappy default value for the display text, but it will teach
		// users to provide a proper display text value!
		$thisLink = array(
			'text' => ( empty( $text ) ? $link : $text ),
		);

		// handle additional named parameters
		$extraArgs = array_slice( func_get_args(), 3 );
		// for grepping i18n keys: extralanguagelink-param-class
		// extralanguagelink-param-hreflang extralanguagelink-param-lang
		// extralanguagelink-param-style extralanguagelink-param-title
		$allowedArgs = array( 'class', 'hreflang', 'lang', 'style', 'title' );
		foreach ( $extraArgs as $arg ) {
			// we need an equals sign!
			if ( strpos( $arg, '=' ) === false ) {
				continue;
			}

			$argName = trim( strtok( $arg, '=' ) );
			foreach ( $allowedArgs as $allowedArg ) {
				if (
					$argName == $allowedArg ||
					$argName == wfMessage( "extralanguagelink-param-$allowedArg" )->text()
				) {
					$thisLink[$allowedArg] = trim( strtok( '' ) );
					break;
				}
			}
		}

		// need to sanitize CSS
		if ( isset( $thisLink['style'] ) ) {
			$thisLink['style'] = Sanitizer::checkCss( $thisLink['style'] );
		}

		// generate an appropriate href
		if ( $title = Title::newFromText( $link ) ) {
			$iw = $title->getInterwiki();
			if (
				$wgExtraLanguageLinkAllowedPrefixes === false ||
				in_array( mb_strtolower( $iw ), $wgExtraLanguageLinkAllowedPrefixes )
			) {
				$thisLink['href'] = $title->getLocalURL();
			} else {
				// a bad interwiki, let's bail out
				return self::errorString( 'extralanguagelink-badinterwiki', $iw );
			}
		} else {
			return self::errorString( 'extralanguagelink-badtitle', $link );
		}

		// add our extra link to the page_props table
		$output = $parser->getOutput();
		$property = $output->getProperty( 'extralanguagelinks' );
		$data = is_string( $property ) ? unserialize( $property ) : array();
		$data[] = $thisLink;
		if ( count( $data ) > 0 ) {
			$output->setProperty( 'extralanguagelinks', serialize( $data ) );
		}

		return '';
	}

	/**
	 * Generates a nice error message.
	 * @param $msg string Message name
	 * @param $param string The $1 parameter for the message
	 * @return string
	*/
	private static function errorString( $msg, $param ) {
		$result = '<div class="error">{{';
		$result .= MagicWord::get( 'MAG_EXTRALANGUAGELINK' )->getSynonym( 0 );
		$result .= '}}: ' . wfMessage( 'error' )->text() . ': ';
		$result .= wfMessage( $msg, $param )->text() . '</div>';
		return $result;
	}
}
