<?php

/**
 * Entry point of the Ask Serialization library.
 *
 * @since 1.0
 * @codeCoverageIgnore
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( defined( 'ASK_SERIALIZATION_VERSION' ) ) {
	// Do not initialize more then once.
	return 1;
}

define( 'ASK_SERIALIZATION_VERSION', '1.0' );

if ( defined( 'MEDIAWIKI' ) ) {
	$GLOBALS['wgExtensionCredits']['datavalues'][] = array(
		'path' => __DIR__,
		'name' => 'Ask Serialization',
		'version' => ASK_SERIALIZATION_VERSION,
		'author' => array(
			'[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]'
		),
		'url' => 'https://github.com/wmde/AskSerialization',
		'description' => 'Serializers and deserializers for the Ask language',
	);
}