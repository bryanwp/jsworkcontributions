jQuery(function ($) {
    'use strict';

    var Settings = WBC.settings,
        Builder = {
        has_upload  : false,                   // Check if there are any files uploaded
        CntID : 0,
        TempColors  : [],
        price_charts: [],                   // Array of price chart
        data: {
            total_price     : 0,            // Total Price of wristband selected
            total_qty       : 0,            // Total Quantity of wristband selected
            has_color_split : false,        // Check if selection has color split
            has_extra_size  : false,        // Check if selection has extra sizes
            size_number     : 0,           // Number of sizes that are inputted
            colors          : [],           // Color selected
            free_colors          : [],           // Color selected
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
            //this.removeColor(key);
            this.data.colors.push(value);
            this.observer();
        },
        addFreeColor: function(key, value) {
            this.data.free_colors.push(value);
            this.observer();
        },
        updateColor: function(name, textColorName, Type, lists) {

            for (var i in this.data.colors) {
                if( name != '') {
                    if( this.data.colors[i].name ==  name && this.data.colors[i].text_color_name == textColorName && Type == this.data.colors[i].type) {
                        //this.data.colors[i].name            = (lists.name != '') ? lists.name : this.data.colors[i].color;
                        //this.data.colors[i].color           = (lists.color != '') ? lists.color : this.data.colors[i].color;
                        //this.data.colors[i].type            = (lists.type != '') ? lists.type : this.data.colors[i].type;
                        //this.data.colors[i].text_color      = lists.text_color;
                        //this.data.colors[i].text_color_name = lists.text_color_name;
                        this.data.colors[i].sizes['adult']  = (lists.sizes['adult'] != '' || lists.sizes['adult'] == 0) ? lists.sizes['adult'] : this.data.colors[i].sizes['adult'];
                        this.data.colors[i].sizes['medium'] = (lists.sizes['medium'] != '' || lists.sizes['medium'] == 0) ? lists.sizes['medium'] : this.data.colors[i].sizes['medium'];
                        this.data.colors[i].sizes['youth']  = (lists.sizes['youth'] != '' || lists.sizes['youth'] == 0) ? lists.sizes['youth'] : this.data.colors[i].sizes['youth']; 

                        // this.data.colors[i].free['adult']  = (lists.free['adult'] != '' || lists.free['adult'] == 0) ? lists.free['adult'] : this.data.colors[i].free['adult'];
                        // this.data.colors[i].free['medium'] = (lists.free['medium'] != '' || lists.free['medium'] == 0) ? lists.free['medium'] : this.data.colors[i].free['medium'];
                        // this.data.colors[i].free['youth']  = (lists.free['youth'] != '' || lists.free['youth'] == 0) ? lists.free['youth'] : this.data.colors[i].free['youth']; 

                        this.data.free_colors[i].free['adult']  = (lists.free['adult'] != '' || lists.free['adult'] == 0) ? lists.free['adult'] : this.data.free_colors[i].free['adult'];
                        this.data.free_colors[i].free['medium'] = (lists.free['medium'] != '' || lists.free['medium'] == 0) ? lists.free['medium'] : this.data.free_colors[i].free['medium'];
                        this.data.free_colors[i].free['youth']  = (lists.free['youth'] != '' || lists.free['youth'] == 0) ? lists.free['youth'] : this.data.free_colors[i].free['youth']; 
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

                        // this.data.colors[i].free['adult']  = (lists.free['adult'] != '') ? lists.free['adult'] : this.data.colors[i].free['adult'];
                        // this.data.colors[i].free['medium'] = (lists.free['medium'] != '') ? lists.free['medium'] : this.data.colors[i].free['medium'];
                        // this.data.colors[i].free['youth']  = (lists.free['youth'] != '') ? lists.free['youth'] : this.data.colors[i].free['youth'];     

                        this.data.free_colors[i].free['adult']  = (lists.free['adult'] != '') ? lists.free['adult'] : this.data.free_colors[i].free['adult'];
                        this.data.free_colors[i].free['medium'] = (lists.free['medium'] != '') ? lists.free['medium'] : this.data.free_colors[i].free['medium'];
                        this.data.free_colors[i].free['youth']  = (lists.free['youth'] != '') ? lists.free['youth'] : this.data.free_colors[i].free['youth'];     
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
        removeColor: function(name, color_Textname) {
            for (var i in this.data.colors) {
                //console.log(this.data.colors);
                if((this.data.colors[i].name == name && this.data.colors[i].text_color_name == color_Textname) || this.data.colors[i].temp == true) {
                    this.data.colors.splice(i, 1);
                }
            }
            this.observer();
        },
        // Check if there are any split color and extra sizes
        checkColorSplitAndExtraSize: function() {
            var array_sizes = [], size_definition = [], color_list = [];

            this.data.has_color_split   = false;
            this.data.has_extra_size    = false;
            this.data.size_number       = 0;

            for (var i in this.data.colors) {
                if(color_list.indexOf(this.data.colors[i].color) == -1)                    
                    color_list.push(this.data.colors[i].color);

                 for (var size in this.data.colors[i].sizes) {
                    if (array_sizes.indexOf(size) == -1 && toInt(this.data.colors[i].sizes[size]) > 0) {
                        array_sizes.push(size);
                    }
                    if (array_sizes.length == 2) {
                        this.data.has_extra_size = true;
                        this.data.size_number = 2;
                    }
                    if (array_sizes.length == 3) {
                        this.data.has_extra_size = true;
                        this.data.size_number = 3;
                    }
                }
            }

            if (color_list.length > 1) {
                this.data.has_color_split = true;
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
                for( var option in addOption) {
                     var choose_size = addOption[option].choose_size;
                    for (var i = 0; i < choose_size.length; i++) {
                            if ( choose_size[i] === size ) {
                               value = 'true';
                               break;
                            } else { value = 'not true'; }  
                    } 
                        if(value == 'true') { $('#id_'+option).show(); } 
                        else if(value == 'not true') { $('#id_'+option).hide(); }
                }
        },

        // Observe any changes and calcuate price and quantity for display
        observer: function() {
                this.checkColorSplitAndExtraSize();
                this.collectQuantity();
                this.collectPrices();
                var total_qty   = this.data.total_qty,
                    total_price = this.data.total_price;

                this.data.total_qty = total_qty;
                this.data.total_price = total_price;  

                $('#qty_handler').text(numberFormat(total_qty, 0) + (total_qty > Settings.max_qty ? ' + 100 FREE' : ''));
                $('#price_handler').text(numberFormat(total_price));
                if( total_qty < 100){ $('#id_convert_to_keychains').hide(); } 
                else { $('#id_convert_to_keychains').show(); }
            this.buildPreview();
        },

        buildPreview: function() {
            var StyleColor = $('input[name="color_style"]:checked').val();
            var y = $('#wristband-color-items .color-wrap.selected > div').data('color');
            this.previewForText();
            if (y != undefined) { if($('#bandcolor').length) { SelectBandColor(StyleColor,y); } }
        },

        previewForText: function(){
            var message_type = $('input[name="message_type"]:checked').val();
            var inside_msg = $('input[name="inside_message"]').val();
            //     a = $('.preview-button.active').data('input'),
            //     input = message_type == 'continues' ? 'continues_message' : a;
            // $("#front-text").text($('input[name="'+ input  +'"]').val().toUpperCase());
            // $('#insidetextpath').text($('input[name="inside_message"]').val().toUpperCase());
            // $('#front-text').attr('font-family', $('select[name="font"] option:selected').val());
            //console.log(message_type);

            if(message_type == 'continues'){
                var cont_msg = $('input[name="continues_message"]').val();
                // $("#front-text1").text(cont_msg.toUpperCase());
                // $("#front-text2").text(cont_msg.toUpperCase());
                // $("#front-text1").text($('#txtInputCont').val().substring(0, Math.ceil(cont_msg.length / 2)));
                // $("#front-text2").text($('#txtInputCont').val().substring((Math.ceil($("#txtInputCont").val().length / 2) - 1), $("#txtInputCont").val().length));

                if (cont_msg.length < $('input[name=textcount]').val().length + 1) {
                    $("#front-textcont2").text('');
                    disableWrapped();
                }
                $("#front-textcontainer").text(cont_msg);
                if ($("#bandtextcontainer")[0].getBoundingClientRect().width > '750') {

                    enableWrapped();
                    $("#front-textcont1").text(cont_msg.substring(0, Math.ceil(cont_msg.length / 2)));
                    $("#front-textcont2").text(cont_msg.substring((Math.ceil(cont_msg.length / 2) - 1), cont_msg.length));
                } else {
                    disableWrapped();
                    //if ($("#bandtextcontainer")[0].getBoundingClientRect().width > '715') {
                    if ($("#bandtextcontainer")[0].getBoundingClientRect().width > '480') {
                        $("#front-endcont2").empty().append($("#front-endcont2-icon :selected").text());
                        $("#front-endcont1").empty();
                        $('input[name=isWrapCont]').val('1');

                        var span_textcont1 = $('input[name=textcount]').val().length;
                        $("#front-textcont2").text(cont_msg.substring(span_textcont1 - 1, cont_msg.length));

                    } else {
                        $("#front-endcont1").empty().append($("#front-endcont2-icon :selected").text());
                        $("#front-endcont2").empty();
                        $('input[name=isWrapCont]').val('0');

                        $("#front-textcont1").text(cont_msg.substring(0, cont_msg.length));
                        $('input[name=textcount]').val(cont_msg.substring(0, cont_msg.length));
                    }

                    if ($('input[name=wrapPaste]').val() === '1') {
                        enableWrapped();
                        $("#front-textcont1").text(cont_msg.substring(0, Math.ceil(cont_msg.length / 2)));
                        $("#front-textcont2").text(cont_msg.substring((Math.ceil(cont_msg.length / 2) - 1), cont_msg.length));
                        $("#front-endcont2").empty().append($("#front-endcont2-icon :selected").text());
                        $("#front-endcont1").empty();
                    }

                }
            }else{
                var front_msg = $('input[name="front_message"]').val(),
                    back_msg = $('input[name="back_message"]').val();

                $("#front-text1").text(front_msg);
                $("#front-text2").text(back_msg);
                $('#front-text1').attr('font-family', $('select[name="font"] option:selected').val());
                $('#front-text2').attr('font-family', $('select[name="font"] option:selected').val());
            }
            
            // console.log($('input[name=textinside]').val().length + 1);
            if (inside_msg.length < $('input[name=textinside]').val().length + 1) {
                    $("#front-textinside2").text('');
                    disableWrapped2();
            }
            $("#front-textcontainer2").text(inside_msg);
            if ($("#bandtextcontainer2")[0].getBoundingClientRect().width > '750') {

                enableWrapped2();

                $("#front-textinside1").text(inside_msg.substring(0, Math.ceil(inside_msg.length / 2)));
                $("#front-textinside2").text(inside_msg.substring((Math.ceil(inside_msg.length / 2) - 1), inside_msg.length));
            } else {
                disableWrapped2();
                if ($("#bandtextcontainer2")[0].getBoundingClientRect().width > '480') {
                    $("#front-endinside2").empty().append($("#front-endinside2-icon :selected").text());
                    $("#front-endinside1").empty();
                    $('input[name=isWrapInside]').val('1');

                    var span_textinside1 = $('input[name=textinside]').val().length;
                    $("#front-textinside2").text(inside_msg.substring(span_textinside1 - 1, inside_msg.length));
                    } else {
                    $("#front-endinside1").empty().append($("#front-endinside2-icon :selected").text());
                    $("#front-endinside2").empty();
                    $('input[name=isWrapInside]').val('0');

                    $("#front-textinside1").text(inside_msg.substring(0, inside_msg.length));
                    $('input[name=textinside]').val(inside_msg.substring(0, inside_msg.length));
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

                if (Settings[c[i] + "_price_list"][$size.data('group')] == undefined) continue;

                var t = Settings.customization.dates[c[i]];
                var g = Settings[c[i] + "_price_list"][$size.data('group')];

                for (var y in t) {
                    var val = t[y].days;
                    var price = toFloat(this.getDayPrice(g[y]));
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
            $('select[name="style"], input[name="message_type"]').trigger('change');

            // Trigger keyup on ready
            $('.trigger-limit-char').trigger('keyup');

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
                    beforeSend: function(xhr){
                        if(this.files[0].size > 2000000)
                        {
                            alert("Maximum file size is 2MB.");
                            return false;
                        }
                        var allowedFiles = [".png", ".jpeg", ".gif", ".cdr",".psd", ".ai", ".pdf", ".eps", ".bmp", ".tiff"];
                        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
                        if (!regex.test(this.files[0].name.toLowerCase())) 
                        {
                            alert("Allowed file types are CDR, JPG, JPEG, PSD, AI, PDF, PNG, GIF, EPS, TIFF, BMP");
                            return false;
                        }                        
                    },
                    done: function (e, data) {
                        var $self = $(this);
                        $.each(data.result.files, function (index, file) {
                            //console.log(file);

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
                                .attr('src', file.url)
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
                                .addClass('fa-upload');

                            Builder.observer();
                       });
                   },
                    progressall: function (e, data) {
                        var $self = $(this);

                        $self.closest('.fileinput-button')
                            .find('span')
                            .css({'padding-left' : '10px'})
                            .end()
                            .find('.fa-upload')
                            .removeClass('fa-upload')
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
            return this.rangePrice(list, this.data.total_qty);
        },

        collectDataToPost: function() {
            var addtional_options   = [],
                messages            = {},
                $production_time    = $('select[name="customization_date_production"] option:selected'),
                $shipping_time      = $('select[name="customization_date_shipping"] option:selected');

            $('input[name="additional_option[]"]:checked').each(function() {
               addtional_options.push($(this).val());
            });

            if ($('input[name="message_type"]:checked').val() == 'front_and_back') {
                messages['Front Message']   = $('input[name="front_message"]').val();
                messages['Back Message']    = $('input[name="back_message"]').val();
            } else {
                messages['Continuous Message'] = $('input[name="continues_message"]').val();
            }
            messages['Inside Message']  = $('input[name="inside_message"]').val();

            messages['Additional Notes'] = $('textarea#additional_notes').val();

            $.extend(this.data, {
                product                 : $('select#style').val(),
                size                    : $('select#width').val(),
                font                    : $('select#font').val(),
                message_type            : $('input[name="message_type"]:checked').val(),
                messages                : messages,
                additional_options      : addtional_options,
                customization_location  : $('input[name="customization_location"]:checked').data('title'),
                customization_date_production : $production_time.text(),
                customization_date_shipping : $shipping_time.text(),
                guaranteed_delivery: $('#delivery_date').text()
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
            var total_days = toInt($production_time.val()) + toInt($shipping_time.val());

            // Start escape saturday and sunday and holiday
            var flag = true, cntr = 0;

            while (flag == true) {
                the_date.setDate(the_date.getDate() + 1);
                if (toInt(the_date.getDay())  != 0 && toInt(the_date.getDay()) != 6 && !this.isHoliday(the_date)) { cntr++; }
                if (cntr >= total_days) { break; }
            }

            var month_name = [
                "January", "February", "March",
                "April", "May", "June", "July",
                "August", "September", "October",
                "November", "December"
                ];
            var week_name = [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ];
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
            this._customizationLocation(qty);
            this._customizationDate();
        },

        _priceChart: function(qty) {
            if (qty <= 0) return 0;
            var price_charts = this.price_charts,
                additional  = this.rangePrice(price_charts, qty),
                total = 0;
                total  = additional * qty;

                if ( qty == 0 ) { this.data.total_price += additional; } 
                else { this.data.total_price += total; }
        },

        _colorSplit: function(qty) {
            if (!this.data.has_color_split) return;
            if(this.data.colors.length > 1) {
                var color_split_cost = Settings.color_split_cost_price_list,
                additional = this.rangePrice(color_split_cost, qty) * 1 ;
                this.data.total_price += additional;
            }
        },

        _extraSize: function(qty) {
            if (!this.data.has_extra_size) return;
            var extra_size_cost = Settings.color_extra_size_cost_price_list;

            if (this.data.size_number == 1) { return; } 
            else if (this.data.size_number == 2) { this.data.total_price += this.rangePrice(extra_size_cost,qty);} 
            else { this.data.total_price += this.rangePrice(extra_size_cost,qty) * 2; }
        },

        _colorStylePrice: function(qty) {
   
            if(qty <= 0) return;

            var color_style_price = Settings.price_list,
                styleID = $('.color-wrap.selected').eq(0).attr('title');

            if ($('.color-wrap.selected').eq(0).attr('title')){ /* nothing*/ } 
            else { styleID = $('input[name="color_style"]:checked').val(); }

            if(Settings.color_style[styleID].price_list) {
                var color_style_cost = Settings.color_style[styleID].price_list,
                    additional = this.rangePrice(color_style_cost, qty);
                this.data.total_price += additional;
            } else { return; } 
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
                        var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each',
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
                    //alert(costType + "====" + additional_price)
                $(this).closest('.checkbox').closest('.checkbox').find('.each-message').remove();
                if (additional_price > 0) {
                    if(costType == 'Each Quantity') {
                        Builder.data.total_price += additional_price * qty;
                        // Render alert message
                        var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each', {
                                currency_symbol: Settings.currency_symbol,
                                price: additional_price,
                            } );
                        Builder.appendAlertMsg(tpl, $(this).closest('.checkbox'), 'each-message');
                    } else {
                        Builder.data.total_price += additional_price;
                        // Render alert message
                        var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} per order.', {
                                currency_symbol: Settings.currency_symbol,
                                price: additional_price,
                            }
                        );
                        Builder.appendAlertMsg(tpl, $(this).closest('.checkbox'), 'per-order');
                    }
                }   
            });
        },
        _customizationLocation: function(qty) {
            var location = $('input[name="customization_location"]:checked').val(),
                additional_price = toFloat(Settings.customization.location[location].price);

            if (additional_price <= 0) return;

            this.data.total_price += additional_price * qty;
            // Render alert message
            var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each',
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
            //for (var i in this.data.clipart) {

            if(this.data.clipart['wristband_stat'] == "front_and_back")
            {
                if (this.data.clipart['back_end'] != '' || this.data.clipart['back_start'] != '' || this.data.clipart['front_start'] != '' || this.data.clipart['front_end'] != '') {
                    flag = true;
                }
            }
            else
            {
                if (this.data.clipart['wrap_end'] != '' || this.data.clipart['wrap_start'] != '') {
                    flag = true;
                }
            }
           // }
            if (! flag) return;

            var price_list =  Settings.logo.prices,
                additional_price = this.rangePrice(price_list, qty);
            this.data.total_price += additional_price * qty;

            // Render alert message
            var tpl = Mustache.render('+{{{currency_symbol}}} {{price}} each',
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

    function enableWrapped() {

                $('#bandtextcont1')[0].setAttribute('text-anchor', 'middle');
                $('#bandtextcont1')[0].setAttribute('textLength', '280');
                $('#bandtextcont1')[0].setAttribute('lengthAdjust', 'spacingAndGlyphs');
                $('#bandtextpathcont1')[0].setAttribute('startOffset', '50%');

                $('#bandtextcont2')[0].setAttribute('text-anchor', 'middle');
                $('#bandtextcont2')[0].setAttribute('textLength', '280');
                $('#bandtextcont2')[0].setAttribute('lengthAdjust', 'spacingAndGlyphs');
                $('#bandtextpathcont2')[0].setAttribute('startOffset', '50%');
            }
     function disableWrapped() {
                $('#bandtextcont1')[0].setAttribute('text-anchor', '');
                $('#bandtextcont1')[0].setAttribute('textLength', '');
                $('#bandtextcont1')[0].setAttribute('lengthAdjust', '');
                $('#bandtextpathcont1')[0].setAttribute('startOffset', '0%');

                $('#bandtextcont2')[0].setAttribute('text-anchor', '');
                $('#bandtextcont2')[0].setAttribute('textLength', '');
                $('#bandtextcont2')[0].setAttribute('lengthAdjust', '');
                $('#bandtextpathcont2')[0].setAttribute('startOffset', '0%');
            }
    function enableWrapped2() {
                $('#bandtextinside1')[0].setAttribute('text-anchor', 'middle');
                $('#bandtextinside1')[0].setAttribute('textLength', '280');
                $('#bandtextinside1')[0].setAttribute('lengthAdjust', 'spacingAndGlyphs');
                $('#bandtextpathinside1')[0].setAttribute('startOffset', '50%');

                $('#bandtextinside2')[0].setAttribute('text-anchor', 'middle');
                $('#bandtextinside2')[0].setAttribute('textLength', '280');
                $('#bandtextinside2')[0].setAttribute('lengthAdjust', 'spacingAndGlyphs');
                $('#bandtextpathinside2')[0].setAttribute('startOffset', '50%');
            }
    function disableWrapped2() {
                $('#bandtextinside1')[0].setAttribute('text-anchor', '');
                $('#bandtextinside1')[0].setAttribute('textLength', '');
                $('#bandtextinside1')[0].setAttribute('lengthAdjust', '');
                $('#bandtextpathinside1')[0].setAttribute('startOffset', '0%');

                $('#bandtextinside2')[0].setAttribute('text-anchor', '');
                $('#bandtextinside2')[0].setAttribute('textLength', '');
                $('#bandtextinside2')[0].setAttribute('lengthAdjust', '');
                $('#bandtextpathinside2')[0].setAttribute('startOffset', '0%');
            }

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
        return file.match(/\.(jpeg|jpg|png|gif|cdr|psd|ai|pdf|eps|bmp|tiff)$/) != null;
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
            if (document.getElementById("bandtextpathinside")){
                document.getElementById("bandtextpathinside").style.fill = '#999999';
                document.getElementById("bandtextpathinside").style.opacity = "0.4";

                document.getElementById("bandtextpath").style.fill = '#999999';
                document.getElementById("bandtextpath").style.opacity = "0.4";
            }
        } else {
            document.getElementById("bandtextpathinside").style.fill = SetColor;
            document.getElementById("bandtextpathinside").style.opacity = "1";

            document.getElementById("bandtextpathinside1").style.fill = SetColor;
            document.getElementById("bandtextpathinside1").style.opacity = "1";

            document.getElementById("bandtextpathinside2").style.fill = SetColor;
            document.getElementById("bandtextpathinside2").style.opacity = "1";

            document.getElementById("bandtextpath").style.fill = SetColor;
            document.getElementById("bandtextpath").style.opacity = "1";

            document.getElementById("bandtextpath1").style.fill = SetColor;
            document.getElementById("bandtextpath1").style.opacity = "1";

            document.getElementById("bandtextpath2").style.fill = SetColor;
            document.getElementById("bandtextpath2").style.opacity = "1";

        }
    }


   function wbTextColorFromTbl(SetColor) {
        if(SetColor == undefined) {
            if (document.getElementById("bandtextpathinside")){
                document.getElementById("bandtextpathinside").style.fill = '#999999';
                document.getElementById("bandtextpathinside").style.opacity = "0.4";

                document.getElementById("bandtextpath").style.fill = '#999999';
                document.getElementById("bandtextpath").style.opacity = "0.4";
            }
        } else {
            document.getElementById("bandtextpathinside").style.fill = SetColor;
            document.getElementById("bandtextpathinside").style.opacity = "1";

            document.getElementById("bandtextpath").style.fill = SetColor;
            document.getElementById("bandtextpath").style.opacity = "1";
        }
    }



    //Display the default message option which front, back & inside
    function messageOptionDisplay(value) {
        if (value == "front_and_back"){ 
            $("#ForFrontBackID").css({display: 'block'}); 
            $("#ForContiID").css({display: 'none'});
            //changing the mask
            $("#outsidesolid1").removeAttr("display");
            $("#outsidesolid2").removeAttr("display");
            $("#mask1_band1").removeAttr("display");
            $("#mask2_band1").removeAttr("display");
            $("#mask1_band2").removeAttr("display");
            $("#mask2_band2").removeAttr("display");

            $("#bandtext1").removeAttr("display");
            $("#bandtext2").removeAttr("display");
            $("#bandtextcont1").attr("display", "none");
            $("#bandtextcont2").attr("display", "none");

            $("#imagepathinside").attr("display", "none");
            //hidebackshadow();
            $("#segcolor1_cover_band1").removeAttr("display");
            $("#segcolor2_cover_band1").removeAttr("display");
            $("#segcolor3_band1").removeAttr("display");

            $("#segcolor1_cover_band2").removeAttr("display");
            $("#segcolor2_cover_band2").removeAttr("display");             
        } else if (value == 'continues') { 
            $("#ForFrontBackID").css({display: 'none'}); 
            $("#ForContiID").css({display: 'block'});
            //changing the mask
            $("#outsidesolid1").removeAttr("display");
            $("#outsidesolid2").removeAttr("display");
            $("#mask1_band1").removeAttr("display");
            $("#mask2_band1").removeAttr("display");
            $("#mask1_band2").removeAttr("display");
            $("#mask2_band2").removeAttr("display");

            $("#bandtextcont1").removeAttr("display");
            $("#bandtextcont2").removeAttr("display");
            $("#bandtext1").attr("display", "none");
            $("#bandtext2").attr("display", "none");
            $("#imagepathinside").attr("display", "none");
            //hidebackshadow();
            $("#segcolor1_cover_band1").removeAttr("display");
            $("#segcolor2_cover_band1").removeAttr("display");
            $("#segcolor3_band1").removeAttr("display");

            $("#segcolor1_cover_band2").removeAttr("display");
            $("#segcolor2_cover_band2").removeAttr("display");
        }

        $('[class*="hide-if-message_type-"]').css({display: 'block'});
        $('.hide-if-message_type-' + value).css({'display': 'none'});
        $('[class*="if-message_type_is-"]').css({display: ''});
        $('.if-message_type_is-' + value).css({display: 'none'});

        Builder.data["clipart"]["wristband_stat"] = value;
    }

    function TempReloadSVG(){
        // var ContainerID =  document.getElementById("preview_container")
        // var Temp = ContainerID.innerHTML;
        // ContainerID.innerHTML = Temp;
    }

    function ChangeStyle(val){
        switch (val) { 
                case 'Imprinted': 
                        var cssVal = "0 0 0";
                        $("#bandtext").css({textShadow: "0 0 0"});
                        $("#bandtext1").css({textShadow: cssVal});
                        $("#bandtext2").css({textShadow: cssVal});
                        $("#bandtextcont1").css({textShadow: cssVal});
                        $("#bandtextcont2").css({textShadow: cssVal});
                        $("#bandtextinside1").css({textShadow: cssVal});
                        $("#bandtextinside2").css({textShadow: cssVal});
                        break;
                case 'Debossed': 
                        //$("#bandtext").css({textShadow: "0 1.5px 0 black"});
                        var cssVal = "0px -1px 1px black";
                        $("#bandtext").css({textShadow: "0px -1px 1px black"});
                        $("#bandtext1").css({textShadow: cssVal});
                        $("#bandtext2").css({textShadow: cssVal});
                        $("#bandtextcont1").css({textShadow: cssVal});
                        $("#bandtextcont2").css({textShadow: cssVal});
                        $("#bandtextinside1").css({textShadow: cssVal});
                        $("#bandtextinside2").css({textShadow: cssVal});
                        break;
                case 'Embossed': 
                        var cssVal = "rgba(255, 255, 255, 0.1) -2px -2px 2px, rgba(0, 0, 0, 0.5) 2px 2px 2px";
                        $("#bandtext").css({textShadow: "rgba(255, 255, 255, 0.1) -2px -2px 2px, rgba(0, 0, 0, 0.5) 2px 2px 2px"});
                        $("#bandtext1").css({textShadow: cssVal});
                        $("#bandtext2").css({textShadow: cssVal});
                        $("#bandtextcont1").css({textShadow: cssVal});
                        $("#bandtextcont2").css({textShadow: cssVal});
                        $("#bandtextinside1").css({textShadow: cssVal});
                        $("#bandtextinside2").css({textShadow: cssVal});
                        break;      
                default:
                        var cssVal = "0 0 0";
                        $("#bandtext").css({textShadow: "0 0 0"});
                        $("#bandtext1").css({textShadow: cssVal});
                        $("#bandtext2").css({textShadow: cssVal});
                        $("#bandtextcont1").css({textShadow: cssVal});
                        $("#bandtextcont2").css({textShadow: cssVal});
                        $("#bandtextinside1").css({textShadow: cssVal});
                        $("#bandtextinside2").css({textShadow: cssVal});
        } 
    }

    function CheckEdit(){ if(document.getElementById("EditModeID")){ StartEdit(); } }

    function StartEdit(){
        var val = document.getElementById('EditModeID').name;
        val = val.split("|");
        var MultiAdd = val[2];

        SetSelectCheckedText("style", val[0]);
        LoadTOArray(MultiAdd);
        $("#style").change();
        SetSelectCheckedText("width", val[1]);
        $("#width").change();

        LoadAdditionalOption(val[6],val[7],val[8],val[9]);
        LoadPicture(val[10],val[11],val[12],val[13],val[14],val[15],val[17],val[18]);

        Builder.observer();
        Builder.renderProductionShippingOptions();
        SetProdShipTime(val[3],val[4],val[5]);
        $("#delivery_date").html(val[16]);

        setTimeout(function(){ ComputeAll(); }, 100);
    }

    function ComputeAll(){
        Builder.checkColorSplitAndExtraSize();
        Builder.collectQuantity();
        Builder.collectPrices();
        var total_qty   = Builder.data.total_qty,
        total_price = Builder.data.total_price;

        Builder.data.total_qty = total_qty;
        Builder.data.total_price = total_price;  

        $('#qty_handler').text(numberFormat(total_qty, 0) + (total_qty > Settings.max_qty ? ' + 100 FREE' : ''));
        $('#price_handler').text(numberFormat(total_price));
        if( total_qty < 100){ $('#id_convert_to_keychains').hide(); } 
        else { $('#id_convert_to_keychains').show(); }

        Builder._clipart(total_qty);
        Builder.calculateDeliveryDate();
    }

    function SetSelectCheckedText(Obj, setSelected){
        var myObj = document.getElementById(Obj);
        for(var i = 0, j = myObj.options.length; i < j; ++i) {
            if(myObj.options[i].innerHTML === setSelected) {
               myObj.selectedIndex = i;
               break;
            }
        }
    }

    function LoadTOArray(MultiAdd){
        var SplitItem = MultiAdd.split("~");

        for(var x=0;x<=SplitItem.length-1;x++){
            var TempSplit = SplitItem[x].split("^");

            var value = {
                name: TempSplit[0],
                color: TempSplit[2],
                type: TempSplit[1],
                text_color_name: TempSplit[3],
                text_color: TempSplit[4],
                sizes: {
                    adult: toInt(TempSplit[5]),
                    medium: toInt(TempSplit[6]),
                    youth: toInt(TempSplit[7]),
                },
                free: {
                    adult: toInt(TempSplit[8]),
                    medium: toInt(TempSplit[9]),
                    youth: toInt(TempSplit[10]),
                }
            }            
            Builder.data.colors.push(value);

            var value1 = {
                free: {
                    adult: toInt(TempSplit[8]),
                    medium: toInt(TempSplit[9]),
                    youth: toInt(TempSplit[10]),
               }
            }
            Builder.data.free_colors.push(value1);
        }
    }

    function SetProdShipTime(C_location,C_date_prod,C_date_ship){
        var TmpDateprod = C_date_prod.split(" ")[0],
            TmpDateship = C_date_ship.split(" ")[0];
       $('input[name="customization_location"]').each( function () {
            if ($(this).attr("data-title") == C_location){
                $(this).attr('checked', true);
            }
        });       

        $("#customization_date_production").val(TmpDateprod);
        if (!Number(TmpDateship)){ 
            SetSelectCheckedText("customization_date_shipping", "International Shipping - Free");
        } else {
            $("#customization_date_shipping").val(TmpDateship);
        }
    }

    function LoadAdditionalOption(InPackaging, Eco, Thick, DigitalPro){
        
       $('input[name="additional_option[]"]').each( function () {
            if ($(this).val() == InPackaging){ $(this).attr('checked', true); } 
            else if ($(this).val() == Eco){ $(this).attr('checked', true); } 
            else if ($(this).val() == Thick){ $(this).attr('checked', true); } 
            else if ($(this).val() == DigitalPro){ $(this).attr('checked', true); }
        });
    }

    function LoadPicture(FS,FE,BS,BE,VP,WristStat,WS,WE){
        $('.clipart-list li').each( function () {
            var glyp = $(this).data('icon-code');


            if ($(this).data('icon') == FS){ 
                $('#FsID').removeClass('fa fa-ban icon-preview hide-if-upload');
                $('#FsID').addClass('fa icon-preview hide-if-upload ' + $(this).data('icon'));
                $('#front_start').text(glyp);
                $('#icon_start').text(  $('#front_start').text());
                $('#icon_end').text(  $('#front_end').text());
            } 
            if ($(this).data('icon') == FE){
                $('#FeID').removeClass('fa fa-ban icon-preview hide-if-upload');
                $('#FeID').addClass('fa icon-preview hide-if-upload ' + $(this).data('icon'));
                $('#front_end').text(glyp);
                $('#icon_start').text(  $('#front_start').text());
                $('#icon_end').text(  $('#front_end').text());
            } 
            if ($(this).data('icon') == BS){
                $('#BsID').removeClass('fa fa-ban icon-preview hide-if-upload');
                $('#BsID').addClass('fa icon-preview hide-if-upload ' + $(this).data('icon'));
                $('#back_start').text(glyp);
                $('#icon_start').text(  $('#back_start').text());
                $('#icon_end').text(  $('#back_end').text());
            } 
            if ($(this).data('icon') == BE){
                $('#BeID').removeClass('fa fa-ban icon-preview hide-if-upload');
                $('#BeID').addClass('fa icon-preview hide-if-upload ' + $(this).data('icon'));;
                $('#back_end').text(glyp);
                $('#icon_start').text(  $('#back_start').text());
                $('#icon_end').text(  $('#back_end').text());
            } 
            if ($(this).data('icon') == WS){
                $('#WsID').removeClass('fa fa-ban icon-preview hide-if-upload');
                $('#WsID').addClass('fa icon-preview hide-if-upload ' + $(this).data('icon'));;
                $('#wrap_start').text(glyp);
                $('#icon_start').text(  $('#wrap_start').text());
                $('#icon_end').text(  $('#wrap_end').text());
            } 
            if ($(this).data('icon') == WE){
                $('#WeID').removeClass('fa fa-ban icon-preview hide-if-upload');
                $('#WeID').addClass('fa icon-preview hide-if-upload ' + $(this).data('icon'));;
                $('#wrap_end').text(glyp);
                $('#icon_start').text(  $('#wrap_start').text());
                $('#icon_end').text(  $('#wrap_end').text());
            }
        });

        if(FS.indexOf('.') > -1)
        {
            $('#FsID').css({display: 'none'});
            $('#FsID').next('img.image-upload').css({display: 'inline-block'});
            $('#FsID').next('img.image-upload').attr('src', '/wp-content/uploads/clipart/thumbnail/'+FS);
        }

        if(FE.indexOf('.') > -1)
        {
            $('#FeID').css({display: 'none'});
            $('#FeID').next('img.image-upload').css({display: 'inline-block'});
            $('#FeID').next('img.image-upload').attr('src', '/wp-content/uploads/clipart/thumbnail/'+FE);
        }

        if(BS.indexOf('.') > -1)
        {
            $('#BsID').css({display: 'none'});
            $('#BsID').next('img.image-upload').css({display: 'inline-block'});
            $('#BsID').next('img.image-upload').attr('src', '/wp-content/uploads/clipart/thumbnail/'+BS);
        }

        if(BE.indexOf('.') > -1)
        {
            $('#BeID').css({display: 'none'});
            $('#BeID').next('img.image-upload').css({display: 'inline-block'});
            $('#BeID').next('img.image-upload').attr('src', '/wp-content/uploads/clipart/thumbnail/'+BE);
        }

        if(WS.indexOf('.') > -1)
        {
            $('#WsID').css({display: 'none'});
            $('#WsID').next('img.image-upload').css({display: 'inline-block'});
            $('#WsID').next('img.image-upload').attr('src', '/wp-content/uploads/clipart/thumbnail/'+WS);
        }

        if(WE.indexOf('.') > -1)
        {
            $('#WeID').css({display: 'none'});
            $('#WeID').next('img.image-upload').css({display: 'inline-block'});
            $('#WeID').next('img.image-upload').attr('src', '/wp-content/uploads/clipart/thumbnail/'+WE);
        }

        Builder.data.clipart['front_start'] = FS;
        Builder.data.clipart['front_end'] = FE;
        Builder.data.clipart['back_start'] = BS;
        Builder.data.clipart['back_end'] = BE;

        Builder.data.clipart['wrap_end'] = WS;
        Builder.data.clipart['wrap_start'] = WE;

        Builder.data.clipart['wristband_stat'] = WristStat;
    }


     function DistributeAddup(){
        var TempCnt = Builder.CntID;
        if (TempCnt > 0){

            var CntDis = 0,
                ArrayID = [],
                CntTemp = 0,
                TotalCnt = 0,
                ArrayCount = [];

            for(var x=0;x<= TempCnt;x++){
                if (document.getElementById("inpAdult-" + x)){
                    if (toInt($("#inpAdult-" + x).val()) > 0){
                        ArrayID[CntTemp] = "spanAdultup-" + x;
                        ArrayCount[CntTemp] = toInt($("#inpAdult-" + x).val());
                        TotalCnt = Number(TotalCnt) + toInt($("#inpAdult-" + x).val());
                        CntTemp++;
                    } 

                    if (toInt($("#inpMedium-" + x).val()) > 0){
                        ArrayID[CntTemp] = "spanMediumup-" + x;
                        ArrayCount[CntTemp] = toInt($("#inpMedium-" + x).val());
                        TotalCnt = Number(TotalCnt) + toInt($("#inpMedium-" + x).val());
                        CntTemp++;
                    }

                    if (toInt($("#inpYouth-" + x).val()) > 0){
                        ArrayID[CntTemp] = "spanYouthup-" + x;
                        ArrayCount[CntTemp] = toInt($("#inpYouth-" + x).val());
                        TotalCnt = Number(TotalCnt) + toInt($("#inpYouth-" + x).val());
                        CntTemp++;
                    }
                    $("#spanAdultup-" + x).html("");
                    $("#spanMediumup-" + x).html("");
                    $("#spanYouthup-" + x).html("");
                }
            }


            // Equal distribution
            /* var b = 100,      c = ArrayID.length,
                d = 100%c,    e = b - d,
                f = e / c,    g = f + d,          first = true;

            if (TotalCnt > 100){
                for(var a=0;a <= ArrayID.length-1;a++){
                    if (first){
                        $("#" + ArrayID[a]).html("&nbsp; +" + g );
                        first = false;
                    } else { $("#" + ArrayID[a]).html("&nbsp; +" + f ); }
                }
            } */

            // Proportional distribution
            if (TotalCnt >= 100){
                var calcTotal = 0, ArrayCalc = [], first = true;
                for(var a=0;a <= ArrayID.length-1;a++){
                    ArrayCalc[a] = toInt( ( toInt( ArrayCount[a] ) / toInt( TotalCnt ) ) * 100 );
                    calcTotal += toInt( ( toInt( ArrayCount[a] ) / toInt( TotalCnt ) ) * 100 );
                }

                var reminder = 100 % toInt( calcTotal );
                for(var a=0;a <= ArrayID.length-1;a++){
                    if(first)
                    {
                        $("#" + ArrayID[a]).html("&nbsp; +" + (toInt( ArrayCalc[a] ) + toInt( reminder) ) );
                        $("#" + ArrayID[a]).attr("data-plus", (toInt( ArrayCalc[a] ) + toInt( reminder) ) );
                        first = false;
                    }
                    else
                    {
                        if(ArrayCalc[a] != 0)
                        {
                            $("#" + ArrayID[a]).html("&nbsp; +" + ArrayCalc[a] );
                            $("#" + ArrayID[a]).attr("data-plus", ArrayCalc[a] );
                        }
                    }
                }
            }
        }
    }

    // function SelectBandColor(StyleColor,y){
    //     var insidesolid = document.getElementById("insidesolid");
    //     var outsidesolid = document.getElementById("outsidesolid");
    //     var bandcolor = document.getElementById("bandcolor");

    //     var mask1       = document.getElementById("mask1");               
    //     var mask1inside = document.getElementById("mask1inside");

    //     var mask2       = document.getElementById("mask2");             
    //     var mask2inside = document.getElementById("mask2inside");

    //     mask1.style.opacity = 1;            
    //     mask1inside.style.opacity = 1; 

    //     mask2.style.opacity = 1;            
    //     mask2inside.style.opacity = 1;

    //     if (StyleColor == "Segmented"){

    //     } else if (StyleColor == "Swirl"){
    //         var SplitColor = y.split(",");

    //         insidesolid.style.fill = SplitColor[0];
    //         bandcolor.style.fill = SplitColor[0];

    //         outsidesolid.style.fill = SplitColor[0];
          
    //         mask1.style.fill = SplitColor[1];            
    //         mask1inside.style.fill = SplitColor[1];

    //         mask2.style.fill = SplitColor[2];               
    //         mask2inside.style.fill = SplitColor[2];
    //     } else {
    //         insidesolid.style.fill=y;
    //         outsidesolid.style.fill=y;
    //         bandcolor.style.fill=y;
    //         mask1.style.fill = y;            
    //         mask1inside.style.fill = y;
    //         mask2.style.fill = y;               
    //         mask2inside.style.fill = y;
    //     }
    // }

function SelectBandColor(StyleColor,y){
        var insidesolid = document.getElementById("insidesolid");
        var outsidesolid = document.getElementById("outsidesolid");
        var bandcolor = document.getElementById("bandcolor");

        //var mask1       = document.getElementById("mask1");               
        //var mask1inside = document.getElementById("mask1inside");

        //var mask2       = document.getElementById("mask2");             
        //var mask2inside = document.getElementById("mask2inside");

        var insidesolid1 = document.getElementById("insidesolid1");
        var insidesolid2 = document.getElementById("insidesolid2");
        var outsidesolid1 = document.getElementById("outsidesolid1");
        var outsidesolid2 = document.getElementById("outsidesolid2");
        var mask1_band1 = document.getElementById("mask1_band1");
        var mask1inside_band1 = document.getElementById("mask1inside_band1");
        var mask2inside_band1 = document.getElementById("mask2inside_band1");
        var mask1_band2 = document.getElementById("mask1_band2");
        var mask1inside_band2 = document.getElementById("mask1inside_band2");
        var mask2_band2 = document.getElementById("mask2_band2");
        var mask2inside_band2 = document.getElementById("mask2inside_band2");

/// insidesolid1
/// insidesolid2
/// outsidesolid1
/// outsidesolid2
/// mask1_band1
/// mask1inside_band1
/// mask2inside_band1
/// mask1_band2
/// mask1inside_band2
/// mask2_band2
/// mask2inside_band2
// segcolor1_band1
// segcolor1_cover_band1
// segcolor2_band1
// segcolor2_cover_band1
// segcolor3_band1
// segcolor1_band2
// segcolor1_cover_band2
// segcolor2_band2
// segcolor2_cover_band2
// segcolor3_band2

    
        //mask1.style.opacity = 1;            
        //mask1inside.style.opacity = 1; 

        //mask2.style.opacity = 1;            
        //mask2inside.style.opacity = 1;

        mask1_band1.style.opacity = 1;
        mask1inside_band1.style.opacity = 1;
        mask2inside_band1.style.opacity = 1;

        mask1_band2.style.opacity = 1;

        mask1inside_band2.style.opacity = 1;
        mask2_band2.style.opacity = 1;
        mask2inside_band2.style.opacity = 1;


        if (StyleColor == "Segmented"){

        } else if (StyleColor == "Swirl"){
            var SplitColor = y.split(",");

            insidesolid.style.fill = SplitColor[0];
            bandcolor.style.fill = SplitColor[0];

            outsidesolid.style.fill = SplitColor[0];
          
            mask1.style.fill = SplitColor[1];            
            mask1inside.style.fill = SplitColor[1];

            mask2.style.fill = SplitColor[2];               
            mask2inside.style.fill = SplitColor[2];
        } else {
            // insidesolid.style.fill=y;
            // outsidesolid.style.fill=y;
            // bandcolor.style.fill=y;
            //mask1.style.fill = y;            
            //mask1inside.style.fill = y;
            //mask2.style.fill = y;               
            //mask2inside.style.fill = y;
            
            insidesolid1.style.fill=y;
            insidesolid2.style.fill=y;
            outsidesolid1.style.fill=y;
            outsidesolid2.style.fill=y;
            mask1_band1.style.fill=y;
            mask1inside_band1.style.fill=y;
            mask2inside_band1.style.fill=y;
            mask1_band2.style.fill=y;
            mask1inside_band2.style.fill=y;
            mask2_band2.style.fill=y;
            mask2inside_band2.style.fill=y;
        }
    }

    function AddNewColor($wc){
        // var $wc = $('#wristband-color-tab .color-wrap.selected > div'),
        var $tc = $('#wristband-text-color .color-wrap.selected > div'),
            bg_style_tpl_text = '<div class="{{hide}}"><div class="color-wrap colortext--wrap color-text-added" data-toggle="modal" data-target="#wristband-text-color-modal" ' +
                                'style="display:{{style_display}}" ><div data-color="{{bg_color}}" style="background-color:{{bg_color}}; ' +
                                'background: -webkit-linear-gradient(90deg,{{bg_color}});background: -o-linear-gradient(90deg,{{bg_color}}); ' +
                                'background: -moz-linear-gradient(90deg,{{bg_color}});background: linear-gradient(90deg,{{bg_color}});"></div></div>{{qty}}</div>',
            $aq    = $('#qty_adult'),
            $mq    = $('#qty_medium'),
            $yq    = $('#qty_youth');

        var _adult_qty   = toInt($aq.val()),
            _medium_qty  = toInt($mq.val()),
            _youth_qty   = toInt($yq.val()),
            _wristband_text_color_box = '',
            _adult_qtyE   = 0,
            _medium_qtyE  = 0,
            _youth_qtyE   = 0;

        if ((toInt($aq.val()) <= 0 && toInt($mq.val()) <= 0 && toInt($yq.val()) <= 0)) { Builder.popupMsg('error', 'Error', 'Please select wristband color/text color/quantity.'); return; }
        if ( typeof($wc.data('name')) == 'undefined' ) { Builder.popupMsg('error', 'Error', 'Please select wristband color/text color/quantity.'); return; }
        
        //====================== Check table
        var _txtColorName = "White",
            _txtColor = "#FFFFFF";

        var textStyle = $("#style").find("option:selected").text();
        if (textStyle == "Blank" || textStyle == "Figured" || textStyle == "Embossed" || textStyle == "Debossed"){ _wristband_text_color_box = Mustache.render(bg_style_tpl_text, {hide: '',style_display: 'none', bg_color: '#ffffff', qty: ''});
        
        } else {
            _wristband_text_color_box = Mustache.render(bg_style_tpl_text, {hide: '',style_display: 'inline-block', bg_color: $tc.data('color'), qty: ''}); 
            _txtColorName = $tc.data('name');
            _txtColor = $tc.data('color');
        }

        var bg_style_tpl = '<div class="{{hide}}"><div class="color-wrap color-added" data-textColor="' + _txtColor + '" data-W_type="' + $('input[name="color_style"]:checked').val() + '"><div data-color="{{bg_color}}" ' + 
            ' style="background-color:{{bg_color}};background: -webkit-linear-gradient(90deg,{{bg_color}});' +
            'background: -o-linear-gradient(90deg,{{bg_color}});background: -moz-linear-gradient(90deg,{{bg_color}});' +
            'background: linear-gradient(90deg,{{bg_color}});"></div>&nbsp;<span class="SpanColorbox">' + $wc.data('name') + " - " + $('input[name="color_style"]:checked').val() + '</span></div>{{qty}}</div>',
            _wristband_color_box    = Mustache.render(bg_style_tpl, {hide: '', bg_color: $wc.data('color'), qty: ''});



        var SaveStatus = true,
            SelectedID = "";
        for(var x=0;x<=Builder.CntID;x++){
            if (document.getElementById("inpAdult-" + x)){ 
                if ($("#DelID-" + x).attr('data-name') == $wc.data('name') && $("#DelID-" + x).attr('data-textname') == _txtColorName && $("#DelID-" + x).attr('data-type') == $('input[name="color_style"]:checked').val()){ SaveStatus = false; SelectedID = x; break; } 
            }
        }

        if (SaveStatus){
        //===============Add Color
            Builder.CntID++;

            var TempID = Builder.CntID; 
            var row_tpl = Mustache.render(
                '<tr data-name="{{name}}" class="option-tr" id="Tr-' + TempID + '">'
                + '<td style="text-align: left" id="colorBox-' + TempID + '"><div class="DivColorBox">{{{wristband_color_box}}}</div></td>'
                + '<td style="text-align: left"><left><span style="font-weight: bold;" id="spanAdult-' + TempID +'">{{{adult_qt}}}</span><span id="spanAdultup-' + TempID + '" class="CssAddup"></span><input type="number" min="0" class="input-text fusion-one-third InpCss keyupTxtView" id="inpAdult-' + TempID + '" value="{{{num_aq}}}"><span id="spanAdultupE-' + TempID + '" class="CssAddup keyupSpanEdit" style="display:none">+</span><input type="number" min="0" class="input-text fusion-one-third InpCss CssAddup keyupTxtEdit" id="inpAdultE-' + TempID + '" value="{{{num_aqE}}}"></left></td>'
                + '<td style="text-align: left"><left><span style="font-weight: bold;" id="spanMedium-' + TempID +'">{{{medium_qty}}}</span><span id="spanMediumup-' + TempID + '" class="CssAddup"></span><input type="number" min="0" class="input-text fusion-one-third InpCss keyupTxtView" id="inpMedium-' + TempID + '" value="{{{num_mq}}}"><span id="spanMediumupE-' + TempID + '" class="CssAddup keyupSpanEdit" style="display:none">+</span><input type="number" min="0" class="input-text fusion-one-third InpCss CssAddup keyupTxtEdit" id="inpMediumE-' + TempID + '" value="{{{num_mqE}}}"></left></td>'
                + '<td style="text-align: left"><left><span style="font-weight: bold;" id="spanYouth-' + TempID +'">{{{youth_qty}}}</span><span id="spanYouthup-' + TempID + '" class="CssAddup"></span><input type="number" min="0" class="input-text fusion-one-third InpCss keyupTxtView" id="inpYouth-' + TempID + '" value="{{{num_yq}}}"><span id="spanYouthupE-' + TempID + '" class="CssAddup keyupSpanEdit" style="display:none">+</span><input type="number" min="0" class="input-text fusion-one-third InpCss CssAddup keyupTxtEdit" id="inpYouthE-' + TempID + '" value="{{{num_yqE}}}"></left></td>'
                + '<td style="text-align: left" id="colorTextBox-' + TempID + '"><center>{{{wristband_text_color_box}}}</center></td>'
                + '<td colspan="1" style="text-align: right;"><a style="display:none;" href="#" id="EditID-' + TempID +'"  data-name="{{name}}" class="edit-selection" data-tempID="' + TempID +'">Edit</a><a id="DelID-' + TempID +'" href="#" class="delete-selection CssTitleRed font-size-11" data-tempID="' + TempID +'" data-name="{{name}}" data-textname="{{textColorName}}" data-type="{{Wrist_Type}}">Delete</a></td>'
                + '</tr>',
                {
                    name                        : $wc.data('name'),
                    adult_qt                    : _adult_qty,
                    medium_qty                  : _medium_qty,
                    youth_qty                   : _youth_qty,
                    wristband_color_box         : _wristband_color_box,
                    wristband_text_color_box    : _wristband_text_color_box,
                    num_aq                      : toInt($aq.val()),
                    num_mq                      : toInt($mq.val()),
                    num_yq                      : toInt($yq.val()),
                    num_aqE                     : 0,
                    num_mqE                     : 0,
                    num_yqE                     : 0,
                    textColorName               : ($tc.data('name') == null)? _txtColorName : $tc.data('name'),
                    Wrist_Type                  : $('input[name="color_style"]:checked').val(),
               }
            );
            var $tr = $('#selected_color_table > tbody tr[data-name="'+ $wc.data('name') +'"]');
            $('#selected_color_table > tbody').append(row_tpl);

            DistributeAddup();//Addup

            _adult_qtyE = $('#spanAdultup-'+TempID).data('plus');
            _medium_qtyE = $('#spanMediumup-'+TempID).data('plus');
            _youth_qtyE = $('#spanYouthup-'+TempID).data('plus');

            Builder.addColor($wc.data('name'), {
                name                : $wc.data('name'),
                color               : $wc.data('color'),
                type                : $('input[name="color_style"]:checked').val(),
                text_color_name     : _txtColorName,
                text_color          : _txtColor,
                sizes: {
                    adult           : toInt($aq.val()),
                    medium          : toInt($mq.val()),
                    youth           : toInt($yq.val()),
                },
                free: {
                    adult           : toInt(_adult_qtyE),
                    medium          : toInt(_medium_qtyE),
                    youth           : toInt(_youth_qtyE),
               }
            });
            Builder.addFreeColor($wc.data('name'), {
                free: {
                    adult           : toInt(_adult_qtyE),
                    medium          : toInt(_medium_qtyE),
                    youth           : toInt(_youth_qtyE),
               }
            });

            if ($("#EditSaveID").html() == "Save"){ Enab_Dis("Disabled"); }
         //   
        //===================================
        } else {
            var Total_aq = Number(_adult_qty) + Number($("#inpAdult-" + SelectedID).val());
            var Total_mq = Number(_medium_qty) + Number($("#inpMedium-" + SelectedID).val());
            var Total_yq = Number(_youth_qty) + Number($("#inpYouth-" + SelectedID).val());

            $("#spanAdult-" + SelectedID).html(numberFormat(toInt(Total_aq), 0));
            $("#spanMedium-" + SelectedID).html(numberFormat(toInt(Total_mq), 0));
            $("#spanYouth-" + SelectedID).html(numberFormat(toInt(Total_yq), 0));

            $("#inpAdult-" + SelectedID).val(toInt(Total_aq));
            $("#inpMedium-" + SelectedID).val(toInt(Total_mq));
            $("#inpYouth-" + SelectedID).val(toInt(Total_yq));

            DistributeAddup();//Addup

            _adult_qtyE = $('#spanAdultup-' + SelectedID).data('plus');
            _medium_qtyE = $('#spanMediumup-' + SelectedID).data('plus');
            _youth_qtyE = $('#spanYouthup-' + SelectedID).data('plus');
         
            Builder.updateColor($wc.data('name'), _txtColorName, $('input[name="color_style"]:checked').val(), {
                                            name: $wc.data('name'),
                                            color: $wc.data('color'),
                                            type: $('input[name="color_style"]:checked').val(),
                                            text_color: ($tc.data('color') == null)? '#FFFFFF' : $tc.data('color'),
                                            text_color_name: _txtColorName,
                                            sizes: {
                                                adult: toInt(Total_aq),
                                                medium:toInt(Total_mq),
                                                youth: toInt(Total_yq),
                                            },
                                            free: {
                                                adult: toInt(_adult_qtyE),
                                                medium:toInt(_medium_qtyE),
                                                youth: toInt(_youth_qtyE),
                                            }
                                        });
        }

        // update free distribution in Builder
        for (var x=0;x<= Builder.CntID;x++){
                if (document.getElementById("DelID-" + x)){
                    var ColorName = $("#DelID-" + x).attr('data-name'),
                        TextColorName = $("#DelID-" + x).attr('data-textname'),
                        Type = $("#DelID-" + x).attr('data-type'),
                        aq = $("#inpAdult-" + x),
                        mq = $("#inpMedium-" + x),
                        yq = $("#inpYouth-" + x),
                        aqE = $("#spanAdultup-" + x),
                        mqE = $("#spanMediumup-" + x),
                        yqE = $("#spanYouthup-" + x);

                        Builder.updateColor(ColorName, TextColorName,Type, {
                                                        name: "",
                                                        color: "",
                                                        type: "",
                                                        text_color: "",
                                                        text_color_name: "",
                                                        sizes: {
                                                            adult: toInt(aq.val()),
                                                            medium:toInt(mq.val()),
                                                            youth: toInt(yq.val()),
                                                        },
                                                        free: {
                                                            adult: toInt(aqE.attr('data-plus')),
                                                            medium:toInt(mqE.attr('data-plus')),
                                                            youth: toInt(yqE.attr('data-plus')),
                                                        }
                                                    });
                }
        }
        $('#qty_adult, #qty_medium, #qty_youth').val('');
        Builder.renderProductionShippingOptions();
        return false;
    }


    function Enab_Dis(Stat){
        for(var x=0;x<=Builder.CntID;x++){
            if (document.getElementById("inpAdult-" + x)){
            var TempId = x;
                if (Stat == "Enabled" || Stat == "SaveEdit"){
                    $("#spanAdult-" + TempId).show();
                    $("#spanMedium-" + TempId).show();
                    $("#spanYouth-" + TempId).show();

                    $("#spanAdultup-" + TempId).show();
                    $("#spanMediumup-" + TempId).show();
                    $("#spanYouthup-" + TempId).show();

                    $("#inpAdult-" + TempId).hide();
                    $("#inpMedium-" + TempId).hide();
                    $("#inpYouth-" + TempId).hide();

                    $("#spanAdultupE-" + TempId).hide();
                    $("#spanMediumupE-" + TempId).hide();
                    $("#spanYouthupE-" + TempId).hide();

                    $("#inpAdultE-" + TempId).hide();
                    $("#inpMediumE-" + TempId).hide();
                    $("#inpYouthE-" + TempId).hide();

                    if (Stat == "SaveEdit"){
                        $("#spanAdult-" + TempId).html(numberFormat(toInt($("#inpAdult-" + TempId).val()), 0));
                        $("#spanMedium-" + TempId).html(numberFormat(toInt($("#inpMedium-" + TempId).val()), 0));
                        $("#spanYouth-" + TempId).html(numberFormat(toInt($("#inpYouth-" + TempId).val()), 0));

                        if(toInt($("#inpAdultE-" + TempId).val()) > 0)
                        {
                            $("#spanAdultup-" + TempId).html('&nbsp; +'+numberFormat(toInt($("#inpAdultE-" + TempId).val()), 0));
                            $("#spanAdultup-" + TempId).attr("data-plus", toInt($("#inpAdultE-" + TempId).val()));
                        }

                        if(toInt($("#inpMediumE-" + TempId).val()) > 0)
                        {
                            $("#spanMediumup-" + TempId).html('&nbsp; +'+numberFormat(toInt($("#inpMediumE-" + TempId).val()), 0));
                            $("#spanMediumup-" + TempId).attr("data-plus", toInt($("#inpMediumE-" + TempId).val()));
                        }

                        if(toInt($("#inpYouthE-" + TempId).val()) > 0)
                        {
                            $("#spanYouthup-" + TempId).html('&nbsp; +'+numberFormat(toInt($("#inpYouthE-" + TempId).val()), 0));
                            $("#spanYouthup-" + TempId).attr("data-plus", toInt($("#inpYouthE-" + TempId).val()));
                        }
                    } else {
                        $("#inpAdult-" + TempId).val($("#spanAdult-" + TempId).html().replace(",",""));
                        $("#inpMedium-" + TempId).val($("#spanMedium-" + TempId).html().replace(",",""));
                        $("#inpYouth-" + TempId).val($("#spanYouth-" + TempId).html().replace(",",""));
                    }
                    $("#DelID-" + TempId).closest('.delete-selection').removeClass('CssDisabledDel');
                } else {
                    $("#spanAdult-" + TempId).hide();
                    $("#spanMedium-" + TempId).hide();
                    $("#spanYouth-" + TempId).hide();

                    $("#spanAdultup-" + TempId).hide();
                    $("#spanMediumup-" + TempId).hide();
                    $("#spanYouthup-" + TempId).hide();

                    $("#inpAdult-" + TempId).show();
                    $("#inpMedium-" + TempId).show();
                    $("#inpYouth-" + TempId).show();
                    $("#DelID-" + TempId).closest('.delete-selection').addClass('CssDisabledDel');
                    $("#inpAdult-" + TempId).val($("#spanAdult-" + TempId).html().replace(",",""));
                    $("#inpMedium-" + TempId).val($("#spanMedium-" + TempId).html().replace(",",""));
                    $("#inpYouth-" + TempId).val($("#spanYouth-" + TempId).html().replace(",",""));

                    if(Builder.data.total_qty >= 100)
                    {
                        $("#spanAdultupE-" + TempId).css( "display", "block") ;
                        $("#inpAdultE-" + TempId).val($("#spanAdultup-" + TempId).attr('data-plus'));
                        $("#inpAdultE-" + TempId).show();
                    }

                    if(Builder.data.total_qty >= 100)
                    {
                        $("#spanMediumupE-" + TempId).css( "display", "block") ;
                        $("#inpMediumE-" + TempId).val($("#spanMediumup-" + TempId).attr('data-plus'));
                        $("#inpMediumE-" + TempId).show();
                    }

                    if(Builder.data.total_qty >= 100)
                    {
                        $("#spanYouthupE-" + TempId).css( "display", "block") ;
                        $("#inpYouthE-" + TempId).val($("#spanYouthup-" + TempId).attr('data-plus'));
                        $("#inpYouthE-" + TempId).show();
                    }
                }
            }
        }
    }


    function WithTextColor(textStyle){
        var items = [];

        if (textStyle){ /*nothing */ } 
        else {
            for (var i in Builder.data.colors) {
                var TempName = Builder.data.colors[i].name,
                    TempColor = Builder.data.colors[i].color,
                    TempType = Builder.data.colors[i].type,
                    TempText_color = Builder.data.colors[i].text_color,
                    TempText_color_name = Builder.data.colors[i].text_color_name,
                    TempAdult = Builder.data.colors[i].sizes['adult'],
                    TempMedium = Builder.data.colors[i].sizes['medium'],
                    TempYouth = Builder.data.colors[i].sizes['youth'];


            //---------------------------------------------

                var AddStatus = true,
                    FullItem = "";

                 for (var x in items) {
                    if (items[x].name == TempName && items[x].type == TempType){
                        items[x].sizes['adult'] = Number(TempAdult) + Number(items[x].sizes['adult']);
                        items[x].sizes['medium'] = Number(TempMedium) + Number(items[x].sizes['medium']);
                        items[x].sizes['youth'] = Number(TempYouth) + Number(items[x].sizes['youth']);
                        AddStatus = false;
                        break;
                    }
                 }

                //*******************************
  
                if (AddStatus){
                    FullItem = {            
                                    name: TempName,
                                    color: TempColor,
                                    type: TempType,
                                    text_color: "#ffffff",
                                    text_color_name: "White",
                                    sizes: {
                                        adult: TempAdult,
                                        medium: TempMedium,
                                        youth: TempYouth,
                                    }
                                };
                    items.push(FullItem)   
                } 
            //---------------------------------------------
            }
            Builder.data.colors = items;
        }
    }


    function DeleteRows(){
        var myTable = document.getElementById("selected_color_table");
        var rowCount = myTable.rows.length;
        for (var x=rowCount-1; x>0; x--) { myTable.deleteRow(x); }
    }


    function CheckItems(){
        Builder.TempColors = Builder.data.colors;
        var textStyle = $("#style").find("option:selected").text(),
            TempArray = [];
  

        if (textStyle == "Blank" || textStyle == "Figured" || textStyle == "Embossed" || textStyle == "Debossed"){
            for (var i in Builder.data.colors) {
                var Tmp = {
                    name                : Builder.data.colors[i].name,
                    color               : Builder.data.colors[i].color,
                    type                : Builder.data.colors[i].type,
                    sizes: {
                        adult           : Builder.data.colors[i].sizes['adult'],
                        medium          : Builder.data.colors[i].sizes['medium'],
                        youth           : Builder.data.colors[i].sizes['youth'],
                   }
                }
                TempArray.push(Tmp);
            }
            Builder.data.colors = TempArray;
        }
    }


    function ConnectItems(){ Builder.data.colors = Builder.TempColors; }


    function getImageToDisplay(width) {
            //var textdesign = $('input[name=textdesign]').filter(':checked').val();
            //var size = $("#ddlSize").val();
             var newwidth = width.replace('/','_');
            $("#img1_1").attr("display", "none");
            $("#img1_1_2").attr("display", "none");
            $("#img1_3_4").attr("display", "none");
            $("#img1_1_4").attr("display", "none");
            $("#img2_1").attr("display", "none");
            $("#img2_1_2").attr("display", "none");
            $("#img2_3_4").attr("display", "none");
            $("#img2_1_4").attr("display", "none");
            $("#arc1").attr("display", "none");

            $("#no_arc_img1_1").attr("display", "none");
            $("#no_arc_img1_1_2").attr("display", "none");
            $("#no_arc_img1_3_4").attr("display", "none");
            $("#no_arc_img1_1_4").attr("display", "none");
            $("#no_arc_img2_1").attr("display", "none");
            $("#no_arc_img2_1_2").attr("display", "none");
            $("#no_arc_img2_3_4").attr("display", "none");
            $("#no_arc_img2_1_4").attr("display", "none");
            $("#arc2").attr("display", "none");
            //console.log(width);
            //console.log(newwidth);
            // if (textdesign !== 'inside') {
            //     $("#img1_" + wb[size]['ImgSource']).removeAttr("display");
            //     $("#img2_" + wb[size]['ImgSource']).removeAttr("display");
            // } else {
            //     $("#no_arc_img1_" + wb[size]['ImgSource']).removeAttr("display");
            //     $("#no_arc_img2_" + wb[size]['ImgSource']).removeAttr("display");

            //     $('#InsideArc')[0].setAttribute('d', wb[size]['InsideArc']);
            //     $("#arc1").removeAttr("display");
            //     $("#arc2").removeAttr("display");
            // }
            $("#img1_" + newwidth).removeAttr("display");
            $("#img2_" + newwidth).removeAttr("display");

            //$('#InsideArc')[0].setAttribute('d', wb[size]['InsideArc']);
            //$("#arc1").removeAttr("display");
            //$("#arc2").removeAttr("display");
        }


// function changeFontSize() {
//         if ($("#txtInput1").val().length < 6) {
//             document.getElementById("bandtext1").style.fontSize = wb[$("#ddlSize").val()]['MaxFont'] + 'px';
//         }
//         if ($("#txtInput2").val().length < 6) {
//             document.getElementById("bandtext2").style.fontSize = wb[$("#ddlSize").val()]['MaxFont'] + 'px';
//         }
//         if ($("#txtInputCont").val().length < 18) {
//             document.getElementById("bandtextcontainer").style.fontSize = wb[$("#ddlSize").val()]['MaxFont'] + 'px';
//             document.getElementById("bandtextcont1").style.fontSize = wb[$("#ddlSize").val()]['MaxFont'] + 'px';
//             document.getElementById("bandtextcont2").style.fontSize = wb[$("#ddlSize").val()]['MaxFont'] + 'px';
//         }
//         if ($("#txtInputInside").val().length < 18) {
//             document.getElementById("bandtextcontainer2").style.fontSize = wb[$("#ddlSize").val()]['MaxFont'] + 'px';
//             document.getElementById("bandtextinside1").style.fontSize = wb[$("#ddlSize").val()]['MaxFont'] + 'px';
//             document.getElementById("bandtextinside2").style.fontSize = wb[$("#ddlSize").val()]['MaxFont'] + 'px';
//         }
//     }








    $(document).ready(function() {

        $(document.body)

            .on('click','.prdct-info', function() {

                var slctd_product = Settings.products[$('#style').val()];
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
                var textStyle = this.options[this.selectedIndex].text,
                    slctd_product = Settings.products[this.value];
                
                ChangeStyle(textStyle);
                e.preventDefault();
               // Builder.reset();

                WithTextColor(slctd_product.text_color);
                var i = [],
                    slctd_style = $(this).val(),
                    color_lists = Builder.data.colors;

                 //console.log(slctd_product);
                if (slctd_product != undefined) {
                    if (document.getElementById("wbc_add_to_cart")){
                        $('#wbc_add_to_cart').removeAttr('disabled');
                    }
                    $('select#width').empty().removeAttr('disabled');

                    for( var size in slctd_product.sizes) { i.push(slctd_product.sizes[size].count); } 
                    var hold_index_sort = i.sort();

                    for( var index_size in hold_index_sort) {
                        for(var size in slctd_product.sizes) {
                            if(index_size == slctd_product.sizes[size].count ) {
                                var $option = $('<option>').val(size).text(size);
                                                       
                                    if (size == slctd_product.default_size) {
                                        $option = $('<option>').val(size).attr('selected','selected').text(size).attr('data-group', Builder.getSizeGroup(size));
                                    } else {
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
                    $('#wristband-text-color-modal-body ul').empty();
                    $('#selectTextColorLabel').hide();

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
                            var tplModal = '<li><div class="color-wrap"><div data-name="{{name}}" data-color="{{color}}" style="background-color:{{color}};"></div></div></li>';
                            var renderModal = Mustache.render(tplModal, {
                                name: slctd_product.text_color[i].name,
                                color: slctd_product.text_color[i].color
                            });
                            $('#wristband-text-color-modal-body ul').append(renderModal);
                        }
                        $('#selectTextColorLabel').show();
                   } else { /* $('#wristband-text-color').closest('.form-group').hide(); */ }

                    messageOptionDisplay($('input[name="message_type"]:checked').val()); // display the default message option which front, back & inside
                    // wbTextColor(); //display the text color in the wristband preview
                    DeleteRows();

                    //get the color list and update the additional color table list
                    var free_lists = Builder.data.free_colors;
                    var lists = Builder.data.colors;
                    Builder.CntID = 0;
                    var TempID = Builder.CntID;
                    for (var index in lists) {
                        var bg_style_tpl =  '<div class="{{hide}}"><div class="color-wrap color-added" data-textColor="' + lists[index].text_color + '" data-w_type="' + lists[index].type + '"><div data-color="{{bg_color}}" ' + 
                                            'style="background-color:{{bg_color}};background: -webkit-linear-gradient(90deg,{{bg_color}});' +
                                            'background: -o-linear-gradient(90deg,{{bg_color}});background: -moz-linear-gradient(90deg,{{bg_color}});' + 
                                            'background: linear-gradient(90deg,{{bg_color}});"></div>&nbsp;<span class="SpanColorbox">' + lists[index].name + " - " + lists[index].type + '</span></div>{{qty}}</div>',
                        bg_style_tpl_text = '<div class="{{hide}}"><div class="color-wrap colortext--wrap color-text-added" data-toggle="modal" data-target="#wristband-text-color-modal" style="display:{{style_display}}" ' +
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
                            + '<td style="text-align: left" id="colorBox-' + TempID + '"><div class="DivColorBox">{{{wristband_color_box}}}</div></td>'
                            + '<td style="text-align: left"><left><span style="font-weight: bold;" id="spanAdult-' + TempID +'">{{{adult_qt}}}</span><span id="spanAdultup-' + TempID + '" class="CssAddup" data-plus="{{{num_aqE}}}">{{{num_aqE_view}}}</span><input type="number" min="0" class="input-text fusion-one-third InpCss keyupTxtView" id="inpAdult-' + TempID + '" value="{{{num_aq}}}"><span id="spanAdultupE-' + TempID + '" class="CssAddup keyupSpanEdit" style="display:none">+</span><input type="number" min="0" class="input-text fusion-one-third InpCss CssAddup keyupTxtEdit" id="inpAdultE-' + TempID + '" value="{{{num_aqE}}}"></left></td>'
                            + '<td style="text-align: left"><left><span style="font-weight: bold;" id="spanMedium-' + TempID +'">{{{medium_qty}}}</span><span id="spanMediumup-' + TempID + '" class="CssAddup" data-plus="{{{num_mqE}}}">{{{num_mqE_view}}}</span><input type="number" min="0" class="input-text fusion-one-third InpCss keyupTxtView" id="inpMedium-' + TempID + '" value="{{{num_mq}}}"><span id="spanMediumupE-' + TempID + '" class="CssAddup keyupSpanEdit" style="display:none">+</span><input type="number" min="0" class="input-text fusion-one-third InpCss CssAddup keyupTxtEdit" id="inpMediumE-' + TempID + '" value="{{{num_mqE}}}"></left></td>'
                            + '<td style="text-align: left"><left><span style="font-weight: bold;" id="spanYouth-' + TempID +'">{{{youth_qty}}}</span><span id="spanYouthup-' + TempID + '" class="CssAddup" data-plus="{{{num_yqE}}}">{{{num_yqE_view}}}</span><input type="number" min="0" class="input-text fusion-one-third InpCss keyupTxtView" id="inpYouth-' + TempID + '" value="{{{num_yq}}}"><span id="spanYouthupE-' + TempID + '" class="CssAddup keyupSpanEdit" style="display:none">+</span><input type="number" min="0" class="input-text fusion-one-third InpCss CssAddup keyupTxtEdit" id="inpYouthE-' + TempID + '" value="{{{num_yqE}}}"></left></td>'
                            + '<td style="text-align: left" id="colorTextBox-' + TempID + '"><center>{{{wristband_text_color_box}}}</center></td>'
                            + '<td colspan="1" style="text-align: right;"><a style="display:none;" href="#" id="EditID-' + TempID +'"  data-name="{{name}}" class="edit-selection" data-tempID="' + TempID +'">Edit</a><a id="DelID-' + TempID +'" href="#" class="delete-selection CssTitleRed font-size-11" data-tempID="' + TempID +'" data-name="{{name}}" data-textname="{{textColorName}}" data-type="{{Wrist_Type}}">Delete</a></td>'
                            + '</tr>',
                            {
                                name                        : lists[index].name,
                                adult_qt                    : numberFormat(toInt(lists[index].sizes['adult']), 0),
                                medium_qty                  : numberFormat(toInt(lists[index].sizes['medium']), 0),
                                youth_qty                   : numberFormat(toInt(lists[index].sizes['youth']), 0),
                                wristband_color_box         : _wristband_color_box,
                                wristband_text_color_box    : _wristband_text_color_box,
                                num_aq                      : lists[index].sizes['adult'],
                                num_mq                      : lists[index].sizes['medium'],
                                num_yq                      : lists[index].sizes['youth'],
                                num_aqE                     : free_lists[index].free['adult'],
                                num_mqE                     : free_lists[index].free['medium'],
                                num_yqE                     : free_lists[index].free['youth'],
                                num_aqE_view                : toInt(free_lists[index].free['adult']) > 0 ? ('&nbsp; +' + numberFormat(toInt(free_lists[index].free['adult']), 0)):'',
                                num_mqE_view                : toInt(free_lists[index].free['medium']) > 0 ? ('&nbsp; +' + numberFormat(toInt(free_lists[index].free['medium']), 0)):'',
                                num_yqE_view                : toInt(free_lists[index].free['youth']) > 0 ? ('&nbsp; +' + numberFormat(toInt(free_lists[index].free['youth']), 0)):'',
                                textColorName               : lists[index].text_color_name,
                                Wrist_Type                  : lists[index].type 
                           }
                        );

                    $('#selected_color_table > tbody').append(row_tpl); 
                    TempID++;
                    }

                    Builder.CntID = TempID;
                    if(slctd_product.text_color) {
                        $('.colortext--wrap').show(); // show text color in the additional table list
                        $('.text_to_alter').show();   // show th color in the additional table list
                         // wbTextColor();
                    } else {
                        $('.colortext--wrap').hide(); // hide text color in the additional table list
                        $('.text_to_alter').hide();   // hide text color in the additional table list
                    }
                }
                var width = $("#width").val();
                $("#SelectStyleID").html(textStyle + "&nbsp;-" + width);
                // wbTextColor();
            })
            // Populate width dropdown
            .on('change', 'select#width', function() {
                var tempSelect = document.getElementById("style");
                var tempVal = tempSelect.options[tempSelect.selectedIndex].text;
                var width = $("#width").val();
                $("#SelectStyleID").html(tempVal + "&nbsp;-" + $(this).val());
                getImageToDisplay(width);
                // changeFontSize();
                //console.log(width);
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
                 // wbTextColor();
                $('#qty_adult, #qty_medium, #qty_youth').trigger('keyup');
                Builder.observer();
            })

            // Text Color Modal Selection
            .on('click', '#wristband-text-color-modal-body .color-wrap', function() {
                $('#wristband-text-color-modal-body .color-wrap').removeClass('selected');
                $(this).addClass('selected');

                // update wristband preview text color
                /*var $frontext   = document.getElementById("bandtextpath"),
                    $insidetext = document.getElementById("bandtextpathinside");

                $frontext.style.fill = $(this).find('div').attr('data-color');
                $insidetext.style.fill = $(this).find('div').attr('data-color');
                $frontext.style.opacity = "1"; 
                $insidetext.style.opacity = "1"; */
                // EOL - update wristband preview text color

                var editIndex = $('#wristband-text-color-modal-body').attr('data-color_index');
                var colorEdit = $('.color-text-added').eq( editIndex ).html();
                $('.color-text-added').eq( editIndex ).html(colorEdit.replace(new RegExp($('#wristband-text-color-modal-body').attr('data-color'),"g"), $(this).find('div').attr('data-color')));
                $('#wristband-text-color-modal').modal('hide');

                Builder.data.colors[editIndex].text_color      = $(this).find('div').attr('data-color');
                Builder.data.colors[editIndex].text_color_name = $(this).find('div').attr('data-name');
            })

            // Wristband Color Selection
            .on('click', '#wristband-color-items .color-wrap', function() {
                var $aq    = $('#qty_adult'),
                    $mq    = $('#qty_medium'),
                    $yq    = $('#qty_youth');
                var previous_color_selected = "", previous_element = -1;
                if ( $('#wristband-color-items .color-wrap.selected').length )
                {
                    previous_color_selected = $('#wristband-color-items .color-wrap.selected').find('div').data('color');
                    previous_element = $('#wristband-color-items .color-wrap.selected').find('div');
                }

                var current_color_selected = $(this).find('div').data('color');

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
                    if ((toInt($aq.val()) > 0 ||toInt($mq.val()) > 0 || toInt($yq.val()) > 0)) 
                    { 
                        if(previous_color_selected != current_color_selected && previous_color_selected != "")
                            AddNewColor(previous_element); 
                    }
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
                if ($wc.length == 0 || (toInt($aq.val()) <= 0 && toInt($mq.val()) <= 0 && toInt($yq.val()) <= 0)){ return; }

                if(tbl_color == undefined) {
                    /*
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
*/
                    Builder.renderProductionShippingOptions();

                } 
            })
            .on('click', '#add_color_to_selections', function(e) {
                e.preventDefault();
                AddNewColor($('#wristband-color-items .color-wrap.selected').find('div'));
            })

            .on('keyup', '.keyupTxtView', function(e) {
                var total = 0;
                $('.keyupTxtView').each(function(index, elem){
                    total += toInt($(elem).val());
                });

                if(total >= 100)
                {
                    $('.keyupTxtEdit').css("display", "block");
                    $('.keyupSpanEdit').css("display", "block");

                    var totalFree = 0;
                    $('.keyupTxtEdit').each(function(index, elem){
                        totalFree += toInt($(elem).val());
                    });
                    $('#freeCounter').html('Total Free Wristband: '+totalFree);
                    var classN = 'CssTitleBlue';
                    if(totalFree != 100)
                        classN = 'CssTitleRed';
                    $('#freeCounter').attr('class', classN);
                }
                else
                {
                    $('.keyupTxtEdit').val(0);

                    $('.keyupTxtEdit').hide();
                    $('.keyupSpanEdit').hide();

                    $('#freeCounter').html('');
                }
            })

            .on('keyup', '.keyupTxtEdit', function(e) {
                var getVal = toInt($(this).parent('left').find('.keyupTxtView').val());
                if(getVal == 0)
                {
                    $(this).val(0);
                }

                var totalW = 0;
                $('.keyupTxtView').each(function(index, elem){
                    totalW += toInt($(elem).val());
                });
                if(totalW >= 100)
                {
                    var totalFree = 0;
                    $('.keyupTxtEdit').each(function(index, elem){
                        totalFree += toInt($(elem).val());
                    });
                    $('#freeCounter').html('Total Free Wristband: '+totalFree);
                    var classN = 'CssTitleBlue';
                    if(totalFree != 100)
                        classN = 'CssTitleRed';
                    $('#freeCounter').attr('class', classN);
                }
            })

            .on('click', '#EditSaveID', function(e) {
                var Stat = $(this).html();
                if (Stat == "Edit Quantity"){
                    $(this).html("Save");
                    $("#CancelID").html("Cancel");
                    Enab_Dis("Disabled");

                    if(Builder.data.total_qty >= 100)
                    {
                        $('#freeCounter').html('Total Free Wristband: 100');
                        $('#freeCounter').attr('class', 'CssTitleBlue');
                    }

                } else {
                    var Saving = true;
                    var total_qty = 0;
                    var totalFree = 0;
                    for (var x=0;x<= Builder.CntID;x++){
                        if (document.getElementById("DelID-" + x)){
                            var aq = $("#inpAdult-" + x).val(),
                                mq = $("#inpMedium-" + x).val(),
                                yq = $("#inpYouth-" + x).val(),
                                aqE = $("#inpAdultE-" + x).val(),
                                mqE = $("#inpMediumE-" + x).val(),
                                yqE = $("#inpYouthE-" + x).val();

                                if (toInt(aq) > 0 || toInt(mq) > 0 || toInt(yq) > 0){ 
                                    total_qty += toInt(aq);
                                    total_qty += toInt(mq);
                                    total_qty += toInt(yq);

                                    totalFree += toInt(aqE);
                                    totalFree += toInt(mqE);
                                    totalFree += toInt(yqE);
                                }
                                else{ 
                                    Saving = false; 
                                    break; 
                                }
                        }
                    }
                    //------------------------------------------------
                    if (Saving){
                    //*************************************
                        if(total_qty >= 100 && totalFree != 100) { Builder.popupMsg('error', 'Error', 'Current free wristband quantity is '+totalFree+'. Please make sure to make it 100 in all.');  return; }

                        for (var x=0;x<= Builder.CntID;x++){
                            if (document.getElementById("DelID-" + x)){
                                var ColorName = $("#DelID-" + x).attr('data-name'),
                                    TextColorName = $("#DelID-" + x).attr('data-textname'),
                                    Type = $("#DelID-" + x).attr('data-type'),
                                    aq = $("#inpAdult-" + x),
                                    mq = $("#inpMedium-" + x),
                                    yq = $("#inpYouth-" + x),
                                    aqE = $("#inpAdultE-" + x),
                                    mqE = $("#inpMediumE-" + x),
                                    yqE = $("#inpYouthE-" + x);

                                    Builder.updateColor(ColorName, TextColorName,Type, {
                                                                    name: "",
                                                                    color: "",
                                                                    type: "",
                                                                    text_color: "",
                                                                    text_color_name: "",
                                                                    sizes: {
                                                                        adult: toInt(aq.val()),
                                                                        medium:toInt(mq.val()),
                                                                        youth: toInt(yq.val()),
                                                                    },
                                                                    free: {
                                                                        adult: toInt(aqE.val()),
                                                                        medium:toInt(mqE.val()),
                                                                        youth: toInt(yqE.val()),
                                                                    }
                                                                });
                            }
                        }
                        $('#freeCounter').html('');
                        $(this).html("Edit Quantity");
                        $("#CancelID").html("");
                        Enab_Dis("SaveEdit");
                    //*************************************
                    } else { Builder.popupMsg('error', 'Error', 'Please select wristband color/text color/quantity.'); return; }
                }
            })

            .on('click', '#CancelID', function(e) {
                var Stat = $(this).html();

                if (Stat == "Cancel"){
                    $('#freeCounter').html('');
                    $("#EditSaveID").html("Edit Quantity");
                    $(this).html("");
                    Enab_Dis("Enabled");
                }
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
                    var $row = $(this).closest('tr'),
                        color_name = $(this).attr('data-name'),
                        color_Textname = $(this).attr('data-textname');

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
                    Builder.removeColor(color_name,color_Textname);

                    if (Builder.data.colors.length == 0){
                        $("#EditSaveID").html("Edit Quantity");
                        $("#CancelID").html("");
                        Enab_Dis("SaveEdit");
                        $('#freeCounter').html('');
                    }

                    return false;
                }
            })

    /*
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

                    $("#inpAdult-" + TempId).val($("#spanAdult-" + TempId).html().replace(",",""));
                    $("#inpMedium-" + TempId).val($("#spanMedium-" + TempId).html().replace(",",""));
                    $("#inpYouth-" + TempId).val($("#spanYouth-" + TempId).html().replace(",",""));

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

                    $("#spanAdult-" + TempId).html(numberFormat(toInt($("#inpAdult-" + TempId).val()), 0));
                    $("#spanMedium-" + TempId).html(numberFormat(toInt($("#inpMedium-" + TempId).val()), 0));
                    $("#spanYouth-" + TempId).html(numberFormat(toInt($("#inpYouth-" + TempId).val()), 0));



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
    */        
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
                            bg_style_tpl_text = '<div class="{{hide}}"><div class="color-wrap colortext--wrap color-text-added" data-toggle="modal" data-target="#wristband-text-color-modal" style="display:{{style_display}}" ><div data-color="{{bg_color}}" style="background-color:{{bg_color}};background: -webkit-linear-gradient(90deg,{{bg_color}});background: -o-linear-gradient(90deg,{{bg_color}});background: -moz-linear-gradient(90deg,{{bg_color}});background: linear-gradient(90deg,{{bg_color}});"></div></div>{{qty}}</div>';

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
                                        + '<td><left>{{{adult_qt}}}</left></td>'
                                        + '<td><left>{{{medium_qty}}}</left></td>'
                                        + '<td><left>{{{youth_qty}}}</left></td>'
                                        + '<td  style="text-align: left"><center>{{{wristband_text_color_box}}}</center></td>'
                                        + '<td><a href="#" id="edit" data-name="{{name}}" class="edit-selection"><i class="fa fa-pencil"></i></a><a href="#" class="delete-selection CssTitleRed"><i class="fa fa-trash"></i></a></td>'
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
                //milbert
                var SelectedColor = $(this).find('div').data('color'),
                    StyleDColor = $(this).attr('data-W_type');

                SelectBandColor(StyleDColor,SelectedColor);
                wbTextColorFromTbl($(this).attr('data-textcolor'))
            })

            .on('click', '.color-text-added', function(e){
                // update wristband preview text color
                /*var $frontext   = document.getElementById("bandtextpath"),
                    $insidetext = document.getElementById("bandtextpathinside");

                $frontext.style.fill = $(this).find('div').data('color');
                $insidetext.style.fill = $(this).find('div').data('color');
                $frontext.style.opacity = "1"; 
                $insidetext.style.opacity = "1"; */
                // EOL - update wristband preview text color

                $('#wristband-text-color-modal-body').attr('data-color', $(this).find('div').data('color'));
                $('#wristband-text-color-modal-body').attr('data-color_index', $(this).index('.color-text-added'));
                $('#wristband-text-color-modal-body .color-wrap').removeClass('selected');
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
                CheckItems();
                e.preventDefault();
                if (!Builder.validateForm()) { return; }

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
                    data: {meta: Builder.data, action: 'wbc_add_to_cart'},
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
                ConnectItems();
                return false;
            })



            .on('click', '#wbc_edit_to_cart', function(e) {
                CheckItems();
                e.preventDefault();
                if (!Builder.validateForm()) { return; }

                var $self = $(this),
                    $icon = $self.find('.fa'),
                    UpdateID = $("#EditModeID").val(),
                    $button_text = $self.find('.fusion-button-text-left');

                $icon.removeClass('fa-shopping-cart');
                $icon.addClass('fa-spinner');
                $button_text.text('Processing...');

                Builder.collectDataToPost();

                $.ajax({
                    url: WBC.ajax_url,
                    type: 'POST',
                    data: {UpdateID: UpdateID, meta: Builder.data, action: 'wbc_ajax_edit_to_cart'},
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
                    $("#mmk").html(response.data.message)

                    if (response.success)
                        setTimeout(function(){ window.location = "/cart"; }, 1000);
                });
                ConnectItems();
                return false;
            })


                //save button
            .on('click','#save_button',function(e) {
                e.preventDefault();

                if(Builder.data.total_qty > 0)
                {
                    var message_design = 'In a hurry? Enter your email address here and we will send you a link to your saved design to complete later.';
                    Builder.popupMsg('', 'Save Your Design', message_design+'<br><br><input type="text" placeholder="Email Address" id="SaveDesignEmail" style="width: 180px;"><a id="SendDesign" href="#" class="fusion-button button-default button-small">Send</a><div id="saveDesignMessage"></div>');
                }
                else
                {
                    Builder.popupMsg('error', 'Save Your Design', 'Please add color(s) to your wristband design.');
                }
            })

            .on('click','#SendDesign',function(e) {
                e.preventDefault();
                $('#SaveDesignEmail').removeClass('borderRed');
                 var emailFormat = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;

                if($('#SaveDesignEmail').val() != "" && emailFormat.test($('#SaveDesignEmail').val()))
                {
                    Builder.collectDataToPost();
                    
                    var holdData = Builder.data;
                    var tempSelect = document.getElementById("style");
                    var tempVal = tempSelect.options[tempSelect.selectedIndex].text;

                    holdData.title = tempVal;
                    holdData.size = $('#width').val();
                    holdData.email = $('#SaveDesignEmail').val();
                    $('#SendDesign').html('<i class="fa fa-spinner"></i>Send');

                    $.ajax({
                        url: WBC.ajax_url,
                        type: 'POST',
                        data: { meta: holdData, action: 'send_save_design'},
                        dataType: 'JSON',
                    }).done(function(response) {

                        $('#SaveDesignEmail').val('');
                        $('#SendDesign').html('Send');

                        var type = 'success',
                            title = 'Success',
                            classD = 'CssTitleBlue';

                        if (!response.success) {
                            type = 'error';
                            title = 'Error';
                            classD = 'CssTitleRed';
                        }
                        else {                            
                            var wc_colors = '';
                            $(holdData.colors).each(function(indx, val){
                                wc_colors += val.name+' - '+val.type+': '+val.color+', ';
                                if(val.text_color_name != '')
                                    wc_colors += 'Text Color: '+val.text_color_name+' - '+val.text_color+', ';
                                $(val.sizes).each(function(sindx, sval){
                                    if(sval.adult != 0)
                                    {
                                        wc_colors += 'Adult - '+sval.adult;
                                        if(holdData.free_colors[indx].free.adult != 0)
                                            wc_colors += ' + '+holdData.free_colors[indx].free.adult+', ';
                                        else
                                            wc_colors += ', ';
                                    }
                                    if(sval.medium != 0)
                                    {
                                        wc_colors += 'Medium - '+sval.medium;
                                        if(holdData.free_colors[indx].free.medium != 0)
                                            wc_colors += ' + '+holdData.free_colors[indx].free.medium+', ';
                                        else
                                            wc_colors += ', ';
                                    }
                                    if(sval.youth != 0)
                                    {
                                        wc_colors += 'Youth - '+sval.youth;
                                        if(holdData.free_colors[indx].free.youth != 0)
                                            wc_colors += ' + '+holdData.free_colors[indx].free.youth+', ';
                                        else
                                            wc_colors += ', ';
                                    }
                                });
                            });

                            var wc_additional_options = '';
                            $(holdData.additional_options).each(function(indx, val){
                                wc_additional_options += 'Additional Options: ';
                                wc_additional_options += val+', ';
                            });

                            var wc_message_type = '';
                            if(holdData.message_type == 'front_and_back')
                                wc_message_type = ' Front/Back';
                            else
                                wc_message_type = 'Wrap Around';

                            var wc_cust_shipping = '';
                            if(holdData.customization_date_shipping != '-- Select Shipping Time --')
                                wc_cust_shipping = holdData.customization_date_shipping;
                            var wc_cust_production = '';
                            if(holdData.customization_date_production != '-- Select Production Time --')
                                wc_cust_production = holdData.customization_date_production;

                            var wc_font = '';
                            if(holdData.font != -1)
                                wc_font = holdData.font;

                            $("#inf_field_Email").val(holdData.email);
                            $("#inf_custom_Design1").val(response.data.link);
                            $("#inf_custom_Style").val(holdData.title);
                            $("#inf_custom_Size").val(holdData.size);
                            $("#inf_custom_Colors0").text(wc_colors);
                            $("#inf_custom_MessageType").val(wc_message_type);
                            $("#inf_custom_FontStyle").val(wc_font);
                            $("#inf_custom_AdditionalNotes0").text(holdData.messages['Additional Notes']);
                            $("#inf_custom_FrontMessage").val(holdData.messages['Front Message']);
                            $("#inf_custom_BackMessage").val(holdData.messages['Back Message']);
                            $("#inf_custom_ContinuousMessage").val(holdData.messages['Continuous Message']);
                            $("#inf_custom_InsideMessage").val(holdData.messages['Inside Message']);
                            $("#inf_custom_AdditionalOptions0").text(wc_additional_options);
                            $("#inf_custom_FrontStart").val(holdData.clipart.front_start);
                            $("#inf_custom_FrontEnd").val(holdData.clipart.front_end);
                            $("#inf_custom_BackStart").val(holdData.clipart.back_start);
                            $("#inf_custom_BackEnd").val(holdData.clipart.back_end);
                            $("#inf_custom_WrapAroundStart").val(holdData.clipart.wrap_start);
                            $("#inf_custom_WrapAroundEnd").val(holdData.clipart.wrap_end);
                            $("#inf_custom_CustomizationLocation").val(holdData.customization_location);
                            $("#inf_custom_ProductionTime").val(wc_cust_production);
                            $("#inf_custom_ShippingTime").val(wc_cust_shipping);
                            $("#inf_custom_GuaranteedDelivery").val(holdData.guaranteed_delivery);
                            $("#inf_custom_TotalQuantity").val($('#qty_handler').text());
                            $("#inf_custom_Price0").val($('#price_handler').text());
                            $("#infusion-form").submit();
                        }
                        $('#saveDesignMessage').html('<span class="'+classD+'">'+response.data.message+'</span>');
                        // Builder.popupMsg(type, title, response.data.message);
                    });

                    // if ($('#preview_container').length) {
                    //     Pablo(document.getElementById("svgelement"))
                    //     .download('png', 'circle.png', function(result){ });
                    // }
                }
                else
                {
                    $('#SaveDesignEmail').addClass('borderRed');
                }
            })

            .on('submit', '#infusion-form', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'post',
                    url: 'https://zt232.infusionsoft.com/app/form/process/50257f1da49a3883663775d73e9a6174',
                    data: $(this).serialize()
                });
            })

            .on('change', 'select#customization_date_production, select#customization_date_shipping', function() {
                Builder.calculateDeliveryDate();
            })

            .on('focus','input[name="inside_message"]', function(e) {

                $("#outsidesolid1").attr("display", "none");
                $("#outsidesolid2").attr("display", "none");
                $("#mask1_band1").attr("display", "none");
                $("#mask2_band1").attr("display", "none");
                $("#mask1_band2").attr("display", "none");
                $("#mask2_band2").attr("display", "none");

                $("#bandtext1").attr("display", "none");
                $("#bandtext2").attr("display", "none");
                $("#bandtextcont1").attr("display", "none");
                $("#bandtextcont2").attr("display", "none");
                $("#bandtextinside1").removeAttr("display");
                $("#bandtextinside2").removeAttr("display");
                    //hidebackshadow();                 
                $("#segcolor1_cover_band1").attr("display", "none");
                $("#segcolor2_cover_band1").attr("display", "none");
                $("#segcolor3_band1").attr("display", "none");

                $("#segcolor1_cover_band2").attr("display", "none");
                $("#segcolor2_cover_band2").attr("display", "none"); 

            })
            
            .on('focusout','input[name="inside_message"]', function(e) {
                console.log($('input[name="message_type"]:checked').val());
                messageOptionDisplay($('input[name="message_type"]:checked').val());
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

                Builder.data["clipart"]["view_position"] = view;
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
        CheckEdit();

        $('#qty_adult, #qty_medium, #qty_youth').trigger('keyup'); // trigger  the Input Quanity field when the page is reloaded to calculate the total.




    });
});
