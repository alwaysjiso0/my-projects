<div id="forgot_pwd" class="container">
      <div class="col-4 offset-4 enter_email">
			<?php echo form_open(base_url().'ForgotPassword/send_email'); ?>
				<h3 class="text-center mb-5">Forgot Password</h3>       
				<div class="form-group">
                    <h5>1. Send a verification code to your email.</h5>
					<label for="email">Enter registered email address:</label>
					<input type="text" class="form-control" placeholder="Email" required="required" name="email">
				</div>
				<div class="form-group">
                    <?php if (isset($error)) echo $error; ?>
				</div>
				<div class="form-group">
                    <a href="<?php echo base_url(); ?>ForgotPassword/send_email" >
						<button type="submit" class="btn btn-dark btn-block">Send verification email</button>
                    </a>
				</div>  
			<?php echo form_close(); ?>
	</div>
    <div class="col-4 offset-4 mt-5 enter_code">
			<?php echo form_open(base_url().'ForgotPassword/verify_code'); ?>    
				<div class="form-group">
					<h5>2. Enter the verification code from the email.</h5>
                    <label for="vcode">Enter verification code:</label>
					<input type="text" class="form-control" placeholder="Verification code" required="required" name="vcode">
				</div>
				<div class="form-group">
				<?php if (isset($v_error)) echo $v_error; ?>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-dark btn-block <?php  ?>">Verify</button>
				</div>  
			<?php echo form_close(); ?>
	</div>
    <div class="col-4 offset-4 mt-5 enter_pwd">
        <?php echo form_open(base_url().'ForgotPassword/change_password'); ?>
			<div class="form-group">
				<h5>3. Set a new password.</h5>
			    <label for="new_password">New Password:</label>
				<input type="text" class="form-control mt-2" placeholder="Enter new password" name="new_password">
				<a href="<?php echo base_url(); ?>ForgotPassword/change_password" >
					<button type="submit" class="btn btn-dark btn-block mt-2 mb-5">Change</button>
				</a>
			</div>
        <?php echo form_close(); ?>
	</div>
</div>
