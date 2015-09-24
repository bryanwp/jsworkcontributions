<?php

//Template Name: WC Order Now Layout

get_header();

echo '<pre>';
print_r($GLOBALS['wbc_settings']);
echo '</pre>';
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
        <div class="row">
            <div class="fusion-one-third one_third fusion-layout-column fusion-spacing-yes">
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
                        <label for="mesage_type" class="checkbox">
                            <input type="radio" name="mesage_type" value="front_and_back" />
                            Front and Back
                        </label>
                    </p>
                    <p class="form-row">
                        <label for="message" class="checkbox">
                            <input type="radio" name="mesage_type" value="continues" />
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

            </div><!--/.col-md-4-->
            <div class="fusion-one-third one_third fusion-layout-column fusion-spacing-yes">
                <div class="form-row">
                    <div class="image-preview">
                        <img src="http://wristband.local/wp-content/uploads/2015/09/main-debossed-fill.png" alt="">
                    </div>
                    <div class="link-buttons">
                        <a class="fusion-button button-flat button-round button-xsmall button-default" target="_blank" href="#"><span class="fusion-button-text">Product Info</span></a>
                        <a class="fusion-button button-flat button-round button-xsmall button-default" target="_blank" href="#"><span class="fusion-button-text">Save Design</span></a>
                        <a class="fusion-button button-flat button-round button-xsmall button-default" target="_blank" href="#"><span class="fusion-button-text">Front</span></a>
                        <a class="fusion-button button-flat button-round button-xsmall button-default" target="_blank" href="#"><span class="fusion-button-text">Back</span></a>
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

                <button class="fusion-button button-flat button-round button-small button-default alignright">Add to Cart</button>
            </div><!--/.col-md-4-->
            <div class="fusion-one-third one_third fusion-layout-column fusion-spacing-yes">

            </div><!--/.col-md-4-->
        </div>
    </section>

</div>




<?php

get_footer();