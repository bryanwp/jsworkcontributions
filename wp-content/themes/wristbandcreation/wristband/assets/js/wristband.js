jQuery( function ( $ ) {
    'use strict';

    var HELPER = {
        // Convert string to integer
        iv: function( n ) {
            n = parseInt( n );

            return isNaN( n ) ? 0 : n;
        },
        // Convert string to float
        fv: function( n ) {
            n = parseFloat( n );


            return isNaN( n ) ? 0 : n;
        },
        // Format number to 2 decimal places
        nf: function( n, f ) {

            if ( n == undefined ) return 0;
            f = f == undefined ? 2 : f;

            return  n.toFixed( f ).replace(/./g, function(c, i, a) {
                return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
            });
        },
        // Check if file is image
        is_image: function( file ) {

            if ( file == undefined ) return false;

            return file.match(/\.(jpeg|jpg|png|gif)$/) != null;
        }
    };


    var WRISTBAND = {
        data: {
            total_price     : 0,            // Total Price of wristband selected
            total_qty       : 0,            // Total Quantity of wristband selected
            has_color_split : false,        // Check if selection has color split
            has_extra_size  : false,        // Check if selection has extra sizes
            colors          : [],           // Color selected
            clipart         : {
                front_start: '',            // Front Start Clipart
                front_end: '',              // Front End Clipart
                back_start: '',             // Back Start Clipart
                back_end: '',               // Back End Clipart
            },
        },
        has_upload: false,                   // Check if there are any files uploaded
        price_charts: [],                   // Array of price chart

        init: function() {
            this.render_price_chart();
            $.material.init();
        },
        reset: function() {
            WRISTBAND.data['total_price']       = 0;
            WRISTBAND.data['total_qty']         = 0;
            WRISTBAND.data['has_color_split']   = 0;
            WRISTBAND.data['has_extra_size']    = 0;
            WRISTBAND.data['colors']            = [];

            WRISTBAND.observer();

            $( '.color-wrap').removeClass( 'added selected' );
            $( '#selected_color_table > tbody' ).empty();

        },
        // Check if color is already selected
        is_color_exist: function( name ) {

            if ( WRISTBAND.data.colors[name] != undefined ) return true;

            return false;
        },
        // Add color selected to wristband data
        add_color: function( key, value ) {

            this.remove_color( key );

            WRISTBAND.data.colors.push(value);
            WRISTBAND.observer();
        },
        get_color_index: function( name ) {
            for ( var i in WRISTBAND.data.colors ) {
                if( WRISTBAND.data.colors[i].name == name ) {
                    return i;
                }
            }
        },
        // Remove color selected
        remove_color: function( name ) {


            for ( var i in WRISTBAND.data.colors ) {
                if( WRISTBAND.data.colors[i].name == name ) {
                    delete WRISTBAND.data.colors[i];
                }
            }

            WRISTBAND.observer();

        },
        // Check if there are any split color and extra sizes
        check_color_split_and_extra_size: function() {

            WRISTBAND.data['has_color_split']   = false;
            WRISTBAND.data['has_extra_size']    = false;

            var array_sizes = [];

            if ( WRISTBAND.data.colors.length > 1 ) {
                WRISTBAND.data['has_color_split'] = true;
            }

            for ( var i in WRISTBAND.data.colors ) {

                for ( var size in WRISTBAND.data.colors[i].sizes ) {


                    if ( array_sizes.length > 1 ) {
                        WRISTBAND.data['has_extra_size'] = true;
                        return;
                    }

                    if ( array_sizes.indexOf( size ) == -1 && WRISTBAND.data.colors[i].sizes[size].qty > 0 ) {


                        array_sizes.push(size);
                    }


                }

            }
        },

        // Collect all quantity
        collect_quantity: function( ) {
            var total_qty       = 0;

            for ( var color in WRISTBAND.data.colors ) {

                for ( var size in WRISTBAND.data.colors[color].sizes ) {
                    total_qty += WRISTBAND.data.colors[color].sizes[size].qty;
                }

            }

            WRISTBAND.data.total_qty = total_qty;

        },

        // Append alert messages
        append_alert_msg: function( _msg, el, uniq_class ) {
            var tpl  = Mustache.render( '<i class="alert-notify '+ uniq_class +'">{{{message}}}</i>', { message: _msg } );

            if ( uniq_class != undefined )
                $( el).parent().find( '.' + uniq_class).remove();

            $( tpl ).insertAfter( $( el ) );
        },
        // Get the price from quantity range
        range_price: function( range, qty ) {

            if ( range == undefined ) return;
            var price = 0;
            var keys = Object.keys( range );

            for ( var i = 0; i < keys.length; i++ ) {

                var z = i < keys.length - 1 ? i + 1 : i;
                if ( ( i < keys.length && qty >= HELPER.iv( keys[i] ) && qty < HELPER.iv( keys[z] ) ) ||
                    ( i >= keys.length - 1 && HELPER.iv( keys[i] ) <= qty ) ) { //|| ( i == 0 && qty > 0 && HELPER.iv( keys[i] ) >= qty )

                    price = HELPER.fv( range[keys[i]] );
                    break;
                }
            }


            return price;

        },
        // Observe any changes and calcuate price and quantity for display
        observer: function() {


            this.check_color_split_and_extra_size();


            this.collect_quantity();

            this.collect_prices();


            var total_qty   = this.data.total_qty,
                total_price = this.data.total_price;


            this.data['total_qty'] = total_qty;
            this.data['total_price'] = total_price;

            $( '#qty_handler' ).text( HELPER.nf( total_qty, 0 ) + ( total_qty > WBC.settings.max_qty ? ' + 100 Free' : '' ) );
            $( '#price_handler' ).text( HELPER.nf( total_price ) );



        },

        render_production_shipping_options: function() {

            if ( this.data.total_qty <= 0 )return;

            var $size =  $( '#width option:selected' );

            var c = ['production', 'shipping'];
            for ( var i in c ) {


                var $select = $( 'select[name="customization_date_'+ c[i] +'"]' );

                $select.removeAttr( 'disabled' );

                $( 'option:not(:first-child)', $select).remove();

                var t = WBC.settings.customization.dates[c[i]];

                for ( var y in t ) {

                    var val = t[y].days;


                    var price = HELPER.fv( WRISTBAND.get_day_price( WBC.settings.production_price_list[$size.data( 'group' )][y] ) );

                    var lbl = price > 0 ? WBC.settings.currency_symbol + HELPER.nf( price ) : 'Free';

                    var $option = $( '<option />')
                        .val( val )
                        .text( t[y].name  + ' - ' + lbl )
                        .attr( 'data-price', price );

                    $select.append( $option );

                }

                $select.trigger( 'change' );

            }

        },
        // Bind element to jquery library/packages on load
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

                $self.fileupload( {
                    url             : WBC.ajax_url,
                    formData        : {
                        action: 'clipart-fileupload',
                        clipart_type: $self.data( 'clipart-type' ),
                    },
                    dataType        : 'json',
                    maxNumberOfFiles: 1,
                    done: function ( e, data ) {

                        var $self = $( this );

                        $.each( data.result.files, function ( index, file ) {

                            var button = $self.closest( '.fusion-column-wrapper' ).find( '.toggle-modal-clipart' );
                            // Delete previous file
                            if (  HELPER.is_image( WRISTBAND.data.clipart[button.data('position')] ) ) {
                                WRISTBAND.delete_clipart( WRISTBAND.data.clipart[button.data('position')] );
                            }

                            button.attr( 'data-file', file.name );

                            WRISTBAND.has_upload = true;
                            WRISTBAND.data.clipart[button.data('position')] = file.name;

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
                                .removeClass( 'fa-spinner' )
                                .addClass( 'fa-cloud-upload' );


                            WRISTBAND.observer();

                        });


                    },
                    progressall: function ( e, data ) {
                        var $self = $( this );

                        $self.closest( '.fileinput-button' )
                            .find( 'span' )
                            .css( { 'padding-left' : '10px' } )
                            .end()
                            .find( '.fa-cloud-upload' )
                            .removeClass( 'fa-cloud-upload' )
                            .addClass( 'fa-spinner' );
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
        },
        delete_clipart: function( file ) {
            return $.ajax({
                url     : WBC.ajax_url + '?file=' + file + '&action=delete_clipart',
                type    : 'DELETE',
                dataType: 'json',
                async   :false,
            });
        },


        get_size_group: function( size ) {

            var group = '';
            for ( var type in WBC.settings.customization.options ) {
                for ( var i in WBC.settings.customization.options[type].set_size_list ) {
                    if ( WBC.settings.customization.options[type].set_size_list[i] != size ) continue;
                    group = type;

                    break;
                }
                if ( group != '' ) break;
            }

            return group

        },

        get_day_price: function( list ) {
            return this.range_price( list, WRISTBAND.data.total_price );
        },

        collect_data_to_post: function() {

            var addtional_options    = [],
                messages            = {},
                $production_time    = $( 'select[name="customization_date_production"] option:selected'),
                $shipping_time      = $( 'select[name="customization_date_shipping"] option:selected');

            $( 'input[name="additional_option[]"]:checked' ).each(function() {
               addtional_options.push( $( this).val() );
            });


            if ( $( 'input[name="mesage_type"]' ).val() == 'front_and_back' ) {
                messages['Front Message']   = $( 'input[name="front_message"]' ).val();
                messages['Back Message']    = $( 'input[name="back_message"]' ).val();
                messages['Inside Message']  = $( 'input[name="inside_message"]' ).val();
            } else {
                messages['Continues Message'] = $( 'input[name="continues_message"]' ).val();
            }

            messages['Additional Notes'] = $( 'textarea#additional_notes').val();

            $.extend(WRISTBAND.data, {
                product                 : $( 'select#style' ).val(),
                size                    : $( 'select#width' ).val(),
                font                    : $( 'select#font').val(),
                message_type            : $( 'input[name="mesage_type"]' ).val(),
                messages                : messages,
                additional_options      : addtional_options,
                customization_location  : $( 'input[name="customization_location"]').data('title'),
                customization_date_production : $production_time.text(),
                customization_date_shipping : $production_time.text(),
                guaranteed_delivery: 'Oct 4, 2016'
            });



        },
        popup_message: function( _status, _title, _message ) {
            var template  = $( '#modal_message_template').html();
            var tpl  = Mustache.render( template, { status: _status, title: _title, message: _message } );

            $( '#modal_message').remove();

            $( 'body').append( tpl );


            $( '#modal_message').modal( 'show' );



        },
        validate_form: function() {
            var flag    = true,
                msg     = '';


            if ( WRISTBAND.data.colors.length == 0 ) {
                msg += 'Please select a color/quantity.<br />';
                flag = false;
            }

            if ( $( 'select[name="customization_date_production"]').val() == -1 ) {
                msg += 'Production time is required.<br />';
                flag = false;
            }

            if ( $( 'select[name="customization_date_shipping"]').val() == -1 ) {
                msg += 'Shipping Time is required.<br />';
                flag = false;
            }

            if ( !flag )
                WRISTBAND.popup_message( 'error', 'Error', msg );


            return flag;
        },

        calculate_delivery_date: function() {
            var $production_time    = $( 'select#customization_date_production' ),
                $shipping_time      = $( 'select#customization_date_shipping'),
                the_date            = new Date();


            if ($production_time.val() == -1 || $shipping_time.val() == -1) return;

            var total_days          = HELPER.iv( $production_time.val() ) + HELPER.iv( $shipping_time.val() );





            // Start escape saturday and sunday and holiday
            var flag = true,
                cntr = 0;

            while ( flag == true ) {

                the_date.setDate( the_date.getDate() + 1 );

                if ( HELPER.iv( the_date.getDay() )  != 0 && HELPER.iv( the_date.getDay() ) != 6 && !this.is_holiday( the_date ) ) {
                    cntr++;
                }

                if (cntr >= total_days) {
                    break;
                }
            }

            var month_name = [
                "January", "February", "March",
                "April", "May", "June", "July",
                "August", "September", "October",
                "November", "December"
            ];
            var week_name = [
              "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
            ];
            // End escape
            var delivery_date = week_name[the_date.getDay()] + ' ' + month_name[the_date.getMonth()] +' '+ the_date.getDate() + ', ' + the_date.getUTCFullYear();
            $( '#delivery_date').text( delivery_date )
            WRISTBAND.data['guaranteed_delivery'] = delivery_date;



        },

        is_holiday: function(t) {

            for ( var i = 0; i < WBC.settings.holidays.length; i++ ) {
                var now = new Date(WBC.settings.holidays[i] * 1000);
                if ( now.getDate() == t.getDate() && now.getMonth() == t.getMonth() && now.getYear() == t.getYear() ) {
                    return true;
                }
            }

            return false;

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
            this._additional_options( qty );
            this._clipart( qty );
            this._customization_location();
            this._customization_date();

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

        _additional_options: function( qty ) {


            $( 'input[name="additional_option[]"]:checked').each( function(  ) {
                var price_list = WBC.settings['additional_options'][$( this ).data('key')].price_list;

                var additional_price = WRISTBAND.range_price( price_list, qty );

                $( this ).closest( '.checkbox').closest( '.checkbox').find( '.each-message').remove();
                if ( additional_price > 0 ) {

                    WRISTBAND.data.total_price += additional_price;


                    // Render alert message
                    var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each.',
                        {
                            currency_symbol: WBC.settings.currency_symbol,
                            price: additional_price,
                        }
                    );

                    WRISTBAND.append_alert_msg(tpl, $(this).closest('.checkbox'), 'each-message');
                }
            } );

        },
        _customization_location: function() {
            var location = $( 'input[name="customization_location"]:checked' ).val();




            var additional_price = HELPER.fv( WBC.settings.customization.location[location].price );





            if ( additional_price <= 0 ) return;

            WRISTBAND.data.total_price += additional_price;

            // Render alert message
            var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each.',
                {
                    currency_symbol: WBC.settings.currency_symbol,
                    price: additional_price,
                }
            );

            $( '.customization_location.each-message' ).remove();
            WRISTBAND.append_alert_msg( tpl, $( 'input[name="customization_location"]:checked' ).closest( '.radio' ), 'customization_location each-message' );

        },

        _customization_date: function( ) {


            $( 'select.customization-date-select option:selected').each( function() {

                var additional_price = $( this).data( 'price' );

                additional_price = HELPER.fv( additional_price );
                WRISTBAND.data.total_price += additional_price == undefined ? 0 : additional_price;

            });

        },

        _clipart: function( qty ) {
            if ( qty <= 0 ) return;
            // Check if there are any cliparts uploaded/selected
            var flag = false;
            for ( var i in WRISTBAND.data.clipart ) {
                if ( WRISTBAND.data.clipart[i] != '' && WRISTBAND.data.clipart[i] != undefined ) {
                    flag = true;
                    break;
                }
            }

            if ( ! flag ) return;

            var price_list =  WBC.settings.logo.prices;
            var additional_price = WRISTBAND.range_price( price_list, qty );
            WRISTBAND.data.total_price += additional_price;


            // Render alert message
            var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each.',
                {
                    currency_symbol: WBC.settings.currency_symbol,
                    price: additional_price,
                }
            );

            $( '.clipart.each-message' ).remove();
            WRISTBAND.append_alert_msg( tpl, '#add-clipart > h2', 'clipart each-message' );

        },


        /**=========================================================================
         * End Prices Collection
         *==========================================================================*/

    };




    $( document).ready(function() {

        $( document.body )
            // Get Product sizes on style changed
            .on( 'change', 'select[name="style"]', function() {

                WRISTBAND.reset();

                var slctd_product = WBC.settings.products[this.value];

                if ( slctd_product != undefined ) {
                    $( '#wbc_add_to_cart').removeAttr( 'disabled' );

                    $( 'select#width').empty().removeAttr( 'disabled' );
                    for( var size in slctd_product.sizes ) {
                        var $option = $('<option>').val( size).text( size );

                        $option.attr( 'data-group', WRISTBAND.get_size_group( size ) );


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
                WRISTBAND.reset();
                WRISTBAND.init();
                WRISTBAND.render_production_shipping_options();

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

                var _adult_text_color_box   = Mustache.render( bg_style_tpl, {hide: ( HELPER.iv( $aq.val() ) <= 0 ? 'hide' : '' ), bg_color: $('option:selected', $atc).data( 'color' ), qty: HELPER.nf( HELPER.iv( $aq.val() ), 0 ) }),
                    _medium_text_color_box  = Mustache.render( bg_style_tpl, {hide: ( HELPER.iv( $mq.val() ) <= 0 ? 'hide' : '' ), bg_color: $('option:selected', $mtc).data( 'color' ), qty: HELPER.nf( HELPER.iv( $mq.val() ), 0 ) }),
                    _youth_text_color_box   = Mustache.render( bg_style_tpl, {hide: ( HELPER.iv( $yq.val() ) <= 0 ? 'hide' : '' ), bg_color: $('option:selected', $ytc).data( 'color' ), qty: HELPER.nf( HELPER.iv( $yq.val() ), 0 ) }),
                    _wristband_color_box    = Mustache.render( bg_style_tpl, {hide: '', bg_color: $wc.data( 'color' ), qty: '' });



                if ( $wc.length == 0 || ( HELPER.iv( $aq.val() ) <= 0 && HELPER.iv( $mq.val() ) <= 0 &&
                    HELPER.iv( $yq.val() ) <= 0 ) ) {

                    WRISTBAND.popup_message( 'error', 'Error', 'Please select color/quantity.' );
                    return;
                }



                //if ( WRISTBAND.is_color_exist( $wc.data( 'name' ) ) ) {
                //    alert( 'Color already selected' );
                //    return;
                //}

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
                    name: $wc.data('name'),
                    color: $wc.data('color'),
                    type: $('input[name="color_style"]:checked').val(),
                    sizes: {
                        adult: {
                            qty: HELPER.iv($aq.val()),
                            name: $('option:selected', $atc).val(),
                            color: $('option:selected', $atc).data('color'),

                        },
                        medium: {
                            qty: HELPER.iv($mq.val()),
                            name: $('option:selected', $mtc).val(),
                            color: $('option:selected', $mtc).data('color'),

                        },
                        youth: {
                            qty: HELPER.iv($yq.val()),
                            name: $('option:selected', $ytc).val(),
                            color: $('option:selected', $ytc).data('color'),

                        }
                    }
                });

                var $tr = $( '#selected_color_table > tbody tr[data-name="'+ $wc.data( 'name' ) +'"]' );

                if ( $tr.length ) {
                   $tr.replaceWith( row_tpl );
                } else {
                    $( '#selected_color_table > tbody' ).append( row_tpl );
                }


                $wc.closest( '.color-wrap' ).addClass( 'added' );

                $( '#wristband-color-items .color-wrap').removeClass( 'selected' );
                $( '#qty_adult, #qty_medium, #qty_youth' ).val( '' );


                $( this ).find( '.fusion-button-text').text( 'Add an additional color' );


                WRISTBAND.render_production_shipping_options();

                return false;
            })

            .on( 'click', '.delete-selection', function( e ) {
                e.preventDefault();
                var $row = $( this ).closest( 'tr' );
                // Remove color from selections
                WRISTBAND.remove_color( $row.data( 'name' ) );

                // Remove "added" class in wristband colors
                $( '#wristband-color-tab  div[data-name^="'+ $row.data( 'name' )  +'"]' ).closest( '.color-wrap' ).removeClass( 'added selected' );

                $row.remove();

                return false;

            })

            .on( 'click', '.edit-selection', function( e ) {
                e.preventDefault();

                var color_name  = $( this).closest( 'tr' ).data( 'name'),
                    i = WRISTBAND.get_color_index(color_name),
                    color   = WRISTBAND.data.colors[i];

                $( '#qty_adult ').val( color.sizes.adult.qty );
                $( '#qty_medium' ).val( color.sizes.medium.qty );
                $( '#qty_youth' ).val( color.sizes.youth.qty );


                $( 'select[name="adult_text_color"] option[value="'+ color.sizes.adult.name +'"]').trigger( 'change' );
                $( 'select[name="medium_text_color"] option[value="'+ color.sizes.medium.name +'"]').trigger( 'change' );
                $( 'select[name="youth_text_color"] option[value="'+ color.sizes.youth.name +'"]').trigger( 'change' );

                $( '.color-wrap' ).removeClass( 'selected' );


                $( 'input[name=color_style][value="'+ color.type +'"]').trigger( 'click' );

                $( '.color-wrap > div[data-name^="'+ color.name +'"]').closest( '.color-wrap').addClass( 'selected' );

                $( '#add_color_to_selections > .fusion-button-text').text( 'Update Color' );

            })

            .on( 'keyup', 'input[name="front_message"], input[name="back_message"], input[name="inside_message"]', function() {
                WRISTBAND.observer();
            })

            // Trigger change when message type is choosen
            .on( 'change', 'input[name="mesage_type"], .customization-date-select', function() {
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

                var icon = $( this ).data( 'icon' );

                button.find( '.icon-preview' ).removeClass(function (index, css) {
                    return (css.match (/(^|\s)fa-\S+/g) || []).join(' ');
                });

                button.find( '.icon-preview' ).addClass( icon == undefined ? 'fa-ban' : icon );


                WRISTBAND.data['clipart'][button.data('position')] =  icon == undefined ? '' : icon;
                WRISTBAND.has_upload = false;

                $( '#wristband-clipart-modal' ).modal( 'hide' );

                if ( button.data( 'file') != undefined ) {
                    // Delete previous file
                    var result = WRISTBAND.delete_clipart( button.data('file') );
                    result.success( function() {

                        button.removeAttr( 'data-file' );
                        button.find( '.icon-preview' ).css( { display: 'inline-block' } );
                        button.find( '.image-upload' ).css( { display: 'none' } );
                    } );
                }


                WRISTBAND.observer();

            })

            .on( 'change', 'input[name="additional_option[]"], input[name="customization_location"]', function(){
               WRISTBAND.observer();
            })

            .on( 'click', '#wbc_add_to_cart', function(e) {
                e.preventDefault();

                if ( !WRISTBAND.validate_form() ) {
                    return;
                }

                var $self = $( this),
                    $icon = $self.find( '.fa'),
                    $button_text = $self.find( '.fusion-button-text-left');

                $icon.removeClass( 'fa-shopping-cart' );
                $icon.addClass( 'fa-spinner' );
                $button_text.text( 'Processing...' );

                WRISTBAND.collect_data_to_post();

                $.ajax({
                    url: WBC.ajax_url,
                    type: 'POST',
                    data: {meta: JSON.stringify(WRISTBAND.data), action: 'wbc_add_to_cart'},
                    dataType: 'JSON',
                }).done(function(response) {
                    var type = 'success',
                        title = 'Success';

                    $icon.removeClass( 'fa-spinner' );
                    $icon.addClass( 'fa-shopping-cart' );
                    $button_text.text( 'Add to Cart' );

                    if ( !response.success ) {
                        type = 'error';
                        title = 'Error';
                    }
                    WRISTBAND.has_upload = false;
                    WRISTBAND.popup_message( type, title, response.data.message + ' <a href="'+ WBC.settings.site_url +'/cart">view cart <i class="fa fa-long-arrow-right"></i></a>' );

                });



                return false;
            } )
            .on( 'change', 'select#customization_date_production, select#customization_date_shipping', function() {
                WRISTBAND.calculate_delivery_date();

            });


        // Alert message if attempt to leave/unload page
        $( window ).on( 'beforeunload', function() {
            if ( WRISTBAND.has_upload )
                return 'There are unsaved data.';
        });

        // Delete any uploaded clipart before leaving page
        $( window ).on( 'unload',function(){
            if ( WRISTBAND.has_upload ) {
                //Delete file clipart if page is leave/unload
                for ( var i in WRISTBAND.data.clipart ) {
                    if ( WRISTBAND.data.clipart[i].match(/\.(jpeg|jpg|png|gif)$/) != null ) {

                        var result = WRISTBAND.delete_clipart( WRISTBAND.data.clipart[i] );
                        result.success( function() {
                            WRISTBAND.has_upload = false;
                        } );
                    }
                }
            }

        });



        // Call function on load
        WRISTBAND.on_load();

    });



});