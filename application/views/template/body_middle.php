<div id="body_middle" class="col-lg-3">
    <div class="new_post">
        <a href="<?php echo base_url(); ?>write">
            <span></span>
            <p>New Post</p>
        </a>
    </div>
    <div class="trending_post">
        <h5>Trending this week</h5>
        <ul>
        <?php
            if (isset($top_posts)) {
            foreach ($top_posts as $row) {?> 
            <li>
                <a href="<?php echo base_url(); ?>Post/open_post/<?php echo $category; ?>/<?php echo $row->id; ?>">
                <?php echo form_open('Layout', array('method'=>'get'))?> 
                    <div class="post_wrapper">
                        <div>
                            <p class="post_title">
                                <?php echo $row->title; ?>
                            </p>
                            <p class="post_owner">
                                <?php echo $row->username; ?>
                            </p>
                        </div>
                        <div>
                            <span></span>
                            <p class="post_likes">
                                <?php echo $row->likes; ?> 
                            </p>
                        </div>
                    </div>
                    <p class="post_content">
                        <?php echo $row->content; ?> 
                    </p>
                    
                </a>  
                </li>
            <?php }}?>
        </ul>
    </div>
    <div class="posts_wrapper">
        
        <?php echo form_open(base_url().'Post/list_post'); ?> 
        <h5>Posts</h5>
        <ul class="posts">
            <?php
                if (isset($posts)) {
                foreach ($posts as $row) {?> 
                <li>
                    <a href="<?php echo base_url(); ?>Post/open_post/<?php echo $category; ?>/<?php echo $row->id; ?>">
                    <?php echo form_open('Layout', array('method'=>'get'))?> 
                        <p class="post_title">
                            <?php echo $row->title; ?>
                        </p>
                        <p class="post_owner">
                            <?php echo $row->username; ?>
                        </p>
                        <p class="post_content">
                            <?php echo $row->content; ?> 
                        </p>
                    </a>  
                </li>
            <?php }}?>
        </ul>
    </div>
</div>


<script>

    var scroll_item = document.querySelector("#body_middle .posts_wrapper ul");

    window.addEventListener("beforeunload", event => {
        var hey = scroll_item.scrollTop;
        localStorage.setItem('pageVerticalPosition', hey);
    });

    window.addEventListener("load", event => {
        scroll_item.scrollTop = localStorage.getItem("pageVerticalPosition") || 0;
    });

</script>