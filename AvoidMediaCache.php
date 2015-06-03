<?php
/**
 * MediaWiki Extension: WatchAnalytics
 * http://www.mediawiki.org/wiki/Extension:WatchAnalytics
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * This program is distributed WITHOUT ANY WARRANTY.
 */

/**
 *
 * @file
 * @ingroup Extensions
 * @author James Montalvo
 * @licence MIT License
 */

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/AvoidMediaCache/AvoidMediaCache.php" );
EOT;
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$GLOBALS['wgExtensionCredits']['other'][] = array(
	'path' => __FILE__,
	'name' => 'AvoidMediaCache',
	'url' => 'https://www.mediawiki.org/wiki/Extension:AvoidMediaCache',
	'author' => array( '[https://www.mediawiki.org/wiki/User:Jamesmontalvo3 James Montalvo]' ),
	'descriptionmsg' => 'avoidmediacache-desc',
);

$GLOBALS['wgMessagesDirs']['AvoidMediaCache'] = __DIR__ . '/i18n';



// Hook which works in MW 1.25+
// adds class to media links. Links with this class are then modified
// via javascript (doing this at the PHP level is impacted by page-
// caching, and a new random number is required for each page load
// to guarantee the file is re-downloaded each time)
$GLOBALS['wgHooks']['LinkerMakeMediaLinkFile'][] = function ( $title, $file, &$html, &$attribs, &$ret ) {
	
	if ( isset( $attribs['class'] ) ) {
		$attribs['class'] .= ' media-link';
	}
	else {
		$attribs['class'] = 'media-link';		
	}

};


$GLOBALS['wgHooks']['OutputPageParserOutput'][] = function ( OutputPage &$out, ParserOutput $parseroutput ) {
	$out->addModules( 'ext.avoidmediacache.base' );
};


$avoidMediaCacheResourceTemplate = array(
	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'AvoidMediaCache/modules',
);

$GLOBALS['wgResourceModules'] += array(

	'ext.avoidmediacache.base' => $avoidMediaCacheResourceTemplate + array(
		
		'scripts' => array(
			'base/base.js',
		),

	),


);
