<?php

//Template Name: WC Order Now Layout

get_header();


?>
<div id="wristband-builder-content">
    <section id="price_chart">
        <div class="panel-body table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td>Qty</td>
                    <td>1</td>
                    <td>5</td>
                    <td>10</td>
                    <td>1</td>
                    <td>5</td>
                    <td>10</td>
                    <td>1</td>
                    <td>5</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>
                        Price $
                    </td>
                    <td>1</td>
                    <td>5</td>
                    <td>10</td>
                    <td>1</td>
                    <td>5</td>
                    <td>10</td>
                    <td>1</td>
                    <td>5</td>
                    <td>10</td>
                </tr>
            </table>
        </div>
    </section>

    <section id="wristband-builder">
        <div class="fusion-row">
            <div class="fusion-one-third one_third fusion-layout-column fusion-spacing-yes">
                <div class="fusion-column-wrapper">
                    <div class="form-group">
                        <label for="style">Select Style
                            <span class="fusion-popover" data-animation="" data-class="popover-1"
                                  data-container="popover-1"
                                  data-content="This is the content" data-placement="top" data-title="Select Style"
                                  data-toggle="popover" data-trigger="hover" data-original-title="">?</span>
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
                            <span class="fusion-popover" data-animation="" data-class="popover-1"
                                  data-container="popover-1"
                                  data-content="This is the content" data-placement="top" data-title="Select Style"
                                  data-toggle="popover" data-trigger="hover" data-original-title="">?</span>
                        </label>
                        <select name="width" id="width" class="form-control enable-if-style-selected" disabled></select>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <h2>Message on Wristbands</h2>
                        <p class="form-row">
                            <input type="radio" name="mesage_type" value="front_and_back" checked/>
                            <label for="mesage_type" class="checkbox">
                                Front and Back
                                 <span class="fusion-popover" data-animation="" data-class="popover-1"
                                       data-content="Front and Back Message" data-placement="top"
                                       data-title="" data-toggle="popover" data-trigger="hover"
                                       data-original-title="">?</span>
                            </label>
                        </p>
                        <p class="form-row">
                            <input type="radio" name="mesage_type" value="continues" />
                            <label for="message" class="checkbox">
                                Continues
                                <span class="fusion-popover" data-animation="" data-class="popover-1"
                                      data-content="Continues Message" data-placement="top"
                                      data-title="" data-toggle="popover" data-trigger="hover"
                                      data-original-title="">?</span>
                            </label>
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
                        <h2>Add Clipart</h2>
                        <div class="form-row">

                            <div class="fusion-one-fourth one_fourth fusion-layout-column fusion-spacing-yes">
                                <div class="fusion-column-wrapper">
                                    <label class="text-label">Front Start</label>
                                </div>
                            </div><!-- /.fusion-one-third -->

                            <div class="fusion-two-third fusion-layout-column fusion-column-last fusion-spacing-yes">
                                <div class="fusion-column-wrapper">
                                    <button class="fusion-button button-flat button-round button-small button-green"
                                            target="_blank" href="#" data-toggle="modal" data-target=".avada_modal">
                                        <span class="fusion-button-text-right">
                                            <i class="fa fa-taxi icon-preview hide-if-upload"></i>
                                                <img class="image-upload hide-if-icon" width="16" height="16"/>
                                            select</span>
                                        <span class="button-icon-divider-right"><i class="fa fa-caret-down"></i></span>
                                    </button>
                                    <span class="space-separator">or</span>
                                    <span class="fusion-button button-flat button-round button-small button-default fileinput-button">
                                        <span>Upload</span>
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
                                    <button class="fusion-button button-flat button-round button-small button-green"
                                            target="_blank" href="#" data-toggle="modal" data-target=".avada_modal">
                                            <span class="fusion-button-text-right">
                                                <i class="fa fa-taxi icon-preview hide-if-upload"></i>
                                                <img class="image-upload hide-if-icon" width="16" height="16"/>
                                                select</span>
                                        <span class="button-icon-divider-right"><i class="fa fa-caret-down"></i></span>
                                    </button>
                                    <span class="space-separator">or</span>
                                        <span class="fusion-button button-flat button-round button-small button-default fileinput-button">
                                            <span>Upload</span>
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
                                    <button class="fusion-button button-flat button-round button-small button-green"
                                            target="_blank" href="#" data-toggle="modal" data-target=".avada_modal">
                                            <span class="fusion-button-text-right">
                                                <i class="fa fa-taxi icon-preview hide-if-upload"></i>
                                                <img class="image-upload hide-if-icon" width="16" height="16"/>
                                                select</span>
                                        <span class="button-icon-divider-right"><i class="fa fa-caret-down"></i></span>
                                    </button>
                                    <span class="space-separator">or</span>
                                        <span class="fusion-button button-flat button-round button-small button-default fileinput-button">
                                            <span>Upload</span>
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
                                    <button class="fusion-button button-flat button-round button-small button-green"
                                            target="_blank" href="#" data-toggle="modal" data-target=".avada_modal">
                                            <span class="fusion-button-text-right">
                                                <i class="fa fa-taxi icon-preview hide-if-upload"></i>
                                                <img class="image-upload hide-if-icon" width="16" height="16"/>
                                                select</span>
                                        <span class="button-icon-divider-right"><i class="fa fa-caret-down"></i></span>
                                    </button>
                                    <span class="space-separator">or</span>
                                        <span class="fusion-button button-flat button-round button-small button-default fileinput-button">
                                            <span>Upload</span>
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
                            <a class="fusion-button button-flat button-round button-xsmall button-default" target="_blank"
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
                        <h2>Total Price: <span class="price-handler">$100.00</span></h2>
                        <h2>Quantity: <span class="qty-handler">10 + 100 Free</span></h2>
                    </div>


                    <div class="form-row">
                        <p>Guaranteed to be delived on or by</p>
                        <div class="form-group">
                            <label for="additional_notes">Addition Notes</label>
                            <textarea class="form-control input-text" name="additional_notes" id="additional_notes" cols="30" rows="5"></textarea>
                        </div>
                    </div>

                    <button class="fusion-button button-flat button-round button-large button-default alignright">
                        <span class="button-icon-divider-left"><i class="fa fa-shopping-cart"></i></span>
                         <span class="fusion-button-text-left">Add to Cart</span>
                    </button>
                </div><!-- /.fusion-column-wrapper -->
            </div><!--/.fusion-one-third-->
            <div class="fusion-one-third one_third fusion-layout-column fusion-column-last fusion-spacing-yes">
                <div class="fusion-column-wrapper">
                <?php if (isset($GLOBALS['wbc_settings']->additional_options)):?>
                    <div class="fusion-row" id="additional-option-section">
                        <h2 data-fontsize="19" data-lineheight="20">Additional Options</h2>
                    <?php $i = 1; foreach ($GLOBALS['wbc_settings']->additional_options as $index => $option):?>


                    <div class="fusion-one-half one_half fusion-layout-column fusion-spacing-yes <?php echo $i % 2 == 0 ? 'fusion-column-last' : '' ?>">
                        <div class="fusion-column-wrapper">
                            <div class="addon">
                                <input type="checkbox" name="additional_option[]" value="<?php echo $index; ?>" />
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
                                <span class="fusion-popover" data-animation="" data-class="popover-1"
                                      data-content="<?php echo esc_attr($option->tool_tip_text); ?>" data-placement="top"
                                      data-title="<?php echo $option->name; ?>" data-toggle="popover" data-trigger="hover"
                                      data-original-title="">?</span>
                            </label>

                        </div><!-- /.fusion-column-wrapper -->
                    </div><!-- /.fusion-one-third -->
                        <?php $i++; endforeach;?>
                    </div><!-- /.fusion-row -->
                    <?php endif;
                    if (isset($GLOBALS['wbc_settings']->customization)):?>
                    <div class="fusion-row" id="customization-section">
                        <h2 data-fontsize="19" data-lineheight="20">Production and Shipping</h2>
                        <?php foreach ($GLOBALS['wbc_settings']->customization->location as $index => $cus_location): ?>
                            <input type="radio" name="customization_location"
                                   value="<?php echo sanitize_title_with_underscore($cus_location->name) ;?>"
                                    data-price="<?php echo esc_attr($cus_location->price); ?>"/>
                            <label for="customization_location">
                                <?php echo esc_attr($cus_location->name); ?>
                                <span class="fusion-popover" data-animation="" data-class="popover-1"
                                      data-content="<?php echo esc_attr($cus_location->tool_tip_text); ?>" data-placement="top"
                                      data-title="<?php echo $cus_location->name; ?>" data-toggle="popover" data-trigger="hover"
                                      data-original-title="">?</span>
                            </label><br />
                        <?php endforeach; ?>

                        <?php foreach ($GLOBALS['wbc_settings']->customization->dates as $type => $date): ?>
                            <div class="form-group">
                                <label for="customization_date_<?php echo $type; ?>"><?php echo ucwords($type); ?> Time</label>
                                <select name="customization_date_<?php echo $type; ?>" class="form-control">
                                    <option value="-1">-- Select <?php echo ucwords($type) ?> Time --</option>

                                    <?php if (is_array($date)):
                                        foreach ($date as $d):?>
                                        <option value="<?php echo esc_attr($d->days); ?>"><?php echo esc_attr($d->name); ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php endif; ?>

                </div><!--/.fusion-column-wrapper -->
            </div><!--/.fusion-one-third -->
        </div>
    </section>

</div>

<div class="fusion-modal modal fade modal-1 avada_modal" tabindex="-1" role="dialog"
     aria-labelledby="modal-heading-1" aria-hidden="true" style="display: none;">
    <style type="text/css">.modal-1 .modal-header, .modal-1 .modal-footer{border-color:#ebebeb}</style>
    <div class="modal-dialog modal-lg">
        <div class="modal-content fusion-modal-content" style="background-color:#f6f6f6">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="modal-heading-1" data-dismiss="modal" aria-hidden="true"
                    data-fontsize="17" data-lineheight="36">
                    Choose your Front Start Clipart</h3>
            </div>
            <div class="modal-body">
               ...
            </div>
            <div class="modal-footer">
                <a class="fusion-button button-default button-medium button default medium" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div><!-- /.fusion-modal -->
<?php

echo '<pre>';
print_r($GLOBALS['wbc_settings']);
echo '</pre>';

get_footer();