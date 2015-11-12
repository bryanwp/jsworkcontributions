<?php
get_header();
echo '<pre>';
print_r($GLOBALS['wbc_settings'] );
echo '</pre>';
?>
<section id="price_chart">
    <div class="panel-heading">
        <h3>Price Chart</h3>
    </div>
    <div class="panel-body">
        <!-- price chart -->
    </div>
</section>
<section id="styles">
    <div class="section-heading">
        <h2>Step 1 - Choose your Style</h2>
    </div>
    <div class="container">
        <div class="row">
        <?php
            if (isset($GLOBALS['wbc_settings']['products'])) {
                foreach ($GLOBALS['wbc_settings']['products'] as $post_id => $post) {

                    ?>

                    <div class="col-xs-3">
                        <div class="product">
                            <div class="product-inner">
                                <div class="product-image">
                                    <?php wbc_post_image($post['product_ID']); ?>
                                </div>
                            </div>
                            <div class="product-inner product-inner-bottom">
                                <div class="product-name">
                                    <div class="radio">
                                        <input type="radio" name="style" value="<?php echo $post['product_ID']; ?>"/>
                                        <?php echo $post['product_title']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
                }
            }
        ?>
        </div>
    </div>
</section>
<section id="sizes">
    <div class="section-heading">
        <h2>Step 2 - Choose your size</h2>
    </div>
    <div class="container">
        <div class="row" id="sizesContainer">

        </div>
    </div>
</section>


    <script id="wristband_price_chart_template" type="x-tmpl-mustache">
        <div class="table-responsive">
            <table id="price_chart_table" class="pull-right">
                <tbody>
                    {{price_chart}}
                </tbody>
            </table>
        </div>
    </script>

    <script id="wristband_size_template" type="x-tmpl-mustache">
        <div class="col-xs-3">
            <div class="product">
                <div class="product-inner">
                    <div class="product-image">
                        <img src="{{image}}" width="150" />
                    </div>
                </div>
                <div class="product-inner product-inner-bottom">
                    <div class="product-name">
                        <div class="radio">
                            <input type="radio" name="size" value="{{size}}"
                            {{#checked}} checked="true" {{/checked}}/>
                            {{size}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </script>
<?php


get_footer();