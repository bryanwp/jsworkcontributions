jQuery( function ( $ ) {
    'use strict';


    var WRISTBAND = {
        init: function() {
            this.render_color_style();
        },

        render_color_style: function() {
            $( '#color-style-selection').empty();


            if ( WBC.settings.color_style != undefined && WBC.settings.color_style.length != 0 ) {
                var color_style_html = '';
                for (var _style in WBC.settings.color_style ) {
                    var data = {
                        color_style: _style
                    };

                    color_style_html += Mustache.render( $( '#wristband_color_style_template').html(), data );
                }
            }

            $( '#color-style-selection' ).html(color_style_html);
        }

    };




    WRISTBAND.init();




    $( document.body )
        .on( 'change', '#sizes input[name^="size"]', function() {

            if ($(this).is(':checked')) {
                var product_id  = $( '#styles input[name=style]' ).val(),
                    size        = this.value,
                    size_settings     = WBC.settings.products[product_id]['sizes'][size];

                $( '#price_chart .panel-body' )
                    .find( 'tr > td:not(:first-child)' )
                    .remove();


                if ( size_settings != undefined && size_settings.price_chart.length != 0 ) {

                    for ( var _qty in size_settings.price_chart ) {
                        $( '#price_chart .panel-body' )
                            .find( 'tr:first-child' )
                            .append( Mustache.render( '<td>{{qty}}</td>', { qty: _qty } ) )
                            .end()

                            .find( 'tr:eq(1)' )
                            .append( Mustache.render( '<td>{{price}}</td>', { price: size_settings.price_chart[_qty] } ) );
                    }


                }

            }
        })

        .on( 'change', '#styles input[name="style"]', function(e, element, error_type) {
            if ( this.checked ) {
                var product_id = this.value;

                if ( WBC.settings.products[product_id]['sizes'] != undefined ) {
                    var product_settings = WBC.settings.products[product_id];;

                    $( '#sizes-container' ).empty();
                    if ( product_settings['sizes'].length != 0 ) {

                        for ( var i in product_settings['sizes'] ) {

                            $( '#sizes-container' ).append(
                                Mustache.render( $( '#wristband_size_template' ).html(), {
                                    size    : product_settings['sizes'][i]['size'],
                                    image   : product_settings['sizes'][i]['image']['url'],
                                    checked : (product_settings['sizes'][i]['size'] == product_settings['default_size']),
                                } )
                            );

                            if ( product_settings['sizes'][i]['size'] == product_settings['default_size'] ) {


                                $( 'input[name="size"][value="'+ product_settings['default_size'] +'"]' )
                                    .prop( 'checked', true)
                                    .trigger( 'change' );

                            }
                        }

                    }

                }
            }
        });

    $( '#styles input[name=style]:eq(0)' ).trigger( 'click' );



});