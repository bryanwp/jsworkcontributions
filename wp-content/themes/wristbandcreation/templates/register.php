<?php
  
//Template Name: Register

include ('custom-header.php'); 
$countries_obj = new WC_Countries();
    $countries = $countries_obj->__get('countries');
// echo "<pre>";
//     var_dump($countries_obj);
//     var_dump($countries);
//     die();

?>
<div class="container white">
   <div class="row reg-form">
    <div class="col-md-12">
    
      <div class="panel panel-login">
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-12">
              <form id="login-form" action="#" method="post" role="form" style="display: block;">
            	<div class="form-group row">
            	<h2 class="form-title">Sign Up</h2>
            	<hr class="divider" />
            	<div class="err-container">
                	<p class="err-msg"></p>
             	</div>
            	</div>
              	<div class="form-group col-md-6">
                	<input type="text" name="fname" id="fname" tabindex="1" class="form-control" placeholder="First Name" value="">
             	</div>
             	<div class="form-group col-md-6">
                	<input type="text" name="lname" id="lname" tabindex="1" class="form-control" placeholder="Last Name" value="">
             	</div>
             	<div class="form-group col-md-6">
                	<input type="text" name="company_name" id="company_name" tabindex="1" class="form-control" placeholder="Company Name">
              	</div>
              	<div class="form-group col-md-6">
                	<input type="text" name="phone" id="phone" tabindex="1" class="form-control" placeholder="Phone No." value="">
             	</div>
              	<div class="form-group">
                	<input type="text" name="card" id="card" tabindex="1" class="form-control" placeholder="Credit Card No." value="">
             	</div>
             	<div class="form-group">
                	<!-- <input type="text" name="country" id="country" tabindex="1" class="form-control" placeholder="Country" value=""> -->
                 	<select class="country_select" name="country" id="country">
                        <?php foreach ($countries as $key => $value): ?>
                            <option value="<?php echo $key?>"><?php echo $value?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
             	<div class="form-group">
                	<input type="text" name="address" id="address" tabindex="1" class="form-control" placeholder="Address" value="">
             	</div>
             	<div class="form-group">
                	<input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" value="">
             	</div>
             	<div class="form-group col-md-6">
                	<input type="password" name="pass" id="pass" tabindex="1" class="form-control" placeholder="Password" value="">
             	</div>
             	<div class="form-group col-md-6">
                	<input type="password" name="cpass" id="cpass" tabindex="1" class="form-control" placeholder="Confirm Password" value="">
             	</div>
             	<div class="form-group">
                	<select class="form-control select" name="secret_question" id="secret_question">
                		<option value="" default> --Select Security Question--</option>
						<option value="In which city were you born?">In which city were you born?</option>
						<option value="What is the name of your favorite cousin?">What is the name of your favorite cousin?</option>
						<option value="What is the name of the street where you grew up?">What is the name of the street where you grew up?</option>
						<option value="Who was your childhood hero?">Who was your childhood hero?</option>
						<option value="What is the name of your favorite pet?">What is the name of your favorite pet?</option>
						<option value="What was the name of your primary school?">What was the name of your primary school?</option>
                	</select>
             	</div>
             	<div class="form-group">
                	<input type="text" name="sanswer" id="sanswer" tabindex="1" class="form-control" placeholder="Security Answer" value="">
             	</div>
               <div class="form-group">
                 <!-- <div><div style="width: 304px; height: 78px;"><iframe src="https://www.google.com/recaptcha/api2/anchor?k=6LeA3A8TAAAAAH_P6KbEt2YAklZK_WeDo2EWcqkZ&amp;co=aHR0cDovL2t1bGF5ZnVsd3AubG9jYWw6ODA.&amp;hl=en&amp;v=r20160425122911&amp;size=normal&amp;cb=hmcg54exuix6" title="recaptcha widget" width="304" height="78" role="presentation" frameborder="0" scrolling="no" name="undefined"></iframe></div><textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid #c1c1c1; margin: 10px 25px; padding: 0px; resize: none;  display: none; "></textarea></div> -->
                <div class="g-recaptcha" data-sitekey="6Lef9SATAAAAAGqT0Oz08FcmG-dkubPypBaY5H7J"></div>
                </div>

             	<div class="form-group">
             	    <input type="hidden" name="role" value="user">
             		<input type="submit" name="add_user" value="Submit" class="submit">
             	</div>

              </form>
       
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


<?php include ('custom-footer.php'); ?>