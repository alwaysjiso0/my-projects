<div id="body_post" class="col-lg-7">
    <div class="post_wrapper">
        <div class="post_title">
            <h2><?php echo $current_post->title; ?></h2>
        </div>
        <!-- END of post_title -->
        
        <div class="post_user">
            <div class="post_owner">
                <span></span>
                <p class="post_owner_username" onclick="drop_user_options(this)"><?php echo $current_post->username; ?></p>
            </div>
            
            <div class="post_views">
                <p><?php echo $current_post->views; ?></p>
                <p>VIEWS</p>
            </div>
        </div>
        <!-- END of post_user -->
        
        <div class="post_content"> 
            <?php 
                echo $current_post->content; 
                ?><br><br>
                <?php
                if (isset($current_post->filename_1)) {
                    ?>
                    <img max-width="600px" height="auto" src="<?php echo base_url(); ?>uploads/<?php echo $current_post->filename_1 ?>" />
                    <?php
                }
            ?><br><br>
                <?php
                if (isset($current_post->filename_2)) {
                    ?>
                    <img max-width="600px" height="auto" src="<?php echo base_url(); ?>uploads/<?php echo $current_post->filename_2 ?>" />
                    <?php
                }
            ?>
        </div>
        <!-- END of post_content -->

        <?php
        if ($username == $current_post->username) {?>
        <div class="post_crud">
            <div class="post_edit">
                <a href="<?php echo base_url(); ?>Post/edit_post/<?php echo $current_post->category; ?>/<?php echo $current_post->id;?>" class="post_edit">Edit</a>
                <a href="<?php echo base_url(); ?>Post/delete_post/<?php echo $current_post->category; ?>/<?php echo $current_post->id;?>" class="post_delete">Delete</a>
            </div>
        </div>
        <?php
        }  
        ?>
        <!-- END of post_crud -->

        <div class="post_options">
            <div class="post_like">
                <?php echo form_open(base_url().'Post/like_post'); ?>
                <a href="<?php echo base_url(); ?>Post/like_post/<?php echo $current_post->category; ?>/<?php echo $current_post->id; ?>">
                    <span class="like_icon" style="background-image: url('../../../assets/img/icons/heart<?php if(isset($like_status)) { if ($like_status == 'active') {echo '_black';} else {
                        echo '';}}?>.png');">
                    </span>
                </a>
                <span class="like_count">
                    <?php echo $current_post->likes; ?>
                </span>
                <?php echo form_close(); ?>
            </div>
            <div class="post_bmark">
                <a href="<?php echo base_url(); ?>Post/bookmark_post/<?php echo $current_post->category; ?>/<?php echo $current_post->id; ?>">
                    <span class="bmark_icon" style="background-image: url('../../../assets/img/icons/bookmark<?php if(isset($bmark_status)) { if ($bmark_status == 'active') {echo '_black';} else {
                        echo '';}}?>.png');"> </span>
                </a>
            </div>
        </div>
        <!-- END of post_options -->
 
        <div class="post_comment">
        <?php echo form_open(base_url().'Post/write_comment/'.$current_post->category.'/'.$current_post->id); ?>
            <form class="post_comment_form">
                <input type="text" placeholder="write a comment" name="comment"></input>
                <button type="submit">Post</button>
            </form>

            <div class="comment_list">
                <ul>
                <?php
                    if (isset($comments)) {
                    foreach ($comments as $row) {?> 
                    <li>
                        <div>
                            <div class="comment_user">
                                <span></span>
                                <p><?php echo $row->username; ?></p>
                            </div>
                            <div class="comment_content">
                                <p><?php echo $row->comment; ?></p>
                            </div>
                        </div>
                        <div>
                            <?php echo $row->created_at; ?>
                        </div>
                    </li>
                <?php }}?>
                </ul>
            </div>
        </div>
        <!-- END of post_comment -->

    </div> 
</div>

<script>

    var scroll_post_item = document.querySelector("#body_post");

    window.addEventListener("beforeunload", event => {
        var hey2 = scroll_post_item.scrollTop;
        localStorage.setItem('postVerticalPosition', hey2);
    });

    window.addEventListener("load", event => {
        scroll_post_item.scrollTop = localStorage.getItem("postVerticalPosition") || 0;
    });

</script>