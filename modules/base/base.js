/*global window:false */
( function ( $, mw ) {
	'use strict';

	// note: class=media-link-preMW125-core-hack kept for compatibility prior to MW 1.25
	// you must edit the $IP/includes/Linker.php file, method makeMediaLinkFile()
	// and change this line:
	//     $class = 'internal';
	// to:
	//     $class = 'internal media-link-preMW125-core-hack'; // MW CORE HACK required until MW 1.25
	// When you upgrade to MW 1.25 this hack is no longer needed.
	$('.media-link, .media-link-preMW125-core-hack').each(function(i,e) {
		var $e = $(e);
		var href = $e.attr( 'href' );

		// if a ? not present, add one to the end of the href
		// (e.g. start query string)
		if ( href.indexOf( '?' ) === -1 ) {
			href += '?';
		}
		// else query string already exists, add to it
		else {
			href += '&';
		}

		// add random number to query string
		href += 'rand=' + Math.random();

		// modify href
		$e.attr( 'href', href );
	});

} )( jQuery, mediaWiki );