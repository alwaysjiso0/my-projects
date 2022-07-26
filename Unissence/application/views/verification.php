<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'Account/verify_user'); ?>
				<h2 class="text-center">Verify my account</h2>       
					<div class="form-group">
                        <label for="vcode">Enter the verification code sent to your email:</label>
						<input type="text" class="form-control" placeholder="Verification code" required="required" name="vcode">
					</div>
					<div class="form-group">
					<?php if(isset($v_error)) echo $v_error; ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-secondary btn-block">Verify</button>
					</div>   
			<?php echo form_close(); ?>
	</div>
</div>
