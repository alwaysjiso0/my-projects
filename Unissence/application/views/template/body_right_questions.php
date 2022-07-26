<div id="body_right_questions" class="col-lg-7">
    <div class="q_intro">My Posts</div>
        <div class="qlist">
        <?php echo form_open(base_url().'Layout/list_myposts'); ?> 
            <ul>
                <?php
                    if (isset($my_posts)) {
                    foreach ($my_posts as $row) {?> 
                    <li>
                        <a href="<?php echo base_url(); ?>Post/open_post/<?php echo $row->category; ?>/<?php echo $row->id; ?>">
                            <div class="qlist_item_wrapper">
                                <h5>
                                    <?php echo $row->title; ?>
                                </h5>
                                <p>
                                    <?php echo $row->content; ?>
                                </p> 
                            <div>
                            <span></span>
                        </a>
                    </li>
                <?php }}?>
            </ul>
        </div>
    </div>
</div> 