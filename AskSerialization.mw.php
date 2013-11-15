<?php

/**
 * MediaWiki setup for the Ask Serialization extension.
 * The extension should be included via the main entry point, AskSerialization.php.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( defined( 'MW_PHPUNIT_TEST' ) ) {
	require_once __DIR__ . '/Tests/testLoader.php';
}

/**
 * Hook to add PHPUnit test cases.
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UnitTestsList
 *
 * @codeCoverageIgnore
 *
 * @since 1.0
 *
 * @param array $files
 *
 * @return boolean
 */
$GLOBALS['wgHooks']['UnitTestsList'][]	= function( array &$files ) {
	$directoryIterator = new RecursiveDirectoryIterator( __DIR__ . '/Tests/' );

	/**
	 * @var SplFileInfo $fileInfo
	 */
	foreach ( new RecursiveIteratorIterator( $directoryIterator ) as $fileInfo ) {
		if ( substr( $fileInfo->getFilename(), -8 ) === 'Test.php' ) {
			$files[] = $fileInfo->getPathname();
		}
	}

	return true;
};
