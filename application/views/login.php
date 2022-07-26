<div class="container">
      <div class="col-4 offset-4">
	  <?php echo form_open(base_url().'login/check_login'); ?>
				<h2 class="text-center">Login</h2>       
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Username" required="required" name="username">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" required="required" name="password">
					</div>
					<div class="form-group">
					<?php if(isset($error)) echo $error; ?>
					</div> 

					<p id="captImg"><?php if(isset($captchaImg)) echo $captchaImg; ?></p>
					<div class="form-group mt-2">
						<input type="text" class="form-control" placeholder="Enter the catcha code above" required="required" name="captcha">
					</div>

					<div class="form-group">
					<?php if(isset($captcha_error)) echo $captcha_error; ?>
					</div> 

					<div class="form-group">
						<button type="submit" class="btn btn-dark btn-block">Log in</button>
					</div>
					<div class="clearfix">
						<label class="float-left form-check-label"><input type="checkbox" name="remember"> Remember me</label>
						<a href="<?php echo base_url(); ?>ForgotPassword" class="float-right">Forgot Password?</a>
					</div>
					<div class="clearfix">
						<a href="<?php echo base_url(); ?>Register" class="float-right">Register</a>
					</div>     
			<?php echo form_close(); ?>

			

	</div>
</div>
