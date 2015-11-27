<?php

//Template Name: WC Order Now Layout

get_header();

?>



<div id="wristband-builder-content">
    <section id="wristband-builder">
        <form action="#" method="post">
            <div class="fusion-row">
                <div id="price_chart" class="">
                    <div class="fusion-column-wrapper">
                        <table class="table table-bordered">
                            <tr>
                                <td>Qty</td>
                            </tr>
                            <tr>
                                <td>
                                    Price $
                                </td>
                            </tr>
                        </table>
                    </div>
                </div><!-- /#price_chart -->

                <div class="fusion-one-fourth one_fourth fusion-layout-column fusion-spacing-yes">
                    <div class="fusion-column-wrapper">
                        <p class="form-row form-row-wide" id="style_field">
                            <label for="style" class="form-group-heading">Select Style
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top" title="Select Style">?</span>
                            </label>
                            <select name="style" id="style" class="input-select">
                                <?php if (isset($GLOBALS['wbc_settings']->products)):
                                    foreach ($GLOBALS['wbc_settings']->products as $product_id => $product):?>
                                        <option value="<?php echo $product_id; ?>"><?php echo $product->product_title; ?></option>
                                    <?php endforeach;
                                endif; ?>
                            </select>
                        </p>
                        <p class="form-row form-row-wide" id="width_field">
                            <label for="width" class="form-group-heading">Select Width
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                      title="Select Width">?</span>
                            </label>
                            <select name="width" id="width" class="input-select enable-if-style-selected" disabled></select>
                        </p>
                        
                        <div class="form-group table-responsive">
                            <table id="selected_color_table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Adult</th>
                                        <th>Medium</th>
                                        <th>Youth</th>
                                        <th>Color</th>
                                        <th class = "text_to_alter">Text</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label class="form-group-heading" >Select Wristband Color</label>
                            <div id="wristband-color-tab" class="fusion-tabs classic horizontal-tabs">
                                <div class="nav">
                                    <ul class="nav-tabs nav-justified">
                                        <?php $flag = true; foreach ($GLOBALS['wbc_settings']->color_style as $style => $data ): ?>
                                        <li class="<?php echo $flag ? 'active' : ''; ?>">
                                            <a class="tab-link" id="<?php echo sanitize_title($style); ?>" href="#tab-<?php echo sanitize_title($style); ?>"
                                               data-toggle="tab">
                                                <div class="radio">
                                                    <label>
                                                        <center><input type="radio" name="color_style" value="<?php echo esc_attr($style); ?>"
                                                            <?php echo $flag ? 'checked' : ''; ?>/>
                                                        <?php echo esc_attr($style); ?></center>
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <?php $flag = false; endforeach; ?>
                                    </ul>
                                </div>

                                <div class="tab-content" id="wristband-color-items">

                                    <?php $flag = true; $x = 0; foreach ($GLOBALS['wbc_settings']->color_style as $style => $data):?>

                                    <div class="tab-pane fade <?php echo $flag ? 'active in' : ''; ?>" id="tab-<?php echo sanitize_title($style); ?>">
                                        <ul>
                                            <?php foreach ($data->color_list as $i => $color_list): ?>
                                                <li  class="color-enabled" data-toggle="tooltip" data-placement="top"
                                                    title="<?php echo $color_list->name; ?>">
                                                    <div id="colorStyleBox" title= "<?php echo $style; ?>" class="color-wrap <?php //if( $x == 0){ if ($i == 0){echo "selected";}}else{echo '';} ?>">
                                                <?php
                                                $colorx = array();
                                                foreach($color_list as $key => $list):
                                                if (strpos($key, 'color_') === false || empty($list)) continue;

                                                    $colorx[] = $list?>

                                                <?php endforeach; ?>


                                                <div data-name="<?php echo $color_list->name; ?>" data-color="<?php echo implode( ',', $colorx ); ?>" style="background-color: <?php echo implode( ',', $colorx ); ?>;
                                                    background: -webkit-linear-gradient(90deg,<?php echo implode( ',', $colorx ); ?>); /* For Safari 5.1 to 6.0 */
                                                    background: -o-linear-gradient(90deg,<?php echo implode( ',', $colorx ); ?>); /* For Opera 11.1 to 12.0 */
                                                    background: -moz-linear-gradient(90deg,<?php echo implode( ',', $colorx ); ?>); /* For Firefox 3.6 to 15 */
                                                    background: linear-gradient(90deg,<?php echo implode( ',', $colorx ); ?>); /* Standard syntax */">
                                                </div>


                                                    </div>
                                                </li>
                                            <?php $flag = false; endforeach; ?>
                                        </ul>
                                    </div>

                                    <?php $x++; endforeach; ?>

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-group-heading" >Select Text Color</label>
                            <div id="wristband-text-color">
                                <ul>

                                </ul>
                            </div>
                        </div>
                        <div id="quantity_group_field">
                            <label class="form-group-heading" >Input Quantity <span>(Side View Guide)</span></label>
                            <p class="form-row quantity-row fusion-one-third one_third fusion-layout-column fusion-spacing-yes">
                                <label for="qty_adult">Adult</label>
                                <input type="number" name="qty_adult" id="qty_adult" min="0" class="input-text">
                            </p>
                            <p class="form-row quantity-row fusion-one-third one_third fusion-layout-column fusion-spacing-yes">
                                <label for="qty_medium">Medium</label>
                                <input type="number" name="qty_medium" id="qty_medium"  min="0" class="input-text">
                            </p>
                            <p class="form-row form-row-last fusion-one-third one_third fusion-layout-column fusion-column-last fusion-spacing-yes">
                                <label for="qty_youth">Youth</label>
                                <input type="number" name="qty_youth" id="qty_youth"  min="0" class="input-text">
                            </p>
                            <div class="clear"></div>
                            
                        </div><!-- /.quantity_group_field -->
                        <a class="alignright" target="_blank" href="#" id="add_color_to_selections"><i class="fa fa-plus"></i> <span class="fusion-button-text">Add an additional color</span></a>
                    <?php if (isset($GLOBALS['wbc_settings']->additional_options)):?>
                        <div id="additional-option-section">
                            <label class="form-group-heading"  data-fontsize="19" data-lineheight="20">Additional Options</label>
                        <?php $i = 1; foreach ($GLOBALS['wbc_settings']->additional_options as $index => $option):?>


                        <div id="<?php echo 'id_'.$index; ?>" class="additional-option-item fusion-one-half one_half fusion-layout-column fusion-spacing-yes <?php echo $i % 2 == 0 ? 'fusion-column-last' : '' ?>">
                            <div class="fusion-column-wrapper">
                                <div class="addon">
                                    <span class="addon-price-handler">
                                    <div class="checkbox">
                                        <input type="checkbox" name="additional_option[]" data-key="<?php echo $index; ?>" value="<?php echo $option->name; ?>" />
                                    </div>
                                    </span>
                                </div>
                                <div class="imageframe-align-center">
                                    <img height="80" src="<?php echo $option->image->url; ?>" alt="<?php echo $option->name; ?>"
                                         class="img-responsive">
                                </div>

                                <div class="fusion-sep-clear"></div>
                                <span class="aligncenter">
                                    <?php echo $option->name; ?>
                                    <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                          title="<?php echo esc_attr($option->tool_tip_text); ?>">?</span>
                                </span>

                            </div><!-- /.fusion-column-wrapper -->
                        </div><!-- /.fusion-one-third -->
                            <?php $i++; endforeach;?>
                        </div><!-- /.fusion-row -->
                        <?php endif; ?>
                    </div>
                </div><!--/.fusion-one-third-->
                <div class="fusion-one-half one_half fusion-layout-column fusion-spacing-yes">
                    <div class="fusion-column-wrapper">
                        <div class="fusion-row">
                            <div class="link-buttons aligncenter">
                                <a class="fusion-button button-flat button-round button-small button-orange preview-button active if-message_type_is-continues" href="#" id="front_view_button" data-input="front_message" data-view="front"><span class="fusion-button-text">Front</span></a>
                                <a class="fusion-button button-flat button-round button-small button-default preview-button if-message_type_is-continues" id="back_view_button" data-input="back_message" data-view="back" href="#" ><span class="fusion-button-text">Back</span></a>
                            </div>


                            <div class="imageframe-align-center image-preview">
                                <div id="preview_container" class="container--ph">
                                </div>
                            </div>


                            <div class="link-buttons aligncenter">
                                <a class="fusion-button button-flat button-round button-small button-orange prdct-info" href="#"><span class="fusion-button-text">Product Info</span></a>
                                <a id= "save_button" class="fusion-button button-flat button-round button-small button-default" href="#"><span class="fusion-button-text">Save Design</span></a>
                            </div>



                            <!-- 
                            <div id="hiddenDiv" style="display:none" >
                              <canvas id="hiddenCanvas"></canvas>
                              <a id="hiddenPng" />
                            </div> -->
                        </div>

                        <p class="fusion-row price price-with-decimal">
                            <span class="currency"><?php echo get_woocommerce_currency_symbol(); ?></span>
                            <span class="integer-part price-handler" id="price_handler">0.00</span>
                            <span class="time">Total Amount</span>
                            <br />
                            <span id="qty_handler" class="qty-handler">0</span> Quantity
                        </p>

                        <p class="form-row form-row-wide">
                            Guaranteed to be delived on or by : <strong id="delivery_date"></strong>
                        </p>

                        <p class="form-row form-row-wide">
                            <label for="additional_notes"  class="form-group-heading">Addition Notes</label>
                            <textarea class="input-text" name="additional_notes" id="additional_notes" cols="30" rows="5"></textarea>
                        </p>

                        <button id="wbc_add_to_cart" href="#" class="fusion-button button-flat button-round button-large button-default alignright">
                            <span class="button-icon-divider-left"><i class="fa fa-shopping-cart"></i></span>
                             <span class="fusion-button-text-left">Add to Cart</span>
                        </button>
                    </div><!-- /.fusion-column-wrapper -->
                </div><!--/.fusion-one-third-->
                <div class="fusion-one-fourth one_fourth fusion-layout-column fusion-column-last fusion-spacing-yes">
                    <div class="fusion-column-wrapper">
                        <div class="form-row">
                            <label for="message_type" class="form-group-heading">Message on Wristbands</label class="form-group-heading" >
                            <p class="radio">
                                <input type="radio" name="message_type" value="front_and_back" checked/>
                                Front and Back
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                  title="Front and Back Message" data-placement="top">?</span>
                            </p>
                            <p class="radio">
                                <input type="radio" name="message_type" value="continues"/>
                                Continuous
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                      title="Continuous Message" data-placement="top">?</span>
                            </p>
                        </div><!-- /.form-group -->
                        <?php if (isset($GLOBALS['wbc_settings']->tool_tip_text)):
                                $tooltip = $GLOBALS['wbc_settings']->tool_tip_text ; ?>
                        <p class="form-row form-row-wide hide-if-message_type-continues" id="width_field">
                            <label for="front_message"  class="form-group-heading">Front Message
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                  title="<?php echo $tooltip->front;?>" data-placement="top">?
                                </span>
                                <span class="char_left_wrapper alignright">
                                    ( <em class="front_message_chars_left"> <?php echo WBC_MESSAGE_CHAR_LIMIT; ?></em> ) Chars Left
                                </span>
                            </label>
                            <input type="text" name="front_message" class="input-text trigger-limit-char"
                                   data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" />
                        </p>

                        <p class="form-row form-row-wide hide-if-message_type-continues">
                            <label for="back_message"  class="form-group-heading">Back Message
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                  title="<?php echo $tooltip->back;?>" data-placement="top">?
                                </span>
                                <span class="char_left_wrapper alignright">
                                    ( <em class="back_message_chars_left"> <?php echo WBC_MESSAGE_CHAR_LIMIT; ?></em> ) Chars Left
                                </span>
                            </label>
                            <input type="text" name="back_message"  class="input-text trigger-limit-char"
                                   data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" >
                        </p><!-- /.form-group -->


                        <p class="form-row form-row-wide hide-if-message_type-front_and_back">
                            <label for="continues_message"  class="form-group-heading">Continuous Message
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                  title="<?php echo $tooltip->wrap_around;?>" data-placement="top">?
                                </span>
                                <span class="char_left_wrapper alignright">
                                    ( <em class="continues_message_chars_left"><?php echo WBC_MESSAGE_CHAR_LIMIT; ?></em> ) Chars Left
                                </span>
                            </label>
                            <input type="text" name="continues_message" class="input-text trigger-limit-char"
                                   data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>">
                        </p><!-- /.form-group -->

                        <p class="form-row form-row-wide">
                            <label for="inside_message"  class="form-group-heading">Inside Message
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                  title="<?php echo $tooltip->inside;?>" data-placement="top">?
                                </span>
                                <span class="char_left_wrapper alignright">
                                    ( <em class="inside_message_chars_left"> <?php echo WBC_MESSAGE_CHAR_LIMIT; ?></em> ) Chars Left
                                </span>
                            </label>
                            <input type="text" name="inside_message" class="input-text trigger-limit-char"
                                   data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" />
                        </p><!-- /.form-group -->
                    <?php endif; ?>
                        <p class="form-row form-row-wide">
                            <label for="font" class="form-group-heading">Font</label>
                            <select name="font" id="font" class="input-select enable-if-style-selected">
                                <option value="-1">-- Select --</option>

                                <?php if (isset($GLOBALS['wbc_settings']->fonts)):
                                    foreach ($GLOBALS['wbc_settings']->fonts as $font):?>
                                        <option style="font-size:18px;font-family: '<?php echo esc_attr($font); ?>' !important;"
                                                value="<?php echo esc_attr($font); ?>"><?php echo esc_attr($font); ?></option>
                                <?php endforeach;
                                    endif; ?>
                            </select>
                        </p><!-- /.form-group -->
                        <div id="add-clipart">
                            <label class="form-group-heading" >Add Clipart</label>
                            <div class="button-box hide-if-message_type-continues">
                                <span class="text-label">Front Start</span>
                                <div class="alignright">
                                    <a id="front_start_btn" data-view="front" data-position="front_start" href="#" data-title="Front Start" data-toggle="modal"
                                            data-target="#wristband-clipart-modal"
                                            class="toggle-modal-clipart">
                                        <span class="fusion-button-text-right">
                                            <i class="fa fa-ban icon-preview hide-if-upload"></i>
                                                <img class="image-upload hide-if-icon" width="10" height="16"/>
                                            select</span>
                                    </a>
                                    <a href="#" class="fileinput-button">
                                        <span><i class="fa fa-cloud-upload"></i> Upload</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input class="fileupload" type="file" name="files[]" accept="image/png"
                                               data-clipart-type="frontstart">
                                    </a>
                                </div>
                            </div>
                            <div class="button-box hide-if-message_type-continues">
                                <span class="text-label">Front End</span>
                                <div class="alignright">
                                    <a id="front_end_btn" data-view="front" data-position="front_end" href="#" data-title="Front End" data-toggle="modal"
                                       data-target="#wristband-clipart-modal"
                                       class="toggle-modal-clipart">
                                        <span class="fusion-button-text-right">
                                            <i class="fa fa-ban icon-preview hide-if-upload"></i>
                                                <img class="image-upload hide-if-icon" width="10" height="16"/>
                                            select</span>
                                    </a>
                                    <a href="#" class="fileinput-button">
                                        <span><i class="fa fa-cloud-upload"></i> Upload</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input class="fileupload" type="file" name="files[]" accept="image/png"
                                               data-clipart-type="frontend">
                                    </a>
                                </div>
                            </div>

                            <div class="button-box hide-if-message_type-continues">
                                <span class="text-label">Back Start</span>
                                <div class="alignright">
                                    <a id="back_start_btn" data-view="back" data-position="back_start" href="#" data-title="Back Start" data-toggle="modal"
                                       data-target="#wristband-clipart-modal"
                                       class="toggle-modal-clipart">
                                        <span class="fusion-button-text-right">
                                            <i class="fa fa-ban icon-preview hide-if-upload"></i>
                                                <img class="image-upload hide-if-icon" width="10" height="16"/>
                                            select</span>
                                    </a>
                                    <a href="#" class="fileinput-button">
                                        <span><i class="fa fa-cloud-upload"></i> Upload</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input class="fileupload" type="file" name="files[]" accept="image/png"
                                               data-clipart-type="backstart">
                                    </a>
                                </div>
                            </div>


                            <div class="button-box hide-if-message_type-continues">
                                <span class="text-label ">Back End</span>
                                <div class="alignright">
                                    <a id="back_end_btn" data-view="back" data-position="back_end" href="#" data-title="Back End" data-toggle="modal"
                                       data-target="#wristband-clipart-modal"
                                       class="toggle-modal-clipart">
                                        <span class="fusion-button-text-right">
                                            <i class="fa fa-ban icon-preview hide-if-upload"></i>
                                                <img class="image-upload hide-if-icon" width="10" height="16"/>
                                            select</span>
                                    </a>
                                    <a href="#" class="fileinput-button">
                                        <span><i class="fa fa-cloud-upload"></i> Upload</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input class="fileupload" type="file" name="files[]" accept="image/png"
                                               data-clipart-type="backend">
                                    </a>
                                </div>
                            </div>


                             <div class="button-box hide-if-message_type-front_and_back">
                                <span class="text-label">Wrap Around Start</span>
                                <div class="alignright">
                                    <a id="wrap_around_start" data-position="wrap_start" href="#" data-title="Wrap Around Start" data-toggle="modal"
                                       data-target="#wristband-clipart-modal"
                                       class="toggle-modal-clipart">
                                        <span class="fusion-button-text-right">
                                            <i class="fa fa-ban icon-preview hide-if-upload"></i>
                                                <img class="image-upload hide-if-icon" width="10" height="16"/>
                                            select</span>
                                    </a>
                                    <a href="#" class="fileinput-button">
                                        <span><i class="fa fa-cloud-upload"></i> Upload</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input class="fileupload" type="file" name="files[]" accept="image/png"
                                               data-clipart-type="backend">
                                    </a>
                                </div>
                            </div>


                            <div class="button-box hide-if-message_type-front_and_back">
                                <span class="text-label">Wrap Around End</span>
                                <div class="alignright">
                                    <a id="wrap_around_end" data-position="wrap_end" href="#" data-title="Wrap Around End" data-toggle="modal"
                                       data-target="#wristband-clipart-modal"
                                       class="toggle-modal-clipart">
                                        <span class="fusion-button-text-right">
                                            <i class="fa fa-ban icon-preview hide-if-upload"></i>
                                                <img class="image-upload hide-if-icon" width="10" height="16"/>
                                            select</span>
                                    </a>
                                    <a href="#" class="fileinput-button">
                                        <span><i class="fa fa-cloud-upload"></i> Upload</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input class="fileupload" type="file" name="files[]" accept="image/png"
                                               data-clipart-type="backend">
                                    </a>
                                </div>
                            </div>

                        </div><!-- /#add-clipart -->
                        <?php if (isset($GLOBALS['wbc_settings']->customization)):?>
                        <div id="customization-section">
                            <label class="form-group-heading">Production and Shipping</label>
                            <?php $flag = false; foreach ($GLOBALS['wbc_settings']->customization->location as $cus_location): ?>
                                <p class="form-row form-row-wide">
                                    <label>
                                        <input type="radio" name="customization_location" data-title="<?php echo esc_attr($cus_location->name); ?>"
                                               value="<?php echo sanitize_title_with_underscore($cus_location->name) ;?>"
                                               data-price="<?php echo esc_attr($cus_location->price); ?>"
                                            <?php echo !$flag ? 'checked' : ''; ?>/>
                                        <?php echo esc_attr($cus_location->name); ?>

                                       <!--  <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                              title="<?php echo esc_attr($cus_location->tool_tip_text); ?>">?</span> -->
                                    </label>

                               </p>
                            <?php $flag = true; endforeach; ?>

                            <?php foreach ($GLOBALS['wbc_settings']->customization->dates as $type => $date): ?>
                                <p class="form-row form-row-wide">
                                    <label for="customization_date_<?php echo $type; ?>" class="form-group-heading"><?php echo ucwords($type); ?> Time</label>
                                    <select id="customization_date_<?php echo $type; ?>"
                                            name="customization_date_<?php echo $type; ?>"
                                            class="input-select customization-date-select" disabled required>
                                        <option value="-1">-- Select <?php echo ucwords($type) ?> Time --</option>
                                    </select>
                                </p>
                            <?php endforeach; ?>
                        </div>

                        <?php endif; ?>

                    </div><!--/.fusion-column-wrapper -->
                </div><!--/.fusion-one-third -->
            </div>
        </form>
    </section><!-- /#wristband-builder -->

</div><!-- /#wristband-builder-content -->

<div id="wristband-clipart-modal" class="fusion-modal modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content fusion-modal-content" style="background-color:#f6f6f6">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="modal-heading-1" data-dismiss="modal" aria-hidden="true"
                    data-fontsize="17" data-lineheight="36">
                    Choose your Front Start Clipart</h3>
            </div>
                <?php if (count($GLOBALS['wbc_settings']->logo->list) != 0): ?>
               <ul class="clipart-list">

                   <li class="fusion-li-item active">
                       <label for="">
                           <div class="icon-preview">
                               <i class="fusion-li-icon fa fa-times color-red"></i>
                           </div>
                       </label>
                   </li>
                   <?php foreach ($GLOBALS['wbc_settings']->logo->list as $name => $icon): 
                   ?>
                   <li class="fusion-li-item" data-icon-code="<?php echo esc_attr($icon->glyp_code); ?>" data-icon="<?php echo esc_attr($icon->glyphicon); ?>" data-icon-name="<?php echo esc_attr($icon->name); ?>">
                       <label for="">
                           <div class="icon-preview">
                                <i class="fusion-li-icon fa <?php echo esc_attr($icon->glyphicon); ?>"></i>
                           </div>
                           <!--<div class="clearpart-info text-center">
                                <?php echo esc_attr($name); ?>
                           </div>-->
                       </label>
                   </li>
                   <?php endforeach; ?>
               </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>





<script id="modal_message_template2" type="x-tmpl-mustache">
    <div id="modal_message2" class="fusion-modal modal fade {{status}}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content fusion-modal-content" style="background-color:#f6f6f6">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title" id="modal-heading-1" data-dismiss="modal" aria-hidden="true"
                    data-fontsize="17" data-lineheight="36">{{title}}</h3>
                </div>
                <div class="modal-body">
                    {{{message}}}
                </div>
            </div>
        </div>
    </div><!-- /.fusion-modal -->
</script>

<!-- /.fusion-modal -->
<script id="modal_message_template" type="x-tmpl-mustache">
    <div id="modal_message" class="fusion-modal modal fade {{status}}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content fusion-modal-content" style="background-color:#f6f6f6">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title" id="modal-heading-1" data-dismiss="modal" aria-hidden="true"
                    data-fontsize="17" data-lineheight="36">{{title}}</h3>
                </div>
                <div class="modal-body">
                    {{{message}}}
                </div>
            </div>
        </div>
    </div><!-- /.fusion-modal -->
</script>

<?php
//echo '<pre>';
//print_r($GLOBALS['wbc_settings']);
//echo '</pre>';
get_footer();