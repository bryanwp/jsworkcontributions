jQuery(document).ready(function ($) {

   var   row = 0;
 $('#wtotalprice').change(function(){
      var sumtotal = 0;
      var totalprice = 0;
      for (var i = 1; i < row + 1; i++) {
         totalprice = parseInt($('.num_'+i+' input.thetotal').val());
         sumtotal += totalprice;
         totalprice = 0;
      };
      $('#wtotalprice').text(sumtotal);
      $('#wtotalprice1').val(sumtotal);

   })

 $('#status-submit').click(function(){

      console.log('here');

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
    })

   $('#addfield').click(function(){
            var value = $('#selectedfield option:selected').val();
            arrlabel = ["Mold - Set Up","Printing - Set Up","Laser Engraving","Color Fill","Embossed-Color","Imprinting Fee","Swirl","Segmented","Glow","Dual Layer","Inside Embossed","Individual Packaging","Keychains","Shipping (DHL)"]
            arrquantity = ["moldquantity_", "printingquantity_", "laserquantity_","colorfillquantity_","embossedquantity_","imprintingquantity_","swirlquantity_","segmentedquantity_","glowquantity_","duallayerquantity_","insideembossedquantity_","individualpkgquantity_","keychainsquantity_","shipdhlquantity_"];
            arrprice = ["moldprice_", "printingprice_", "laserprice_","colorfillprice_","embossedprice_","imprintingprice_","swirlprice_","segmentedprice_","glowprice_","duallayerprice_","insideembossedprice_","individualpkgprice_","keychainsprice_","shipdhlprice_"];
            arrtotal = ["mold_","printing_","laser_","colorfill_","embossedp_","imprintingp_","swirlp_","segmentedp_","glowp_","duallayerp_","insideembossed_","individualpkg_","keychains_","shipdhl_"];
            
            row++;
            for(x = 0; x < 14; x++)
            {
                if (value == x) {            
                  var i = $('#appendedid #divappend_'+value+'').size() + 1;
                  $('<div><div class="form-group clearfix num_'+row+'" id="divappend_'+value+'" >'+
                        '<label class="pricestyle"> '+arrlabel[value]+' </label>'+
                        '<input type="number" name="'+arrquantity[value]+i+'" id="'+arrquantity[value]+i+'" class="form-control priceinputstyle inputqty" placeholder="Quantity" value="">'+
                        '<input type="number" name="'+arrprice[value]+i+'" id="'+arrprice[value]+i+'" class="form-control priceinputstyle inputprice" placeholder="Unit Price" value="">'+
                        '<input type="number" name="'+arrtotal[value]+i+'" id="'+arrtotal[value]+i+'" value="" class="form-control priceinputstyle thetotal" placeholder="Total" readonly>'+
                        '<input type="hidden" name="maxrowval" value="'+row+'">'+
                     '<a href="#" id="removestyle">Remove</a></div>').appendTo($('#appendedid'));
               }
            }
         return false;
   })

   $(document)

         .on('click','#removestyle',function() { 
               $(this).parent('div').remove();
               return false;
              })
         .on('change','.inputqty',function(){
            var qtyval  = $(this).val(),
               priceval = $(this).next().val() == '' ? 0 : $(this).next().val(),
               valtotal = $(this).next().next();
               total    = qtyval * priceval;

               valtotal.val(total);
               $('#wtotalprice').trigger('change');

         })

         .on('change','.inputprice',function(){
            var priceval  = $(this).val(),
               qtyval = $(this).prev().val() == '' ? 0 : $(this).prev().val(),
               valtotal = $(this).next();
               total    = qtyval * priceval;

               valtotal.val(total);
               $('#wtotalprice').trigger('change');

         })


});