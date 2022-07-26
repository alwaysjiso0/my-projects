<div id="body-wrapper">
    <div id="body_left" class="col-lg-2">
        <ul onclick="highlightLeft(event)">
            <li id="general_tab" style="background-color: <?php if(isset($bg_l_general)) echo $bg_l_general?>">
                <a href="<?php echo base_url(); ?>Post/list_post/general"> 
                    General
                </a>
            </li>
            <li id="academics_tab" style="background-color: <?php if(isset($bg_l_academics)) echo $bg_l_academics?>">
                <a href="<?php echo base_url(); ?>Post/list_post/academics">
                    Academics
                </a>  
            </li>
            <li id="employability_tab" style="background-color: <?php if(isset($bg_l_employability)) echo $bg_l_employability?>">
                <a href="<?php echo base_url(); ?>Post/list_post/employability">
                    Employability
                </a> 
            </li>
            <li id="financial_tab" style="background-color: <?php if(isset($bg_l_financial)) echo $bg_l_financial?>">
                <a href="<?php echo base_url(); ?>Post/list_post/fvisa">
                    Financials & Visa
                </a> 
            </li>
            <li id="social_tab" style="background-color: <?php if(isset($bg_l_social)) echo $bg_l_social?>">
                <a href="<?php echo base_url(); ?>Post/list_post/social">
                    Social Life
                </a> 
            </li>
        </ul>
        
        <a href="<?php echo base_url(); ?>Layout/references" class="references_link"> References</a>

    </div>


