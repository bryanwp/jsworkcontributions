jQuery( function ( $ ) {
    'use strict';
    var WRISTBAND = {
        init: function() {
            this.render_price_chart();
            $.material.init();
        },
        on_load: function() {

            $( 'select:not(#font, .text-color-list)' ).select2();

            $( 'select#font' ).select2({
                templateResult: function( font ) {

                    if ( ! font.id || font.id == '-1' ) { return font.text; }


                    var $font = $(
                        '<span style="font-size:16px; font-family: \''+ font.text +'\'">' + font.text + '</span>'
                    );


                    return $font;
                }
            });


            $( 'select.text-color-list' ).select2({
                templateResult: function( color ) {

                    if ( ! color.id || color.id == '-1' ) { return color.text; }

                    var data_color = $( color.element ).data( 'color' );

                    var $text_color = $(
                        '<span><div class="color-wrap"><div style="background-color: '+ data_color +';"></div></div>' + color.text + '</span>'
                    );


                    return $text_color;
                }
            });


            // Trigger change on ready
            $( 'select[name="style"], input[name="mesage_type"]' ).trigger( 'change' );
            // Trigger keyup on ready
            $( '.trigger-limit-char').trigger( 'keyup' );






            // With transparent color
            //$( '.color-selector' ).colorpicker();
            // Change this to the location of your server-side upload handler:
            $( '.fileupload' ).fileupload( {
                url             : WBC.ajax_url,
                formData        : {
                    action: 'blueimp-fileupload',
                    clipart_type: $( this ),
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

                        $self.closest( '.fileinput-button' )
                            .find( 'span' )
                            .css( { 'padding-left' : '0' } )
                            .end()
                            .find( '.fa-spinner' )
                            .remove();


                    });
                },
                progressall: function ( e, data ) {
                    var $self = $( this );

                    $self.closest( '.fileinput-button' )
                        .find( 'span' )
                        .css( { 'padding-left' : '10px' } )
                        .prepend( '<i class="fa fa-spinner" /> ' );
                }
            } )
                .prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');

        },
        render_price_chart: function() {

            var price_charts = WBC.settings.products[$( 'select[name="style"]').val()]['sizes'][$( 'select#width' ).val()]['price_chart'];
            $( '#price_chart table tr td:not(:first-child)' ).remove();

            for ( var _qty in price_charts ) {

                var output_qty_tpl = Mustache.render( '<td>{{qty}}</td>', { qty: _qty } );
                var output_price_tpl = Mustache.render( '<td>{{price}}</td>', { price: price_charts[_qty] } );

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

                    //$( '#text-color-section').empty();
                    $('.text-color-list' ).empty();

                    if (  slctd_product.text_color ) {
                        $( '.text-color-list').closest( '.form-group' ).show();
                        $('.text-color-list' ).select2( 'data', null );

                        for ( var i in slctd_product.text_color ) {
                            var text_color_tpl = $( '<option />' )
                                .val( slctd_product.text_color[i].name )
                                .text( slctd_product.text_color[i].name )
                                .attr( 'data-color', slctd_product.text_color[i].color );

                            $('.text-color-list' ).append( text_color_tpl );
                        }


                    } else {
                        $( '.text-color-list').closest( '.form-group' ).hide();
                    }

                }
            })
            // Populate width dropdown
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
            // Message character limit
            .on( 'keyup', '.trigger-limit-char', function(e) {
                var limit       = $(this).data('limit'),
                    cur_len     = $(this).val().length,
                    cur_name    = $(this).attr('name'),
                    char_left   = limit - cur_len;
                if ( char_left < 0 ) char_left = 0;
                $( 'input[name="' + cur_name + '_chars_left"]' ).val( char_left );
            })
            // Wristband color style tab
            .on( 'shown.bs.tab', '#wristband-color-tab li a[data-toggle="tab"]', function() {
                $( this ).find( 'input[type=radio]' ).attr( 'checked', true );
            })
            // Text Color Selection
            .on( 'click', '#text-color-section .color-wrap', function() {
                $( '#text-color-section .color-wrap').removeClass( 'selected' );

                $( this).addClass( 'selected' );
            })
            // Wristband Color Selection
            .on( 'click', '#wristband-color-items .color-wrap', function() {
                $( '#wristband-color-items .color-wrap').removeClass( 'selected' );

                $( this).addClass( 'selected' );
            })
            .on( 'click', '#add-an-additional-color', function(e) {
                e.preventDefault();

                var $slctd_color     = $( '#wristband-color-tab .color-wrap.selected' ),
                    $slctd_txt_color = $( '#text-color-section .color-wrap.selected' ),
                    qty_adult       = $( '#qty_adult').val(),
                    qty_medium      = $( '#qty_medium').val(),
                    qty_youth       = $( '#qty_youth').val();




                var tpl = Mustache.render(
                    '<tr>' +
                    '<td>{{qty_adult}}</td><td>{{qty_medium}}</td><td>{{qty_youth}}</td><td>{{color}}</td><td></td>' +
                    '</tr>',
                    {
                        qty_adult   : qty_adult,
                        qty_medium  : qty_medium,
                        qty_youth   : qty_youth,
                    }
                );

                $( '#colors-seleted-info table > tbody' ).append( tpl );

                return false;
            });





        // Call function on load
        WRISTBAND.on_load();

    });



});