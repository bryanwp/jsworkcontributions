<?php 

 //Template Name: New Order Now

function getwimg(){
  if($_SERVER[HTTP_HOST] === 'localhost' || $_SERVER[HTTP_HOST] === '192.168.2.165'){
    return '..';
  }
}
get_header();

$isEdit = false;
$isStatus = '';
$metaInfo = false;

if (isset($_REQUEST['id'])) {
    // $isEdit = isset($_REQUEST['Status']) && $_REQUEST['Status'] == 'edit' ? true : false;

  if(isset($_REQUEST['Status']))
  {
    $isStatus = $_REQUEST['Status'];
  }
    //echo $isStatus;
  $metaInfo = getMetaToAutoSet($_REQUEST['id'], $_REQUEST['Status']);
  if ($metaInfo != false) {
    echo '<input id="EditModeID" name="' . $metaInfo['all'] . '" value="' . $_REQUEST['id'] . '" type="hidden">';
  } else {
    echo '<script>window.location = "' . get_site_url() . '/order-now/";</script>';
  }
}

?>
<?php require_once(get_stylesheet_directory() . '/wristband/includes/check_mask.php'); ?>
<!-- start of the body -->
<div class="header-title text-center">
    <h1>Order Now</h1>
</div>
<div class="section-order-page">
    <div class="container p-0">
        <div class="col-md-3 p-0">
            <div class="col-holder">
                <div class="col-title">
                    <h5>Wristband style & Width</h5>
                </div>
                <div class="col-content-holder col-select">
                    <div class="form-group">
                        <div class="select-button">
                            <i class="select-down"></i>
                            <!-- <select class="form-control" name="select-choice"> -->
                                <!-- <option>Debossed-Filled</option>
                                <option>Debossed-Filled</option>
                                <option>Debossed-Filled</option>
                                <option>Debossed-Filled</option> -->
                                <!-- </select> -->
                            <select name="style" id="style" class="input-select form-control">
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
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="select-button">
                            <i class="select-down"></i>
                            <!-- <select class="form-control" name="select-choice">
                                <option>1/2 inch</option>
                                <option>1/2 inch</option>
                                <option>1/2 inch</option>
                                <option>1/2 inch</option>
                            </select> -->
                            <select name="width" id="width" class="input-select enable-if-style-selected form-control" disabled> inch</select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-holder">
                <div class="col-title">
                    <h5>Color & Quantity</h5>
                </div>
                <div class="col-content-holder col-select">
                    <!-- <div class="form-group">
                        <div class="radio">
                            <label><input type="radio" name="optradio" checked="checked">Solid <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="Solid"></i></label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">Segmented <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="Segmented"></i></label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">Swirl <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="Swirl"></i></label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">Glow <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="Glow"></i></label>
                        </div>
                    </div>
                    <div class="col-color">
                        <h4>Wristband Color</h4>
                        <div class="col-color-select">
                            <ul>
                                <li>
                                    <div class="color-box color-transparent"></div>
                                </li>
                                <li>
                                    <div class="color-box color-black"></div>
                                </li>
                                <li>
                                    <div class="color-box color-white"></div>
                                </li>
                                <li>
                                    <div class="color-box color-red"></div>
                                </li>
                                <li>
                                    <div class="color-box color-orange"></div>
                                </li>
                                <li>
                                    <div class="color-box color-yellow"></div>
                                </li>
                                <li>
                                    <div class="color-box color-lawngreen"></div>
                                </li>
                                <li>
                                    <div class="color-box color-darkgreen"></div>
                                </li>
                                <li>
                                    <div class="color-box color-seagreen"></div>
                                </li>
                                <li class="color-check">
                                    <div class="color-box color-lightblue"></div>
                                </li>
                                <li>
                                    <div class="color-box color-blue"></div>
                                </li>
                                <li>
                                    <div class="color-box color-mediumblue"></div>
                                </li>
                                <li>
                                    <div class="color-box color-violet"></div>
                                </li>
                                <li>
                                    <div class="color-box color-purple"></div>
                                </li>
                                <li>
                                    <div class="color-box color-peach"></div>
                                </li>
                                <li>
                                    <div class="color-box color-brown"></div>
                                </li>
                                <li>
                                    <div class="color-box color-pink"></div>
                                </li>
                                <li>
                                    <div class="color-box color-darkgray"></div>
                                </li>
                                <li>
                                    <div class="color-box color-maroon"></div>
                                </li>
                                <li>
                                    <div class="color-box color-darkyellow"></div>
                                </li>
                                <li>
                                    <div class="color-box color-gray"></div>
                                </li>
                                <li>
                                    <div class="color-box color-lightpurple"></div>
                                </li>
                                <li>
                                    <div class="color-box color-darkblue"></div>
                                </li>
                                <li>
                                    <div class="color-box color-green"></div>
                                </li>
                                <li>
                                    <div class="color-box color-lightpink"></div>
                                </li>
                            </ul>
                        </div>
                    </div> -->

                    <div id="wristband-color-tab" class="fusion-tabs classic horizontal-tabs">
                <div class="nav">
                  <!-- <ul id="wbcolor" class="nav-tabs nav-justified"> -->
                  <ul id="wbcolor">
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
                    <h4>Wristband Color</h4>
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

                         <div id="colorStyleBox" title= "<?php echo $style; ?>" class="color-box <?php echo $Selected; ?>">
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
                           background: linear-gradient(90deg,<?php echo implode(',', $colorx); ?>); /* Standard syntax */
                           height: 100%;
                           ">
                            
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

                    <div class="col-color">
                        <!-- <h4>Text Color</h4> -->
                        <!-- <div class="col-color-select">
                            <ul>
                                <li>
                                    <div class="color-box color-transparent"></div>
                                </li>
                                <li>
                                    <div class="color-box color-black"></div>
                                </li>
                                <li class="color-check">
                                    <div class="color-box color-white"></div>
                                </li>
                                <li>
                                    <div class="color-box color-red"></div>
                                </li>
                                <li>
                                    <div class="color-box color-orange"></div>
                                </li>
                                <li>
                                    <div class="color-box color-yellow"></div>
                                </li>
                                <li>
                                    <div class="color-box color-lawngreen"></div>
                                </li>
                                <li>
                                    <div class="color-box color-darkgreen"></div>
                                </li>
                                <li>
                                    <div class="color-box color-seagreen"></div>
                                </li>
                                <li>
                                    <div class="color-box color-lightblue"></div>
                                </li>
                                <li>
                                    <div class="color-box color-blue"></div>
                                </li>
                                <li>
                                    <div class="color-box color-mediumblue"></div>
                                </li>
                                <li>
                                    <div class="color-box color-violet"></div>
                                </li>
                                <li>
                                    <div class="color-box color-purple"></div>
                                </li>
                                <li>
                                    <div class="color-box color-peach"></div>
                                </li>
                                <li>
                                    <div class="color-box color-brown"></div>
                                </li>
                                <li>
                                    <div class="color-box color-pink"></div>
                                </li>
                                <li>
                                    <div class="color-box color-darkgray"></div>
                                </li>
                                <li>
                                    <div class="color-box color-maroon"></div>
                                </li>
                                <li>
                                    <div class="color-box color-darkyellow"></div>
                                </li>
                                <li>
                                    <div class="color-box color-gray"></div>
                                </li>
                                <li>
                                    <div class="color-box color-lightpurple"></div>
                                </li>
                                <li>
                                    <div class="color-box color-darkblue"></div>
                                </li>
                                <li>
                                    <div class="color-box color-green"></div>
                                </li>
                                <li>
                                    <div class="color-box color-lightpink"></div>
                                </li>
                            </ul>
                        </div> -->
                        <div class="form-group">
                            <label class="" id="selectTextColorLabel" style="display:none"><h4>Text Color</h4></label>
                            <div id="wristband-text-color">
                              <ul>

                              </ul>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-color">
                        <h4>Quantity</h4>
                        <div class="col-quantity">
                            <div class="form-group form-quantity">
                                <input type="text" class="form-control">
                                <label for="">Adult</label>
                            </div>
                            <div class="form-group form-quantity">
                                <input type="text" class="form-control">
                                <label for="">Medium</label>
                            </div>
                            <div class="form-group form-quantity">
                                <input type="text" class="form-control">
                                <label for="">Youth</label>
                            </div>
                            <div class="form-quantity">
                                <input type="submit" class="form-control btn-blue" value="Add">
                                <label for=""></label>
                            </div>
                        </div>
                    </div> -->
                    <div id="notify-customization"></div>
                      <div id="quantity_group_field" class="col-color">
                        <h4>Quantity</h4>
                        <!-- <label class="form-group-heading CssTitleBlack" >Input Quantity <span>(Side View Guide)</span></label> -->
                        <p class="form-row quantity-row fusion-one-fourth one_third fusion-layout-column fusion-spacing-yes">
                          <!-- <label class="form-group-heading CssTitleBlack" for="qty_adult">Adult</label> -->
                          <input type="number" name="qty_adult" id="qty_adult" min="0" class="input-text form-control" style="padding: 0; text-align: center;">
                          <label class="" for="qty_adult">Adult</label>
                        </p>
                        <p class="form-row quantity-row fusion-one-fourth one_third fusion-layout-column fusion-spacing-yes">
                          <!-- <label class="form-group-heading CssTitleBlack" for="qty_medium">Medium</label> -->
                          <input type="number" name="qty_medium" id="qty_medium"  min="0" class="input-text form-control" style="padding: 0; text-align: center;">
                          <label class="" for="qty_medium">Medium</label>
                        </p>
                        <p class="form-row form-row-last fusion-one-fourth one_third fusion-layout-column fusion-column-last fusion-spacing-yes">
                          <!-- <label class="form-group-heading CssTitleBlack" for="qty_youth">Youth</label> -->
                          <input type="number" name="qty_youth" id="qty_youth"  min="0" class="input-text " style="padding: 0; text-align: center;">
                          <label class="" for="qty_youth">Youth</label>
                        </p>
                        <p id="quantity_group_field_button" class="form-row quantity-row fusion-one-fourth one_third fusion-layout-column fusion-spacing-yes">
                          <br>
                          <!-- <a class="TempAddCss" target="_blank" href="#" id="add_color_to_selections"><span class="fusion-button-text">Add</span></a> -->
                          <button id="add_color_to_selections" href="#" class="changetolink">
                            <span class="fusion-button-text-left btn-blue">Add</span>
                          </button> 
                        </p>                    
                        <div class="clear"></div>

                      </div>
                </div>
            </div>

            <!-- Additional options -->
          <?php if (isset($GLOBALS['wbc_settings']->additional_options)): ?>
            <div id="additional-option-section" class="col-holder">
              <!-- <label class="form-group-heading CssTitleBlack"  data-fontsize="19" data-lineheight="20">Additional Options</label> -->
              <div class="col-title">
                    <h5>Additional Options</h5>
                </div>
            <div class="col-content-holder col-select">
              <?php $i = 1;
              foreach ($GLOBALS['wbc_settings']->additional_options as $index => $option):
                                    //removes digital proof
                if ($index != 'digital_proof'):
                 ?>
               <div id="<?php echo 'id_' . $index; ?>" class="additional-option-item">
                <!-- <div class="fusion-column-wrapper"> -->
                  <div class="addon">
                    <span class="addon-price-handler">
                      <div class="checkbox">
                        <!-- <input type="checkbox" name="additional_option[]" data-key="<?php // echo $index; ?>" value="<?php // echo $option->name; ?>" /> -->
                        <label><input type="checkbox" value=""><?php echo $option->name; ?> <i class="fa fa-question-circle" aria-hidden="true" id="options<?php echo $i; ?>"></i></label>
                        <div class="options-hover">
                                <div class="options-img">
                                    <img src="<?php echo $option->image->url; ?>" alt="<?php echo $option->name; ?>" >
                                </div>
                                <div class="options-desc">
                                    <p><?php echo esc_attr($option->tool_tip_text); ?></p>
                                </div>
                            </div>
                      </div>
                    </span>
                  </div>
                <!-- </div> -->
                <!-- /.fusion-column-wrapper -->
              </div><!-- /.fusion-one-third -->
              <?php $i++;
              endif;  
              endforeach; ?>
            </div>
            </div>
          <?php endif; ?>
          <!-- /. additional options -->
           <!--  <div class="col-holder">
                <div class="col-title">
                    <h5>Additional Options</h5>
                </div>
                <div class="col-content-holder col-select">
                    <div class="form-group">
                        <div class="checkbox">
                            <label><input type="checkbox" value="">Individual Packaging <i class="fa fa-question-circle" aria-hidden="true" id="options1"></i></label>
                            <div class="options-hover">
                                <div class="options-img">
                                    <img src="images/keychains.png" alt="">
                                </div>
                                <div class="options-desc">
                                    <p>Make your wristbands more useful for everyday use by converting them into keychains</p>
                                </div>
                            </div>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" value="">Eco Friendly <i class="fa fa-question-circle" aria-hidden="true" id="options2"></i></label>
                            <div class="options-hover">
                                <div class="options-img">
                                    <img src="images/keychains.png" alt="">
                                </div>
                                <div class="options-desc">
                                    <p>Make your wristbands more useful for everyday use by converting them into keychains</p>
                                </div>
                            </div>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" value="">3mm Thick <i class="fa fa-question-circle" aria-hidden="true" id="options3"></i></label>
                            <div class="options-hover">
                                <div class="options-img">
                                    <img src="images/keychains.png" alt="">
                                </div>
                                <div class="options-desc">
                                    <p>Make your wristbands more useful for everyday use by converting them into keychains</p>
                                </div>
                            </div>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" value="">Convert to Keychains <i class="fa fa-question-circle" aria-hidden="true" id="options4"></i></label>
                            <div class="options-hover">
                                <div class="options-img">
                                    <img src="images/keychains.png" alt="">
                                </div>
                                <div class="options-desc">
                                    <p>Make your wristbands more useful for everyday use by converting them into keychains</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="col-md-6">
            <div class="wristband-view col-wristband text-center">
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
            <div id="ifrontcontend" style="display:none"></div>
            <div class="wbdiv">
                <div class="wristband-holder">
                    <div class="view-title">
                        <h3>Front View</h3>
                    </div>
                    <div class="view-img">
                        <!-- <img src="images/wristband.png" alt=""> -->
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
                        			<tspan id="front-start1" class="fa" dominant-baseline="middle"></tspan>
                        			<tspan id="front-text1" dominant-baseline="middle"></tspan>
                        			<tspan id="front-end1" class="fa" dominant-baseline="middle"></tspan>
                        		</textPath>
                        	</text>
                        	<text id="bandtextcont1" fill="#9d1d20" style="font-family: Arial; font-size: 30px; fill: #999999; opacity: 0.6;"  display="none">
                        		<textPath id="bandtextpathcont1" xlink:href="#MyPathCont1" startOffset="0%">
                        			<tspan id="front-startcont1" class="fa" dominant-baseline="middle"></tspan>
                        			<tspan id="front-textcont1" dominant-baseline="middle"></tspan>
                        			<tspan id="front-endcont1" class="fa" dominant-baseline="middle"></tspan>
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
                            <!-- <text id="frontw" text-anchor="middle" x="150" y="12" style="fill: white; stroke: White; stroke-width: 0.5">FRONT VIEW</text>
                            <text id="frontb" text-anchor="middle" x="150" y="12" style="fill: black; stroke: Black; stroke-width: 0.5">FRONT VIEW</text> -->
                            <rect width="100%" height="100%" style="stroke:white;stroke-width:2;fill-opacity:0;">

                        </svg>
                    </div>
                </div>
                <div class="wristband-holder">
                    <div class="view-title">
                        <h3>Back View</h3>
                    </div>
                    <div class="view-img">
                        <!-- <img src="images/wristband.png" alt=""> -->
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
                        			<tspan id="front-start2" class="fa" dominant-baseline="middle"></tspan>
                        			<tspan id="front-text2" dominant-baseline="middle"></tspan>
                        			<tspan id="front-end2" class="fa" dominant-baseline="middle"></tspan>
                        		</textPath>
                        	</text>
                        	<text id="bandtextcont2" fill="#9d1d20" style="font-family: Arial; font-size: 30px; fill: #999999; opacity: 0.6;" display="none">
                        		<textPath id="bandtextpathcont2" xlink:href="#MyPathCont2" startOffset="0%">
                        			<tspan id="front-startcont2" class="fa" dominant-baseline="middle"></tspan>
                        			<tspan id="front-textcont2" dominant-baseline="middle"></tspan>
                        			<!--<tspan id="front-endcont2" class="fa" dominant-baseline="middle">&#xf096;</tspan>-->
                        			<tspan id="front-endcont2" class="fa" dominant-baseline="middle"></tspan>
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
                                <!-- <text id="backw" text-anchor="middle" x="150" y="12" style="fill: white; stroke: White; stroke-width: 0.5">BACK VIEW</text>
                                <text id="backb" text-anchor="middle" x="150" y="12" style="fill: black; stroke: Black; stroke-width: 0.5">BACK VIEW</text> -->
                                <rect width="100%" height="100%" style="stroke:white;stroke-width:2;fill-opacity:0;">
                        </svg>
                    </div>
                </div>
                </div>
                <div class="note-content">
                    <p>Note: We will email you a more accurate layout of your digital proof for your
                        approval after you place your order.</p>
                </div>
            </div>
            <div class="col-wristband">
                <div class="col-holder">
                    <div class="col-title-gray">
                        <h5>Message on Wristband</h5>
                    </div>
                </div>
                <div class="col-message-select">
                    <div class="form-group">
                            <div class="radio">
                                    <label><input type="radio" name="message_type" value="front_and_back" <?php echo isset($metaInfo['wristband_stat']) ? ($metaInfo['wristband_stat'] == 'front_and_back' ? 'checked' : '') : 'checked'; ?> />Front & Back Message<i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="Front & Back"></i></label>
                            </div>
                            <div class="radio">
                                    <label><input type="radio" name="message_type" value="continues" <?php echo $metaInfo['wristband_stat'] == 'continues' ? 'checked' : ''; ?> />Continuous Message<i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="Continuous Message"></i></label>
                            </div>
                    </div>
                </div>
                <div class="col-content-holder col-wrist-details">
                    <form class="form-horizontal">                        
                    <?php if (isset($GLOBALS['wbc_settings']->tool_tip_text)):
                        $tooltip = $GLOBALS['wbc_settings']->tool_tip_text;
                    ?>
                    <div id="ForFrontBackID">
                        <div class="form-row form-row-wide hide-if-message_type-continues">
                            <div class="form-group">
                                <label for="front_message" class="col-sm-4 control-label p-0">Front Message <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="<?php echo $tooltip->front; ?>"></i></label>
                                <div class="col-sm-8 p-0">
                                <input type="text" id="front_message" name="front_message" class="input-text trigger-limit-char form-control" data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" value="<?php echo $metaInfo['Front_msg']; ?>" >
                                <div id="fwarning-msg"></div>
                                </div>
                            </div>  
                        </div>
                        <div class="form-row form-row-wide hide-if-message_type-continues">
                            <div class="form-group">
                                <label for="back_message" class="col-sm-4 control-label p-0">Back Message <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="<?php echo $tooltip->back; ?>"></i></label>
                                <div class="col-sm-8 p-0">
                                    <!-- <input type="text" class="form-control"> -->
                                    <input type="text" id="back_message" name="back_message"  class="input-text trigger-limit-char form-control" data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" value="<?php echo $metaInfo['Back_msg']; ?>" />
                                      <div id="bwarning-msg"></div>
                                </div>
                            </div>
                        </div><!-- /.form-group -->
                    </div>
                    <div id="ForContiID">
                        <div class="form-row form-row-wide hide-if-message_type-front_and_back">                            
                            <div class="form-group">
                                    <label for="continues_message" class="col-sm-4 control-label p-0">Continuous Message<i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="<?php echo $tooltip->wrap_around; ?>"></i></label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" id="continues_message" name="continues_message" class="input-text trigger-limit-char form-control" data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" value="<?php echo $metaInfo['Wrap_msg']; ?>" />
                                        <div id="cwarning-msg"></div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row form-row-wide">
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label p-0">Inside Message <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="<?php echo $tooltip->inside; ?>"></i></label>
                            <div class="col-sm-8 p-0">
                                <input type="text" id="inside_message" name="inside_message" class="input-text trigger-limit-char form-control" data-limit="<?php echo WBC_MESSAGE_CHAR_LIMIT; ?>" value="<?php echo $metaInfo['Inside_msg']; ?>" />
                                <div id="iwarning-msg"></div>
                            </div>
                        </div>                   
                    </div>
                    <?php endif; ?>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label p-0">Font</label>
                            <div class="col-sm-8 p-0">
                                <div class="select-button">
                                    <div class="dropdown form-control">

                                    <?php if (isset($metaInfo['FontStyle'])) {
                                        echo '<input value="'.$metaInfo['FontStyle'].'" id="selectFont" READONLY type="text" name="selectFont" class="caretfont input-select" style="font-family:'.$metaInfo['FontStyle'].'" >';
                                     }else{ ?>
                                    <input value="Select Font" id="selectFont" type="text" name="selectFont" READONLY class="caretfont input-select" style="font-family: Arial" >
                                    <?php } ?>

                                    <span class="dd-pointer dd-pointer-down"></span></input>
                                    <div id="fontID" class="dropdown-menu font-dropdown fadeFont">
                                      <ul class="font-class">
                                       <?php if (isset($GLOBALS['wbc_settings']->fonts)):
                                       usort($GLOBALS['wbc_settings']->fonts, 'strnatcasecmp');
                                       foreach ($GLOBALS['wbc_settings']->fonts as $font):
                                        $newlabel = change_font_to_label(esc_attr($font));
                                      ?>
                                      <li>
                                        <div class="inner-content">
                                          <label class="fontliststyle" style="font-family: '<?php echo esc_attr($font); ?>' !important;">Ag</label><br>
                                          <label class="font-label"><?php echo ($newlabel)? $newlabel:esc_attr($font); ?></label>
                                          <input class="fontvalue" type="hidden" value="<?php echo esc_attr($font); ?>">
                                        </div>
                                      </li>
                                    <?php endforeach;
                                    endif;
                                    ?>
                                  </ul>
                                </div>
                              </div>
                              </div>
                            </div>
                        </div>
                        <div class="form-group clipart-btn">
                            <label for="" class="col-sm-4 control-label p-0">Clipart</label>
                            <!-- <div class="col-sm-8 p-0">
                                <div class="form-group form-quantity form-clipart">
                                    <button type="button" class="btn-clipart" data-toggle="modal" data-target="#myModal">+ADD</button>
                                    <label for="">Front Start</label>
                                </div>
                                <div class="form-group form-quantity form-clipart">
                                    <button type="button" class="btn-clipart" data-toggle="modal" data-target="#myModal">+ADD</button>
                                    <label for="">Front End</label>
                                </div>
                                <div class="form-group form-quantity form-clipart">
                                    <button type="button" class="btn-clipart" data-toggle="modal" data-target="#myModal">+ADD</button>
                                    <label for="">Back Start</label>
                                </div>
                                <div class="form-group form-quantity form-clipart">
                                    <button type="button" class="btn-clipart" data-toggle="modal" data-target="#myModal">+ADD</button>
                                    <label for="">Back End</label>
                                </div>
                            </div> -->

                            <!-- Clipart -->
                        <div id="add-clipart">
                          <!-- <label id="clipartTitle" class="form-group-heading CssTitleBlack col-md-6 col-xs-6" >Add Clipart</label> -->
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

                        <!-- modal for clipart -->
                        <div id="wristband-clipart-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button class="close" type="button" data-dismiss="modal" aria-hidden="true" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h3 class="modal-title" id="modal-heading-1" data-dismiss="modal" aria-hidden="true"
                                  data-fontsize="17" data-lineheight="36">
                                  </h3>
                                </div>
                                <div class="select-add">
                                    <h4>Select a clipart below or <input type="file" value="Upload Your Own" class="upload-file"></h4>
                                </div>
                              <div class="modal-body">
                                <div class="clipart-holder">
                                    <?php if (count($GLOBALS['wbc_settings']->logo->list) != 0): ?>
                                      <ul class="clipart-list">

                                        <li class="active">
                                          <label for="">
                                            <div class="icon-preview clipart-img">
                                              <i class="fusion-li-icon fa fa-times color-red"></i>
                                            </div>
                                          </label>
                                        </li>
                                        <?php foreach ($GLOBALS['wbc_settings']->logo->list as $name => $icon):
                                        ?>
                                        <li data-icon-code="<?php echo esc_attr($icon->glyp_code); ?>" data-icon="<?php echo esc_attr($icon->glyphicon); ?>" data-icon-name="<?php echo esc_attr($icon->name); ?>">
                                          <label for="">
                                            <div class="icon-preview clipart-img">
                                              <i class="fusion-li-icon fa <?php echo esc_attr($icon->glyphicon); ?>"></i>
                                            </div>
                                            <div class="clearpart-info text-center">
                                              <?php echo esc_attr($icon->name); ?>
                                            </div>
                                          </label>
                                        </li>
                                      <?php endforeach; ?>
                                    </ul>
                                    <?php endif; ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- end modal for clipart -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-0">
            <div class="col-holder">
                <div class="col-title">
                    <h5>Summary <i class="fa fa-pencil-square-o" aria-hidden="true"></i></h5>
                </div>
                <div class="col-content-holder col-select col-summary">
                    <!-- <table class="table table-summary">
                        <tbody>
                            <tr class="summary-head">
                                <td>Color</td>
                                <td>Adult</td>
                                <td>Medium</td>
                                <td>Youth</td>
                                <td>Text</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="color-view color-pink"></div>
                                </td>
                                <td>
                                    <div class="summary-content">
                                        100 <span>+26</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="summary-content">
                                        61 <span>+41</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="summary-content">
                                        150 <span>+35</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="color-view color-orange"></div>
                                </td>
                                <td>
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="color-view color-violet"></div>
                                </td>
                                <td>
                                    <div class="summary-content">
                                        0
                                    </div>
                                </td>
                                <td>
                                    <div class="summary-content">
                                        11 <span>+2</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="summary-content">
                                        100 <span>+23</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="color-view color-yellow"></div>
                                </td>
                                <td>
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table> -->
                    <div id="quantity-notice"></div>
                        <!-- Color Quantity table -->
                        <div class="col-content-holder col-select col-summary">
                          <span id="freeCounter" class="CssTitleBlue"></span>
                          <div class="form-group table-responsive">
                            <table id="selected_color_table" class="table table-summary" border="0">
                              <thead>
                                <tr>
                                  <td >Color</th>
                                  <td class="TempCss1">Adult</td>
                                  <td class="TempCss1">Medium</td>
                                  <td class="TempCss1">Youth</td>
                                  <td class = "text_to_alter">Text</td>
                                  <th colspan="2" style="text-align:right;"><a class="CssEditSave CssTitleBlue font-size-11" id="EditSaveID" style="cursor: pointer;"><i class="fa fa-pencil"></i></a><br><a style="cursor: pointer;" class="CssEditSave CssTitleRed font-size-11"  id="CancelID"></a></th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                            </table>
                          </div>
                        </div>

                    <div class="table-desc text-center">
                        <p>Get 100 free wristbands for all orders
                            with 100 wristbands & above.</p>
                    </div>
                </div>
            </div>
            <div class="col-holder">
                <div class="col-title">
                     <h5>Production & Shipping</h5>
                </div>
                <div class="col-content-holder col-select">
                        <!-- customized date and shipping -->
                        <?php if (isset($GLOBALS['wbc_settings']->customization)): ?>
                          <div id="customization-section">
                            <!-- <label class="form-group-heading CssTitleBlack">Production and Shipping</label> -->
                            <!-- <div class="fusion-clearfix"></div> -->
                            <div class="form-group form-shipping">
                            <?php $flag = false;
                            foreach ($GLOBALS['wbc_settings']->customization->location as $cus_location): ?>
                            <div class="radio">
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
                                <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="<?php echo esc_attr($cus_location->tool_tip_text); ?>"></i>
                                <!-- <span class="fusion-popover tooltip-img" data-toggle="tooltip" data-placement="top"
                                title="<?php //echo esc_attr($cus_location->tool_tip_text); ?>">?</span> -->
                              </label>

                            </p>
                            </div>
                            <?php $flag = true;
                            endforeach; ?>
                            </div> 
                            <?php foreach ($GLOBALS['wbc_settings']->customization->dates as $type => $date): ?>
                              <div class="col-color">
                                  <p class="form-row form-row-wide">
                                    <label for="customization_date_<?php echo $type; ?>" class="form-group-heading CssTitleBlack"><h4><?php echo ucwords($type); ?> Time</h4></label>
                                    <div class="col-color-select">
                                        <div class="form-group">
                                            <div class="select-button">
                                                <select id="customization_date_<?php echo $type; ?>"
                                                  name="customization_date_<?php echo $type; ?>"
                                                  class="input-select customization-date-select form-control" required>
                                                  <option value="-1">-- Select <?php echo ucwords($type) ?> Time --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                  </p>
                              </div>
                            <?php endforeach; ?>
                          </div>
                        <?php endif; ?>
                        <p class="form-row form-row-wide">
                          <span id="guaranteed_note"></span>
                          <span id="delivery_date"></span>
                          <span id="datetotal" style="display:none"></span>
                        </p>

                    </div>        <!-- end of customized date and shipping -->
                </div>
            <!-- <div class="col-holder">
                <div class="col-title">
                    <h5>Production & Shipping</h5>
                </div>
                <div class="col-content-holder col-select">
                    <div class="form-group form-shipping">
                        <div class="radio">
                            <label><input type="radio" name="optradio2" checked="checked">Customized in China <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="Printed and decorated in China"></i></label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio2">Customized in USA <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="Printed and decorated in United States of America"></i></label>
                        </div>
                    </div>
                    <div class="col-color">
                        <h4>Production Time</h4>
                        <div class="col-color-select">
                            <div class="form-group">
                                <div class="select-button">
                                    <i class="select-down"></i>
                                    <select class="form-control" name="select-choice">
                                        <option>-Select time-</option>
                                        <option>8:00 am</option>
                                        <option>8:00 am</option>
                                        <option>8:00 am</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-color">
                        <h4>Shipping Time</h4>
                        <div class="col-color-select">
                            <div class="form-group">
                                <div class="select-button">
                                    <i class="select-down"></i>
                                    <select class="form-control" name="select-choice">
                                        <option>-Select time-</option>
                                        <option>8:00 am</option>
                                        <option>8:00 am</option>
                                        <option>8:00 am</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-holder">
                <!-- <div class="col-title">
                    <h5>Additional Notes</h5>
                </div>
                <div class="col-content-holder col-select">
                    <div class="form-group">
                        <div class="form-group">
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>
                    </div>
                </div> -->
                <div class="col-title">
                          <label for="additional_notes"  class="form-group-heading CssTitleBlack"><h5>Additional Notes</h5></label>
                        </div>
  

                          <div class="col-content-holder col-select">
                            <div class="form-group">
                                          <p class="form-row form-row-wide">
                                <div class="form-group">
                                    <textarea class="input-text form-control" name="additional_notes" id="additional_notes" cols="30" rows="5"><?php echo $metaInfo['AddNotes_msg']; ?></textarea>
                                </div>
                                </p>
                            </div>
                          </div>  
                <div class="col-content-holder col-total">
                    <!-- <div class="total-details">
                        <div class="col-total-content">
                            <h1>$123.45</h1>
                            <p>Total Quantity: 422 <span>+100 free wristbands</span></p>
                            <div class="btn-add-to-cart">
                                <a href="" class="btn-cart">
                                    <img src="images/btn-cart.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div> -->
                    <div class="total-details">
                        <div class="col-total-content">
                        <p class="fusion-row price price-with-decimal">
                          <span class="currency CurrencyAddup"><h1><?php echo get_woocommerce_currency_symbol(); ?><span class="integer-part price-handler" id="price_handler">0.00</span></h1></span>
                          <p>
                            Total Quantity:
                            <span id="qty_handler">0</span>
                          </p>
                        </p>
                        <!-- <div class="btn-add-to-cart">
                                    <a href="" class="btn-cart">
                                        <img src="images/btn-cart.png" alt="">
                                    </a>
                                </div> -->
                        </div>
                    </div>
                    <div class="btn-view-holder">
                        <div class="btn-action-holder">
                            <!-- <a href="" class="btn-action btn-design">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>Save Design
                            </a>
                            <a href="" class="btn-action btn-clear">
                                <i class="fa fa-undo" aria-hidden="true"></i>Clear
                            </a> -->

                            <?php if ($isStatus == 'edit'){ ?>
                                <button id="wbc_edit_to_cart" href="#" class="fusion-button button-flat button-round button-large button-default alignright">
                                  <span class="button-icon-divider-left"><i class="fa fa-shopping-cart"></i></span>
                                  <span class="fusion-button-text-left">Update Cart</span>
                                </button>
                                <div class="link-buttons alignright">
                                  <a id= "save_button" class="fusion-button button-flat button-round button-small button-default" href="#"><span class="fusion-button-text">Save Design</span></a>
                                  <a class="fusion-button button-flat button-round button-small button-default button-red" href="/cart"><span class="fusion-button-text">Cancel</span></a>
                                </div>
                                <?php } else if( $isStatus == 'copy') { ?>
                            <!-- <button id="wbc_add_to_cart" href="#" class="fusion-button button-flat button-round button-large button-default alignright">
                                <span class="button-icon-divider-left"><i class="fa fa-shopping-cart"></i></span>
                                <span class="fusion-button-text-left">Add to Cart</span>
                              </button> -->
                              <button id="wbc_add_to_cart" href="#" class="fusion-button button-flat button-round button-large button-default alignright">
                                <span class="button-icon-divider-left"><i class="fa fa-shopping-cart"></i></span>
                                <span class="fusion-button-text-left">Add to Cart</span>
                              </button> 
                              <div class="link-buttons alignright">
                                <a id= "save_button" class="fusion-button button-flat button-round button-small button-default" href="#"><span class="fusion-button-text">Save Design</span></a>
                                <a class="fusion-button button-flat button-round button-small button-default button-red" href="/cart"><span class="fusion-button-text">Go back to Cart</span></a>
                              </div>
                              <?php } else { ?>
                                <div class="btn-add-to-cart">
                              <button id="wbc_add_to_cart" href="#" class="btn-cart" style="
                              background: url(<?php echo get_stylesheet_directory_uri();?>/btn-cart.png); width: 106%; height: 60px; background-repeat: no-repeat; border: none;"></button>
                              </div> 
                              <div class="link-buttons aligncenter">
                                <a id= "save_button" class="btn-action btn-design" href="#"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save Design</a>
                                <a href="" class="btn-action btn-clear">
                                <i class="fa fa-undo" aria-hidden="true"></i>Clear
                                </a>
                              </div>
                              <?php } ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-price-chart">
    <div class="container p-0">
        <!-- <table class="table table-price-chart">
            <tbody>
                <tr>
                    <td>Quantity</td>
                    <td>1</td>
                    <td>5</td>
                    <td>10</td>
                    <td>20</td>
                    <td>50</td>
                    <td>100</td>
                    <td>200</td>
                    <td>300</td>
                    <td>500</td>
                    <td>1,000</td>
                    <td>2,000</td>
                    <td>3,000</td>
                    <td>5,000</td>
                    <td>10,000</td>
                    <td>20,000</td>
                    <td>50,000</td>
                    <td>100,000</td>
                </tr>
                <tr>
                    <td>Price ($)</td>
                    <td>3.45</td>
                    <td>1.91</td>
                    <td>1.91</td>
                    <td>1.91</td>
                    <td>0.73</td>
                    <td>0.53</td>
                    <td>0.31</td>
                    <td>0.27</td>
                    <td>0.24</td>
                    <td>0.17</td>
                    <td>0.17</td>
                    <td>0.17</td>
                    <td>0.16</td>
                    <td>0.15</td>
                    <td>0.15</td>
                    <td>0.15</td>
                    <td>0.12</td>
                </tr>
            </tbody>
        </table> -->
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
    </div>
</div>
<!-- end of the body -->


<script id="modal_message_template" type="x-tmpl-mustache">
                <div id="modal_message" class="fusion-modal modal fade {{status}}"  tabindex="-1" role="dialog">
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



<?php
 if ($metaInfo != false) { echo "<script type='text/javascript'>
 	(function($){ 
 		$('#qty_adult, #qty_medium, #qty_youth').trigger('keyup'); 
 	})(jQuery);</script>";}
 	
get_footer();