(function($) {

$(document).ready( function() {
	var file_frame; // variable for the wp.media file_frame
	var file_frame2 = file_frame; // re-declare the frame to prevent conflict

// attach a click event (or whatever you want) to some element on your page
	$( '.media-button' ).on( 'click', function( event ) {
		event.preventDefault();
 
		// if the file_frame has already been created, just reuse it
		if ( file_frame ) {
			file_frame.open();
			return;
		}

		file_frame = wp.media.frames.file_frame = wp.media({
			title: $( this ).data( 'uploader_title' ),
			button: {
				text: $( this ).data( 'uploader_button_text' ),
			},
			library: {
         	   type: 'image'
            },
			multiple: false // set this to true for multiple file selection
		});

		file_frame.on( 'select', function() {
		

			attachment = file_frame.state().get('selection').first().toJSON();
			// console.log(attachment);
			var el = '',
				div = $('.file form');

					el +='<div class="img-holder">';
						el +='<span class="remove-file">x</span>';
						el +='<img class="img-artwork" src="'+attachment.url+'" alt="'+attachment.title+'">';
						// el +='<p>'+attachment.filename+'</p>';
						el +='<input type="hidden" class="attachment_id" name=" " value="'+attachment.url+'">';
					el +='</div>';

					//el +='<input type="hidden" id="post-featured" name="post_featured" value="">';

					// $('.artwork').empty().html(''); //remove old uploaded file from other tab	
					div.append(el); //render the current uploaded file	
					$('.no-file').remove();
					$('.file').fadeIn();
					artworkCounter();
		});

		file_frame.open();
	});	

	// $('.remove-file').live( "click", function(){
        
 //   	});

  	function artworkCounter() {
	    var count    =  $('#art-work-count'),
	    	counter  =  1,
	        artworks =  $('.img-artwork').map(function(){return true;}).get(),
			names 	 =  $('.attachment_id').map(function(){
							$(this).attr( 'name', 'img'+counter );
							counter++;
							return true;
						}).get();
					
					console.log(artworks.length);
					count.val(artworks.length);
	}


    $(document).on('click', '.remove-file', function(){
      	$(this).parent().remove();
        artworkCounter();
   	});

});

})(jQuery);