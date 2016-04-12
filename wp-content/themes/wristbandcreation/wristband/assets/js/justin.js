jQuery(document).ready(function ($) {

   var   row = 0;
 $('#wtotalprice').change(function(){
      var sumtotal = 0;
      var totalprice = 0;
      var row = $('.clearfix').length;
      for (var i = 0; i < row + 1; i++) {
         totalprice = parseFloat($('.num_'+i+' input.thetotal').val() == '' ? 0 : $('.num_'+i+' input.thetotal').val());
         if (isNaN(totalprice)){totalprice = 0;}
         sumtotal += totalprice;
         totalprice = 0;
      };
      $('#wtotalprice').text(sumtotal);
      $('#wtotalprice1').val(sumtotal);

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
            $('#maxrowval').val(row);
            for(x = 0; x < 14; x++)
            {
                if (value == x) {            
                  var i = $('#appendedid #divappend_'+value+'').size() + 1;
                  $('<div><div class="form-group clearfix num_'+row+'" id="divappend_'+value+'" >'+
                        '<label class="pricestyle"> '+arrlabel[value]+' </label>'+
                        '<input type="number" name="'+arrquantity[value]+i+'" id="'+arrquantity[value]+i+'" class="form-control priceinputstyle inputqty" placeholder="Quantity" value="">'+
                        '<input type="number" step="any" name="'+arrprice[value]+i+'" id="'+arrprice[value]+i+'" class="form-control priceinputstyle inputprice" placeholder="Unit Price" value="">'+
                        '<input type="number" name="'+arrtotal[value]+i+'" id="'+arrtotal[value]+i+'" value="" class="form-control priceinputstyle thetotal" placeholder="Total" readonly>'+
                     '<a href="#" id="removestyle">Remove</a></div></div>').appendTo($('#appendedid'));
               }
            }
         return false;
   })

    $('#save-price').click(function(){
      var tracknum = $('#trackingnum').val();
      var total = $('#wtotalprice1').val();
         $('.err-container1').empty();
         $('.err-container1').fadeIn();
         if(total =='' || total == 0){
          $('<p class="err-msg1">No Field added / Field added does not have Quantity or Price</p>').appendTo($('.err-container1'));
          return false;
        }
    })

    // $('#status-submit').click(function(){
    //   var status    = ["pending_production","pending_artwork_approval","in_production","in_reproduction","produced_pending_shipment","shipped"],
    //       prevstatus = status.indexOf($('#savedstatus').val()),
    //       newstatus = $('#newstatus').val();
    //   $('.err-container2').empty();
    //   $('.err-container2').fadeIn();

    //   if (newstatus <= prevstatus) {
    //       console.log('hello');
    //       $('<p class="err-msg2">Cannot Save Status</p>').appendTo($('.err-container2')); 
    //       return false;
    //   }

    // })

    $('#track-submit').click(function(){

      var trackval = $('#trackingnum').val();
      $('.err-container3').empty();
      $('.err-container3').fadeIn();
      if (trackval == '' || trackval == 0) {
              console.log('dragon empty');
              $('<p class="err-msg3">Track Number Empty</p>').appendTo($('.err-container3'));
        return false;
      }
    })

   $(document)

         .on('click','#removestyle',function() { 
               $(this).parent('div').remove();
               $('#wtotalprice').trigger('change');
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