/**
 * Base Scripts
 *
 * @author   clivern
 * @since    1.0.0
 */

var bear_theme = bear_theme || {};


/*!
 * Bear Utils Module
 */
bear_theme.utils = (function (window, document, $) {
    'use strict';

    var base = {
        init : function() {
            //
        },
    };
    return {
        init: base.init,
    };
})(window, document, jQuery);


/*!
 * Bear Customizer Module
 */
bear_theme.customizer = (function (window, document, $) {
    'use strict';

    var base = {
        init : function() {
            // Site title and description.
            wp.customize( 'blogname', function( value ) {
                value.bind( function( to ) {
                    $( '.site-title a' ).text( to );
                } );
            });

            wp.customize( 'blogdescription', function( value ) {
                value.bind( function( to ) {
                    $( '.site-description' ).text( to );
                } );
            });

            // Header text color.
            wp.customize( 'header_textcolor', function( value ) {
                value.bind( function( to ) {
                    if ( 'blank' === to ) {
                        $( '.site-title a, .site-description' ).css( {
                            'clip': 'rect(1px, 1px, 1px, 1px)',
                            'position': 'absolute'
                        } );
                    } else {
                        $( '.site-title a, .site-description' ).css( {
                            'clip': 'auto',
                            'position': 'relative'
                        } );
                        $( '.site-title a, .site-description' ).css( {
                            'color': to
                        } );
                    }
                } );
            });
        },
    };
    return {
        init: base.init,
    };
})(window, document, jQuery);
