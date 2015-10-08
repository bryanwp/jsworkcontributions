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
                </div><!-- /.fusion-fifth-fifth -->
                <div class="fusion-one-third one_third fusion-layout-column fusion-spacing-yes">
                    <div class="fusion-column-wrapper">


                        <div class="form-group">
                            <label for="style">Select Style
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top" title="Select Style">?</span>
                            </label>
                            <select name="style" id="style" class="form-control">
                                <?php if (isset($GLOBALS['wbc_settings']->products)):
                                    foreach ($GLOBALS['wbc_settings']->products as $product_id => $product):?>
                                <option value="<?php echo $product_id; ?>"><?php echo $product->product_title; ?></option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="width">Select Width
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                      title="Select Width">?</span>
                            </label>
                            <select name="width" id="width" class="form-control enable-if-style-selected" disabled></select>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <h2 class="form-group-heading" >Message on Wristbands</h2 class="form-group-heading" >
                            <p class="form-row">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="mesage_type" value="front_and_back" checked/>
                                        Front and Back
                                    </label>
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                      title="Front and Back Message" data-placement="top">?</span>
                                </div>
                            </p>
                            <p class="form-row">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="mesage_type" value="continues"/>
                                        Continues
                                    </label>
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                      title="Front and Back Message" data-placement="top">?</span>
                                </div>
                            </p>
                        </div><!-- /.form-group -->
                        <div class="form-group hide-if-message_type-continues">
                            <label for="width">Front Message
                                <span class="char_left_wrapper pull-right">
                                    <input type="text" name="front_message_chars_left" class="input-text input-text-xs"
                                           value="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" size="5" disabled=""> Chars Left
                                </span>
                            </label>
                            <input type="text" name="front_message" class="form-control trigger-limit-char"
                                   data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" />

                        </div><!-- /.form-group -->
                        <div class="form-group  hide-if-message_type-continues">
                            <label for="width">Back Message
                                <span class="char_left_wrapper pull-right">
                                    <input type="text" name="back_message_chars_left" class="input-text input-text-xs"
                                           value="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" size="5" disabled=""> Chars Left
                                </span>
                            </label>
                            <input type="text" name="back_message"  class="form-control trigger-limit-char"
                                   data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" >
                        </div><!-- /.form-group -->


                        <div class="form-group  hide-if-message_type-front_and_back">
                            <label for="width">Continues Message
                                <span class="char_left_wrapper pull-right">
                                    <input type="text" name="continues_message_chars_left" class="input-text input-text-xs"
                                           value="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" size="5" disabled=""> Chars Left
                                </span>
                            </label>
                            <input type="text" name="continues_message" class="form-control trigger-limit-char"
                                   data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>">
                        </div><!-- /.form-group -->

                        <div class="form-group">
                            <label for="width">Inside Message
                                <span class="char_left_wrapper pull-right">
                                    <input type="text" name="inside_message_chars_left" class="input-text input-text-xs"
                                           value="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" size="5" disabled=""> Chars Left
                                </span>
                            </label>
                            <input type="text" name="inside_message" class="form-control trigger-limit-char"
                                   data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" />
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="font">Font</label>
                            <select name="font" id="font" class="form-control enable-if-style-selected">
                                <option value="-1">-- Select --</option>

                                <?php if (isset($GLOBALS['wbc_settings']->fonts)):
                                    foreach ($GLOBALS['wbc_settings']->fonts as $font):?>
                                        <option style="font-family: <?php echo esc_attr($font); ?>"
                                                value="<?php echo esc_attr($font); ?>"><?php echo esc_attr($font); ?>
                                        </option>
                                <?php endforeach;
                                    endif; ?>
                            </select>
                        </div><!-- /.form-group -->
                        <div class="form-group" id="add-clipart">
                            <h2 class="form-group-heading" >Add Clipart</h2 class="form-group-heading" >
                            <div class="form-row">

                                <div class="fusion-one-fourth one_fourth fusion-layout-column fusion-spacing-yes">
                                    <div class="fusion-column-wrapper">
                                        <label class="text-label">Front Start</label>
                                    </div>
                                </div><!-- /.fusion-one-third -->

                                <div class="fusion-two-third fusion-layout-column fusion-column-last fusion-spacing-yes">
                                    <div class="fusion-column-wrapper">
                                        <button id="front_start_btn" data-position="front_start" href="#" data-title="Front Start" data-toggle="modal"
                                                data-target="#wristband-clipart-modal"
                                                class="toggle-modal-clipart fusion-button button-flat button-round
                                                button-small button-green">
                                            <span class="fusion-button-text-right">
                                                <i class="fa fa-ban icon-preview hide-if-upload"></i>
                                                    <img class="image-upload hide-if-icon" width="16" height="16"/>
                                                select</span>
                                            <span class="button-icon-divider-right"><i class="fa fa-caret-down"></i></span>
                                        </button>
                                        <span class="space-separator">or</span>
                                        <span href="#" class="fusion-button button-flat button-round button-small button-default fileinput-button">
                                            <span><i class="fa fa-cloud-upload"></i> Upload</span>
                                            <!-- The file input field used as target for the file upload widget -->
                                            <input class="fileupload" type="file" name="files[]" accept="image/png"
                                                   data-clipart-type="frontstart">
                                        </span>
                                    </div>
                                </div><!-- /.fusion-two-third -->
                                <div class="fusion-clearfix"></div>
                                <div class="fusion-one-fourth one_fourth fusion-layout-column fusion-spacing-yes">
                                    <div class="fusion-column-wrapper">
                                        <label class="text-label">Front End</label>
                                    </div>
                                </div><!-- /.fusion-one-third -->

                                <div class="fusion-two-third fusion-layout-column fusion-column-last fusion-spacing-yes">
                                    <div class="fusion-column-wrapper">
                                        <button id="front_end_btn" data-position="front_end" href="#" data-title="Front End" data-toggle="modal" data-target="#wristband-clipart-modal" class="toggle-modal-clipart fusion-button button-flat button-round button-small button-green">
                                                <span class="fusion-button-text-right">
                                                    <i class="fa fa-ban icon-preview hide-if-upload"></i>
                                                    <img class="image-upload hide-if-icon" width="16" height="16"/>
                                                    select</span>
                                            <span class="button-icon-divider-right"><i class="fa fa-caret-down"></i></span>
                                        </button>
                                        <span class="space-separator">or</span>
                                            <span href="#" class="fusion-button button-flat button-round button-small button-default fileinput-button">
                                                <span><i class="fa fa-cloud-upload"></i> Upload</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input class="fileupload" type="file" name="files[]" accept="image/png"
                                                       data-clipart-type="frontend">
                                            </span>
                                    </div>
                                </div><!--/.fusion-two-third-->
                                <div class="fusion-clearfix"></div>
                                <div class="fusion-one-fourth one_fourth fusion-layout-column fusion-spacing-yes">
                                    <div class="fusion-column-wrapper">
                                        <label class="text-label">Back Start</label>
                                    </div>
                                </div><!-- /.fusion-one-third -->

                                <div class="fusion-two-third fusion-layout-column fusion-column-last fusion-spacing-yes">
                                    <div class="fusion-column-wrapper">
                                        <button id="back_start_btn" data-position="back_start" href="#" data-title="Back Start" data-toggle="modal" data-target="#wristband-clipart-modal" class="toggle-modal-clipart fusion-button button-flat button-round button-small button-green">
                                                <span class="fusion-button-text-right">
                                                    <i class="fa fa-ban icon-preview hide-if-upload"></i>
                                                    <img class="image-upload hide-if-icon" width="16" height="16"/>
                                                    select</span>
                                            <span class="button-icon-divider-right"><i class="fa fa-caret-down"></i></span>
                                        </button>
                                        <span class="space-separator">or</span>
                                            <span href="#" class="fusion-button button-flat button-round button-small button-default fileinput-button">
                                                <span><i class="fa fa-cloud-upload"></i> Upload</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input class="fileupload" type="file" name="files[]" accept="image/png"
                                                       data-clipart-type="backstart">
                                            </span>
                                    </div>
                                </div><!--/.fusion-two-third-->
                                <div class="fusion-clearfix"></div>
                                <div class="fusion-one-fourth one_fourth fusion-layout-column fusion-spacing-yes">
                                    <div class="fusion-column-wrapper">
                                        <label class="text-label">Back End</label>
                                    </div>
                                </div><!-- /.fusion-one-third -->

                                <div class="fusion-two-third fusion-layout-column fusion-column-last fusion-spacing-yes">
                                    <div class="fusion-column-wrapper">
                                        <button id="back_end_btn" data-position="back_end" href="#" data-title="Back End" data-toggle="modal" data-target="#wristband-clipart-modal"  class="toggle-modal-clipart fusion-button button-flat button-round button-small button-green">
                                                <span class="fusion-button-text-right">
                                                    <i class="fa fa-ban icon-preview hide-if-upload"></i>
                                                    <img class="image-upload hide-if-icon" width="16" height="16"/>
                                                    select</span>
                                            <span class="button-icon-divider-right"><i class="fa fa-caret-down"></i></span>
                                        </button>
                                        <span class="space-separator">or</span>
                                            <span href="#" class="fusion-button button-flat button-round button-small button-default fileinput-button">
                                                <span><i class="fa fa-cloud-upload"></i> Upload</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input class="fileupload" type="file" name="files[]" accept="image/png"
                                                       data-clipart-type="backend">
                                            </span>
                                    </div>
                                </div><!--/.fusion-two-third-->

                            </div>
                        </div><!-- /.form-group -->
                    </div><!-- /.fusion-column-wrapper -->
                </div><!--/.fusion-one-third-->
                <div class="fusion-one-third one_third fusion-layout-column fusion-spacing-yes">
                    <div class="fusion-column-wrapper">
                        <div class="form-row">
                            <div class="imageframe-align-center image-preview">
                                <span class="fusion-imageframe imageframe-none imageframe-17 hover-type-zoomin">
                                    <img src="http://wristband.local/wp-content/uploads/2015/09/main-debossed-fill.png"
                                         alt="Individual Packaging" class="img-responsive" heigt="250">
                                </span>
                            </div>
                            <div class="link-buttons">
                                <a class="fusion-button button-flat button-round button-xsmall button-orange" target="_blank"
                                   href="#"><span class="fusion-button-text">Product Info</span></a>
                                <a class="fusion-button button-flat button-round button-xsmall button-default" target="_blank"
                                   href="#"><span class="fusion-button-text">Save Design</span></a>
                                <a class="fusion-button button-flat button-round button-xsmall button-default" target="_blank"
                                   href="#"><span class="fusion-button-text">Front</span></a>
                                <a class="fusion-button button-flat button-round button-xsmall button-default" target="_blank"
                                   href="#"><span class="fusion-button-text">Back</span></a>
                            </div>
                        </div>

                        <div class="form-row">
                            <h2 class="form-group-heading" >Total Price: <?php echo get_woocommerce_currency_symbol(); ?>
                                <span class="price-handler" id="price_handler">0.00</span></h2 class="form-group-heading" >
                            <h2 class="form-group-heading" >Quantity: <span id="qty_handler" class="qty-handler">0</span></h2 class="form-group-heading" >
                        </div>


                        <div class="form-row">
                            <p>Guaranteed to be delived on or by</p>
                            <div class="form-group">
                                <label for="additional_notes">Addition Notes</label>
                                <textarea class="form-control input-text" name="additional_notes" id="additional_notes" cols="30" rows="5"></textarea>
                            </div>
                        </div>

                        <button id="wbc_add_to_cart" class="fusion-button button-flat button-round button-large button-default alignright">
                            <span class="button-icon-divider-left"><i class="fa fa-shopping-cart"></i></span>
                             <span class="fusion-button-text-left">Add to Cart</span>
                        </button>
                    </div><!-- /.fusion-column-wrapper -->
                </div><!--/.fusion-one-third-->
                <div class="fusion-one-third one_third fusion-layout-column fusion-column-last fusion-spacing-yes">
                    <div class="fusion-column-wrapper">
                        <div class="form-group table-responsive">
                            <table id="selected_color_table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Adult</th>
                                        <th>Medium</th>
                                        <th>Youth</th>
                                        <th>Color</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <h2 class="form-group-heading" >Select Wristband Color</h2 class="form-group-heading" >
                            <div id="wristband-color-tab" class="fusion-tabs classic horizontal-tabs">
                                <div class="nav">
                                    <ul class="nav-tabs nav-justified">
                                        <?php $flag = true; foreach ($GLOBALS['wbc_settings']->color_style as $style => $data ): ?>
                                        <li class="<?php echo $flag ? 'active' : ''; ?>">
                                            <a class="tab-link" id="<?php echo sanitize_title($style); ?>" href="#tab-<?php echo sanitize_title($style); ?>"
                                               data-toggle="tab">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="color_style" value="<?php echo esc_attr($style); ?>"
                                                            <?php echo $flag ? 'checked' : ''; ?>/>
                                                        <?php echo esc_attr($style); ?>
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <?php $flag = false; endforeach; ?>
                                    </ul>
                                </div>

                                <div class="tab-content" id="wristband-color-items">

                                    <?php $flag = true; foreach ($GLOBALS['wbc_settings']->color_style as $style => $data):?>

                                    <div class="tab-pane fade <?php echo $flag ? 'active in' : ''; ?>" id="tab-<?php echo sanitize_title($style); ?>">
                                        <ul>
                                            <?php foreach ($data->color_list as $color_list): ?>
                                                <li data-toggle="tooltip" data-placement="top"
                                                    title="<?php echo $color_list->name; ?>">
                                                    <div class="color-wrap">
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

                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h2 class="form-group-heading" >Input Quantity <span>(Side View Guide)</span></h2 class="form-group-heading" >
                            <div class="fusion-one-third one_third fusion-layout-column fusion-spacing-yes">
                                <div class="fusion-column-wrapper">
                                    <div class="form-group">
                                        <label for="qty_adult">Adult</label>
                                        <input type="number" name="qty_adult" id="qty_adult" min="0" class="input-text form-control">
                                    </div>
                                    <div class="form-group">
                                        <select name="adult_text_color" class="form-control text-color-list"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="fusion-one-third one_third fusion-layout-column fusion-spacing-yes">
                                <div class="fusion-column-wrapper">
                                    <div class="form-group">
                                        <label for="qty_medium">Medium</label>
                                        <input type="number" name="qty_medium" id="qty_medium"  min="0" class="input-text form-control">
                                    </div>
                                    <div class="form-group">
                                        <select name="medium_text_color" class="form-control text-color-list"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="fusion-one-third one_third fusion-layout-column fusion-spacing-yes fusion-column-last">
                                <div class="fusion-column-wrapper">
                                    <div class="form-group">
                                        <label for="qty_youth">Youth</label>
                                        <input type="number" name="qty_youth" id="qty_youth"  min="0" class="input-text form-control">
                                    </div>
                                    <div class="form-group">
                                        <select name="youth_text_color" class="form-control text-color-list"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="fusion-clearfix"></div>
                            <a class="fusion-button button-flat button-round button-xsmall button-red alignright"
                               target="_blank" href="#" id="add_color_to_selections"><span class="fusion-button-text">Add an additional color</span></a>
                        </div><!-- /.fusion-row -->
                    <?php if (isset($GLOBALS['wbc_settings']->additional_options)):?>
                        <div class="fusion-row" id="additional-option-section">
                            <h2 class="form-group-heading"  data-fontsize="19" data-lineheight="20">Additional Options</h2 class="form-group-heading" >
                        <?php $i = 1; foreach ($GLOBALS['wbc_settings']->additional_options as $index => $option):?>


                        <div class="fusion-one-half one_half fusion-layout-column fusion-spacing-yes <?php echo $i % 2 == 0 ? 'fusion-column-last' : '' ?>">
                            <div class="fusion-column-wrapper">
                                <div class="addon">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="additional_option[]" value="<?php echo $index; ?>" />
                                        </label>
                                    </div>
                                    <span class="addon-price-handler"></span>
                                </div>
                                <div class="imageframe-align-center">
                                    <span class="fusion-imageframe imageframe-none imageframe-17 hover-type-zoomin">
                                        <img height="80" src="<?php echo $option->image->url; ?>" alt="<?php echo $option->name; ?>"
                                             class="img-responsive">
                                    </span>
                                </div>

                                <div class="fusion-sep-clear"></div>
                                <label class="aligncenter">
                                    <?php echo $option->name; ?>
                                    <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                          title="<?php echo esc_attr($option->tool_tip_text); ?>">?</span>
                                </label>

                            </div><!-- /.fusion-column-wrapper -->
                        </div><!-- /.fusion-one-third -->
                            <?php $i++; endforeach;?>
                        </div><!-- /.fusion-row -->
                        <?php endif;
                        if (isset($GLOBALS['wbc_settings']->customization)):?>
                        <div class="fusion-row" id="customization-section">
                            <h2 class="form-group-heading"  data-fontsize="19" data-lineheight="20">Production and Shipping</h2 class="form-group-heading" >
                            <?php $flag = false; foreach ($GLOBALS['wbc_settings']->customization->location as $cus_location): ?>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="customization_location"
                                               value="<?php echo sanitize_title_with_underscore($cus_location->name) ;?>"
                                               data-price="<?php echo esc_attr($cus_location->price); ?>"
                                            <?php echo !$flag ? 'checked' : ''; ?>/>
                                        <?php echo esc_attr($cus_location->name); ?>
                                    </label>
                                    <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                          title="<?php echo esc_attr($cus_location->tool_tip_text); ?>">?</span>
                               </div><br />
                            <?php $flag = true; endforeach; ?>

                            <?php foreach ($GLOBALS['wbc_settings']->customization->dates as $type => $date): ?>
                                <div class="form-group">
                                    <label for="customization_date_<?php echo $type; ?>"><?php echo ucwords($type); ?> Time</label>
                                    <select id="customization_date_<?php echo $type; ?>"
                                            name="customization_date_<?php echo $type; ?>"
                                            class="customization-date-select form-control" disabled required>
                                        <option value="-1">-- Select <?php echo ucwords($type) ?> Time --</option>
                                    </select>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php endif; ?>

                    </div><!--/.fusion-column-wrapper -->
                </div><!--/.fusion-one-third -->
            </div>
        </form>
    </section><!-- /#wristband-builder -->

</div><!-- /#wristband-builder-content -->

<div id="wristband-clipart-modal" class="fusion-modal modal fade info" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content fusion-modal-content" style="background-color:#f6f6f6">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="modal-heading-1" data-dismiss="modal" aria-hidden="true"
                    data-fontsize="17" data-lineheight="36">
                    Choose your Front Start Clipart</h3>
            </div>
            <div class="modal-body">
                <?php if (count($GLOBALS['wbc_settings']->logo->list) != 0): ?>
               <ul class="clipart-list">

                   <li class="fusion-li-item active">
                       <label for="">
                           <div class="icon-preview">
                               <i class="fusion-li-icon fa fa-times color-red"></i>
                           </div>
                           <div class="clearpart-info text-center">
                               None
                           </div>
                       </label>
                   </li>
                   <?php foreach ($GLOBALS['wbc_settings']->logo->list as $name => $icon): ?>
                   <li class="fusion-li-item" data-icon="<?php echo esc_attr($icon); ?>" data-icon-name="<?php echo esc_attr($name); ?>">
                       <label for="">
                           <div class="icon-preview">
                                <i class="fusion-li-icon fa <?php echo esc_attr($icon); ?>"></i>
                           </div>
                           <div class="clearpart-info text-center">
                                <?php echo esc_attr($name); ?>
                           </div>
                       </label>
                   </li>
                   <?php endforeach; ?>
               </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><!-- /.fusion-modal -->
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
                    <p>{{message}}</p>
                </div>
            </div>
        </div>
    </div><!-- /.fusion-modal -->
</script>

<?php

echo '<pre style="display:none;">';
print_r($GLOBALS['wbc_settings']);
echo '</pre>';

get_footer();