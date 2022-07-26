<div id="body_middle_account" class="col-lg-3" onclick="highlightActivity(event)">
    <div style="background-color: <?php if(isset($bg_m_myposts)) echo $bg_m_myposts?>">
        <a href="<?php echo base_url(); ?>Layout/list_myposts"> My Posts </a>
    </div>
    <div style="background-color: <?php if(isset($bg_m_bookmarks)) echo $bg_m_bookmarks?>">
        <a href="<?php echo base_url(); ?>Layout/list_bookmark"> Bookmarks </a>
    </div>
    <div style="background-color: <?php if(isset($bg_mid_account)) echo $bg_mid_account?>">
        <a href="<?php echo base_url(); ?>Account"> Manage Account </a>
    </div>
</div>

