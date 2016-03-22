jQuery(document).ready(function ($) {

   $('#moldquantity , #moldprice').change(function(){

      var quantity = parseInt(($('#moldquantity').val() == '') ? 0 : $('#moldquantity').val()),
            price = parseInt(($('#moldprice').val() == '') ? 0 : $('#moldprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);
            $('#mold').val(total);
            $('#wtotalprice').trigger('change');
   })

   $('#printingquantity , #printingprice').change(function(){

      var quantity = parseInt(($('#printingquantity').val() == '') ? 0 : $('#printingquantity').val()),
            price = parseInt(($('#printingprice').val() == '') ? 0 : $('#printingprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);
            $('#printing').val(total);
            $('#wtotalprice').trigger('change');
   })

   $('#laserquantity , #laserprice').change(function(){

      var quantity = parseInt(($('#laserquantity').val() == '') ? 0 : $('#laserquantity').val()),
            price = parseInt(($('#laserprice').val() == '') ? 0 : $('#laserprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);
            $('#laser').val(total);
            $('#wtotalprice').trigger('change');
   })

   $('#colorfillquantity , #colorfillprice').change(function(){

      var quantity = parseInt(($('#colorfillquantity').val() == '') ? 0 : $('#colorfillquantity').val()),
            price = parseInt(($('#colorfillprice').val() == '') ? 0 : $('#colorfillprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);
            $('#colorfill').val(total);
            $('#wtotalprice').trigger('change');
   })

   $('#embossedquantity , #embossedprice').change(function(){

      var quantity = parseInt(($('#embossedquantity').val() == '') ? 0 : $('#embossedquantity').val()),
            price = parseInt(($('#embossedprice').val() == '') ? 0 : $('#embossedprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);
            $('#embossedp').val(total);
            $('#wtotalprice').trigger('change');
   })

   $('#imprintingquantity , #imprintingprice').change(function(){

      var quantity = parseInt(($('#imprintingquantity').val() == '') ? 0 : $('#imprintingquantity').val()),
            price = parseInt(($('#imprintingprice').val() == '') ? 0 : $('#imprintingprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);
            $('#imprintingp').val(total);
            $('#wtotalprice').trigger('change');
   })

   $('#swirlquantity , #swirlprice').change(function(){

      var quantity = parseInt(($('#swirlquantity').val() == '') ? 0 : $('#swirlquantity').val()),
            price = parseInt(($('#swirlprice').val() == '') ? 0 : $('#swirlprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);
            $('#swirlp').val(total);
            $('#wtotalprice').trigger('change');
   })

   $('#segmentedquantity , #segmentedprice').change(function(){

      var quantity = parseInt(($('#segmentedquantity').val() == '') ? 0 : $('#segmentedquantity').val()),
            price = parseInt(($('#segmentedprice').val() == '') ? 0 : $('#segmentedprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);
            $('#segmentedp').val(total);
            $('#wtotalprice').trigger('change');
   })

   $('#glowquantity , #glowprice').change(function(){

      var quantity = parseInt(($('#glowquantity').val() == '') ? 0 : $('#glowquantity').val()),
            price = parseInt(($('#glowprice').val() == '') ? 0 : $('#glowprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);
            $('#glowp').val(total);
            $('#wtotalprice').trigger('change');
   })

   $('#duallayerquantity , #duallayerprice').change(function(){

      var quantity = parseInt(($('#duallayerquantity').val() == '') ? 0 : $('#duallayerquantity').val()),
            price = parseInt(($('#duallayerprice').val() == '') ? 0 : $('#duallayerprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);
            $('#duallayerp').val(total);
            $('#wtotalprice').trigger('change');
   })

   $('#insideembossedquantity , #insideembossedprice').change(function(){

      var quantity = parseInt(($('#insideembossedquantity').val() == '') ? 0 : $('#insideembossedquantity').val()),
            price = parseInt(($('#insideembossedprice').val() == '') ? 0 : $('#insideembossedprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);
            $('#insideembossed').val(total);
            $('#wtotalprice').trigger('change');
   })

   $('#individualpkgquantity , #individualpkgprice').change(function(){

      var quantity = parseInt(($('#individualpkgquantity').val() == '') ? 0 : $('#individualpkgquantity').val()),
            price = parseInt(($('#individualpkgprice').val() == '') ? 0 : $('#individualpkgprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);
            $('#individualpkg').val(total);
            $('#wtotalprice').trigger('change');
   })

   $('#keychainsquantity , #keychainsprice').change(function(){

      var quantity = parseInt(($('#keychainsquantity').val() == '') ? 0 : $('#keychainsquantity').val()),
            price = parseInt(($('#keychainsprice').val() == '') ? 0 : $('#keychainsprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);7
            $('#keychains').val(total);
            $('#wtotalprice').trigger('change');
   })

   $('#shipdhlquantity , #shipdhlprice').change(function(){

      var quantity = parseInt(($('#shipdhlquantity').val() == '') ? 0 : $('#shipdhlquantity').val()),
            price = parseInt(($('#shipdhlprice').val() == '') ? 0 : $('#shipdhlprice').val()),
            total = quantity * price;
            //console.log(quantity +' '+ price);
            $('#shipdhl').val(total);
            $('#wtotalprice').trigger('change');
   })


// $('#shipdhl , #keychains , #individualpkg , #insideembossed , #duallayerp , #glowp , #segmentedp , #swirlp , #imprintingp , #embossedp , #colorfill , #laser , #printing, #mold').change(function(){
         $('#wtotalprice').change(function(){

      var ship = $('#shipdhl').val() == '' ? 0 : $('#shipdhl').val(),
            keychains      = $('#keychains').val() == '' ? 0 : $('#keychains').val(),
            individualpkg  = $('#individualpkg').val() == '' ? 0 : $('#individualpkg').val(),
            insideembossed = $('#insideembossed').val() == '' ? 0 : $('#insideembossed').val(),
            duallayerp     = $('#duallayerp').val() == '' ? 0 : $('#duallayerp').val(),
            glowp          = $('#glowp').val() == '' ? 0 : $('#glowp').val(),
            segmentedp     = $('#segmentedp').val() == '' ? 0 : $('#segmentedp').val(),
            swirlp         = $('#swirlp').val() == '' ? 0 : $('#swirlp').val(),
            imprintingp    = $('#imprintingp').val() == '' ? 0 : $('#imprintingp').val(),
            embossedp      = $('#embossedp').val() == '' ? 0 : $('#embossedp').val(),
            colorfill      = $('#colorfill').val() == '' ? 0 : $('#colorfill').val(),
            laser          = $('#laser').val() == '' ? 0 : $('#laser').val(),
            printing       = $('#printing').val() == '' ? 0 : $('#printing').val(),
            mold           = $('#mold').val() == '' ? 0 : $('#mold').val(),
            total          = parseInt(ship) + parseInt(keychains) + parseInt(individualpkg) + parseInt(insideembossed) + parseInt(duallayerp) + parseInt(glowp) + parseInt(segmentedp) + parseInt(swirlp) + parseInt(imprintingp) + parseInt(embossedp) + parseInt(colorfill) + parseInt(laser) + parseInt(printing) + parseInt(mold);

            // console.log(total);

            $('#wtotalprice').text(total);
            $('#wtotalprice1').val(total);
   })

  function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#imageprev').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#fileToUpload").change(function(){
        readURL(this);
    });

});