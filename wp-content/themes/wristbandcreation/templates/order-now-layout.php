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
                            <input type="radio" name="mesage_type" value="front_and_back" />
                            <label for="mesage_type" class="checkbox">
                                Front and Back
                            </label>
                        </p>
                        <p class="form-row">
                            <input type="radio" name="mesage_type" value="continues" />
                            <label for="message" class="checkbox">
                                Continues
                            </label>
                        </p>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label for="width">Front Message
                            <span class="char_left_wrapper pull-right">
                                <input type="text" name="front_message_chars_left" class="input-text input-text-xs" value="0" size="5" disabled=""> Chars Left
                            </span>
                        </label>
                        <input type="" name="front_message"  class="form-control" >
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label for="width">Back Message
                            <span class="char_left_wrapper pull-right">
                                <input type="text" name="back_message_chars_left" class="input-text input-text-xs" value="0" size="5" disabled=""> Chars Left
                            </span>
                        </label>
                        <input type="" name="back_message"  class="form-control" >
                    </div><!-- /.form-group -->

                    <div class="form-group">
                        <label for="width">Inside Message
                            <span class="char_left_wrapper pull-right">
                                <input type="text" name="inside_message_chars_left" class="input-text input-text-xs" value="0" size="5" disabled=""> Chars Left
                            </span>
                        </label>
                        <input type="" name="inside_message"  class="form-control" >
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label for="font">Font</label>
                        <select name="font" id="font" class="form-control enable-if-style-selected" disabled></select>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <h2>Add Clipart</h2>
                        <p class="form-row">
                            <label for="clipart_front_start" class="checkbox">
                                <span class="text-label fusion-one-third one_third fusion-layout-column fusion-spacing-no">Front Start</span>
                                <span class="input-wrapper fusion-two-third fusion-layout-column fusion-column-last fusion-spacing-no">
                                    <select name="clipart_front_start">
                                        <option>Select</option>
                                        </select> or
                                    <a class="fusion-button button-flat button-round button-xsmall button-default" target="_blank" href="#"><span class="fusion-button-text">Upload</span></a>
                                </span>
                            </label>
                        </p>
                        <p class="form-row">
                            <label for="clipart_front_end" class="checkbox">
                                <span class="text-label fusion-one-third one_third fusion-layout-column fusion-spacing-no">Front End</span>
                                <span class="input-wrapper fusion-two-third fusion-layout-column fusion-column-last fusion-spacing-no">
                                    <select name="clipart_front_end">
                                        <option>Select</option>
                                    </select> or
                                    <a class="fusion-button button-flat button-round button-xsmall button-default" target="_blank" href="#"><span class="fusion-button-text">Upload</span></a>
                                </span>
                            </label>
                        </p>
                        <p class="form-row">
                            <label for="clipart_back_start" class="checkbox">
                                <span class="text-label fusion-one-third one_third fusion-layout-column fusion-spacing-no">Back Start</span>
                                <span class="input-wrapper fusion-two-third fusion-layout-column fusion-column-last fusion-spacing-no">
                                    <select name="clipart_back_start">
                                        <option>Select</option>
                                    </select> or
                                    <a class="fusion-button button-flat button-round button-xsmall button-default" target="_blank" href="#"><span class="fusion-button-text">Upload</span></a>
                                </span>
                            </label>
                        </p>
                        <p class="form-row">
                            <label for="clipart_back_end" class="checkbox">
                                <span class="text-label fusion-one-third one_third fusion-layout-column fusion-spacing-no">Back End</span>
                                <span class="input-wrapper fusion-two-third fusion-layout-column fusion-column-last fusion-spacing-no">
                                    <select name="clipart_back_end">
                                        <option>Select</option>
                                    </select> or
                                    <a class="fusion-button button-flat button-round button-xsmall button-default" target="_blank" href="#"><span class="fusion-button-text">Upload</span></a>
                                </span>
                            </label>
                        </p>
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
                            <textarea class="form-control" name="additional_notes" id="additional_notes" cols="30" rows="5"></textarea>
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




<?php

echo '<pre>';
print_r($GLOBALS['wbc_settings']);
echo '</pre>';

get_footer();