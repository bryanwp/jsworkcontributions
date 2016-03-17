jQuery(document).ready(function ($) {

   $('.submit').click(function(){
   		
   		var fname 		 	  = $('#fname').val(),
   			lname 		 	  = $('#lname').val(),
   			company_name 	  = $('#company_name').val(),
   			phone 		 	  = $('#phone').val(),
   			card  		 	  = $('#card').val(),
   			country		 	  = $('#country').val(),
   			address			  = $('#address').val(),
   			email			  = $('#email').val(),
   			pass			  = $('#pass').val(),
   			cpass			  = $('#cpass').val(),
   			secret_question	  = $('#secret_question').val(),
   			sanswer			  = $('#sanswer').val();

   			//console.log( secret_question );

   			var noError = false;
   			var noPassError = false;
   			var noPassErrorChar = false;
   			var noErrorEmail = false;

   			if ( pass === cpass ) {
	   			noPassError = true;
	   		} else {
	   			console.log('password not match');
	   			noPassError = false;
	   		}

	   		if ( cpass.length < 5 ) {
	   			console.log( cpass.length );
	   			noPassErrorChar = false;
	   		} else {
	   			noPassErrorChar = true;
	   		}

	   		if ( ! isEmail( email ) ) { 
	   				noErrorEmail = false;
	   		} else {
	   				noErrorEmail = true;
	   		}

   			if ( !fname ) { noError = false; } 
   			else if ( !lname ) { noError = false; } 
   			else if ( !company_name ) { noError = false; } 
   			else if ( !phone ) { noError = false; } 
   			else if ( !country ) { noError = false; } 
   			else if ( !address ) { noError = false; } 
   			else if ( !email ) { noError = false; } 
   			else if ( !pass ) { noError = false; } 
   			else if ( !cpass ) { noError = false; } 
   			else if ( !secret_question ) { noError = false; } 
   			else if ( !sanswer ) { noError = false; } 
   			else { noError = true; }	   		

	   	   	if ( ! noError ) {
	   	   		$('.err-container').fadeIn();
	   	   		$('.err-msg').empty();
   				$('.err-msg').append( 'All fields are required' );
   				return false;	
   					
   			} else {

               // $.ajax({
               //    type:'GET',
               //    url:''
               // });

   				if ( ! noPassError ) {
   					$('.err-container').fadeIn();
		   	   		$('.err-msg').empty();
	   				$('.err-msg').append( 'Please enter the same password in the two password fields.' );
	   				return false;b
   				} else if ( ! noPassErrorChar ) {
   					$('.err-container').fadeIn();
		   	   		$('.err-msg').empty();
	   				$('.err-msg').append( 'Password must contain 5  characters or more.' );
	   				return false;
   				} else if ( ! noErrorEmail ) {
   					$('.err-container').fadeIn();
		   	   		$('.err-msg').empty();
	   				$('.err-msg').append( 'Email is invalid.' );
	   				return false;
   				} else {
   					return true;
   					console.log('no errors at all');
   				}
   			}
   		

   		function isEmail( $email ) {
		  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		  return regex.test( $email );
		}

   		
   });

   $('#email').change(function(){
      var email = $('#email').val();
      //console.log( email );
      $.get(sheldz_ajax.ajaxUrl + '?action=check-email&email=' + email, function(response) {
            if (response.data[0]) {
            $('.err-container').fadeIn();
            $('.err-msg').empty();
            $('.err-msg').append( 'Email already exists!' );
         } else {
            $('.err-container').fadeOut();
            console.log('Email is valid');
         }
      });
   });

});