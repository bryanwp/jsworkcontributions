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
            })
            // Hide/Show message type fields
            .on( 'change', 'input[name="mesage_type"]', function() {
                if ( this.checked ) {

                    $( '[class*="hide-if-message_type-"]' ).css({ display: 'block' });

                    $( '.hide-if-message_type-' + this.value).css({ 'display': 'none' });
                }
            })

            .on( 'keyup', '.trigger-limit-char', function(e) {
                var limit       = $(this).data('limit'),
                    cur_len     = $(this).val().length,
                    cur_name    = $(this).attr('name'),
                    char_left   = limit - cur_len;
                if ( char_left < 0 ) char_left = 0;
                $( 'input[name="' + cur_name + '_chars_left"]' ).val( char_left );
            });

        // Trigger change on ready
        $( 'select[name="style"], input[name="mesage_type"]' ).trigger( 'change' );
        // Trigger keyup on ready
        $( '.trigger-limit-char').trigger( 'keyup' );




        // Change this to the location of your server-side upload handler:
        $( '.fileupload' ).fileupload( {
            url             : WBC.ajax_url,
            formData        : {
                action: 'blueimp-fileupload',
            },
            dataType        : 'json',
            maxNumberOfFiles: 1,
            done: function ( e, data ) {

                var $self = $( this );

                $.each( data.result.files, function ( index, file ) {

                    $self.closest( '.fusion-column-wrapper' )
                        .find( '.image-upload' )
                        .attr( 'src', file.thumbnailUrl )
                        .css( { display: 'inline-block' } );

                    $self.closest( '.fusion-column-wrapper' )
                        .find( '.hide-if-upload' )
                        .css( { display : 'none' } );

                    $self.closest( '.fileinput-button' ).find( 'span' ).text( 'Upload' );
                });
            },
            progressall: function ( e, data ) {
                var $self = $( this );
                $self.closest( '.fileinput-button' ).find( 'span' ).text( 'Uploading...' );
            }
        } )
            .prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });



});