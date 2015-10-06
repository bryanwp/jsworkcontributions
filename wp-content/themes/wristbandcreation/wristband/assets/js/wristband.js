jQuery( function ( $ ) {
    'use strict';

    var HELPER = {
        int_val: function( n ) {
            n = parseInt( n );

            return isNaN( n ) ? 0 : n;
        },
        float_val: function( n ) {
            n = parseFloat( n );


            return isNaN( n ) ? 0 : n;
        },
        number_format: function( n, f ) {

            f = f == undefined ? 2 : f;



            return  n.toFixed( f ).replace(/./g, function(c, i, a) {
                return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
            });
        }
    };


    var WRISTBAND = {
        data: {
            total_price     : 0,
            total_qty       : 0,
            has_color_split : false,
            has_extra_size  : false,
            colors          : [],
            clipart         : {
                front_start: '',
                front_end: '',
                back_start: '',
                back_end: '',
            },
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
        check_color_split_and_extra_size: function() {

            WRISTBAND.data['has_color_split']   = false;
            WRISTBAND.data['has_extra_size']    = false;

            var array_sizes = [];



            if ( Object.keys( WRISTBAND.data.colors).length > 1 ) {
                WRISTBAND.data['has_color_split'] = true;
            }

            for ( var color in WRISTBAND.data.colors ) {

                for ( var size in WRISTBAND.data.colors[color].sizes ) {


                    if ( array_sizes.length > 1 ) {

                        WRISTBAND.data['has_extra_size'] = true;
                        return;
                    }

                    if ( array_sizes.indexOf( size ) == -1 && WRISTBAND.data.colors[color].sizes[size].qty > 0 ) {
                        array_sizes.push(size);
                    }


                }

            }
        },
        collect_quantity: function( ) {
            var total_qty       = 0;

            for ( var color in WRISTBAND.data.colors ) {

                for ( var size in WRISTBAND.data.colors[color].sizes ) {
                    total_qty += WRISTBAND.data.colors[color].sizes[size].qty;
                }

            }

            WRISTBAND.data.total_qty = total_qty;

        },

        /**=========================================================================
         * Start Price Collection
         *==========================================================================*/

        collect_prices: function() {

            WRISTBAND.data.total_price = 0;

            var qty = WRISTBAND.data.total_qty;

            this._price_chart( qty );
            this._color_split( qty );
            this._extra_size( qty );
            this._message_more_than_char( qty );
            this._back_inside_message( qty );

        },
        _price_chart: function( qty ) {

            if ( qty <= 0 ) return 0;

            var price_charts = WRISTBAND.price_charts;

            WRISTBAND.data.total_price += this.range_price( price_charts, qty );
        },
        _color_split: function( qty ) {

            if ( !WRISTBAND.data.has_color_split ) return;

            var color_split_cost = WBC.settings.color_split_cost_price_list;

            WRISTBAND.data.total_price += this.range_price( color_split_cost, qty );

        },
        _extra_size: function( qty ) {


            if ( !WRISTBAND.data.has_extra_size ) return;


            var extra_size_cost = WBC.settings.color_extra_size_cost_price_list;

            WRISTBAND.data.total_price += this.range_price( extra_size_cost, qty );


        },


        _message_more_than_char: function( qty ) {


            if ( qty <= 0 ) return;

            var price_list = WBC.settings.messages.more_than_22_characters_price_list;

            var additional_price = this.range_price( price_list, qty );

            var array_el = ['front_message', 'back_message', 'inside_message', 'continues_message'];

            $( '.alert-notify.more-than-char' ).remove();

            for ( var i = 0; i < array_el.length; i++ ) {

                if ( ( $( 'input[name="mesage_type"]:checked' ).val() == 'continues' &&
                        ( array_el[i] == 'front_message' || array_el[i] == 'back_message' ) ) ||
                    ( $( 'input[name="mesage_type"]:checked' ).val() == 'front_and_back' &&
                    array_el[i] == 'continues_message' ) ) {
                    continue;
                }

                var el  = $( 'input[name="'+ array_el[i] +'"]' ).val();

                if ( el.length > WBC.settings.messages.message_char_limit ) {
                    WRISTBAND.data.total_price += additional_price;

                    // Render alert message
                    var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each for more than {{limit}} characters.',
                        {
                            currency_symbol: WBC.settings.currency_symbol,
                            price: additional_price,
                            limit: WBC.settings.messages.message_char_limit
                        }
                    );

                    this.append_alert_msg( tpl, 'input[name="'+ array_el[i] +'"]', 'more-than-char' );
                }

            }


        },

        _back_inside_message: function( qty ) {

            if ( qty <= 0 ) return;

            var array_el = ['back_message', 'inside_message'];


            $( '.alert-notify.each-message' ).remove();

            for ( var i = 0; i < array_el.length; i++ ) {
                var len = $('input[name="' + array_el[i] + '"]').val().length;
                if (len > 0) {
                    var price_list = WBC.settings.messages[array_el[i] + '_price_list'];
                    if ( price_list != undefined ) {

                        var additional_price = this.range_price( price_list, qty );
                        WRISTBAND.data.total_price += additional_price;



                        // Render alert message
                        var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each.',
                            {
                                currency_symbol: WBC.settings.currency_symbol,
                                price: additional_price,
                            }
                        );

                        this.append_alert_msg( tpl, 'input[name="'+ array_el[i] +'"]', 'each-message' );

                    }
                }
            }

        },


        /**=========================================================================
         * End Prices Collection
         *==========================================================================*/


        init: function() {
            this.render_price_chart();
            $.material.init();
        },

        append_alert_msg: function( _msg, el, uniq_class ) {
            var tpl  = Mustache.render( '<i class="alert-notify '+ uniq_class +'">{{{message}}}</i>', { message: _msg } );

            if ( uniq_class != undefined )
                $( el).parent().find( '.' + uniq_class).remove();

            $( tpl ).insertAfter( $( el ) );
        },

        range_price: function( range, qty ) {

            var price = 0;
            var keys = Object.keys( range );

            for ( var i = 0; i < keys.length; i++ ) {

                var z = i < keys.length - 1 ? i + 1 : i;
                if ( ( i < keys.length && qty >= HELPER.int_val( keys[i] ) && qty < HELPER.int_val( keys[z] ) ) ||
                    ( i >= keys.length - 1 && HELPER.int_val( keys[i] ) <= qty ) ) {

                    price = HELPER.float_val( range[keys[i]] );
                    break;
                }
            }


            return price;

        },

        observer: function() {


            WRISTBAND.check_color_split_and_extra_size();


            WRISTBAND.collect_quantity();
            WRISTBAND.collect_prices();


            var total_qty   = WRISTBAND.data.total_qty,
                total_price = WRISTBAND.data.total_price;


            WRISTBAND.data['total_qty'] = total_qty;
            WRISTBAND.data['total_price'] = total_price;

            $( '#qty_handler' ).text( HELPER.number_format( total_qty, 0 ) + ( total_qty > WBC.settings.max_qty ? ' + 100 Free' : '' ) );
            $( '#price_handler' ).text( HELPER.number_format( total_price ) );





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


            $( '.fileupload' ).each(function() {


                var $self = $( this );

                $( this ).fileupload( {
                    url             : WBC.ajax_url,
                    formData        : {
                        action: 'blueimp-fileupload',
                        clipart_type: $self.data( 'clipart-type' ),
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


                            var button = $self.closest( '.fusion-column-wrapper' ).find('.toggle-modal-clipart');

                            button.attr( 'data-deleteUrl', file.deleteUrl );

                            WRISTBAND.data.clipart[button.data('position')] = file.thumbnailUrl;

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
            });


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

                var _adult_text_color_box   = Mustache.render( bg_style_tpl, {hide: ( HELPER.int_val( $aq.val() ) <= 0 ? 'hide' : '' ), bg_color: $('option:selected', $atc).data( 'color' ), qty: HELPER.number_format( HELPER.int_val( $aq.val() ), 0 ) }),
                    _medium_text_color_box  = Mustache.render( bg_style_tpl, {hide: ( HELPER.int_val( $mq.val() ) <= 0 ? 'hide' : '' ), bg_color: $('option:selected', $mtc).data( 'color' ), qty: HELPER.number_format( HELPER.int_val( $mq.val() ), 0 ) }),
                    _youth_text_color_box   = Mustache.render( bg_style_tpl, {hide: ( HELPER.int_val( $yq.val() ) <= 0 ? 'hide' : '' ), bg_color: $('option:selected', $ytc).data( 'color' ), qty: HELPER.number_format( HELPER.int_val( $yq.val() ), 0 ) }),
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

            })


            .on( 'keyup', 'input[name="front_message"], input[name="back_message"], input[name="inside_message"]', function() {
                WRISTBAND.observer();
            })

            // Trigger change when message type is choosen
            .on( 'change', 'input[name="mesage_type"]', function() {
                WRISTBAND.observer();
            })

            .on( 'show.bs.modal', '#wristband-clipart-modal', function(e){

                var button = $( e.relatedTarget );


                var modal = $( this );

                modal.find( '.modal-title' ).text( 'Choose your '+ button.data( 'title' ) +' Clipart ' );
                modal.find( '.clipart-list').data( 'target', '#' + button.attr( 'id' ) );
                modal.find( '.clipart-list').data( 'position', button.attr( 'id' ) );

            })


            .on( 'click', '.clipart-list li', function() {

                $( '.clipart-list li').removeClass( 'active' );

                $( this ).addClass( 'active' );


                var button = $( $( this).closest( '.clipart-list').data( 'target' ) );

                button.find( '.icon-preview' ).removeClass(function (index, css) {
                    return (css.match (/(^|\s)fa-\S+/g) || []).join(' ');
                });

                button.find( '.icon-preview' ).addClass( $( this ).data( 'icon' ) );


                WRISTBAND.data['clipart'][button.data('position')] =  $( this ).data( 'icon' );

                console.log( WRISTBAND.data );

                $( '#wristband-clipart-modal' ).modal( 'hide' );

            });







        // Call function on load
        WRISTBAND.on_load();

    });



});