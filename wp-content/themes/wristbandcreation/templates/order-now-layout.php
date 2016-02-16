<?php
//Template Name: WC Order Now Layout
function getwimg(){
    if($_SERVER[HTTP_HOST] === 'localhost' || $_SERVER[HTTP_HOST] === '192.168.2.165'){
        return '..';
    }
}
get_header();

$isEdit = false;
$metaInfo = false;

if (isset($_REQUEST['id'])) {
    $isEdit = isset($_REQUEST['Status']) && $_REQUEST['Status'] == 'edit' ? true : false;

    $metaInfo = getMetaToAutoSet($_REQUEST['id'], $_REQUEST['Status']);
    if ($metaInfo != false) {
        echo '<input id="EditModeID" name="' . $metaInfo['all'] . '" value="' . $_REQUEST['id'] . '" type="hidden">';
    } else {
        echo '<script>window.location = "' . get_site_url() . '/order-now/";</script>';
    }
}
/* $TempID = $_REQUEST['id'];
  $OrderStatus = $_REQUEST['Status'];

  $Edit = false;
  if (isset($_REQUEST['id']))
  {
  $MultiAdd = "";
  foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {


  $meta = isset($cart_item['wristband_meta']) ? $cart_item['wristband_meta'] : array();
  $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
  $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

  if ($cart_item_key == $TempID){
  $Edit = true;
  $Wrist_Style = $_product->get_title();
  $Wrist_Size = (isset($meta['size']) ? $meta['size'] : '');

  $free_colors = $meta['free_colors'];
  foreach ($meta['colors'] as $pk => $color): if (!isset($color['name']) || empty($color['name'])) continue;
  $ColorName = $color['name'];
  $ColorType = $color['type'];
  $WristColor = $color['color'];
  $TextColorName = $color['text_color_name'];
  $TextColor = $color['text_color'];

  $adult = 0;
  $medium = 0;
  $youth = 0;
  $adult_free = 0;
  $medium_free = 0;
  $youth_free = 0;

  foreach ($color['sizes'] as $k => $qty): if ($qty <= 0) continue;
  if ($k == "adult"){ $adult = $qty; }
  elseif ($k == "medium"){ $medium = $qty;}
  else { $youth = $qty; }
  endforeach;

  foreach ($free_colors[$pk]['free'] as $k => $qty): if ($qty <= 0) continue;
  if ($k == "adult"){ $adult_free = $qty; }
  elseif ($k == "medium"){ $medium_free = $qty;}
  else { $youth_free = $qty; }
  endforeach;


  if ($MultiAdd == ""){ $MultiAdd = $ColorName."^".$ColorType."^".$WristColor."^".$TextColorName."^".$TextColor."^".$adult."^".$medium."^".$youth."^".$adult_free."^".$medium_free."^".$youth_free;
  } else { $MultiAdd = $MultiAdd."~".$ColorName."^".$ColorType."^".$WristColor."^".$TextColorName."^".$TextColor."^".$adult."^".$medium."^".$youth."^".$adult_free."^".$medium_free."^".$youth_free; }
  $FontStyle =  $meta['font'];

  foreach ($meta['messages'] as $label => $val): if (empty($val)) continue;
  if ($label == "Front Message"){ $Front_msg = $val; }
  elseif ($label == "Back Message"){ $Back_msg = $val; }
  elseif ($label == "Continuous Message"){ $Wrap_msg = $val; }
  elseif ($label == "Inside Message"){ $Inside_msg = $val; }
  elseif ($label == "Additional Notes"){ $AddNotes_msg = $val; }
  endforeach;

  if(isset($meta['additional_options']))
  {
  foreach ($meta['additional_options'] as $k => $option):
  if ($k == "0"){ $InPackaging = $option; }
  elseif ($k == "1"){ $Eco = $option; }
  elseif ($k == "2"){ $Thick = $option; }
  else { $DigitalPro = $option; }
  endforeach;
  }

  foreach ($meta['clipart'] as $k => $clipart): if (empty($clipart)) continue;
  if ($k == "front_start"){ $front_start = $clipart; }
  elseif ($k == "front_end"){ $front_end = $clipart; }
  elseif ($k == "back_start"){ $back_start = $clipart; }
  elseif ($k == "back_end"){ $back_end = $clipart; }
  elseif ($k == "wrap_start"){ $wrap_start = $clipart; }
  elseif ($k == "wrap_end"){ $wrap_end = $clipart; }
  elseif ($k == "view_position"){ $view_position = $clipart; }
  else{ $wristband_stat = $clipart; }
  endforeach;

  $C_location = $meta['customization_location'];
  $C_date_prod = $meta['customization_date_production'];
  $C_date_ship = $meta['customization_date_shipping'];
  $guaranteed_delivery = $meta['guaranteed_delivery'];

  $Info = $Wrist_Style."|".$Wrist_Size."|".$MultiAdd;
  endforeach;
  break;
  }
  }
  $Info = $Info."|".$C_location."|".$C_date_prod."|".$C_date_ship."|".$InPackaging.
  "|".$Eco."|".$Thick."|".$DigitalPro.
  "|".$front_start."|".$front_end."|".$back_start."|".$back_end."|".$view_position."|".$wristband_stat."|".$guaranteed_delivery."|".$wrap_start."|".$wrap_end;


  if($Edit == false && $OrderStatus == 'edit')
  {
  echo '<script>window.location = "'.get_site_url().'/order-now/";</script>';
  }

  echo '<input id="EditModeID" name="'.$Info.'" style="display:none;" value="'.$TempID.'">';
  } */
?>


<?php require_once(get_stylesheet_directory() . '/wristband/includes/check_mask.php'); ?>

<div id="wristband-builder-content">
    <div>
        <span id="SelectStyleID" class="form-group-heading CssTitleBlack SelectCss"></span>
    </div>
    <section id="wristband-builder">
        <form action="#" method="post">
            <div class="fusion-row">
                <div id="price-scroll">
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
                </div>

                <div class="fusion-one-fourth one_fourth fusion-layout-column fusion-spacing-yes">
                    <div class="fusion-column-wrapper">
                        <p class="form-row form-row-wide" id="style_field">
                            <label for="style" class="form-group-heading CssTitleBlack">Select Style
                                <span class="fusion-popover tooltip-img" data-toggle="tooltip" data-placement="top" title="Select Style">?</span>
                            </label>
                            <select name="style" id="style" class="input-select">
<?php
if (isset($GLOBALS['wbc_settings']->products)):
    foreach ($GLOBALS['wbc_settings']->products as $product_id => $product):
        //  $Stat = "";
        // if ($Wrist_Style == $product->product_title){ $Stat = "selected"; } 
        ?>
                                        <option value="<?php echo $product_id; ?>" ><?php echo $product->product_title; ?></option>
                                    <?php endforeach;
                                endif;
                                ?>
                            </select>
                        </p>
                        <p class="form-row form-row-wide" id="width_field">
                            <label for="width" class="form-group-heading CssTitleBlack">Select Width
                                <span class="fusion-popover tooltip-img" data-toggle="tooltip" data-placement="top"
                                      title="Select Width">?</span>
                            </label>
                            <select name="width" id="width" class="input-select enable-if-style-selected" disabled> inch</select>
                        </p>


                        <div class="form-group">
                            <label class="form-group-heading CssTitleBlack" >Select Wristband Color</label>
                            <div id="wristband-color-tab" class="fusion-tabs classic horizontal-tabs">
                                <div class="nav">
                                    <ul id="wbcolor" class="nav-tabs nav-justified">
<?php $flag = true;
foreach ($GLOBALS['wbc_settings']->color_style as $style => $data): ?>
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
    <?php $flag = false;
endforeach; ?>
                                    </ul>
                                </div>

                                <div class="tab-content" id="wristband-color-items">

                                    <?php $flag = true;
                                    $x = 0;
                                    foreach ($GLOBALS['wbc_settings']->color_style as $style => $data): ?>

                                        <div class="tab-pane fade <?php echo $flag ? 'active in' : ''; ?>" id="tab-<?php echo sanitize_title($style); ?>">
                                            <ul>
                                        <?php foreach ($data->color_list as $i => $color_list): ?>
                                                    <li  class="color-enabled" data-toggle="tooltip" data-placement="top"
                                                         title="<?php echo $color_list->name; ?>">
                                                             <?php
                                                             $Selected = "color-wrap";
                                                             foreach ($color_list as $key => $list):
                                                                 if (strpos($key, 'color_') === false || empty($customization_locationlist))
                                                                     continue;
                                                                 if (isset($WristColor)) {
                                                                     if ($list == $WristColor) {
                                                                         $Selected = 'color-wrap selected';
                                                                     }
                                                                 }
                                                             endforeach;
                                                             ?>

                                                        <div id="colorStyleBox" title= "<?php echo $style; ?>" class="<?php echo $Selected; ?>">
                                                            <?php
                                                            $colorx = array();
                                                            foreach ($color_list as $key => $list):
                                                                if (strpos($key, 'color_') === false || empty($list))
                                                                    continue;
                                                                $colorx[] = $list
                                                                ?>
                                                          <?php endforeach; ?>


                                                            <div data-name="<?php echo $color_list->name; ?>" data-color="<?php echo implode(',', $colorx); ?>" style="background-color: <?php echo implode(',', $colorx); ?>;
                                                                 background: -webkit-linear-gradient(90deg,<?php echo implode(',', $colorx); ?>); /* For Safari 5.1 to 6.0 */
                                                                 background: -o-linear-gradient(90deg,<?php echo implode(',', $colorx); ?>); /* For Opera 11.1 to 12.0 */
                                                                 background: -moz-linear-gradient(90deg,<?php echo implode(',', $colorx); ?>); /* For Firefox 3.6 to 15 */
                                                                 background: linear-gradient(90deg,<?php echo implode(',', $colorx); ?>); /* Standard syntax */">
                                                            </div>


                                                        </div>
                                                    </li>
                                              <?php $flag = false;
                                          endforeach; ?>
                                       </ul>
                                      </div>

                                          <?php $x++;
                                      endforeach; ?>

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-group-heading CssTitleBlack" id="selectTextColorLabel" style="display:none">Select Text Color</label>
                            <div id="wristband-text-color">
                                <ul>

                                </ul>
                            </div>
                        </div>
                        <div id="quantity_group_field">
                            <!-- <label class="form-group-heading CssTitleBlack" >Input Quantity <span>(Side View Guide)</span></label> -->
                            <p class="form-row quantity-row fusion-one-fourth one_third fusion-layout-column fusion-spacing-yes">
                                <label class="form-group-heading CssTitleBlack" for="qty_adult">Adult</label>
                                <input type="number" name="qty_adult" id="qty_adult" min="0" class="input-text" style="padding: 0; text-align: center;">
                            </p>
                            <p class="form-row quantity-row fusion-one-fourth one_third fusion-layout-column fusion-spacing-yes">
                                <label class="form-group-heading CssTitleBlack" for="qty_medium">Medium</label>
                                <input type="number" name="qty_medium" id="qty_medium"  min="0" class="input-text" style="padding: 0; text-align: center;">
                            </p>
                            <p class="form-row form-row-last fusion-one-fourth one_third fusion-layout-column fusion-column-last fusion-spacing-yes">
                                <label class="form-group-heading CssTitleBlack" for="qty_youth">Youth</label>
                                <input type="number" name="qty_youth" id="qty_youth"  min="0" class="input-text" style="padding: 0; text-align: center;">
                            </p>
                            <p id="quantity_group_field_button" class="form-row quantity-row fusion-one-fourth one_third fusion-layout-column fusion-spacing-yes">
                                <br>
                                <a class="TempAddCss" target="_blank" href="#" id="add_color_to_selections"><span class="fusion-button-text">Add</span></a>
                            </p>                    
                            <div class="clear"></div>

                        </div><!-- /.quantity_group_field -->
                        <!-- Color Quantity table -->
                        <div class="" style = "padding:0px">
                            <span id="freeCounter" class="CssTitleBlue"></span>
                            <div class="form-group table-responsive">
                                <table id="selected_color_table" class="table table-bordered" border="0">
                                    <thead>
                                        <tr>
                                            <th >Color</th>
                                            <th class="TempCss1" style="text-align:left;padding-right: 5px;">Adult</th>
                                            <th class="TempCss1" style="text-align:left;padding-right: 5px;">Medium</th>
                                            <th class="TempCss1" style="text-align:left;padding-right: 5px;">Youth</th>
                                            <th class = "text_to_alter">Text</th>
                                            <th colspan="2" style="text-align:right;"><a class="CssEditSave CssTitleBlue font-size-11" id="EditSaveID" style="cursor: pointer;"><i class="fa fa-pencil"></i></a><br><a style="cursor: pointer;" class="CssEditSave CssTitleRed font-size-11"  id="CancelID"></a></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /. Color Quantity table -->
                            <!-- /.fusion-row -->
                    </div>
                </div><!--/.fusion-one-third-->
                <div class="fusion-one-half one_half fusion-layout-column fusion-spacing-yes">
                    <div class="fusion-column-wrapper">
                        <div class="fusion-row">
                            <!-- <div class="link-buttons alignleft"> -->
                            <div id="viewButtonGroup" class="col-md-2">
                                <!-- <a class="fusion-button button-flat button-round button-small button-orange prdct-info" href="#"><span class="fusion-button-text">Product Info</span></a> -->
                                <!-- <a class="fusion-button button-flat button-round button-small button-orange preview-button active if-message_type_is-continues" href="#" id="front_view_button" data-input="front_message" data-view="front"><span class="fusion-button-text">Front</span></a> -->
                                <!-- <a class="fusion-button button-flat button-round button-small button-default preview-button if-message_type_is-continues" id="back_view_button" data-input="back_message" data-view="back" href="#" ><span class="fusion-button-text">Back</span></a> -->
                            </div>

                            <div class="col-md-12" style = "padding:0px">
                                                <!-- <span id="freeCounter" class="CssTitleBlue"></span>
                                                <div class="form-group table-responsive">
                                                    <table id="selected_color_table" class="table table-bordered" border="0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 150px;">Color</th>
                                                                <th class="TempCss1" style="text-align:left;">Adult</th>
                                                                <th class="TempCss1" style="text-align:left;">Medium</th>
                                                                <th class="TempCss1" style="text-align:left;">Youth</th>
                                                                <th class = "text_to_alter">Text</th>
                                                                <th colspan="2" style="text-align:right;"><a class="CssEditSave CssTitleBlue font-size-11" id="EditSaveID" style="cursor: pointer;">Edit Quantity</a><br><a style="cursor: pointer;" class="CssEditSave CssTitleRed font-size-11"  id="CancelID"></a></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                
                                                        </tbody>
                                                    </table>
                                                </div> -->
                            </div>



                            <input type="hidden" name="wbsize" value="2">
                            <input type="hidden" name="fbfront" value="0">
                            <input type="hidden" name="fbback" value="0">
                            <input type="hidden" name="textcount" value="0">
                            <input type="hidden" name="textcount2" value="0">
                            <input type="hidden" name="textinside" value="0">
                            <input type="hidden" name="isWrapCont" value="0">
                            <input type="hidden" name="isWrapInside" value="0">
                            <input type="hidden" name="frontPaste" value="0">
                            <input type="hidden" name="backPaste" value="0">
                            <input type="hidden" name="wrapPaste" value="0">
                            <input type="hidden" name="insidePaste" value="0">
                            <input type="hidden" name="lengthAdjustFlagBand1" value="0">
                            <input type="hidden" name="lengthAdjustFlagBand2" value="0">
                            <div id="ifrontcontend" style="display:none">&#xf059;</div>
                            <div class="wbdiv">
                                <!--<div class="imageframe-align-center image-preview">-->
                                <div class="containersvg1">
                                    <svg id="svgelement" viewBox="0 0 300 113" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <defs>
                                    <path id="ContainerPath" fill-opacity="0" d="M0 0 q 80 -18 444 -2"/>
                                    <path id="MyPath1" fill-opacity="0" d="M15 75 q 125 23 270 -2"/>
                                    <path id="MyPath2" fill-opacity="0" d="M15 75 q 125 23 270 -2"/>
                                    <path id="MyPathCont1" fill-opacity="0" d="M15 78 q 125 23 280 -4"/>
                                    <path id="MyPathCont2" fill-opacity="0" d="M8 77 q 130 25 280 -2"/>
                                    <path id="MyPathInside1" fill-opacity="0" d="M15 60 q 80 -18 270 -1.5"/>
                                    <path id="MyPathInside2" fill-opacity="0" d="M15 60 q 80 -18 270 -1.5"/>
                                    <path id="InsideArc" fill-opacity="0" d="M15 68 q 125 15 270 -2"/>

                                    <filter id="blurSideShadow" x="-20" y="-20" width="200" height="200">
                                        <feGaussianBlur in="SourceAlpha" stdDeviation="20" />
                                    </filter>
                                    </defs>
                                    <rect id="bandcolor" height="100%" width="100%" style="fill: gray" />
                                    <?php echo $segcolor1_band1 . $segcolor2_band1; ?>
                                    <?php echo $mask_inside_band1; ?>
                                    <?php // $mask1_inside;  ?>            
                                    <?php echo $mask2_inside_band1 . $mask1_inside_band1; ?>           
                                    <text id="bandtextinside1" fill="#9d1d20" style="font-family: Arial; font-size: 30px; fill: #999999; opacity: 0.6;">
                                    <textPath id="bandtextpathinside1" xlink:href="#MyPathInside1" startOffset="0%">
                                        <tspan id="front-startinside1" class="fa" dominant-baseline="middle"></tspan>
                                        <tspan id="front-textinside1" dominant-baseline="middle"></tspan>
                                        <tspan id="front-endinside1" class="fa" dominant-baseline="middle"></tspan>
                                    </textPath>
                                    </text>
                                  <?php echo $mask_outside_band1; ?>
                                  <?php // echo $mask1;   ?>            
                                  <?php echo $mask2_band1 . $mask1_band1; ?>
                                  <?php echo $segcolor1_cover_band1 . $segcolor2_cover_band1; ?>            
                                  <?php echo $segcolor3_band1; ?>            
                                    <text id="bandtext1" text-anchor="middle" fill="#9d1d20" style="font-family: Arial; font-size: 30px; fill: #999999; opacity: 0.6;">
                                    <textPath id="bandtextpath1" xlink:href="#MyPath1" startOffset="50%">
                                        <tspan id="front-start1" class="fa" dominant-baseline="middle">&#xf059;</tspan>
                                        <tspan id="front-text1" dominant-baseline="middle"></tspan>
                                        <tspan id="front-end1" class="fa" dominant-baseline="middle">&#xf059;</tspan>
                                    </textPath>
                                    </text>
                                    <text id="bandtextcont1" fill="#9d1d20" style="font-family: Arial; font-size: 30px; fill: #999999; opacity: 0.6;"  display="none">
                                    <textPath id="bandtextpathcont1" xlink:href="#MyPathCont1" startOffset="0%">
                                        <tspan id="front-startcont1" class="fa" dominant-baseline="middle">&#xf059;</tspan>
                                        <tspan id="front-textcont1" dominant-baseline="middle"></tspan>
                                        <tspan id="front-endcont1" class="fa" dominant-baseline="middle">&#xf059;</tspan>
                                    </textPath>
                                    </text>

                                    <rect x="0" y="15" width="30" height="120" filter="url(#blurSideShadow)" />
                                    <rect x="275" y="15" width="30" height="120" filter="url(#blurSideShadow)" />
                                    <image  id="img1_1" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/1.png" display="none"/>
                                    <image  id="img1_1_2" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/1_2.png" display="none"/>
                                    <image  id="img1_3_4" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/3_4.png" />
                                    <image  id="img1_1_4" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/1_4.png" display="none"/>
                                    <image  id="no_arc_img1_1" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/no_arc_1.png" display="none"/>
                                    <image  id="no_arc_img1_1_2" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/no_arc_1_2.png" display="none"/>
                                    <image  id="no_arc_img1_3_4" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/no_arc_3_4.png" />
                                    <image  id="no_arc_img1_1_4" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/no_arc_1_4.png" display="none"/>

                                    <use id="arc1" xlink:href="#InsideArc" stroke-dasharray="5, 5" stroke="black" display="none"/>
                                    <!--<use xlink:href="#MyPathCont1" fill="none" stroke="blue"  />-->
                                    <!--<use xlink:href="#MyPathInside1" fill="none" stroke="green"  />-->
                                     <?php echo $glow1; ?>
                                    <!-- <text x="3" y="16" style="fill: white; stroke: White; stroke-width: 3">FRONT VIEW</text>
                                    <text x="3" y="16" style="fill: black; stroke: Black; stroke-width: 1">FRONT VIEW</text> -->
                                    <text text-anchor="middle" x="150" y="16" style="fill: white; stroke: White; stroke-width: 3">FRONT VIEW</text>
                                    <text text-anchor="middle" x="150" y="16" style="fill: black; stroke: Black; stroke-width: 1">FRONT VIEW</text>
                                    <rect width="100%" height="100%" style="stroke:white;stroke-width:2;fill-opacity:0;">

                                    </svg>
                                </div>
                                <div class="containersvg2">
                                    <svg id="svgelement2" viewBox="0 0 300 113" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect id="bandcolor2" height="100%" width="100%" style="fill: gray" />
                                    <?php echo $mask_inside_band2; ?>
                                    <?php echo $mask2_inside_band2 . $mask1_inside_band2; ?>
                                    <?php echo $segcolor1_band2 . $segcolor2_band2; ?>
                                    <?php echo $segcolor3_band2; ?>
                                    <text id="bandtextinside2" fill="#9d1d20" style="font-family: Arial; font-size: 30px; fill: #999999; opacity: 0.6;">
                                    <textPath id="bandtextpathinside2" xlink:href="#MyPathInside2" startOffset="0%">
                                        <tspan id="front-startinside2" class="fa" dominant-baseline="middle"></tspan>
                                        <tspan id="front-textinside2" dominant-baseline="middle"></tspan>
                                        <tspan id="front-endinside2" class="fa" dominant-baseline="middle"></tspan>
                                    </textPath>
                                    </text>
                                    <?php echo $mask_outside_band2; ?>
                                    <?php echo $mask2_band2 . $mask1_band2; ?>
                                    <?php echo $segcolor1_cover_band2 . $segcolor2_cover_band2; ?>               
                                    <text id="bandtext2" text-anchor="middle" fill="#9d1d20" style="font-family: Arial; font-size: 30px; fill: #999999; opacity: 0.6;">
                                    <textPath id="bandtextpath2" xlink:href="#MyPath2" startOffset="50%">
                                        <tspan id="front-start2" class="fa" dominant-baseline="middle">&#xf059;</tspan>
                                        <tspan id="front-text2" dominant-baseline="middle"></tspan>
                                        <tspan id="front-end2" class="fa" dominant-baseline="middle">&#xf059;</tspan>
                                    </textPath>
                                    </text>
                                    <text id="bandtextcont2" fill="#9d1d20" style="font-family: Arial; font-size: 30px; fill: #999999; opacity: 0.6;" display="none">
                                    <textPath id="bandtextpathcont2" xlink:href="#MyPathCont2" startOffset="0%">
                                        <tspan id="front-startcont2" class="fa" dominant-baseline="middle"></tspan>
                                        <tspan id="front-textcont2" dominant-baseline="middle"></tspan>
                                        <!--<tspan id="front-endcont2" class="fa" dominant-baseline="middle">&#xf096;</tspan>-->
                                        <tspan id="front-endcont2" class="fa" dominant-baseline="middle">&#xf059;</tspan>
                                    </textPath>
                                    </text>

                                    <text id="bandtextcontainer" fill="#9d1d20" style="font-family: Arial; font-size: 30px; fill: #999999; opacity: 0.6;">
                                    <textPath id="bandtextpathcontainer" xlink:href="#ContainerPath" startOffset="0%">
                                        <tspan id="front-startcontainer" class="fa" dominant-baseline="middle"></tspan>
                                        <tspan id="front-textcontainer" dominant-baseline="middle"></tspan>
                                        <tspan id="front-endcontainer" class="fa" dominant-baseline="middle"></tspan>
                                    </textPath>
                                    </text>            
                                    <text id="bandtextcontainer2" fill="#9d1d20" style="font-family: Arial; font-size: 30px; fill: #999999; opacity: 0.6;">
                                    <textPath id="bandtextpathcontainer2" xlink:href="#ContainerPath" startOffset="0%">
                                        <tspan id="front-startcontainer2" class="fa" dominant-baseline="middle"></tspan>
                                        <tspan id="front-textcontainer2" dominant-baseline="middle"></tspan>
                                        <tspan id="front-endcontainer2" class="fa" dominant-baseline="middle"></tspan>
                                    </textPath>
                                    </text>
                                    <rect x="0" y="15" width="30" height="120" filter="url(#blurSideShadow)" />
                                    <rect x="275" y="15" width="30" height="120" filter="url(#blurSideShadow)" />
                                    <image  id="img2_1" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/1.png" display="none"/>
                                    <image  id="img2_1_2" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/1_2.png" display="none"/>
                                    <image  id="img2_3_4" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/3_4.png" />
                                    <image  id="img2_1_4" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/1_4.png" display="none"/>
                                    <image  id="no_arc_img2_1" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/no_arc_1.png" display="none"/>
                                    <image  id="no_arc_img2_1_2" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/no_arc_1_2.png" display="none"/>
                                    <image  id="no_arc_img2_3_4" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/no_arc_3_4.png" />
                                    <image  id="no_arc_img2_1_4" height="100%" width="100%" xlink:href="<?php echo getwimg();?>/wp-content/themes/wristbandcreation/wristband/assets/images/new/no_arc_1_4.png" display="none"/>

                                    <use id="arc2" xlink:href="#InsideArc" stroke-dasharray="5, 5" stroke="black" display="none"/>
                                    <!--<use xlink:href="#MyPath2" fill="none" stroke="red"  />-->
                                    <!--<use xlink:href="#MyPathCont2" fill="none" stroke="blue"  />-->
                                    <!--<use xlink:href="#MyPathInside2" fill="none" stroke="green"  />-->
                                    <?php echo $glow2; ?>
                                    <!-- <text x="3" y="16" style="fill: white; stroke: White; stroke-width: 3">BACK VIEW</text>
                                    <text x="3" y="16" style="fill: black; stroke: Black; stroke-width: 1">BACK VIEW</text> -->
                                    <text text-anchor="middle" x="150" y="16" style="fill: white; stroke: White; stroke-width: 3">BACK VIEW</text>
                                    <text text-anchor="middle" x="150" y="16" style="fill: black; stroke: Black; stroke-width: 1">BACK VIEW</text>
                                    <rect width="100%" height="100%" style="stroke:white;stroke-width:2;fill-opacity:0;">
                                    </svg>       
                                </div>
                                <!--</div>-->
                            </div>
                            <div>
                                <div class="form-row">
                                    <label for="message_type" class="form-group-heading CssTitleBlack marginTB-5" style="float:left">Message on Wristbands</label class="form-group-heading CssTitleBlack" >

                                    <div class="marginTB-5" style="float: right;">
                                        <input type="radio" name="message_type" value="front_and_back" <?php echo isset($metaInfo['wristband_stat']) ? ($metaInfo['wristband_stat'] == 'front_and_back' ? 'checked' : '') : 'checked'; ?> />
                                        Front/Back
                                        <span class="fusion-popover tooltip-img" data-toggle="tooltip" data-placement="top"
                                              title="Front and Back Message" data-placement="top">?</span>

                                        &nbsp;
                                        <input type="radio" name="message_type" value="continues" <?php echo $metaInfo['wristband_stat'] == 'continues' ? 'checked' : ''; ?> />
                                        Wrap Around
                                        <span class="fusion-popover tooltip-img" data-toggle="tooltip" data-placement="top"
                                              title="Continuous Message" data-placement="top">?</span>

                                    </div>
                                </div>

                                  <?php if (isset($GLOBALS['wbc_settings']->tool_tip_text)):
                                      $tooltip = $GLOBALS['wbc_settings']->tool_tip_text;
                                      ?>
                                    <div id="ForFrontBackID">
                                        <div class="form-row form-row-wide hide-if-message_type-continues">
                                            <table class="marginTB-5" style="width: 100%;" border="0" cellspacing="0"><tr>
                                                    <td class="TdTitleCss">
                                                        <label for="front_message"  class="form-group-heading CssTitleBlack">Front Message
                                                            <span class="fusion-popover tooltip-img" data-toggle="tooltip" data-placement="top"
                                                                  title="<?php echo $tooltip->front; ?>" data-placement="top">?
                                                            </span>
                                                        </label>
                                                    </td><td>
                                                        <input type="text" id="front_message" name="front_message" class="input-text trigger-limit-char"
                                                             maxlength="40" data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" value="<?php echo $metaInfo['Front_msg']; ?>" >
                                                    </td>
                                                </tr></table>
                                        </div>

                                        <div class="form-row form-row-wide hide-if-message_type-continues">
                                            <table class="marginTB-5" style="width: 100%;" border="0" cellspacing="0"><tr>
                                                    <td class="TdTitleCss">
                                                        <label for="back_message"  class="form-group-heading CssTitleBlack">Back Message
                                                            <span class="fusion-popover tooltip-img" data-toggle="tooltip" data-placement="top"
                                                                  title="<?php echo $tooltip->back; ?>" data-placement="top">?
                                                            </span>
                                                        </label>
                                                    </td><td>
                                                        <input type="text" id="back_message" name="back_message"  class="input-text trigger-limit-char"
                                                            maxlength="40" data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" value="<?php echo $metaInfo['Back_msg']; ?>" />
                                                    </td>
                                                </tr></table>
                                        </div><!-- /.form-group -->
                                    </div>

                                    <div id="ForContiID">
                                        <div class="form-row form-row-wide hide-if-message_type-front_and_back">
                                            <table class="marginTB-5" style="width: 100%;" border="0" cellspacing="0"><tr>
                                                    <td class="TdTitleCss">
                                                        <label for="continues_message"  class="form-group-heading CssTitleBlack">Continuous Message
                                                            <span class="fusion-popover tooltip-img" data-toggle="tooltip" data-placement="top"
                                                                  title="<?php echo $tooltip->wrap_around; ?>" data-placement="top">?
                                                            </span>
                                                        </label>
                                                    </td><td>
                                                        <input type="text" id="continues_message" name="continues_message" class="input-text trigger-limit-char"
                                                              maxlength="80" data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" value="<?php echo $metaInfo['Wrap_msg']; ?>" />
                                                    </td>
                                                </tr></table>
                                        </div><!-- /.form-group -->
                                    </div>

                                    <div class="form-row form-row-wide">
                                        <table class="marginTB-5" style="width: 100%;" border="0" cellspacing="0"><tr>
                                                <td class="TdTitleCss">
                                                    <label for="inside_message"  class="form-group-heading CssTitleBlack">Inside Message
                                                        <span class="fusion-popover tooltip-img" data-toggle="tooltip" data-placement="top"
                                                              title="<?php echo $tooltip->inside; ?>" data-placement="top">?
                                                        </span>
                                                    </label>
                                                </td><td>
                                                    <input type="text" id="inside_message" name="inside_message" class="input-text trigger-limit-char"
                                                        maxlength="80" data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" value="<?php echo $metaInfo['Inside_msg']; ?>" />
                                                </td>
                                            </tr></table>
                                    </div><!-- /.form-group -->
                            <?php endif; ?>
                            </div>
                            <!-- 
                            <div id="hiddenDiv" style="display:none" >
                              <canvas id="hiddenCanvas"></canvas>
                              <a id="hiddenPng" />
                          </div> -->
                        </div>
                        <table style="width: 100%;" border="0" cellspacing="0">
                            <tr>
                                <td class="TdTitleCss">
                                    <label for="font" class="form-group-heading CssTitleBlack">Font</label>
                                </td>
                                <td>
                                    <select name="font" id="font" class="input-select enable-if-style-selected">
                                        <option value="-1">-- Select --</option>

                                    <?php if (isset($GLOBALS['wbc_settings']->fonts)):
                                        foreach ($GLOBALS['wbc_settings']->fonts as $font):
                                            ?>
                                            <?php
                                            $Selected = "";
                                            if ($metaInfo['FontStyle'] == esc_attr($font)) {
                                                $Selected = "selected";
                                            }
                                            ?>
                                            <option style="font-size:18px;font-family: '<?php echo esc_attr($font); ?>' !important;"
                                              value="<?php echo esc_attr($font); ?>" <?php echo $Selected; ?> ><?php echo esc_attr($font); ?></option>
                                        <?php endforeach;
                                    endif;
                                    ?>
                                    </select>
                                </td>
                            </tr>
                        </table>     

                        <p class="form-row form-row-wide">
                            <label for="additional_notes"  class="form-group-heading CssTitleBlack">Additional Notes</label>
                            <textarea class="input-text" name="additional_notes" id="additional_notes" cols="30" rows="5"><?php echo $metaInfo['AddNotes_msg']; ?></textarea>
                        </p>


                    </div><!-- /.fusion-column-wrapper -->
                </div><!--/.fusion-one-third-->
                <div class="fusion-one-fourth one_fourth fusion-layout-column fusion-column-last fusion-spacing-yes">
                    <div class="fusion-column-wrapper">
                      <!-- Clipart -->
                        <div id="add-clipart">
                            <label id="clipartTitle" class="form-group-heading CssTitleBlack col-md-6 col-xs-6" >Add Clipart</label>
                            <div class="fusion-clearfix"></div>
                            <div class="button-box hide-if-message_type-continues col-md-12 col-xs-12 marginB-10">
                                <span class="text-label">Front Start</span>
                                <div class="alignright">
                                    <a id="front_start_btn" data-view="front" data-position="front_start" href="#" data-title="Front Start" data-toggle="modal"
                                       data-target="#wristband-clipart-modal"
                                       class="toggle-modal-clipart">
                                        <span class="fusion-button-text-right">
                                            <i class="fa icon-preview hide-if-upload" id="FsID"></i>
                                            <img class="image-upload hide-if-icon" width="16" height="16"/>
                                            Select</span>
                                    </a>
                                    <a href="#" class="fileinput-button">
                                        <span><i class="fa fa-upload"></i> Upload</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input class="fileupload" type="file" name="files[]"
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
                                            <i class="fa icon-preview hide-if-upload" id="FeID"></i>
                                            <img class="image-upload hide-if-icon" width="16" height="16"/>
                                            Select</span>
                                    </a>
                                    <a href="#" class="fileinput-button">
                                        <span><i class="fa fa-upload"></i> Upload</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input class="fileupload" type="file" name="files[]"
                                               data-clipart-type="frontend">
                                    </a>
                                </div>
                            </div>
                            <div class="fusion-clearfix"></div>
                            <div class="button-box hide-if-message_type-continues">
                                <span class="text-label">Back Start</span>
                                <div class="alignright">
                                    <a id="back_start_btn" data-view="back" data-position="back_start" href="#" data-title="Back Start" data-toggle="modal"
                                       data-target="#wristband-clipart-modal"
                                       class="toggle-modal-clipart">
                                        <span class="fusion-button-text-right">
                                            <i class="fa icon-preview hide-if-upload" id="BsID"></i>
                                            <img class="image-upload hide-if-icon" width="16" height="16"/>
                                            Select</span>
                                    </a>
                                    <a href="#" class="fileinput-button">
                                        <span><i class="fa fa-upload"></i> Upload</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input class="fileupload" type="file" name="files[]"
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
                                            <i class="fa icon-preview hide-if-upload" id="BeID"></i>
                                            <img class="image-upload hide-if-icon" width="16" height="16"/>
                                            Select</span>
                                    </a>
                                    <a href="#" class="fileinput-button">
                                        <span><i class="fa fa-upload"></i> Upload</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input class="fileupload" type="file" name="files[]"
                                               data-clipart-type="backend">
                                    </a>
                                </div>
                            </div>

                            <div class="fusion-clearfix"></div>
                            <div class="button-box hide-if-message_type-front_and_back col-md-12 col-xs-12 marginB-10">
                                <span class="text-label">Wrap Around Start</span>
                                <div class="alignright">
                                    <a id="wrap_around_start" data-position="wrap_start" href="#" data-title="Wrap Around Start" data-toggle="modal"
                                       data-target="#wristband-clipart-modal"
                                       class="toggle-modal-clipart">
                                        <span class="fusion-button-text-right">
                                            <i class="fa icon-preview hide-if-upload" id="WsID"></i>
                                            <img class="image-upload hide-if-icon" width="16" height="16"/>
                                            Select</span>
                                    </a>
                                    <a href="#" class="fileinput-button">
                                        <span><i class="fa fa-upload"></i> Upload</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input class="fileupload" type="file" name="files[]"
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
                                            <i class="fa icon-preview hide-if-upload" id="WeID"></i>
                                            <img class="image-upload hide-if-icon" width="16" height="16"/>
                                            Select</span>
                                    </a>
                                    <a href="#" class="fileinput-button">
                                        <span><i class="fa fa-upload"></i> Upload</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input class="fileupload" type="file" name="files[]"
                                               data-clipart-type="backend">
                                    </a>
                                </div>
                            </div>

                        </div><!-- /#add-clipart -->
                        <!-- Additional options -->
                        <?php if (isset($GLOBALS['wbc_settings']->additional_options)): ?>
                            <div id="additional-option-section">
                                <label class="form-group-heading CssTitleBlack"  data-fontsize="19" data-lineheight="20">Additional Options</label>
                                 <?php $i = 1;
                                  foreach ($GLOBALS['wbc_settings']->additional_options as $index => $option):
                                    //removes digital proof
                                    if ($index != 'digital_proof'):
                                   ?>
                                    <div id="<?php echo 'id_' . $index; ?>" class="additional-option-item fusion-one-half one_half fusion-layout-column fusion-spacing-yes <?php echo $i % 2 == 0 ? 'fusion-column-last' : '' ?>">
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
                                                <span class="fusion-popover tooltip-img" data-toggle="tooltip" data-placement="top"
                                                      title="<?php echo esc_attr($option->tool_tip_text); ?>">?</span>
                                            </span>

                                        </div><!-- /.fusion-column-wrapper -->
                                    </div><!-- /.fusion-one-third -->
                                  <?php $i++;
                                  endif;  
                              endforeach; ?>
                            </div>
                            <?php endif; ?>
                        <!-- /. additional options -->
                        <!-- add digital proof -->

                        <!-- end add digital proof -->
                        <?php if (isset($GLOBALS['wbc_settings']->customization)): ?>
                            <div id="customization-section">
                                <label class="form-group-heading CssTitleBlack">Production and Shipping</label>
                                <div class="fusion-clearfix"></div>
                        <?php $flag = false;
                        foreach ($GLOBALS['wbc_settings']->customization->location as $cus_location): ?>
                                    <p class="form-row form-row-wide">
                                        <label>
                                    <?php
                                    $Stat = "";
                                    if (isset($customization_location)) {
                                        if ($customization_location == esc_attr($cus_location->name)) {
                                            $Stat = "checked";
                                        }
                                    }
                                    ?>
                                            <input type="radio" name="customization_location" data-title="<?php echo esc_attr($cus_location->name); ?>"
                                                   value="<?php echo sanitize_title_with_underscore($cus_location->name); ?>"
                                                   data-price="<?php echo esc_attr($cus_location->price); ?>"
                                <?php echo!$flag ? 'checked' : ''; ?> <?php echo $Stat; ?> title="<?php echo esc_attr($cus_location->tool_tip_text); ?>"/>
                                <?php echo esc_attr($cus_location->name); ?>

                                               <!--  <span class="fusion-popover tooltip-img" data-toggle="tooltip" data-placement="top"
                                               title="<?php echo esc_attr($cus_location->tool_tip_text); ?>">?</span> -->
                                        </label>

                                    </p>
                              <?php $flag = true;
                          endforeach; ?>

                          <?php foreach ($GLOBALS['wbc_settings']->customization->dates as $type => $date): ?>
                                    <p class="form-row form-row-wide">
                                        <label for="customization_date_<?php echo $type; ?>" class="form-group-heading CssTitleBlack"><?php echo ucwords($type); ?> Time</label>
                                        <select id="customization_date_<?php echo $type; ?>"
                                                name="customization_date_<?php echo $type; ?>"
                                                class="input-select customization-date-select" required>
                                            <option value="-1">-- Select <?php echo ucwords($type) ?> Time --</option>
                                            <!-- <option value="" selected disabled>-- Select <?php echo ucwords($type) ?> Time --</option> -->
                                        </select>
                                    </p>
                          <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <p class="form-row form-row-wide">
                            Guaranteed to be delivered on or before: <strong id="delivery_date"></strong>
                        </p>
                    </div><!--/.fusion-column-wrapper -->

                    <div>
                        <p class="fusion-row price price-with-decimal">
                            <span class="currency CurrencyAddup"><?php echo get_woocommerce_currency_symbol(); ?></span>
                            <span class="integer-part price-handler" id="price_handler">0.00</span>
                            <br />
                            Total Quantity:
                            <span id="qty_handler" class="qty-handler">0</span>
                        </p>

                            <?php if ($isEdit): ?>
                            <button id="wbc_edit_to_cart" href="#" class="fusion-button button-flat button-round button-large button-default alignright">
                                <span class="button-icon-divider-left"><i class="fa fa-shopping-cart"></i></span>
                                <span class="fusion-button-text-left">Update Cart</span>
                            </button>
                            <div class="link-buttons alignright">
                                <a id= "save_button" class="fusion-button button-flat button-round button-small button-default" href="#"><span class="fusion-button-text">Save Design</span></a>
                                <a class="fusion-button button-flat button-round button-small button-default button-red" href="/cart"><span class="fusion-button-text">Cancel</span></a>
                            </div>
                              <?php else: ?>
                            <!-- <button id="wbc_add_to_cart" href="#" class="fusion-button button-flat button-round button-large button-default alignright">
                                <span class="button-icon-divider-left"><i class="fa fa-shopping-cart"></i></span>
                                <span class="fusion-button-text-left">Add to Cart</span>
                            </button> -->
                            <button id="wbc_add_to_cart" href="#" class="fusion-button button-flat button-round button-large button-default alignright">
                                <span class="button-icon-divider-left"><i class="fa fa-shopping-cart"></i></span>
                                <span class="fusion-button-text-left">Add to Cart</span>
                            </button> 
                            <div class="link-buttons aligncenter">
                                <a id= "save_button" class="fusion-button button-flat button-round button-small button-default SaveBtnAddup" href="#"><span class="fusion-button-text">Save Design</span></a>
                            </div>
                            <?php endif; ?>




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
                </h3>
            </div>
            <div>
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

<div id="wristband-text-color-modal" class="fusion-modal modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content fusion-modal-content" style="background-color:#f6f6f6">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="modal-heading-1" data-dismiss="modal" aria-hidden="true"
                    data-fontsize="17" data-lineheight="36">
                    Select Text Color</h3>
            </div>
            <div id="wristband-text-color-modal-body">
                <ul>

                </ul>
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

<!-- infusionsoft save design -->
<form accept-charset="UTF-8" action="https://zt232.infusionsoft.com/app/form/process/50257f1da49a3883663775d73e9a6174" id="infusion-form" method="POST" style="display:none">
    <input name="inf_form_xid" type="hidden" value="50257f1da49a3883663775d73e9a6174" />
    <input name="inf_form_name" type="hidden" value="WC Save Design Lead" />
    <input name="infusionsoft_version" type="hidden" value="1.48.0.48" />
    <div class="infusion-field">
        <label for="inf_field_Email">Email *</label>
        <input class="infusion-field-input-container" id="inf_field_Email" name="inf_field_Email" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_Design1">Design</label>
        <textarea cols="24" id="inf_custom_Design1" name="inf_custom_Design1" rows="5">
        </textarea>
    </div>
    <div class="infusion-field">
        <label for="inf_custom_Style">Style</label>
        <input class="infusion-field-input-container" id="inf_custom_Style" name="inf_custom_Style" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_Size">Size</label>
        <input class="infusion-field-input-container" id="inf_custom_Size" name="inf_custom_Size" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_Colors0">Colors</label>
        <textarea cols="24" id="inf_custom_Colors0" name="inf_custom_Colors0" rows="5">
        </textarea></div>
    <div class="infusion-field">
        <label for="inf_custom_MessageType">Message Type</label>
        <input class="infusion-field-input-container" id="inf_custom_MessageType" name="inf_custom_MessageType" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_FontStyle">Font Style</label>
        <input class="infusion-field-input-container" id="inf_custom_FontStyle" name="inf_custom_FontStyle" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_AdditionalNotes0">Additional Notes</label>
        <textarea cols="24" id="inf_custom_AdditionalNotes0" name="inf_custom_AdditionalNotes0" rows="5">
        </textarea>
    </div>
    <div class="infusion-field">
        <label for="inf_custom_FrontMessage">Front Message</label>
        <input class="infusion-field-input-container" id="inf_custom_FrontMessage" name="inf_custom_FrontMessage" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_BackMessage">Back Message</label>
        <input class="infusion-field-input-container" id="inf_custom_BackMessage" name="inf_custom_BackMessage" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_ContinuousMessage">Continuous Message</label>
        <input class="infusion-field-input-container" id="inf_custom_ContinuousMessage" name="inf_custom_ContinuousMessage" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_InsideMessage">Inside Message</label>
        <input class="infusion-field-input-container" id="inf_custom_InsideMessage" name="inf_custom_InsideMessage" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_AdditionalOptions0">Additional Options</label>
        <textarea cols="24" id="inf_custom_AdditionalOptions0" name="inf_custom_AdditionalOptions0" rows="5">
        </textarea></div>
    <div class="infusion-field">
        <label for="inf_custom_FrontStart">Front Start</label>
        <input class="infusion-field-input-container" id="inf_custom_FrontStart" name="inf_custom_FrontStart" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_FrontEnd">Front End</label>
        <input class="infusion-field-input-container" id="inf_custom_FrontEnd" name="inf_custom_FrontEnd" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_BackStart">Back Start</label>
        <input class="infusion-field-input-container" id="inf_custom_BackStart" name="inf_custom_BackStart" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_BackEnd">Back End</label>
        <input class="infusion-field-input-container" id="inf_custom_BackEnd" name="inf_custom_BackEnd" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_WrapAroundStart">Wrap Around Start</label>
        <input class="infusion-field-input-container" id="inf_custom_WrapAroundStart" name="inf_custom_WrapAroundStart" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_WrapAroundEnd">Wrap Around End</label>
        <input class="infusion-field-input-container" id="inf_custom_WrapAroundEnd" name="inf_custom_WrapAroundEnd" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_CustomizationLocation">Customization Location</label>
        <input class="infusion-field-input-container" id="inf_custom_CustomizationLocation" name="inf_custom_CustomizationLocation" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_ProductionTime">Production Time</label>
        <input class="infusion-field-input-container" id="inf_custom_ProductionTime" name="inf_custom_ProductionTime" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_ShippingTime">Shipping Time</label>
        <input class="infusion-field-input-container" id="inf_custom_ShippingTime" name="inf_custom_ShippingTime" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_GuaranteedDelivery">Guaranteed Delivery</label>
        <input class="infusion-field-input-container" id="inf_custom_GuaranteedDelivery" name="inf_custom_GuaranteedDelivery" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_TotalQuantity">Total Quantity</label>
        <input class="infusion-field-input-container" id="inf_custom_TotalQuantity" name="inf_custom_TotalQuantity" type="text" />
    </div>
    <div class="infusion-field">
        <label for="inf_custom_Price0">Price</label>
        <input class="infusion-field-input-container" id="inf_custom_Price0" name="inf_custom_Price0" type="text" />
    </div>
    <div class="infusion-submit">
        <input type="submit" value="Submit" />
    </div>
</form>
<script type="text/javascript" src="https://zt232.infusionsoft.com/app/webTracking/getTrackingCode?trackingId=836b445a9eef92908d02a37a83de32bd"></script>
<script src="https://use.typekit.net/afo5vgd.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<?php
if ($metaInfo != false) {
    echo "<script type='text/javascript'> 
            (function($){
                $('#qty_adult, #qty_medium, #qty_youth').trigger('keyup');
            })(jQuery);
</script>";
}

get_footer();
//    echo "<script type='text/javascript'> (function($){alert($('.wbdiv').width());})(jQuery);</script>";