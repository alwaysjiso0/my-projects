<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'Register/check_reg_valid'); ?>
				<h2 class="text-center">Register</h2>  

					<div class="form-group">
						<input type="text" class="form-control" placeholder="Username" required="required" name="reg_username">
					</div>
                    <div class="form-group">
					<?php if (isset($reg_username_error)) echo $reg_username_error; ?>
					</div>

					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" required="required" name="reg_password">
					</div>
					<div class="form-group">
					<?php if (isset($reg_pw_short_error)) echo $reg_pw_short_error; ?>
					</div>

                    <div class="form-group">
						<input type="email" class="form-control" placeholder="Email" required="required" name="reg_email">
					</div>
					<div class="form-group">
					<?php if (isset($reg_email_error)) echo $reg_email_error; ?>
					</div>

					<div class="form-group">
						<input type="text" class="form-control" placeholder="Phone no." name="reg_phone">
					</div>

					<div class="form-group">
                        <a href="<?php echo base_url(); ?>Register/check_reg_valid" >
						    <button type="submit" class="btn btn-dark btn-block">Register</button>
                        </a>
					</div>   

			<?php echo form_close(); ?>
	</div>
</div>
