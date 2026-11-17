( function () {
	'use strict';
	document.querySelectorAll( '.wpfh-pl-card input' ).forEach( function ( el ) {
		el.addEventListener( 'focus', function () { el.parentNode.style.outline = '2px solid #2271b1'; } );
		el.addEventListener( 'blur', function () { el.parentNode.style.outline = ''; } );
	} );
}() );
