<script>
    function showEditPwd(e) {
        e.preventDefault();
		var block_to_hide = document.querySelector('#account .change_phone');
        block_to_hide.classList.remove("show");
		var block_to_show = document.querySelector('#account .change_pwd');
        block_to_show.classList.add("show");
    }
	function showEditPhone(e) {
        e.preventDefault();
		var block_to_hide = document.querySelector('#account .change_pwd');
        block_to_hide.classList.remove("show");
		var block_to_show = document.querySelector('#account .change_phone');
        block_to_show.classList.add("show");
    }
</script>

<div id="account" class="container">
      <div class="col-12">
			<?php echo form_open(base_url().'Account/send_email'); ?>
			<div class="a_intro">My Account</div>
			<div class="alist">

				<div class="col-md-12">
					<h5>My Username: </h5>
					<div class="form-group">
						<?php
							if (isset($user)) echo $user['username'];
						?>
					</div>
					<h5>My Password: </h5>
					<div class="form-group">
						<?php
							if (isset($user)) echo $user['password'];
						?>
						<button onClick="showEditPwd(event)">Edit</button>
					</div>
					<h5>My Email: </h5>
					<div class="form-group">
						<?php
							if (isset($user)) echo $user['email'];
						?>
					</div>
					<h5>My Phone Number: </h5>
					<div class="form-group">
						<?php
							if (isset($user)) echo $user['phone'];
						?>
						<button onClick="showEditPhone(event)">Edit</button>
					</div>	
					<h5>My Verification Status: </h5>
					<div class="form-group">
						<?php
							if (isset($user)) echo $user['verified'];
						?>
						<a href="<?php echo base_url(); ?>Account/send_email" >
							<button>Verify my email</button>
						</a>
					</div>
				</div>
				<?php echo form_close(); ?>

				<?php echo form_open(base_url().'Account/change_password'); ?>
				
				<div class="col-md-12 change_pwd">
					<div class="form-group">
						<label for="new_password">New Password</label>
						<input type="text" class="form-control mt-2" placeholder="Enter new password" name="new_password">
						<a href="<?php echo base_url(); ?>Account/change_password" >
							<button type="submit" class="btn btn-secondary btn-block mt-2">Change</button>
						</a>
					</div>
				</div>

				<?php echo form_close(); ?>

			<?php echo form_open(base_url().'Account/change_phone'); ?>
				<div class="col-md-12 change_phone">
					<div class="form-group">
						<label for="new_phone">New Phone Number</label>
						<input type="text" class="form-control" placeholder="Enter new phone number" name="new_phone">
						<a href="<?php echo base_url(); ?>Account/change_phone" >
							<button type="submit" class="btn btn-secondary btn-block mt-2">Change</button>
						</a>
					</div>
				</div>
			<?php echo form_close(); ?>

			<?php echo form_open(base_url().'Account/delete_user'); ?>
				<div class="form-group mt-5">
                    <a href="<?php echo base_url(); ?>Account/delete_user" >
					    <button type="submit" class="btn btn-secondary" onclick="return confirm('Are you sure you want to delete your account?');">Delete User</button>
                    </a>
				</div>   
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
