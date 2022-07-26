<div id="body_right_bookmark" class="col-lg-7">
    <div class="b_intro">Bookmarks</div>
    <div class="blist">
    <?php echo form_open(base_url().'Layout/list_bookmark'); ?> 
        <ul>
            <?php
                if (isset($bookmarks)) {
                foreach ($bookmarks as $row) {?> 
                <li>
                    <a href="<?php echo base_url(); ?>Post/open_post/<?php echo $row->category; ?>/<?php echo $row->post_id; ?>">
                    <?php echo form_open('Layout', array('method'=>'get'))?>
                    <div class="blist_item_wrapper">
                        <h5 class="bmark_title">
                            <?php echo $row->title; ?>
                        </h5>
                        <p class="bmark_content">
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