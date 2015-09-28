jQuery( function ( $ ) {
    'use strict';
    var WRISTBAND = {
        init: function() {
            this.render_price_chart();
        },
        render_price_chart: function() {

            var price_charts = WBC.settings.products[$( 'select[name="style"]').val()]['sizes'][$( 'select#width' ).val()]['price_chart'];
            $( '#price_chart table tr td:not(:first-child)' ).remove();

            for ( var _qty in price_charts ) {

                var output_qty_tpl = Mustache.render('<td>{{qty}}</td>', {qty: _qty});
                var output_price_tpl = Mustache.render('<td>{{price}}</td>', {price: price_charts[_qty]});

                $( '#price_chart table tr:first-child' ).append( output_qty_tpl );
                $( '#price_chart table tr:eq(1)' ).append( output_price_tpl );
            }


        }
    };



    $( document).ready(function() {

        $( document.body )
            // Get Product sizes on style changed
            .on( 'change', 'select[name="style"]', function() {
                var slctd_product = WBC.settings.products[this.value];

                if ( slctd_product != undefined ) {
                    $( 'select#width').empty().removeAttr( 'disabled' );
                    for( var size in slctd_product.sizes ) {
                        var $option = $('<option>').val( size).text( size )
                        $( 'select#width' ).append($option);
                    }
                    WRISTBAND.init();
                }

            })
            .on( 'change', 'select#width', function() {
                WRISTBAND.init();
            });


            $( 'select[name="style"]' ).trigger('change');
    });



});