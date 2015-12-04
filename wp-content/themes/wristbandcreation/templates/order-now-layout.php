<?php

//Template Name: WC Order Now Layout

get_header();

$TempID = $_REQUEST['id'];
$OrderStatus = $_REQUEST['Status'];


if (isset($_REQUEST['id'])){
    $Edit = false;      $MultiAdd = "";
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $meta = isset($cart_item['wristband_meta']) ? $cart_item['wristband_meta'] : array();
        $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

        if ($cart_item_key == $TempID){
            $Wrist_Style = $_product->get_title();
            $Wrist_Size = (isset($meta['size']) ? $meta['size'] : '');

            foreach ($meta['colors'] as $color): if (!isset($color['name']) || empty($color['name'])) continue;
                $ColorName = $color['name'];
                $ColorType = $color['type'];
                $WristColor = $color['color']; 
                $TextColorName = $color['text_color_name'];
                $TextColor = $color['text_color'];

                foreach ($color['sizes'] as $k => $qty): if ($qty <= 0) continue; 
                   if ($k == "adult"){ $adult = $qty; } 
                   elseif ($k == "medium"){ $medium = $qty;} 
                   else { $youth = $qty; }
                endforeach;


                if ($MultiAdd == ""){ $MultiAdd = $ColorName."^".$ColorType."^".$WristColor."^".$TextColorName."^".$TextColor."^".$adult."^".$medium."^".$youth;
                } else { $MultiAdd = $MultiAdd."~".$ColorName."^".$ColorType."^".$WristColor."^".$TextColorName."^".$TextColor."^".$adult."^".$medium."^".$youth; }
                $FontStyle =  $meta['font'];

                foreach ($meta['messages'] as $label => $val): if (empty($val)) continue;
                    if ($label == "Front Message"){ $Front_msg = $val; }
                    elseif ($label == "Back Message"){ $Back_msg = $val; }
                    else{ $Inside_msg = $val; }
                endforeach;


                foreach ($meta['additional_options'] as $k => $option):
                    if ($k == "0"){ $InPackaging = $option; }
                    elseif ($k == "1"){ $Eco = $option; }
                    elseif ($k == "2"){ $Thick = $option; }
                    else { $DigitalPro = $option; }
                endforeach;

                foreach ($meta['clipart'] as $k => $clipart): if (empty($clipart)) continue;
                    if ($k == "front_start"){ $front_start = $clipart; }
                    elseif ($k == "front_end"){ $front_end = $clipart; }
                    elseif ($k == "back_start"){ $back_start = $clipart; }
                    elseif ($k == "back_end"){ $back_end = $clipart; }
                    elseif ($k == "view_position"){ $view_position = $clipart; }
                    else{ $wristband_stat = $clipart; }
                endforeach;
                $customization_location = $meta['customization_location']; 
                $customization_date_production = $meta['customization_date_production']; 
                $customization_date_shipping = $meta['customization_date_shipping']; 
                $guaranteed_delivery = $meta['guaranteed_delivery']; 

            $Info = $Wrist_Style."|".$Wrist_Size."|".$MultiAdd;
            endforeach;
            break;
        }
    }
    $Info = $Info."|".$customization_date_production."|".$customization_date_production;
?>
    <input id="EditModeID" name="<?php echo $Info; ?>" style="display:none;">

<?php 

}
?>


<?php require_once(get_stylesheet_directory().'/wristband/includes/check_mask.php'); ?>

<div id="wristband-builder-content">
    <div>
        <span id="SelectStyleID" class="form-group-heading CssTitleBlack SelectCss"></span>
    </div>
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
                            <label for="style" class="form-group-heading CssTitleBlack">Select Style
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top" title="Select Style">?</span>
                            </label>
                            <select name="style" id="style" class="input-select">
                                <?php if (isset($GLOBALS['wbc_settings']->products)):
                                    foreach ($GLOBALS['wbc_settings']->products as $product_id => $product):
                                      //  $Stat = "";
                                       // if ($Wrist_Style == $product->product_title){ $Stat = "selected"; } 
                                ?>
                                        <option value="<?php echo $product_id; ?>" ><?php echo $product->product_title; ?></option>
                                    <?php endforeach;
                                endif; ?>
                            </select>
                        </p>
                        <p class="form-row form-row-wide" id="width_field">
                            <label for="width" class="form-group-heading CssTitleBlack">Select Width
                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                      title="Select Width">?</span>
                            </label>
                            <select name="width" id="width" class="input-select enable-if-style-selected" disabled></select>
                        </p>
                        

                        <div class="form-group">
                            <label class="form-group-heading CssTitleBlack" >Select Wristband Color</label>
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
                                                    <?php 
                                                        $Selected = "color-wrap";
                                                        foreach($color_list as $key => $list):
                                                             if (strpos($key, 'color_') === false || empty($list)) continue;
                                                            if ($list == $WristColor){ $Selected = 'color-wrap selected'; }
                                                        endforeach;
                                                    ?>

                                                    <div id="colorStyleBox" title= "<?php echo $style; ?>" class="<?php echo $Selected;  ?>">
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
                            <label class="form-group-heading CssTitleBlack" >Select Text Color</label>
                            <div id="wristband-text-color">
                                <ul>

                                </ul>
                            </div>
                        </div>


                        <div id="quantity_group_field">
                            <label class="form-group-heading CssTitleBlack" >Input Quantity <span>(Side View Guide)</span></label>
                            <p class="form-row quantity-row fusion-one-fourth one_third fusion-layout-column fusion-spacing-yes">
                                <label for="qty_adult">Adult</label>
                                <input type="number" name="qty_adult" id="qty_adult" min="0" class="input-text">
                            </p>
                            <p class="form-row quantity-row fusion-one-fourth one_third fusion-layout-column fusion-spacing-yes">
                                <label for="qty_medium">Medium</label>
                                <input type="number" name="qty_medium" id="qty_medium"  min="0" class="input-text">
                            </p>
                            <p class="form-row form-row-last fusion-one-fourth one_third fusion-layout-column fusion-column-last fusion-spacing-yes">
                                <label for="qty_youth">Youth</label>
                                <input type="number" name="qty_youth" id="qty_youth"  min="0" class="input-text">
                            </p>
                            <p class="form-row quantity-row fusion-one-fourth one_third fusion-layout-column fusion-spacing-yes">
                                <br>
                                <a class="TempAddCss" target="_blank" href="#" id="add_color_to_selections"><span class="fusion-button-text">Add</span></a>
                             </p>                    
                        <div class="clear"></div>
                            
                        </div><!-- /.quantity_group_field -->
                        
                    <?php if (isset($GLOBALS['wbc_settings']->additional_options)):?>
                        <div id="additional-option-section">
                            <label class="form-group-heading CssTitleBlack"  data-fontsize="19" data-lineheight="20">Additional Options</label>
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
                                    <img height="80" src="<?php echo $option->image->url; ?>" alt="<?php echo $option->name; ?>" class="img-responsive">
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
                                <a class="fusion-button button-flat button-round button-small button-orange prdct-info" href="#"><span class="fusion-button-text">Product Info</span></a>
                                <a class="fusion-button button-flat button-round button-small button-orange preview-button active if-message_type_is-continues" href="#" id="front_view_button" data-input="front_message" data-view="front"><span class="fusion-button-text">Front</span></a>
                                <a class="fusion-button button-flat button-round button-small button-default preview-button if-message_type_is-continues" id="back_view_button" data-input="back_message" data-view="back" href="#" ><span class="fusion-button-text">Back</span></a>
                            </div>


                            <div class="imageframe-align-center image-preview">
                                <div id="preview_container" class="container--ph">
                                    <svg id="svgelement" viewBox="0 0 300 180" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <defs>
                                            <path id="MyPath" fill-opacity="0" d="M28 98 q 125 23 250 -2"/>
                                            <path id="MyPathInside" fill-opacity="0" d="M28 90 q 80 -18 250 -2"/>

                                            <filter id="blurFilter8" x="-20" y="-20" width="200" height="200">
                                                <feGaussianBlur in="SourceAlpha" stdDeviation="20" />
                                            </filter>
                                        </defs>
                                        <rect id="bandcolor" height="100%" width="100%" style="fill: gray" />

                                          <tspan id="front_start"></tspan>
                                          <tspan id="front_end"></tspan>
                                          <tspan id="back_start"></tspan>
                                          <tspan id="back_end"></tspan>
                                          <tspan id="wrap_start"></tspan>
                                          <tspan id="wrap_end"></tspan>

                                        <?php echo $mask_inside_band; ?>
                                        <?php echo $mask1_inside . $mask2_inside; ?> 

                                        <text id="bandtextinside" text-anchor="middle" fill="#9d1d20" style="font-family: Arial; font-weight: 600; font-size: 30px; fill: #999999; opacity: 0.6;">
                                        <textPath id="bandtextpathinside" xlink:href="#MyPathInside" startOffset="50%">
                                            <tspan id="insidetextpath" dominant-baseline="middle"></tspan>
                                        </textPath>
                                        </text>

                                        <?php echo $mask_outside_band; ?>
                                        <?php echo $mask1 . $mask2; ?>

                                        <text id="bandtext" text-anchor="middle" fill="#9d1d20" style="font-family: Arial; font-weight: 600; font-size: 30px; fill: #999999; opacity: 0.6;">
                                            <textPath id="bandtextpath" xlink:href="#MyPath" startOffset="50%">
                                                <tspan id="icon_start" class="fa" dominant-baseline="middle"></tspan>
                                                <tspan id="front-text" dominant-baseline="middle"></tspan>
                                                <tspan id="icon_end" class="fa" dominant-baseline="middle"></tspan>
                                            </textPath>
                                        </text>            
                                        <rect x="15" y="75" width="30" height="50" style="stroke: none; fill: #00ff00; filter: url(#blurFilter8);" />
                                        <rect x="260" y="75" width="30" height="50" style="stroke: none; fill: #00ff00; filter: url(#blurFilter8);" />
                                        <image height="100%" width="100%" xlink:href="/wp-content/themes/wristbandcreation/wristband/assets/images/WRISTBAND2.png" />
                                    </svg> 
                                </div>
                            </div>

                            <div>
                                <div class="form-group table-responsive">
                                    <table id="selected_color_table" class="table table-bordered" border="0">
                                        <thead>
                                            <tr>
                                                <th style="width: 150px;">Color</th>
                                                <th class="TempCss1">Adult</th>
                                                <th class="TempCss1">Medium</th>
                                                <th class="TempCss1">Youth</th>
                                                <th class = "text_to_alter">Text</th>
                                                <th colspan="2" style="text-align:right;"><a class="CssEditSave" id="EditSaveID">Edit</a>&nbsp; <a class="CssEditSave"  id="CancelID"></a></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div>
                                <div class="form-row">
                                    <label for="message_type" class="form-group-heading CssTitleBlack">Message on Wristbands</label class="form-group-heading CssTitleBlack" >

                                    <div style="float: right;">
                                        <input type="radio" name="message_type" value="front_and_back" checked/>
                                        Front/Back
                                        <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                          title="Front and Back Message" data-placement="top">?</span>

                                        &nbsp;
                                        <input type="radio" name="message_type" value="continues"/>
                                        Wrap Around
                                        <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                              title="Continuous Message" data-placement="top">?</span>
                                 
                                    </div>
                                </div>

                                <?php if (isset($GLOBALS['wbc_settings']->tool_tip_text)):
                                    $tooltip = $GLOBALS['wbc_settings']->tool_tip_text ; ?>
                                    <div id="ForFrontBackID">
                                        <p class="form-row form-row-wide hide-if-message_type-continues" id="width_field">
                                            <table style="width: 100%;" border="0" cellspacing="0"><tr>
                                                <td class="TdTitleCss">
                                                    <label for="front_message"  class="form-group-heading">Front Message
                                                        <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                                          title="<?php echo $tooltip->front;?>" data-placement="top">?
                                                        </span>
                                                    </label>
                                                </td><td>
                                                    <input type="text" name="front_message" class="input-text trigger-limit-char"
                                                           data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" value="<?php echo $Front_msg; ?>">
                                                </td>
                                            </tr></table>
                                        </p>

                                        <p class="form-row form-row-wide hide-if-message_type-continues">
                                            <table style="width: 100%;" border="0" cellspacing="0"><tr>
                                                <td class="TdTitleCss">
                                                    <label for="back_message"  class="form-group-heading">Back Message
                                                        <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                                          title="<?php echo $tooltip->back;?>" data-placement="top">?
                                                        </span>
                                                    </label>
                                                </td><td>
                                                    <input type="text" name="back_message"  class="input-text trigger-limit-char"
                                                           data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" value="<?php echo $Back_msg; ?>"  />
                                                </td>
                                            </tr></table>
                                        </p><!-- /.form-group -->
                                    </div>

                                <div id="ForContiID">
                                    <p class="form-row form-row-wide hide-if-message_type-front_and_back">
                                        <table style="width: 100%;" border="0" cellspacing="0"><tr>
                                            <td class="TdTitleCss">
                                                <label for="continues_message"  class="form-group-heading">Continuous Message
                                                    <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                                      title="<?php echo $tooltip->wrap_around;?>" data-placement="top">?
                                                    </span>
                                                </label>
                                            </td><td>
                                                <input type="text" name="continues_message" class="input-text trigger-limit-char"
                                                       data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" />
                                            </td>
                                        </tr></table>
                                    </p><!-- /.form-group -->
                                </div>

                                <p class="form-row form-row-wide">
                                    <table style="width: 100%;" border="0" cellspacing="0"><tr>
                                        <td class="TdTitleCss">
                                            <label for="inside_message"  class="form-group-heading">Inside Message
                                                <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                                  title="<?php echo $tooltip->inside;?>" data-placement="top">?
                                                </span>
                                            </label>
                                        </td><td>
                                            <input type="text" name="inside_message" class="input-text trigger-limit-char"
                                                   data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" value="<?php echo $Inside_msg; ?>" />
                                        </td>
                                    </tr></table>
                                </p><!-- /.form-group -->
                                <?php endif; ?>
                            </div>
                            <!-- 
                            <div id="hiddenDiv" style="display:none" >
                              <canvas id="hiddenCanvas"></canvas>
                              <a id="hiddenPng" />
                            </div> -->
                        </div>

                        <p class="form-row form-row-wide">
                            <label for="additional_notes"  class="form-group-heading CssTitleBlack">Addition Notes</label>
                            <textarea class="input-text" name="additional_notes" id="additional_notes" cols="30" rows="5"></textarea>
                        </p>


                    </div><!-- /.fusion-column-wrapper -->
                </div><!--/.fusion-one-third-->
                <div class="fusion-one-fourth one_fourth fusion-layout-column fusion-column-last fusion-spacing-yes">
                    <div class="fusion-column-wrapper">
                        <p class="form-row form-row-wide">
                            <label for="font" class="form-group-heading CssTitleBlack">Font</label>
                            <select name="font" id="font" class="input-select enable-if-style-selected">
                                <option value="-1">-- Select --</option>

                                <?php if (isset($GLOBALS['wbc_settings']->fonts)):
                                    foreach ($GLOBALS['wbc_settings']->fonts as $font):?>
                                        <?php   $Selected = "";
                                                if ($FontStyle == esc_attr($font)){ $Selected = "selected"; }
                                        ?>
                                        <option style="font-size:18px;font-family: '<?php echo esc_attr($font); ?>' !important;"
                                                value="<?php echo esc_attr($font); ?>" <?php echo $Selected; ?> ><?php echo esc_attr($font); ?></option>
                                <?php endforeach;
                                    endif; ?>
                            </select>
                        </p><!-- /.form-group -->
                        <div id="add-clipart">
                            <label class="form-group-heading CssTitleBlack" >Add Clipart</label>
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
                            <label class="form-group-heading CssTitleBlack">Production and Shipping</label>
                            <?php $flag = false; foreach ($GLOBALS['wbc_settings']->customization->location as $cus_location): ?>
                                <p class="form-row form-row-wide">
                                    <label>
                                        <?php 
                                            $Stat = "";
                                            if ($customization_location == esc_attr($cus_location->name)){ $Stat = "checked"; } 
                                        ?>
                                        <input type="radio" name="customization_location" data-title="<?php echo esc_attr($cus_location->name); ?>"
                                               value="<?php echo sanitize_title_with_underscore($cus_location->name) ;?>"
                                               data-price="<?php echo esc_attr($cus_location->price); ?>"
                                            <?php echo !$flag ? 'checked' : ''; ?> <?php echo $Stat; ?> title="<?php echo esc_attr($cus_location->tool_tip_text);  ?>"/>
                                        <?php echo esc_attr($cus_location->name); ?>

                                       <!--  <span class="fusion-popover" data-toggle="tooltip" data-placement="top"
                                              title="<?php echo esc_attr($cus_location->tool_tip_text); ?>">?</span> -->
                                    </label>

                               </p>
                            <?php $flag = true; endforeach; ?>

                            <?php foreach ($GLOBALS['wbc_settings']->customization->dates as $type => $date): ?>
                                <p class="form-row form-row-wide">
                                    <label for="customization_date_<?php echo $type; ?>" class="form-group-heading CssTitleBlack"><?php echo ucwords($type); ?> Time</label>
                                    <select id="customization_date_<?php echo $type; ?>"
                                            name="customization_date_<?php echo $type; ?>"
                                            class="input-select customization-date-select" disabled required>
                                        <option value="-1">-- Select <?php echo ucwords($type) ?> Time --</option>
                                    </select>
                                </p>
                            <?php endforeach; ?>
                        </div>

                        <?php endif; ?>



                      <p class="form-row form-row-wide">
                            Guaranteed to be delived on or by : <strong id="delivery_date"></strong>
                        </p>



                    </div><!--/.fusion-column-wrapper -->



                        <div>
                            <p class="fusion-row price price-with-decimal">
                                <span class="currency CurrencyAddup"><?php echo get_woocommerce_currency_symbol(); ?></span>
                                <span class="integer-part price-handler" id="price_handler">0.00</span>
                                <span class="time">Total Amount</span>
                                <br />
                                <span id="qty_handler" class="qty-handler">0</span> Quantity
                            </p>

                            <button id="wbc_add_to_cart" href="#" class="fusion-button button-flat button-round button-large button-default alignright">
                                <span class="button-icon-divider-left"><i class="fa fa-shopping-cart"></i></span>
                                 <span class="fusion-button-text-left">Add to Cart</span>
                            </button>

                            <div class="link-buttons aligncenter">
                                <a id= "save_button" class="fusion-button button-flat button-round button-small button-default SaveBtnAddup" href="#"><span class="fusion-button-text">Save Design</span></a>
                            </div>
                        </div>




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


<script type="text/javascript">
    function EditMode(){
          


    }






</script>




<?php 
if (isset($_REQUEST['id'])){
    echo "<script type='text/javascript'> 

$('#qty_adult, #qty_medium, #qty_youth').trigger('keyup');

alert('sdadas');
    </script>";
}

?>






<?php
//echo '<pre>';
//print_r($GLOBALS['wbc_settings']);
//echo '</pre>';
get_footer();