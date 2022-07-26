<script>
$(document).ready(function(){
    $('.refreshCaptcha').on('click', function(){
        $.get('<?php echo base_url().'login/refresh'; ?>', function(data){
            $('#captImg').html(data);
        });
    });
});
</script>

<div class="container">
    <div class="col-4 offset-4">
        <?php echo form_open(base_url().'login/load_captcha'); ?>
			<h4>Submit Captcha Code</h4>
			<p id="captImg"><?php echo $captchaImg; ?></p>
			<p>Can't read the image? click <a href="javascript:void(0);" class="refreshCaptcha">here</a> to refresh.</p>
			<form method="post">
				Enter the code : 
				<input type="text" name="captcha" value=""/>
				<input type="submit" name="submit" value="SUBMIT"/>
			</form>
		<?php echo form_close(); ?>
    </div>
</div>