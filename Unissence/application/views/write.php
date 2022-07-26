<div id="body_right_write" class="col-lg-10">
    <div class="col-10 offset-1">
			<?php if(isset($current_post)){echo form_open_multipart(base_url().'Post/edit_success/'.$current_post->category.'/'.$current_post->id);}else{echo form_open_multipart(base_url().'Write/new_post');} ?>
				    <h3 class="text-center">Write a post</h3>  

					<div class="row">

						<div class="col-md-12">
							<div class="form-group">
								<label for="title">Title</label>
								<input type="text" class="form-control" required="required" name="title" value="<?php if(isset($current_post)) echo $current_post->title;?>"/>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="categories">Category</label>
								<select class="form-control" name="categories">
									<option value="general">General</option>
									<option value="academics">Academics</option>
									<option value="employability">Employability</option>
									<option value="fvisa">Financials & Visa</option>
									<option value="social">Social Life</option>
								</select>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="content">Write here:</label>
								<textarea class="form-control" required="required" name="content" rows="10"><?php if(isset($current_post)) echo $current_post->content;?></textarea>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<input type="file" class="form-control dropzone" name="userfile[]" multiple="multiple">
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="form-group">
								<?php if(isset($current_post)) { ?>
									<a href="<?php echo base_url(); ?>Post/edit_success/<?php echo $current_post->category; ?>/<?php echo $current_post->id; ?>">
										<button type="submit" class="btn btn-secondary btn-block">Post</button>
									</a>
								<?php } else { ?>
									<a href="<?php echo base_url(); ?>Write/new_post">
										<button type="submit" class="btn btn-secondary btn-block">Post</button>
									</a>
								<?php } ?>
							</div>   
						</div>

					</div>
					<?php echo form_close(); ?>

	</div>

</div>
