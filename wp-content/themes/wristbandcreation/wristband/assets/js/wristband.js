jQuery( function ( $ ) {
    'use strict';

    var HELPER = {
        int_val: function( n ) {
            n = parseInt( n );

            return isNaN( n ) ? 0 : n;
        }
    };


    var CALCULATOR = {


        get_price: function( qty ) {


            var price_charts = WRISTBAND.price_charts;

            var keys = Object.keys( price_charts );

            for (var i = 0; i < keys.length; i++) {

                console.log( keys.length - 1 );

                var z = i < keys.length - 1 ? i + 1 : i;
                if ( HELPER.int_val( keys[i] ) >= qty && qty <= HELPER.int_val( keys[z] ) ) {
                    return price_charts[keys[i]];
                } else if ( i >= keys.length - 1 &&  HELPER.int_val( keys[i] ) <= qty) {

                    return price_charts[keys[i]];
                }
            }


            return 0;


        },
        get_total_price: function() {

            return this.get_price( HELPER.int_val( WRISTBAND.get_total_quantity() ) );

        }
    };

    var WRISTBAND = {
        data: {
          colors: []
        },
        price_charts: [],
        is_color_exist: function( name ) {

            if ( WRISTBAND.data.colors[name] != undefined ) return true;

            return false;
        },
        add_color: function( key, value ) {
            WRISTBAND.data.colors[key] = value;
            WRISTBAND.observer();
        },
        remove_color: function( name ) {

            if ( WRISTBAND.data.colors[name] == undefined ) return;

            delete WRISTBAND.data.colors[name];

            WRISTBAND.observer();

        },
        get_total_quantity: function( ) {
            var total_qty = 0;
            for ( var color in WRISTBAND.data.colors ) {

                for ( var size in WRISTBAND.data.colors[color].sizes ) {
                    total_qty += WRISTBAND.data.colors[color].sizes[size].qty;
                }

            }

            return total_qty;

        },

        init: function() {
            this.render_price_chart();
            $.material.init();
        },

        observer: function() {

            $( '#qty_handler').text( WRISTBAND.get_total_quantity() );


            $( '#price_handler').text( CALCULATOR.get_total_price() );





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

            var price_charts = WRISTBAND.price_charts = WBC.settings.products[$( 'select[name="style"]' ).val()]['sizes'][$( 'select#width' ).val()]['price_chart'];
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


                    $( 'select#width option:first-child' ).trigger( 'change' );

                    WRISTBAND.init();

                    $( '.text-color-list' ).empty();

                    if (  slctd_product.text_color ) {
                        $( '.text-color-list' ).closest( '.form-group' ).show();
                        $( '.text-color-list' ).select2( 'data', null );

                        for ( var i in slctd_product.text_color ) {
                            var text_color_tpl = $( '<option />' )
                                .val( slctd_product.text_color[i].name )
                                .text( slctd_product.text_color[i].name )
                                .attr( 'data-color', slctd_product.text_color[i].color);

                            $( '.text-color-list' ).append( text_color_tpl );
                        }

                        $( '.text-color-list option:first-child' ).attr( 'selected', 'selected').trigger( 'change' );

                    } else {
                        $( '.text-color-list' ).closest( '.form-group' ).hide();
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

                if ( $( this).hasClass( 'added' )  ) return;

                $( '#wristband-color-items .color-wrap').removeClass( 'selected' );

                $( this ).addClass( 'selected' );
            })

            .on( 'click', '#add_color_to_selections', function( e ) {
                e.preventDefault();

                var $wc = $( '#wristband-color-tab .color-wrap.selected > div' );


                var bg_style_tpl = '<div class="{{hide}}"><div class="color-wrap"><div style="background-color:{{bg_color}};background: -webkit-linear-gradient(90deg,{{bg_color}});background: -o-linear-gradient(90deg,{{bg_color}});background: -moz-linear-gradient(90deg,{{bg_color}});background: linear-gradient(90deg,{{bg_color}});"></div></div>{{qty}}</div>';

                var $aq    = $( '#qty_adult'),
                    $mq    = $( '#qty_medium'),
                    $yq    = $( '#qty_youth'),
                    $atc   = $( 'select[name="adult_text_color"]'),
                    $mtc   = $( 'select[name="medium_text_color"]'),
                    $ytc   = $( 'select[name="youth_text_color"]');

                var _adult_text_color_box   = Mustache.render( bg_style_tpl, {hide: ( HELPER.int_val( $aq.val() ) <= 0 ? 'hide' : '' ), bg_color: $('option:selected', $atc).data( 'color' ), qty: HELPER.int_val( $aq.val() ) }),
                    _medium_text_color_box  = Mustache.render( bg_style_tpl, {hide: ( HELPER.int_val( $mq.val() ) <= 0 ? 'hide' : '' ), bg_color: $('option:selected', $mtc).data( 'color' ), qty: HELPER.int_val( $mq.val() ) }),
                    _youth_text_color_box   = Mustache.render( bg_style_tpl, {hide: ( HELPER.int_val( $yq.val() ) <= 0 ? 'hide' : '' ), bg_color: $('option:selected', $ytc).data( 'color' ), qty: HELPER.int_val( $yq.val() ) }),
                    _wristband_color_box    = Mustache.render( bg_style_tpl, {hide: '', bg_color: $wc.data( 'color' ), qty: '' });



                if ( $wc.length == 0 || ( HELPER.int_val( $aq.val() ) <= 0 && HELPER.int_val( $mq.val() ) <= 0 &&
                    HELPER.int_val( $yq.val() ) <= 0 ) ) return;



                if ( WRISTBAND.is_color_exist( $wc.data( 'name' ) ) ) {
                    alert( 'Color already selected' );
                    return;
                }

                var row_tpl = Mustache.render(
                    '<tr data-name="{{name}}">'
                        + '<td>{{{adult_text_color_box}}}</td>'
                        + '<td>{{{medium_text_color_box}}}</td>'
                        + '<td>{{{youth_text_color_box}}}</td>'
                        + '<td>{{{wristband_color_box}}}</td>'
                        + '<td><a href="#" class="edit-selection"><i class="fa fa-pencil"></i></a><a href="#" class="delete-selection"><i class="fa fa-trash"></i></a></td>'
                    + '</tr>',
                    {
                        name                    : $wc.data( 'name' ),
                        adult_text_color_box    : _adult_text_color_box,
                        medium_text_color_box   : _medium_text_color_box,
                        youth_text_color_box    : _youth_text_color_box,
                        wristband_color_box     : _wristband_color_box,
                    }
                );


                WRISTBAND.add_color($wc.data( 'name' ), {
                    wristband_color: {
                        name    : $wc.data( 'name' ),
                        color   : $wc.data( 'color' ),
                    },
                    sizes: {
                        adult: {
                            qty     : HELPER.int_val( $aq.val() ),
                            name    : $( 'option:selected', $atc ).val(),
                            color   : $( 'option:selected', $atc ).data( 'color' ),

                        },
                        medium: {
                            qty     : HELPER.int_val( $mq.val() ),
                            name    : $( 'option:selected', $mtc ).val(),
                            color   : $( 'option:selected', $mtc ).data( 'color' ),

                        },
                        youth: {
                            qty     : HELPER.int_val( $yq.val() ),
                            name    : $( 'option:selected', $ytc ).val(),
                            color   : $( 'option:selected', $ytc ).data( 'color' ),

                        }
                    }
                });




                $( '#selected_color_table > tbody' ).append( row_tpl );

                $wc.closest( '.color-wrap' ).addClass( 'added' );

                $( '#wristband-color-items .color-wrap').removeClass( 'selected' );
                $( '#qty_adult, #qty_medium, #qty_youth' ).val( '' );

                return false;
            })

            .on( 'click', '.delete-selection', function( e ) {
                e.preventDefault();
                var $row = $( this ).closest( 'tr' );
                // Remove color from selections
                WRISTBAND.remove_color( $row.data( 'name' ) );

                // Remove "added" class in wristband colors
                $( '#wristband-color-tab  div[data-name^="'+ $row.data( 'name' )  +'"]' ).closest( '.color-wrap' ).removeClass( 'added' );

                $row.remove();

                return false;

            });





        // Call function on load
        WRISTBAND.on_load();

    });



});