jQuery(function ($) {
    'use strict';

    console.log(WBC.settings);
    var Settings = WBC.settings,
        Builder = {
        has_upload: false,                   // Check if there are any files uploaded
        CntID : 0,
        price_charts: [],                   // Array of price chart
        data: {
            total_price     : 0,            // Total Price of wristband selected
            total_qty       : 0,            // Total Quantity of wristband selected
            has_color_split : false,        // Check if selection has color split
            has_extra_size  : false,        // Check if selection has extra sizes
            size_number     : 0,           // Number of sizes that are inputted
            colors          : [],           // Color selected
            clipart         : {
                front_start: '',            // Front Start Clipart
                front_end: '',              // Front End Clipart
                back_start: '',             // Back Start Clipart
                back_end: '',               // Back End Clipart
                wrap_start: '',             // Wrap Start Clipart
                wrap_end: '',               // Wrap End Clipart

                view_position: 'front',
                wristband_stat: 'front_and_back',
            },
        },



        init: function() {
            this.renderPriceChart();
        },
        reset: function() {
            //this.data.total_price       = 0;
            //this.data.total_qty         = 0;
            //this.data.has_color_split   = false;
            //this.data.has_extra_size    = false;
            //this.data.colors            = [];
            //this.observer();
            //$('.color-wrap').removeClass('added selected');
            //$('#selected_color_table > tbody').empty();
        },
        // Add color selected to wristband data
        addColor: function(key, value) {
            this.removeColor(key);
            this.data.colors.push(value);
            this.observer();
        },
        updateColor: function(name, lists) {

            for (var i in this.data.colors) {
                    
                if( name != '') {

                    if( this.data.colors[i].name ==  name ) {

                        this.data.colors[i].name            = (lists.name != '') ? lists.name : this.data.colors[i].color;
                        this.data.colors[i].color           = (lists.color != '') ? lists.color : this.data.colors[i].color;
                        this.data.colors[i].type            = (lists.type != '') ? lists.type : this.data.colors[i].type;
                        this.data.colors[i].text_color      = lists.text_color;
                        this.data.colors[i].text_color_name = lists.text_color_name;
                        this.data.colors[i].sizes['adult']  = (lists.sizes['adult'] != '' || lists.sizes['adult'] == 0) ? lists.sizes['adult'] : this.data.colors[i].sizes['adult'];
                        this.data.colors[i].sizes['medium'] = (lists.sizes['medium'] != '' || lists.sizes['medium'] == 0) ? lists.sizes['medium'] : this.data.colors[i].sizes['medium'];
                        this.data.colors[i].sizes['youth']  = (lists.sizes['youth'] != '' || lists.sizes['youth'] == 0) ? lists.sizes['youth'] : this.data.colors[i].sizes['youth']; 

                        break;

                    }
                             
                } else {

                        this.data.colors[i].color           = (lists.color != '') ? lists.color : this.data.colors[i].color;
                        this.data.colors[i].type            = (lists.type != '') ? lists.type : this.data.colors[i].type;
                        this.data.colors[i].text_color      = lists.text_color;
                        this.data.colors[i].text_color_name = lists.text_color_name;
                        this.data.colors[i].sizes['adult']  = (lists.sizes['adult'] != '') ? lists.sizes['adult'] : this.data.colors[i].sizes['adult'];
                        this.data.colors[i].sizes['medium'] = (lists.sizes['medium'] != '') ? lists.sizes['medium'] : this.data.colors[i].sizes['medium'];
                        this.data.colors[i].sizes['youth']  = (lists.sizes['youth'] != '') ? lists.sizes['youth'] : this.data.colors[i].sizes['youth'];    

                    }
            }

            this.observer();

        },
        // Get color list
        getColorLists: function() {
            return this.data.colors;
        },
        getColorIndex: function(name) {
            for (var i in this.data.colors) {
                if(this.data.colors[i].name == name) {
                    return i;
                }
            }
        },
        // Remove color selected
        removeColor: function(name) {
            for (var i in this.data.colors) {
                //console.log(this.data.colors);
                if(this.data.colors[i].name == name || this.data.colors[i].temp == true) {
                    this.data.colors.splice(i, 1);
                }
            }
            this.observer();
        },
        // Check if there are any split color and extra sizes
        checkColorSplitAndExtraSize: function() {
            var array_sizes = [], size_definition = [];

            this.data.has_color_split   = false;
            this.data.has_extra_size    = false;
            this.data.size_number       = 0;
            if (this.data.colors.length > 1) {
                //console.log(this.data.colors);
                this.data.has_color_split = true;
            }
            for (var i in this.data.colors) {
                 for (var size in this.data.colors[i].sizes) {
                    //console.log(this.data);
                    if (array_sizes.indexOf(size) == -1 && this.data.colors[i].sizes[size] > 0)
                    {
                        array_sizes.push(size);
                    }
                    if (array_sizes.length == 2)
                    {
                        this.data.has_extra_size = true;
                        this.data.size_number = 2;
                    }
                    if (array_sizes.length == 3)
                    {
                        this.data.has_extra_size = true;
                        this.data.size_number = 3;
                    }
                   
                }

            }
        },
      
         // Collect all quantity
        collectQuantity: function() {

            var total_qty       = 0;

                for (var color in this.data.colors) {
                    for (var size in this.data.colors[color].sizes) {
                        total_qty += this.data.colors[color].sizes[size];
                    }
                }

                this.data.total_qty = total_qty;
   
        },
        // Append alert messages
        appendAlertMsg: function(_msg, el, uniq_class) {
            var tpl  = Mustache.render('<i class="alert-notify '+ uniq_class +'">{{{message}}}</i>', {message: _msg});
            if (uniq_class != undefined)
                $(el).parent().find('.' + uniq_class).remove();

            $(tpl).insertAfter($(el));
        },
        // Get the price from quantity range
        rangePrice: function(range, qty) {
            if (range == undefined) return;
            var price = 0;
            var keys = Object.keys(range);
            for (var i = 0; i < keys.length; i++) {
                var z = i < keys.length - 1 ? i + 1 : i;
                if ((i < keys.length && qty >= toInt(keys[i]) && qty < toInt(keys[z])) ||
                    (i >= keys.length - 1 && toInt(keys[i]) <= qty)) {
                    price = toFloat(range[keys[i]]);
                    break;
                }
            }
            return price;
        },

        //get the additional option
        additionalOptionsShow: function(size){
            var addOption = Settings.additional_options,
                value = '';
                for( var option in addOption)
                {
                     var choose_size = addOption[option].choose_size;
                    for (var i = 0; i < choose_size.length; i++) 
                    {
                            if ( choose_size[i] === size ) 
                            {
                               value = 'true';
                               break;
                            }   
                            else{
                                    value = 'not true';
                            }  
                    } 
                        if(value == 'true')
                        {
                            $('#id_'+option).show();
                        }
                        else if(value == 'not true')
                        {
                            $('#id_'+option).hide();
                        }
                }
                
        },

        // Observe any changes and calcuate price and quantity for display
        observer: function() {
            //    alert("sadas")
                this.checkColorSplitAndExtraSize();
                this.collectQuantity();
                this.collectPrices();
                var total_qty   = this.data.total_qty,
                    total_price = this.data.total_price;

                this.data.total_qty = total_qty;
                this.data.total_price = total_price;  

                 console.log('this.data.total_qty this.data.total_price');
                 console.log(this.data.total_qty);
                 console.log(this.data.total_price);

                $('#qty_handler').text(numberFormat(total_qty, 0) + (total_qty > Settings.max_qty ? ' + 100 Free' : ''));
                $('#price_handler').text(numberFormat(total_price));
                if( total_qty < 100)
                {
                    $('#id_convert_to_keychains').hide();
                }else
                {
                    $('#id_convert_to_keychains').show();
                }

            this.buildPreview();
            
        },
        buildPreview: function() {
           
            var message_type = $('input[name="message_type"]:checked').val(),
                a = $('.preview-button.active').data('input'),
                input = message_type == 'continues' ? 'continues_message' : a;
            $("#front-text")
                .text($('input[name="'+ input  +'"]').val().toUpperCase());

            $('#insidetextpath')
                .text($('input[name="inside_message"]').val().toUpperCase());

            $('#front-text')
                .attr('font-family', $('select[name="font"] option:selected').val());

     
            var y = $('#wristband-color-items .color-wrap.selected > div').data('color');
            if (y != undefined) {

                if($('#bandcolor').length) {
                    var background = document.getElementById("bandcolor"); 
                    background.style.fill=y;
                }
           }
       },
        renderProductionShippingOptions: function() {
     
            if (this.data.total_qty <= 0)return;
            var $size =  $('#width option:selected'),
                c = ['production', 'shipping'];
            for (var i in c) {
                var $select = $('select[name="customization_date_'+ c[i] +'"]');
                $select.removeAttr('disabled');
                $('option:not(:first-child)', $select).remove();
                var t = Settings.customization.dates[c[i]];
                for (var y in t) {
                    var val = t[y].days;
                    var price = toFloat(this.getDayPrice(Settings.production_price_list[$size.data('group')][y]));
                    var lbl = price > 0 ? Settings.currency_symbol + numberFormat(price) : 'Free';

                    var $option = $('<option />')
                        .val(val)
                        .text(t[y].name  + ' - ' + lbl)
                        .attr('data-price', price);
                    $select.append($option);
                }
                $select.trigger('change');
           }
        },
        // Bind element to jquery library/packages on load
        onLoad: function() {
//milbert


            if ($('#preview_container').length) { Pablo(preview_container).load(Settings.svg); }
                // Trigger change on ready
                $('select[name="style"], input[name="message_type"]').trigger('change');

                // Trigger keyup on ready
                $('.trigger-limit-char').trigger('keyup');


            if (document.getElementById("EditModeID")){
                StartEdit();
            }



            $('.fileupload').each(function() {

                var $self = $(this);
                $self.fileupload({
                    url             : WBC.ajax_url,
                    formData        : {
                        action: 'clipart-fileupload',
                        clipart_type: $self.data('clipart-type'),
                   },
                    dataType        : 'json',
                    maxNumberOfFiles: 1,
                    done: function (e, data) {
                        var $self = $(this);
                        $.each(data.result.files, function (index, file) {

                            var button = $self.closest('.button-box').find('.toggle-modal-clipart');
                            // Delete previous file
                            if (isImg(Builder.data.clipart[button.data('position')])) {
                                Builder.deleteClipart(Builder.data.clipart[button.data('position')]);
                            }
                            button.attr('data-file', file.name);

                            Builder.has_upload = true;
                            Builder.data.clipart[button.data('position')] = file.name;

                            $self.closest('.button-box')
                                .find('.image-upload')
                                .attr('src', file.thumbnailUrl)
                                .css({display: 'inline-block'});

                            $self.closest('.button-box')
                                .find('.hide-if-upload')
                                .css({display : 'none'});

                            $self.closest('.fileinput-button')
                                .find('span')
                                .css({'padding-left' : '0'})
                                .end()
                                .find('.fa-spinner')
                                .removeClass('fa-spinner')
                                .addClass('fa-cloud-upload');

                            Builder.observer();
                       });


                   },
                    progressall: function (e, data) {
                        var $self = $(this);

                        $self.closest('.fileinput-button')
                            .find('span')
                            .css({'padding-left' : '10px'})
                            .end()
                            .find('.fa-cloud-upload')
                            .removeClass('fa-cloud-upload')
                            .addClass('fa-spinner');
                    }
                }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
           });

        },
        renderPriceChart: function() {
            var price_charts = this.price_charts = Settings.products[$('select[name="style"]').val()]['sizes'][$('select#width').val()]['price_chart'];
            $('#price_chart table tr td:not(:first-child)').remove();
            for (var _qty in price_charts) {
                var output_qty_tpl = Mustache.render('<td>{{qty}}</td>', {qty: numberFormat(_qty, 0)});
                var output_price_tpl = Mustache.render('<td>{{price}}</td>', {price: numberFormat(price_charts[_qty], 2)});
                $('#price_chart table tr:first-child').append(output_qty_tpl);
                $('#price_chart table tr:eq(1)').append(output_price_tpl);
            }
        },
        deleteClipart: function(file) {
            return $.ajax({
                url     : WBC.ajax_url + '?file=' + file + '&action=delete_clipart',
                type    : 'DELETE',
                dataType: 'json',
                async   :false,
           });
        },

        getSizeGroup: function(size) {
            var group = '';
            for (var type in Settings.customization.options) {
                for (var i in Settings.customization.options[type].set_size_list) {
                    if (Settings.customization.options[type].set_size_list[i] != size) continue;
                    group = type;

                    break;
                }
                if (group != '') break;
            }
            return group
        },
        getDayPrice: function(list) {
            return this.rangePrice(list, this.data.total_price);
        },
        collectDataToPost: function() {

            var addtional_options   = [],
                messages            = {},
                $production_time    = $('select[name="customization_date_production"] option:selected'),
                $shipping_time      = $('select[name="customization_date_shipping"] option:selected');

            $('input[name="additional_option[]"]:checked').each(function() {
               addtional_options.push($(this).val());
            });

            if ($('input[name="message_type"]').val() == 'front_and_back') {
                messages['Front Message']   = $('input[name="front_message"]').val();
                messages['Back Message']    = $('input[name="back_message"]').val();
                messages['Inside Message']  = $('input[name="inside_message"]').val();
            } else {
                messages['Continues Message'] = $('input[name="continues_message"]').val();
            }

            messages['Additional Notes'] = $('textarea#additional_notes').val();

            $.extend(this.data, {
                product                 : $('select#style').val(),
                size                    : $('select#width').val(),
                font                    : $('select#font').val(),
                message_type            : $('input[name="message_type"]').val(),
                messages                : messages,
                additional_options      : addtional_options,
                customization_location  : $('input[name="customization_location"]').data('title'),
                customization_date_production : $production_time.text(),
                customization_date_shipping : $production_time.text(),
                guaranteed_delivery: 'Oct 4, 2016'
            });
        },
       
        popupMsg: function(_status, _title, _message) {
            var template  = $('#modal_message_template').html();
            var tpl  = Mustache.render(template, {status: _status, title: _title, message: _message});
            $('#modal_message').remove();
            $('body').append(tpl);
            $('#modal_message').modal('show');
        },
        popupProductInfo: function(_status, _title, _message) {
            var template  = $('#modal_message_template2').html();
            var tpl  = Mustache.render(template, {status: _status, title: _title, message: _message});
            $('#modal_message2').remove();
            $('body').append(tpl);
            $('#modal_message2').modal('show');
        },
        validateForm: function() {
            var flag    = true,
                msg     = '';
            if (this.data.colors.length == 0) {
                msg += 'Please select a color/quantity.<br />';
                flag = false;
            }
            if ($('select[name="customization_date_production"]').val() == -1) {
                msg += 'Production time is required.<br />';
                flag = false;
            }
            if ($('select[name="customization_date_shipping"]').val() == -1) {
                msg += 'Shipping Time is required.<br />';
                flag = false;
            }
            if (!flag)
                this.popupMsg('error', 'Error', msg);


            return flag;
        },
        

        calculateDeliveryDate: function() {
            var $production_time    = $('select#customization_date_production'),
                $shipping_time      = $('select#customization_date_shipping'),
                the_date            = new Date();
            if ($production_time.val() == -1 || $shipping_time.val() == -1) return;
            var total_days          = toInt($production_time.val()) + toInt($shipping_time.val());

            // Start escape saturday and sunday and holiday
            var flag = true,
                cntr = 0;

            while (flag == true) {

                the_date.setDate(the_date.getDate() + 1);

                if (toInt(the_date.getDay())  != 0 && toInt(the_date.getDay()) != 6 && !this.isHoliday(the_date)) {
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
            $('#delivery_date').text(delivery_date)
            this.data['guaranteed_delivery'] = delivery_date;

        },
        isHoliday: function(t) {
            for (var i = 0; i < Settings.holidays.length; i++) {
                var now = new Date(Settings.holidays[i] * 1000);
                if (now.getDate() == t.getDate() && now.getMonth() == t.getMonth() && now.getYear() == t.getYear()) {
                    return true;
                }
            }
            return false;
        },

        /**=========================================================================
         * Start Price Collection
         *==========================================================================*/

        collectPrices: function() {
            this.data.total_price = 0;
            var qty = this.data.total_qty;
            this._priceChart(qty);
            this._colorSplit(qty);
            this._extraSize(qty);
            this._colorStylePrice(qty);
            this._msgMoreThanCharLimit(qty);
            this._backInsideMsg(qty);
            this._additionalOptions(qty);
            this._clipart(qty);
            this._customizationLocation();
            this._customizationDate();
        },
        _priceChart: function(qty) {
            if (qty <= 0) return 0;
            var price_charts = this.price_charts,
                additional  = this.rangePrice(price_charts, qty),
                total = 0;
                total  = additional * qty;

                if ( qty == 0 )
                {
                    this.data.total_price += additional; 
                }
                else 
                {
                    this.data.total_price += total;
                }

        },
        _colorSplit: function(qty) {
            if (!this.data.has_color_split) return;
            
            if(this.data.colors.length > 1)
            {
                var color_split_cost = Settings.color_split_cost_price_list,
                additional = this.rangePrice(color_split_cost, qty) * 1 ;
                this.data.total_price += additional;
            }
        },
        _extraSize: function(qty) {
            if (!this.data.has_extra_size) return;
            var extra_size_cost = Settings.color_extra_size_cost_price_list;

                if (this.data.size_number == 1)
                {
                    return;
                }
                else if (this.data.size_number == 2)
                {
                    this.data.total_price += this.rangePrice(extra_size_cost,qty);
                }
                else
                {
                    this.data.total_price += this.rangePrice(extra_size_cost,qty) * 2;
                }
        },
        _colorStylePrice: function(qty) {
            if(qty <= 0) return;
            var color_style_price = Settings.price_list,
                styleID = $('.color-wrap.selected').eq(0).attr('title');
                 console.log('Settings');
                 console.log(Settings);
                 console.log('styleID');
                 console.log(styleID);
                 
                // console.log(Settings.color_style);
                // console.log(Settings.color_style[styleID]);
                if(Settings.color_style[styleID].price_list)
                {
                    var color_style_cost = Settings.color_style[styleID].price_list,
                        additional = this.rangePrice(color_style_cost, qty);
                    this.data.total_price += additional;
                }
                else
                {
                    return;
                } 
                   
        },
        _msgMoreThanCharLimit: function(qty) {
            if (qty <= 0) return;
            var price_list = Settings.messages.more_than_22_characters_price_list,
                additional_price = this.rangePrice(price_list, qty),
                array_el = ['front_message', 'back_message', 'inside_message', 'continues_message'];
            $('.alert-notify.more-than-char').remove();
            for (var i = 0; i < array_el.length; i++) {
                if (($('input[name="message_type"]:checked').val() == 'continues' &&
                    (array_el[i] == 'front_message' || array_el[i] == 'back_message')) ||
                    ($('input[name="message_type"]:checked').val() == 'front_and_back' &&
                    array_el[i] == 'continues_message')) {
                    continue;
                }
                var el  = $('input[name="'+ array_el[i] +'"]').val();
                if (el.length > Settings.messages.message_char_limit) {
                    this.data.total_price += additional_price * qty;
                    // Render alert message
                    var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each for more than {{limit}} characters.',
                        {
                            currency_symbol: Settings.currency_symbol,
                            price: additional_price,
                            limit: Settings.messages.message_char_limit
                        }
                    );
                    this.appendAlertMsg(tpl, 'input[name="'+ array_el[i] +'"]', 'more-than-char');
                }
            }
        },
        _backInsideMsg: function(qty) {
            if (qty <= 0) return;
            var array_el = ['back_message', 'inside_message'];
            $('.alert-notify.each-message').remove();
            for (var i = 0; i < array_el.length; i++) {
                var len = $('input[name="' + array_el[i] + '"]').val().length;
                if (len > 0) {
                    var price_list = Settings.messages[array_el[i] + '_price_list'];
                    if (price_list != undefined) {
                        var additional_price = this.rangePrice(price_list, qty);
                        this.data.total_price += additional_price * qty;
                        // Render alert message
                        var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each.',
                            {
                                currency_symbol: Settings.currency_symbol,
                                price: additional_price,
                            }
                        );
                        this.appendAlertMsg(tpl, 'input[name="'+ array_el[i] +'"]', 'each-message');
                    }
                }
            }
        },
        _additionalOptions: function(qty) {
            $('input[name="additional_option[]"]:checked').each(function() {
                var price_list = Settings['additional_options'][$(this).data('key')].price_list,
                    costType = Settings['additional_options'][$(this).data('key')].cost_type,
                    additional_price = Builder.rangePrice(price_list, qty);

                $(this).closest('.checkbox').closest('.checkbox').find('.each-message').remove();
                if (additional_price > 0) {
                    if(costType == 'Each Quantity')
                    {
                          Builder.data.total_price += additional_price * qty;
                    // Render alert message
                    var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each.',
                        {
                            currency_symbol: Settings.currency_symbol,
                            price: additional_price,
                        }
                    );
                    Builder.appendAlertMsg(tpl, $(this).closest('.checkbox'), 'each-message');
                    }
                    else
                    {

                    Builder.data.total_price += additional_price;
                    // Render alert message
                    var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} per order.',
                        {
                            currency_symbol: Settings.currency_symbol,
                            price: additional_price,
                        }
                    );
                    Builder.appendAlertMsg(tpl, $(this).closest('.checkbox'), 'per-order');
                    }
                }   
            });
        },
        _customizationLocation: function() {
            var location = $('input[name="customization_location"]:checked').val(),
                additional_price = toFloat(Settings.customization.location[location].price);

            if (additional_price <= 0) return;

            this.data.total_price += additional_price;
            // Render alert message
            var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each.',
                {
                    currency_symbol: Settings.currency_symbol,
                    price: additional_price,
                }
            );

            $('.customization_location.each-message').remove();
            this.appendAlertMsg(tpl, $('input[name="customization_location"]:checked').closest('label'), 'customization_location each-message');
        },
        _customizationDate: function() {
            $('select.customization-date-select option:selected').each(function() {
                var additional_price = $(this).data('price');
                additional_price = toFloat(additional_price);
                Builder.data.total_price += additional_price == undefined ? 0 : additional_price;
            });
        },
        _clipart: function(qty) {
            if (qty <= 0) return;
            // Check if there are any cliparts uploaded/selected
            var flag = false;
            for (var i in this.data.clipart) {
                if (this.data.clipart[i] != '' && Builder.data.clipart[i] != undefined) {
                    flag = true;
                    break;
                }
            }
            if (! flag) return;

            var price_list =  Settings.logo.prices,
                additional_price = this.rangePrice(price_list, qty);
            this.data.total_price += additional_price * qty;

            // Render alert message
            var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each.',
                {
                    currency_symbol: Settings.currency_symbol,
                    price: additional_price,
                }
            );

            $('.clipart.each-message').remove();
            this.appendAlertMsg(tpl, '#add-clipart > .form-group-heading', 'clipart each-message');
        },
        /**=========================================================================
         * End Prices Collection
         *==========================================================================*/

    };

    // Convert string to integer
    function toInt(n) {
        n = parseInt(n);
        return isNaN(n) ? 0 : n;
    }
    // Convert string to float
    function toFloat(n) {
        n = parseFloat(n);
        return isNaN(n) ? 0 : n;
    }
    // Format number to 2 decimal places
    function numberFormat(n, f) {
        if (n == undefined) return 0;
        f = f == undefined ? 2 : f;
        n = parseFloat(n);
        f = parseInt(f);

        return  n.toFixed(f).replace(/./g, function(c, i, a) {
            return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
        });
    }
    // Check if file is image
    function isImg(file) {
        if (file == undefined) return false;
        return file.match(/\.(jpeg|jpg|png|gif)$/) != null;
    }

    // Loop not added color and make it as a default selected color the first color in the loop
    function wctColorEnable() {
        $('#wristband-color-tab li.color-enabled').each(function(){
            $(this).find('div.color-wrap').addClass('selected');
            return false;
        });
    }

    function wbTextColor() {
        var SetColor = $('#wristband-text-color div.selected').find('div').data('color');
        if(SetColor == undefined) {
            if (document.getElementById("bandtext")){
                document.getElementById("bandtext").style.fill = '#999999';
                document.getElementById("bandtext").style.opacity = "0.4";
            }
        } else {
            document.getElementById("bandtext").style.fill = SetColor;
            document.getElementById("bandtext").style.opacity = "1";
        }
    }

    //Display the default message option which front, back & inside
    function messageOptionDisplay(value) {
        if (value == "front_and_back"){ 
            $("#ForFrontBackID").css({display: 'block'}); 
            $("#ForContiID").css({display: 'none'}); 
        } else { 
            $("#ForFrontBackID").css({display: 'none'}); 
            $("#ForContiID").css({display: 'block'});
        }

        $('[class*="hide-if-message_type-"]').css({display: 'block'});
        $('.hide-if-message_type-' + value).css({'display': 'none'});
        $('[class*="if-message_type_is-"]').css({display: ''});
        $('.if-message_type_is-' + value).css({display: 'none'});
    }

    function TempReloadSVG(){
        var ContainerID =  document.getElementById("preview_container")
        var Temp = ContainerID.innerHTML;
        ContainerID.innerHTML = Temp;
    }

    function ChangeStyle(val){
        switch (val) { 
                case 'Imprinted': 
                        $("#bandtext").css({textShadow: "0 0 0"});
                        break;
                case 'Debossed': 
                        //$("#bandtext").css({textShadow: "0 1.5px 0 black"});
                        $("#bandtext").css({textShadow: "0px -1px 1px black"});
                        break;
                case 'Embossed': 
                        $("#bandtext").css({textShadow: "rgba(255, 255, 255, 0.1) -2px -2px 2px, rgba(0, 0, 0, 0.5) 2px 2px 2px"});
                        break;      
                default:
                        $("#bandtext").css({textShadow: "0 0 0"});
        } 
    }

    function StartEdit(){
        var val = document.getElementById('EditModeID').name;
        val = val.split("|");



        var MultiAdd = val[2];

        SetWristStyel(val[0]);
        SetWristSize(val[1]);
        EditAdditionalColor(MultiAdd);
    }

    function SetWristStyel(Style){
        var sel = document.getElementById('style');
        for(var i = 0, j = sel.options.length; i < j; ++i) {
            if(sel.options[i].innerHTML === Style) {
               sel.selectedIndex = i;
               break;
            }
        }
    }

    function SetWristSize(Size){
        var sel = document.getElementById('width');
        for(var i = 0, j = sel.options.length; i < j; ++i) {
            if(sel.options[i].innerHTML === Size) {
               sel.selectedIndex = i;
               break;
            }
        }
    }

    function EditAdditionalColor(MultiAdd){
        //milbert
        var SplitItem = MultiAdd.split("~");
        for(var x=0;x<=SplitItem.length;x++){
            var TempSplit = SplitItem[x].split("^");
            
            var bg_style_tpl = '<div class="{{hide}}"><div class="color-wrap color-added">'
                             + '<div data-color="{{bg_color}}" style="background-color:{{bg_color}};' 
                             + 'background: -webkit-linear-gradient(90deg,{{bg_color}});background: -o-linear-gradient(90deg,{{bg_color}});' 
                             + 'background: -moz-linear-gradient(90deg,{{bg_color}});background: linear-gradient(90deg,{{bg_color}});"></div></div>{{qty}}</div>';
            var bg_style_tpl_text = '<div class="{{hide}}"><div class="color-wrap colortext--wrap color-text-added" ' 
                                  + 'style="display:{{style_display}}" ><div data-color="{{bg_color}}" style="background-color:{{bg_color}}; ' 
                                  + 'background: -webkit-linear-gradient(90deg,{{bg_color}});background: -o-linear-gradient(90deg,{{bg_color}}); ' 
                                  + 'background: -moz-linear-gradient(90deg,{{bg_color}});background: linear-gradient(90deg,{{bg_color}});"></div></div>{{qty}}</div>';
                 
            var BoxColor = Mustache.render(bg_style_tpl, {hide: '', bg_color: TempSplit[2], qty: ''});
            var BoxTextColor = "";

            if ( TempSplit[4] != null ) {
                BoxTextColor = Mustache.render(bg_style_tpl_text, {hide: '',style_display: 'inline-block', bg_color: TempSplit[4], qty: ''});
            } else  {
                BoxTextColor = Mustache.render(bg_style_tpl_text, {hide: '',style_display: 'none', bg_color: TempSplit[4], qty: ''});
            }

            Builder.addColor(TempSplit[0], {
                name: TempSplit[0],
                color: TempSplit[2],
                type: TempSplit[1],
                text_color_name: TempSplit[3],
                text_color: TempSplit[4],
                sizes: {
                    adult: toInt(TempSplit[5]),
                    medium: toInt(TempSplit[6]),
                    youth: toInt(TempSplit[7]),
               }
            });

            var row_tpl = Mustache.render(
                '<tr data-name="{{name}}" class="option-tr">'
                + '<td><center>{{{adult_qt}}}</center></td>'
                + '<td><center>{{{medium_qty}}}</center></td>'
                + '<td><center>{{{youth_qty}}}</center></td>'
                + '<td><center>{{{wristband_color_box}}}</center></td>'
                + '<td><center>{{{wristband_text_color_box}}}</center></td>'
                + '<td><a href="#" id="edit" data-name="{{name}}" class="edit-selection"><i class="fa fa-pencil"></i></a><a href="#" class="delete-selection"><i class="fa fa-trash"></i></a></td>'
                + '</tr>',
                {
                    name        : TempSplit[0],
                    adult_qt    : TempSplit[5],
                    medium_qty   : TempSplit[6],
                    youth_qty    : TempSplit[7],
                    wristband_color_box     : BoxColor,
                    wristband_text_color_box : BoxTextColor,
               }
            );

            var $tr = $('#selected_color_table > tbody tr[data-name="'+ TempSplit[0] +'"]');
            if ($tr.length) { $tr.replaceWith(row_tpl); } 
            else { $('#selected_color_table > tbody').append(row_tpl); }

             Builder.renderProductionShippingOptions();
        }
    }

    function DistributeAddup(){
        var TempCnt = Builder.CntID;
        if (TempCnt > 0){
            var CntDis = 0,
                ArrayID = [],
                CntTemp = 0;
            for(var x=0;x<= TempCnt;x++){
                if (document.getElementById("inpAdult-" + x)){
                    if (toInt($("#inpAdult-" + x).val()) > 0){
                        ArrayID[CntTemp] = "spanAdultup-" + x;
                        CntTemp++;
                    } 

                    if (toInt($("#inpMedium-" + x).val()) > 0){
                        ArrayID[CntTemp] = "spanMediumup-" + x;
                        CntTemp++;
                    }

                    if (toInt($("#inpYouth-" + x).val()) > 0){
                        ArrayID[CntTemp] = "spanYouthup-" + x;
                        CntTemp++;
                    }
                    $("#spanAdultup-" + x).html("");
                    $("#spanMediumup-" + x).html("");
                    $("#spanYouthup-" + x).html("");
                }
            }

              var b = 100,      c = ArrayID.length,
                  d = 100%c,    e = b - d,
                  f = e / c,    g = f + d,
                  first = true;

            for(var a=0;a <= ArrayID.length-1;a++){
                if (first){
                    $("#" + ArrayID[a]).html("&nbsp; ( +" + g + " )");
                    first = false;
                } else { $("#" + ArrayID[a]).html("&nbsp; ( +" + f + " )"); }
            }
        }
    }



    $(document).ready(function() {

        $(document.body)

            .on('click','.prdct-info', function() {

                var slctd_product = Settings.products[$('#style').val()];
                console.log(slctd_product);
                Builder.popupProductInfo('info', slctd_product.product_title, slctd_product.product_content);


                // var img = Pablo.image(preview_container);
                // console.log('pabloimage');
               

                // var svgDiv = $("#svgelement");
                 
                // var svg = svgDiv[0].outerHTML;

                //  console.log(svg);
                // var canvas = document.getElementById('hiddenCanvas');
                //  canvg(canvas, svg);
                 
                // var theImage = canvas.toDataURL('image/png');
                // $("#hiddenPng").attr('href', theImage);
              //$("#hiddenPng").click();

                return;
            })
            // Get Product sizes on style changed
            .on('change', 'select[name="style"]', function(e) {
                var textStyle = this.options[this.selectedIndex].text;
                ChangeStyle(textStyle);

                e.preventDefault();
               // Builder.reset();
                var slctd_product = Settings.products[this.value],
                    i = [],
                    slctd_style = $(this).val(),
                    color_lists = Builder.getColorLists();

                // console.log(slctd_product);
                if (slctd_product != undefined) {
                    $('#wbc_add_to_cart').removeAttr('disabled');

                    $('select#width').empty().removeAttr('disabled');

                    for( var size in slctd_product.sizes)
                     {
                        i.push(slctd_product.sizes[size].count);
                     } 
                        
                     var hold_index_sort = i.sort();

                    for( var index_size in hold_index_sort)
                     {

                        for(var size in slctd_product.sizes)
                        {
                            if(index_size == slctd_product.sizes[size].count )
                            {
                                var $option = $('<option>').val(size).text(size);
                                                       
                                    if (size == slctd_product.default_size)
                                        {
                                            $option = $('<option>').val(size).attr('selected','selected').text(size).attr('data-group', Builder.getSizeGroup(size));
                                        }
                                        else
                                        {
                                            $option.attr('data-group', Builder.getSizeGroup(size));   
                                        }                      
                                    
                                    $('select#width').append($option);
                                    break;
                            }
                        }

                     } 

                    $('select#width option:first-child').trigger('change');

                    Builder.init();
                    $('#wristband-text-color ul').empty();
                   

                    if ( slctd_product.text_color) {
                        $('#wristband-text-color').closest('.form-group').show();

                        for (var i in slctd_product.text_color) {
                            if(i == 0 && slctd_product.text_color[0].name !=  '') {
                                var default_tc = slctd_product.text_color[0].name; // set if there is default text color set on the backend.
                            }

                            var tpl = '<li><div class="color-wrap '+ (i == 0 ? 'selected' : '') +'"><div data-name="{{name}}" data-color="{{color}}" style="background-color:{{color}};"></div></div></li>';
                            var render = Mustache.render(tpl, {
                                name: slctd_product.text_color[i].name,
                                color: slctd_product.text_color[i].color
                            });
                            $('#wristband-text-color ul').append(render);

                        }
                        
                        Builder.updateColor('', {name: '',
                                                   color: '',
                                                   type: '',
                                                   text_color: slctd_product.text_color[0].color,
                                                   text_color_name: slctd_product.text_color[0].name,
                                                   sizes: {
                                                        adult: '',
                                                        medium: '',
                                                        youth: '',
                                                    }
                                                 });
                
                   } else {
                        $('#wristband-text-color').closest('.form-group').hide();
                        Builder.updateColor('', {name: '',
                                                      color: '',
                                                      type: '',
                                                      text_color: '#FFFFFF',
                                                      text_color_name: 'White',
                                                      sizes: {
                                                            adult: '',
                                                            medium: '',
                                                            youth: '',
                                                        }
                                                    });

                   }
                    messageOptionDisplay($('input[name="message_type"]:checked').val()); // display the default message option which front, back & inside
                    wbTextColor(); //display the text color in the wristband preview

                    //get the color list and update the additional color table list
                    var lists = Builder.getColorLists();
                    Builder.CntID = 0;
                    var TempID = Builder.CntID;
                    for (var index in lists) {
                        var bg_style_tpl =  '<div class="{{hide}}"><div class="color-wrap color-added"><div data-color="{{bg_color}}" ' + 
                                            'style="background-color:{{bg_color}};background: -webkit-linear-gradient(90deg,{{bg_color}});' +
                                            'background: -o-linear-gradient(90deg,{{bg_color}});background: -moz-linear-gradient(90deg,{{bg_color}});' + 
                                            'background: linear-gradient(90deg,{{bg_color}});"></div>&nbsp;<span class="SpanColorbox">' + lists[index].name + '</span></div>{{qty}}</div>',
                        bg_style_tpl_text = '<div class="{{hide}}"><div class="color-wrap colortext--wrap color-text-added" style="display:{{style_display}}" ' +
                                            '><div data-color="{{bg_color}}" style="background-color:{{bg_color}};background: -webkit-linear-gradient(90deg,{{bg_color}});' +
                                            'background: -o-linear-gradient(90deg,{{bg_color}});background: -moz-linear-gradient(90deg,{{bg_color}});' +
                                            'background: linear-gradient(90deg,{{bg_color}});"></div></div>{{qty}}</div>';
                 
                        var _wristband_color_box    = Mustache.render(bg_style_tpl, {hide: '', bg_color: lists[index].color, qty: ''}),
                        _wristband_text_color_box = '';

                        if ( lists[index].text_color != null ){
                            _wristband_text_color_box = Mustache.render(bg_style_tpl_text, {hide: '',style_display: 'inline-block', bg_color: lists[index].text_color, qty: ''});
                        } else {
                            _wristband_text_color_box = Mustache.render(bg_style_tpl_text, {hide: '',style_display: 'none', bg_color: lists[index].text_color, qty: ''});
                        }

                        var  $tr = $('#selected_color_table > tbody tr[data-name="'+ lists[index].name +'"]'); 
                        var row_tpl = Mustache.render(
                            '<tr data-name="{{name}}" class="option-tr" id="Tr-' + TempID + '">'
                            + '<td style="text-align: left" id="colorBox-' + TempID + '">{{{wristband_color_box}}}</td>'
                            + '<td><center><span id="spanAdult-' + TempID +'">{{{adult_qt}}}</span><span id="spanAdultup-' + TempID + '" class="CssAddup"></span><input type="number" min="0" class="input-text fusion-one-third InpCss" id="inpAdult-' + TempID + '" value="{{{adult_qt}}}"></center></td>'
                            + '<td><center><span id="spanMedium-' + TempID +'">{{{medium_qty}}}</span><span id="spanMediumup-' + TempID + '" class="CssAddup"></span><input type="number" min="0" class="input-text fusion-one-third InpCss" id="inpMedium-' + TempID + '" value="{{{medium_qty}}}"></center></td>'
                            + '<td><center><span id="spanYouth-' + TempID +'">{{{youth_qty}}}</span><span id="spanYouthup-' + TempID + '" class="CssAddup"></span><input type="number" min="0" class="input-text fusion-one-third InpCss" id="inpYouth-' + TempID + '" value="{{{youth_qty}}}"></center></td>'
                            + '<td style="text-align: center" id="colorTextBox-' + TempID + '"><center>{{{wristband_text_color_box}}}</center></td>'
                            + '<td style="text-align: right;"><a href="#" id="EditID-' + TempID +'"  data-name="{{name}}" class="edit-selection" data-tempID="' + TempID +'">Edit</a><a id="DelID-' + TempID +'" href="#" class="delete-selection" data-tempID="' + TempID +'" data-name="{{name}}" >Delete</a></td>'
                            + '</tr>',
                            {
                                name         : lists[index].name,
                                adult_qt     : lists[index].sizes['adult'],
                                medium_qty   : lists[index].sizes['medium'],
                                youth_qty    : lists[index].sizes['youth'],
                                wristband_color_box     : _wristband_color_box,
                                wristband_text_color_box : _wristband_text_color_box,
                           }
                        );
                        $tr.replaceWith(row_tpl);
                    TempID++;
                    }


                    if(slctd_product.text_color) {
                        $('.colortext--wrap').show(); // show text color in the additional table list
                        $('.text_to_alter').show();   // show th color in the additional table list
                         wbTextColor();
                    } else {
                        $('.colortext--wrap').hide(); // hide text color in the additional table list
                        $('.text_to_alter').hide();   // hide text color in the additional table list
                    }
                }
                var width = $("#width").val();
                $("#SelectStyleID").html(textStyle + "&nbsp;-" + width);
            })
            // Populate width dropdown
            .on('change', 'select#width', function() {
                var tempSelect = document.getElementById("style");
                var tempVal = tempSelect.options[tempSelect.selectedIndex].text;

                $("#SelectStyleID").html(tempVal + "&nbsp;-" + $(this).val());

                Builder.reset();
                Builder.additionalOptionsShow(this.value);
                Builder.init();
                Builder.renderProductionShippingOptions();
            })
            // Hide/Show message type fields
            .on('change', 'input[name="message_type"]', function() {
                if (this.checked) {

                    messageOptionDisplay(this.value); // display the default message option which front, back & inside
                }
            })
            // Message character limit
            .on('keyup', '.trigger-limit-char', function(e) {
                var limit       = $(this).data('limit'),
                    cur_len     = $(this).val().length,
                    cur_name    = $(this).attr('name'),
                    char_left   = limit - cur_len;
                if (char_left < 0) char_left = 0;

                $('.' + cur_name + '_chars_left').text(char_left);
            })

            // Wristband color style tab
            .on('shown.bs.tab', '#wristband-color-tab li a[data-toggle="tab"]', function() {
                $(this).find('input[type=radio]').attr('checked', true);
            })

            // Text Color Selection
            .on('click', '#wristband-text-color .color-wrap', function() {
                var tbl_color = $('.edit-selection').find('.fa-undo').closest('a').data('name');
                
                if(tbl_color){
                     $('#wristband-text-color .color-wrap').removeClass('selected');
                     $(this).addClass('selected');
                    return;
                } 
                $('#wristband-text-color .color-wrap').removeClass('selected');
                $(this).addClass('selected');

                //display the text color in the wristband preview;
                 wbTextColor();
                $('#qty_adult, #qty_medium, #qty_youth').trigger('keyup');
                Builder.observer();
            })

            // Wristband Color Selection
            .on('click', '#wristband-color-items .color-wrap', function() {

                var tbl_color = $('.edit-selection').find('.fa-undo').closest('a').data('name');

                if(tbl_color){

                    $('#wristband-color-items .color-wrap').removeClass('selected');
                    $(this).addClass('selected');
                    return;
                } 

                if ($(this).hasClass('added') ) return;
                $('#wristband-color-items .color-wrap').removeClass('selected');
                $(this).addClass('selected');
                $('#qty_adult, #qty_medium, #qty_youth').trigger('keyup');
                Builder.observer();
            })
            .on('keyup mouseup', '#qty_adult, #qty_medium, #qty_youth', function() {
                $('.alert-notify.each-message').remove(); //remove old price message

                var tbl_color = $('.edit-selection').find('.fa-undo').closest('a').data('name');

                var $wc = $('#wristband-color-tab .color-wrap.selected > div'),
                    $tc = $('#wristband-text-color .color-wrap.selected > div'),
                    $aq    = $('#qty_adult'),
                    $mq    = $('#qty_medium'),
                    $yq    = $('#qty_youth');
                  
                if($aq.val() <= 0 && $mq.val() <= 0 && $yq.val() <= 0) {
                     
                      $('#price_handler').text('0.00');
                      $('#qty_handler').text('0');

                }

                // ($('#wristband-text-color ul li').length && $tc.length == 0) ||
                if ($wc.length == 0 || (toInt($aq.val()) <= 0 && toInt($mq.val()) <= 0 && toInt($yq.val()) <= 0)) 
                {
                    return;
                }

                if(tbl_color == undefined) {
                   //do this process if it's not updating the additional table list     
                   Builder.addColor($wc.data('name'), {
                        name: $wc.data('name'),
                        color: $wc.data('color'),
                        type: $('input[name="color_style"]:checked').val(),
                        text_color_name: $tc.data('name'),
                        text_color: $tc.data('color'),
                        sizes: {
                            adult: toInt($aq.val()),
                            medium: toInt($mq.val()),
                            youth: toInt($yq.val()),
                        },
                        temp: true, // This is for temporary color during keyup
                    });
                    Builder.renderProductionShippingOptions();

                } 
            })
            .on('click', '#add_color_to_selections', function(e) {
                e.preventDefault();
                Builder.CntID++;

                var $wc = $('#wristband-color-tab .color-wrap.selected > div'),
                    $tc = $('#wristband-text-color .color-wrap.selected > div'),
                    bg_style_tpl = '<div class="{{hide}}"><div class="color-wrap color-added"><div data-color="{{bg_color}}" style="background-color:{{bg_color}};background: -webkit-linear-gradient(90deg,{{bg_color}});background: -o-linear-gradient(90deg,{{bg_color}});background: -moz-linear-gradient(90deg,{{bg_color}});background: linear-gradient(90deg,{{bg_color}});"></div>&nbsp;<span class="SpanColorbox">' + $wc.data('name') + '</span></div>{{qty}}</div>',
                    bg_style_tpl_text = '<div class="{{hide}}"><div class="color-wrap colortext--wrap color-text-added" style="display:{{style_display}}" ><div data-color="{{bg_color}}" style="background-color:{{bg_color}};background: -webkit-linear-gradient(90deg,{{bg_color}});background: -o-linear-gradient(90deg,{{bg_color}});background: -moz-linear-gradient(90deg,{{bg_color}});background: linear-gradient(90deg,{{bg_color}});"></div></div>{{qty}}</div>',
                    $aq    = $('#qty_adult'),
                    $mq    = $('#qty_medium'),
                    $yq    = $('#qty_youth');


                var _adult_qty   = numberFormat(toInt($aq.val()), 0),
                    _medium_qty  = numberFormat(toInt($mq.val()), 0),
                    _youth_qty   = numberFormat(toInt($yq.val()), 0),
                    _wristband_color_box    = Mustache.render(bg_style_tpl, {hide: '', bg_color: $wc.data('color'), qty: ''}),
                    _wristband_text_color_box = '';

                    if ( $tc.data('color') != null ) {
                        _wristband_text_color_box = Mustache.render(bg_style_tpl_text, {hide: '',style_display: 'inline-block', bg_color: $tc.data('color'), qty: ''});
                    } else  {
                        _wristband_text_color_box = Mustache.render(bg_style_tpl_text, {hide: '',style_display: 'none', bg_color: $tc.data('color'), qty: ''});
                    }


                if ($wc.length == 0 || (toInt($aq.val()) <= 0 && toInt($mq.val()) <= 0 && toInt($yq.val()) <= 0)) {
                    Builder.popupMsg('error', 'Error', 'Please select wristband color/text color/quantity.');
                    return;
                }

                Builder.addColor($wc.data('name'), {
                    name: $wc.data('name'),
                    color: $wc.data('color'),
                    type: $('input[name="color_style"]:checked').val(),
                    text_color_name: $tc.data('name'),
                    text_color: $tc.data('color'),
                    sizes: {
                        adult: toInt($aq.val()),
                        medium: toInt($mq.val()),
                        youth: toInt($yq.val()),
                   }
                });

                var TempID = Builder.CntID; 
                var row_tpl = Mustache.render(
                    '<tr data-name="{{name}}" class="option-tr" id="Tr-' + TempID + '">'
                    + '<td style="text-align: left" id="colorBox-' + TempID + '"><div class="DivColorBox">{{{wristband_color_box}}}</div></td>'
                    + '<td style="text-align: center"><center><span style="font-weight: bold;" id="spanAdult-' + TempID +'">{{{adult_qt}}}</span><span id="spanAdultup-' + TempID + '"></span><input type="number" min="0" class="input-text fusion-one-third InpCss" id="inpAdult-' + TempID + '" value="{{{adult_qt}}}"></center></td>'
                    + '<td style="text-align: center"><center><span style="font-weight: bold;" id="spanMedium-' + TempID +'">{{{medium_qty}}}</span><span id="spanMediumup-' + TempID + '"></span><input type="number" min="0" class="input-text fusion-one-third InpCss" id="inpMedium-' + TempID + '" value="{{{medium_qty}}}"></center></td>'
                    + '<td style="text-align: center"><center><span style="font-weight: bold;" id="spanYouth-' + TempID +'">{{{youth_qty}}}</span><span id="spanYouthup-' + TempID + '"></span><input type="number" min="0" class="input-text fusion-one-third InpCss" id="inpYouth-' + TempID + '" value="{{{youth_qty}}}"></center></td>'
                    + '<td style="text-align: center" id="colorTextBox-' + TempID + '"><center>{{{wristband_text_color_box}}}</center></td>'
                    //+ '<td><a href="#" id="edit" data-name="{{name}}" class="edit-selection"><i class="fa fa-pencil"></i></a><a href="#" class="delete-selection"><i class="fa fa-trash"></i></a></td>'
                    + '<td style="text-align: right;"><a href="#" id="EditID-' + TempID +'"  data-name="{{name}}" class="edit-selection" data-tempID="' + TempID +'">Edit</a><a id="DelID-' + TempID +'" href="#" class="delete-selection" data-tempID="' + TempID +'" data-name="{{name}}" >Delete</a></td>'
                    + '</tr>',
                    {
                        name        : $wc.data('name'),
                        adult_qt    : _adult_qty,
                        medium_qty   : _medium_qty,
                        youth_qty    : _youth_qty,
                        wristband_color_box     : _wristband_color_box,
                        wristband_text_color_box : _wristband_text_color_box,
                   }
                );

                var $tr = $('#selected_color_table > tbody tr[data-name="'+ $wc.data('name') +'"]');
                    if ($tr.length) { $tr.replaceWith(row_tpl); } 
                    else { $('#selected_color_table > tbody').append(row_tpl); }

                $wc.closest('.color-wrap').addClass('added');
                $wc.closest('li').removeClass('color-enabled');
                $wc.closest('li').addClass('color-disabled');
                $('#wristband-color-items .color-wrap, #wristband-text-colors .color-wrap').removeClass('selected');

                //loop not added color and make it as a default selected color the first color in the loop
                wctColorEnable();
                
                $('#qty_adult, #qty_medium, #qty_youth').val('');
                $(this).find('.fusion-button-text').text('Add');
                $('#qty_adult, #qty_medium, #qty_youth').trigger('keyup');
                DistributeAddup();//Addup
                Builder.renderProductionShippingOptions();
                return false;
            })

            .on('click', '.delete-selection', function(e) {
                e.preventDefault();
                
                var Stat = $(this).html();
                var TempId = $(this).attr( "data-tempID" );

                if (Stat == "Cancel"){
                    $('.option-tr').removeClass('is-disabled'); // allow all additional option to be editable
                    $("#EditID-" + TempId).html("Edit");
                    $(this).html("Delete");

                    $("#spanAdult-" + TempId).show();
                    $("#spanMedium-" + TempId).show();
                    $("#spanYouth-" + TempId).show();

                    $("#inpAdult-" + TempId).hide();
                    $("#inpMedium-" + TempId).hide();
                    $("#inpYouth-" + TempId).hide();

                } else {
                    e.preventDefault();
                    var $row = $(this).closest('tr');
                    var color_name = $(this).attr('data-name')
                    //return;

                    $('#qty_adult, #qty_medium, #qty_youth').trigger('keyup');

                    // Remove "added" class in wristband colors
                    $('#wristband-color-tab  div[data-name^="'+ $row.data('name')  +'"]').closest('.color-wrap').removeClass('added');
                    // Remove all "selected" class in wristband colors
                    $('#wristband-color-tab  .color-wrap').removeClass('selected');

                    $('#wristband-color-tab  div[data-name^="'+ $row.data('name')  +'"]').closest('li').removeClass('color-disabled'); 
                    $('#wristband-color-tab  div[data-name^="'+ $row.data('name')  +'"]').closest('li').addClass('color-enabled'); 

                    //loop not added color and make it as a default selected color the first color in the loop
                    wctColorEnable();

                    //Remove it on the additional color table list
                    $row.remove();
                    DistributeAddup();//Addup
                    // Remove color from selections
                    Builder.removeColor(color_name);
                    return false;
                }
            })

            .on('click', '.edit-selection', function(e) {
                e.preventDefault();
                var Stat = this.innerHTML;
                var TempId = $(this).attr( "data-tempID" );


                var color_name = $(this).attr('data-name'),
                    i = Builder.getColorIndex(color_name),
                    color   = Builder.data.colors[i];



                if (Stat == "Edit"){
                    $("#DelID-" + TempId).html("Cancel");
                    $(this).html("Save");

                    $("#spanAdult-" + TempId).hide();
                    $("#spanMedium-" + TempId).hide();
                    $("#spanYouth-" + TempId).hide();

                    $("#spanAdultup-" + TempId).hide();
                    $("#spanMediumup-" + TempId).hide();
                    $("#spanYouthup-" + TempId).hide();

                    $("#inpAdult-" + TempId).show();
                    $("#inpMedium-" + TempId).show();
                    $("#inpYouth-" + TempId).show();

                    $("#inpAdult-" + TempId).val($("#spanAdult-" + TempId).html());
                    $("#inpMedium-" + TempId).val($("#spanMedium-" + TempId).html());
                    $("#inpYouth-" + TempId).val($("#spanYouth-" + TempId).html());

                    $('.option-tr').addClass('is-disabled'); // disable all additioanl option to be editable first
                    $(this).closest('tr').removeClass('is-disabled'); // enable to specific additional option to be editable

                    $('#wristband-color-tab  div[data-name^="'+ color_name  +'"]').closest('.color-wrap').removeClass('added');
                    $('#wristband-color-tab  div[data-name^="'+ color_name  +'"]').closest('.color-wrap').addClass('selected');

                    $('.color-wrap').removeClass('selected');
                    $('#wristband-color-items .color-wrap > div[data-name^="'+ color_name +'"]').closest('.color-wrap').addClass('selected');
                    $('#wristband-text-color .color-wrap > div[data-name^="'+ color.text_color_name +'"]').closest('.color-wrap').addClass('selected');
                } else {
                    var tbl_color = $(this).attr('data-name');
                    var $wc = $('#wristband-color-tab .color-wrap.selected > div'),
                        $tc = $('#wristband-text-color .color-wrap.selected > div'),
                        bg_style_tpl = '<div class="{{hide}}"><div class="color-wrap color-added"><div data-color="{{bg_color}}" style="background-color:{{bg_color}};background: -webkit-linear-gradient(90deg,{{bg_color}});background: -o-linear-gradient(90deg,{{bg_color}});background: -moz-linear-gradient(90deg,{{bg_color}});background: linear-gradient(90deg,{{bg_color}});"></div>&nbsp;<span class="SpanColorbox">' + $wc.data('name') + '</span></div>{{qty}}</div>',
                        bg_style_tpl_text = '<div class="{{hide}}"><div class="color-wrap colortext--wrap color-text-added" style="display:{{style_display}}" ><div data-color="{{bg_color}}" style="background-color:{{bg_color}};background: -webkit-linear-gradient(90deg,{{bg_color}});background: -o-linear-gradient(90deg,{{bg_color}});background: -moz-linear-gradient(90deg,{{bg_color}});background: linear-gradient(90deg,{{bg_color}});"></div></div>{{qty}}</div>';
                
                    var _wristband_color_box    = Mustache.render(bg_style_tpl, {hide: '', bg_color: $wc.data('color'), qty: ''}),
                        _wristband_text_color_box = '';

                    if ($wc.length == 0 || (toInt($("#inpAdult-" + TempId).val()) <= 0 && toInt($("#inpMedium-" + TempId).val()) <= 0 && toInt($("#inpYouth-" + TempId).val()) <= 0)) {
                        Builder.popupMsg('error', 'Error', 'Please select wristband color/text color/quantity.');
                        return;
                    }

                    if ( $tc.data('color') != null ) { _wristband_text_color_box = Mustache.render(bg_style_tpl_text, {hide: '',style_display: 'inline-block', bg_color: $tc.data('color'), qty: ''});
                    } else  { _wristband_text_color_box = Mustache.render(bg_style_tpl_text, {hide: '',style_display: 'none', bg_color: $tc.data('color'), qty: ''}); }

                    $("#colorBox-" + TempId).html(_wristband_color_box);
                    $("#colorTextBox-" + TempId).html(_wristband_text_color_box);

                    $("#spanAdult-" + TempId).html($("#inpAdult-" + TempId).val());
                    $("#spanMedium-" + TempId).html($("#inpMedium-" + TempId).val());
                    $("#spanYouth-" + TempId).html($("#inpYouth-" + TempId).val());


                    $("#spanAdult-" + TempId).show();
                    $("#spanMedium-" + TempId).show();
                    $("#spanYouth-" + TempId).show();

                    $("#spanAdultup-" + TempId).show();
                    $("#spanMediumup-" + TempId).show();
                    $("#spanYouthup-" + TempId).show();

                    $("#inpAdult-" + TempId).hide();
                    $("#inpMedium-" + TempId).hide();
                    $("#inpYouth-" + TempId).hide();

                    $("#DelID-" + TempId).html("Delete");
                    $(this).html("Edit");
                    
                    $('.option-tr').removeClass('is-disabled');

                    $(this).attr('data-name',$wc.data('name'));
                    $('DelID-' + TempId).attr('data-name',$wc.data('name'));

                    //if (tbl_color){ tbl_color = $wc.data('name'); }
                    Builder.updateColor(tbl_color, {
                                                    name: $wc.data('name'),
                                                    color: $wc.data('color'),
                                                    type: $('input[name="color_style"]:checked').val(),
                                                    text_color: ($tc.data('color') == null)? '#FFFFFF' : $tc.data('color'),
                                                    text_color_name: ($tc.data('name') == null)? 'White' : $tc.data('name'),
                                                    sizes: {
                                                        adult: toInt($("#inpAdult-" + TempId).val()),
                                                        medium:toInt($("#inpMedium-" + TempId).val()),
                                                        youth: toInt($("#inpYouth-" + TempId).val()),
                                                   }
                                                });
                    if (tbl_color != $wc.data('name')){ $('#wristband-color-tab  div[data-name^="'+ tbl_color  +'"]').closest('.color-wrap').removeClass('added'); }
                    $wc.closest('.color-wrap').addClass('added');
                    wctColorEnable();
                    DistributeAddup();//Addup
                }
            })
            
            .on('click','.edit-button-text',function(e){

                e.preventDefault();
                var $row = $(this).closest('tr');
                // Remove color from selections
              //  Builder.removeColor($row.data('name'));
                // Remove "added" class in wristband colors
                $('#wristband-color-tab  div[data-name^="'+ $row.data('name')  +'"]').closest('.color-wrap').removeClass('added selected');
                $row.remove();
                return false;
            })
            .on('click', '#edit-button-text',function(e) {
                e.preventDefault();
                
                var tbl_color = $('.edit-selection').find('.fa-undo').closest('a').data('name'),
                    slctd_product = Settings.products[$('#style').val()];
 
                var $aq    = $('#qty_adult'),
                    $mq    = $('#qty_medium'),
                    $yq    = $('#qty_youth'),
                    $tc    = $('#wristband-text-color .color-wrap.selected > div'),
                    $wc    = $('#wristband-color-tab .color-wrap.selected > div');

               
                Builder.updateColor(tbl_color, {
                                                name: $wc.data('name'),
                                                color: $wc.data('color'),
                                                type: $('input[name="color_style"]:checked').val(),
                                                text_color: ($tc.data('color') == null)? '#FFFFFF' : $tc.data('color'),
                                                text_color_name: ($tc.data('name') == null)? 'White' : $tc.data('name'),
                                                sizes: {
                                                    adult: toInt($aq.val()),
                                                    medium:toInt($mq.val()),
                                                    youth: toInt($yq.val()),
                                               }
                                            });

                    $('#selected_color_table > tbody').empty().html(''); //empty first the additional color table list

                    //get the color list and update the additional color table list
                    var lists = Builder.getColorLists();



                    for (var index in lists) {

                        var bg_style_tpl = '<div class="{{hide}}"><div class="color-wrap color-added"><div data-color="{{bg_color}}" style="background-color:{{bg_color}};background: -webkit-linear-gradient(90deg,{{bg_color}});background: -o-linear-gradient(90deg,{{bg_color}});background: -moz-linear-gradient(90deg,{{bg_color}});background: linear-gradient(90deg,{{bg_color}});"></div>&nbsp;' + lists[index].name + '</div>{{qty}}</div>', 
                            bg_style_tpl_text = '<div class="{{hide}}"><div class="color-wrap colortext--wrap color-text-added" style="display:{{style_display}}" ><div data-color="{{bg_color}}" style="background-color:{{bg_color}};background: -webkit-linear-gradient(90deg,{{bg_color}});background: -o-linear-gradient(90deg,{{bg_color}});background: -moz-linear-gradient(90deg,{{bg_color}});background: linear-gradient(90deg,{{bg_color}});"></div></div>{{qty}}</div>';

                        var _wristband_color_box    = Mustache.render(bg_style_tpl, {hide: '', bg_color: lists[index].color, qty: ''}),
                            _wristband_text_color_box = '';

                            if ( lists[index].text_color != null ){
                                
                                _wristband_text_color_box = Mustache.render(bg_style_tpl_text, {hide: '',style_display: 'inline-block', bg_color: lists[index].text_color, qty: ''});
                            } else {
                                _wristband_text_color_box = Mustache.render(bg_style_tpl_text, {hide: '',style_display: 'none', bg_color: lists[index].text_color, qty: ''});
                            }

                            var  $tr = $('#selected_color_table > tbody tr[data-name="'+ lists[index].name +'"]');
           
                            var row_tpl = Mustache.render(
                                        '<tr data-name="{{name}}" class="option-tr">'
                                        + '<td style="text-align: left">{{wristband_color_box}}}</td>'
                                        + '<td><center>{{{adult_qt}}}</center></td>'
                                        + '<td><center>{{{medium_qty}}}</center></td>'
                                        + '<td><center>{{{youth_qty}}}</center></td>'
                                        + '<td  style="text-align: center"><center>{{{wristband_text_color_box}}}</center></td>'
                                        + '<td><a href="#" id="edit" data-name="{{name}}" class="edit-selection"><i class="fa fa-pencil"></i></a><a href="#" class="delete-selection"><i class="fa fa-trash"></i></a></td>'
                                        + '</tr>',
                                        {
                                            name         : lists[index].name,
                                            adult_qt     : lists[index].sizes['adult'],
                                            medium_qty   : lists[index].sizes['medium'],
                                            youth_qty    : lists[index].sizes['youth'],
                                            wristband_color_box     : _wristband_color_box,
                                            wristband_text_color_box : _wristband_text_color_box,
                                       }
                                    );
                             $('#selected_color_table > tbody').append(row_tpl);
                    }

                 $wc.closest('.color-wrap').addClass('added');
                 
                 //loop not added color and make it as a default selected color the first color in the loop
                 wctColorEnable();

                 $('#qty_adult, #qty_medium, #qty_youth').val('');
                 $('#edit-button-text').attr('id','add_color_to_selections').html('<i class="fa fa-plus"></i> <span class="fusion-button-text">Add an additional color</span>');

               if(slctd_product.text_color) {
                    $('.colortext--wrap').show(); // show text color in the additional table list
                    $('.text_to_alter').show();   // show th color in the additional table list
                } else {
                    $('.colortext--wrap').hide(); // hide text color in the additional table list
                    $('.text_to_alter').hide();   // hide text color in the additional table list
                }

            })

            .on('click', '.color-added', function(e){
                var background = document.getElementById("bandcolor"); 
                background.style.fill = $(this).find('div').data('color');
            })

            .on('click', '.color-text-added', function(e){
                var $frontext   = document.getElementById("fronttext"),
                    $insidetext = document.getElementById("insidetext");

                $frontext.style.fill = $(this).find('div').data('color');
                $insidetext.style.fill = $(this).find('div').data('color');
                $frontext.style.opacity = "1"; 
                $insidetext.style.opacity = "1"; 
            })

            .on('click','.fa-undo-old', function(e){
                e.preventDefault();

                var color_name  = $(this).closest('tr').data('name');


                $('#wristband-color-tab  div[data-name^="'+ color_name  +'"]').closest('.color-wrap').removeClass('selected');
                $('#wristband-color-tab  div[data-name^="'+ color_name  +'"]').closest('.color-wrap').addClass('added');
                     
                $(this).removeClass('fa-undo').addClass('fa-pencil');
                $('#wristband-color-items .color-wrap, #wristband-text-colors .color-wrap').removeClass('selected');
                $('#qty_adult, #qty_medium, #qty_youth').val('');
                $('#edit-button-text').attr('id','add_color_to_selections').html('<i class="fa fa-plus"></i> <span class="fusion-button-text">Add an additional color</span>');
                return false;
            }) 

            .on('keyup', 'input[name="front_message"], input[name="continues_message"], input[name="back_message"], input[name="inside_message"]', function() {
               Builder.observer();



            })
            // Trigger change when message type is choosen
            .on('change', 'input[name="message_type"], .customization-date-select', function() {
                Builder.observer();
                TempReloadSVG();

                if (this.value == "continues"){
                        $('#icon_start').text( $('#wrap_start').text() );
                        $('#icon_end').text( $('#wrap_end').text() );
                } else {
                    if (Builder.data.clipart.view_position == "front"){
                        $('#icon_start').text( $('#front_start').text() );
                        $('#icon_end').text( $('#front_end').text() );
                    } else {
                        $('#icon_start').text( $('#back_start').text() );
                        $('#icon_end').text( $('#back_end').text() );
                    }
                }
                
               // Builder.observer();
            })

            .on('show.bs.modal', '#wristband-clipart-modal', function(e){
                var button = $(e.relatedTarget),
                    modal = $(this);

                modal.find('.modal-title').text('Choose your '+ button.data('title') +' Clipart ');
                modal.find('.clipart-list').data('target', '#' + button.attr('id'));
                modal.find('.clipart-list').data('position', button.attr('id'));
            })
            .on('click', '.clipart-list li', function() {
                $('.clipart-list li').removeClass('active');
                $(this).addClass('active');
                var button = $($(this).closest('.clipart-list').data('target')),
                    icon = $(this).data('icon'),
                    glyp = $(this).data('icon-code'),
                    position = button.data('position'),
                    view = button.data('view'),
                    preview = $('.preview-button.active').data('view');

                    if(icon == undefined) { $('#'+position).text(''); }  
                    else { $('#'+position).text(glyp); }

                   if (position == "wrap_start" || position == "wrap_end"){
                        $('#icon_start').text(  $('#wrap_start').text() );
                        $('#icon_end').text(  $('#wrap_end').text() );
                   } else {
                        $('#icon_start').text(  $('#'+preview+'_start').text() );
                        $('#icon_end').text(  $('#'+preview+'_end').text() );
                   }

                button.find('.icon-preview').removeClass(function (index, css) {
                    return (css.match (/(^|\s)fa-\S+/g) || []).join(' ');
                });

                button.find('.icon-preview').addClass(icon == undefined ? 'fa-ban' : icon);
                Builder.data['clipart'][button.data('position')] =  icon == undefined ? '' : icon;
                Builder.has_upload = false;
                $('#wristband-clipart-modal').modal('hide');

                if (button.data('file') != undefined) {
                    // Delete previous file
                    var result = Builder.deleteClipart(button.data('file'));
                    result.success(function () {

                        button.removeAttr('data-file');
                        button.find('.icon-preview').css({display: 'inline-block'});
                        button.find('.image-upload').css({display: 'none'});
                    });
                }
                
                Builder.observer();

            })

            .on('change', 'input[name="customization_location"], select#font', function(){
               Builder.observer();
            })

            .on('click', '.additional-option-item', function(e) {
                if ($(e.target).is('input:checkbox')) return;

                var $checkbox = $(this).find(':checkbox');
                $checkbox.attr('checked', !$checkbox[0].checked);
                Builder.observer();
                //$('#textbox1').val($(this).is(':checked'))
            })

            .on('change','input[name = "additional_option[]"]',function(e) {
                    Builder.observer();

            })
            .on('click', '#wbc_add_to_cart', function(e) {
                e.preventDefault();

                if (!Builder.validateForm()) {
                    return;
                }

                var $self = $(this),
                    $icon = $self.find('.fa'),
                    $button_text = $self.find('.fusion-button-text-left');

                $icon.removeClass('fa-shopping-cart');
                $icon.addClass('fa-spinner');
                $button_text.text('Processing...');

                Builder.collectDataToPost();

                $.ajax({
                    url: WBC.ajax_url,
                    type: 'POST',
                    data: {meta: JSON.stringify(Builder.data), action: 'wbc_add_to_cart'},
                    dataType: 'JSON',
                }).done(function(response) {
                    var type = 'success',
                        title = 'Success';

                    $icon.removeClass('fa-spinner');
                    $icon.addClass('fa-shopping-cart');
                    $button_text.text('Add to Cart');

                    if (!response.success) {
                        type = 'error';
                        title = 'Error';
                    }
                    Builder.has_upload = false;
                    Builder.popupMsg(type, title, response.data.message + ' <a href="'+ Settings.site_url +'/cart">view cart <i class="fa fa-long-arrow-right"></i></a>');

                });
                return false;
            })
                //save button
            .on('click','#save_button',function(e) {
                e.preventDefault();

                // console.log('this');
                // console.log( preview_container );
                // console.log($('#preview_container').html());
                //Builder.popupProductInfo('info', 'Preview', $('#preview_container').html());

                if ($('#preview_container').length) {


                    Pablo(document.getElementById("svgelement")).download('svg',Settings.svg, function(result){
                        alert(result.error ? 'Fail' : 'Success');

                    });

                    //Pablo(preview_container).download('svg',Settings.svg, function(result){
                    //    alert(result.error ? 'Fail' : 'Success');
                    //});
                }
            })

            .on('change', 'select#customization_date_production, select#customization_date_shipping', function() {
                Builder.calculateDeliveryDate();
            })



            .on('click', '#front_view_button, #back_view_button', function(e) {
                e.preventDefault();
                TempReloadSVG();

                var view = $(this).data('view');
                Builder.data.clipart.view_position = view;
              
                $('#icon_start').text(  $('#'+view+'_start').text() );
                $('#icon_end').text(  $('#'+view+'_end').text() );

                $('.preview-button').removeClass('active');
                $(this).addClass('active');

                Builder.observer();



                var normalClass = "fusion-button button-flat button-round button-small button-default preview-button if-message_type_is-continues active";
                var SelectedClass = "fusion-button button-flat button-round button-small button-orange preview-button if-message_type_is-continues active";
                document.getElementById("front_view_button").className = normalClass;
                document.getElementById("back_view_button").className = normalClass;
                document.getElementById(this.id).className = SelectedClass;

              //  
                return false;
            });





            
        // Alert message if attempt to leave/unload page
        $(window).on('beforeunload', function() {
            if (Builder.has_upload)
                return 'There are unsaved data.';
        });
        // Delete any uploaded clipart before leaving page
        $(window).on('unload',function(){
            if (Builder.has_upload) {
                //Delete file clipart if page is leave/unload
                for (var i in Builder.data.clipart) {
                    if (Builder.data.clipart[i].match(/\.(jpeg|jpg|png|gif)$/) != null) {
                        var result = Builder.deleteClipart(Builder.data.clipart[i]);
                        result.success(function() {
                            Builder.has_upload = false;
                        });
                    }
                }
            }
        });

        // Call function on load
        Builder.onLoad();

        $('#qty_adult, #qty_medium, #qty_youth').trigger('keyup'); // trigger  the Input Quanity field when the page is reloaded to calculate the total.




    });
});
