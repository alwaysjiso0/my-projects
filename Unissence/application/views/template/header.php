<html>
  <head>
    <title>Unissence</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/dropzone.css" />
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dropzone.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url().'assets/js/jquery-ui.js'?>" type="text/javascript"></script>

  </head>
<body>
  <script> 
    
    function showAccount() {
        document.querySelector(".account_drop").classList.toggle("show");
    }

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.account_icon')) {
        var dropdowns = document.querySelector('.account_drop');
        if (dropdowns.classList.contains('show')) {
          dropdowns.classList.remove('show');
        }
      }
    }


  </script>

  <header>
  
      <nav>
        <a class="header_logo col-lg-2" href="<?php echo base_url(); ?>">Unissence</a>

        <form class="form-inline col-lg-3 my-2 my-lg-0">
        <?php echo form_open('ajax'); ?>
          <input class="form-control col-lg-8 mr-lg-2" type="search" id="search_text" placeholder="Search" name="search" aria-label="Search">
          <div id="suggesstion-box"></div>
          <button class="btn btn-outline-secondary col-lg-3 my-2 my-lg-0" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Search</button>
        <?php echo form_close(); ?>

        <div class="account">
          <span class="account_icon" onclick="showAccount()"></span>
        </div>
        
        <div class="account_drop">
          <ul>
            <?php if(!$this->session->userdata('logged_in')) : ?>
              <li class="login">
                <a href="<?php echo base_url(); ?>login"> Login </a>
              </li>
              <?php endif; ?> 
              <?php if($this->session->userdata('logged_in')) : ?>
                <li class="">
                  <a href="<?php echo base_url(); ?>login/logout"> Logout </a>
                </li>
                <li class="myquestions">
                  <a href="<?php echo base_url(); ?>Layout/list_myposts"> My Posts </a>
                </li>
                <li class="bookmarks">
                  <a href="<?php echo base_url(); ?>Layout/list_bookmark"> Bookmarks </a>
                </li>
                <li class="myaccount">
                  <a href="<?php echo base_url(); ?>Account"> Manage Account </a>
                </li>
              <?php endif; ?>
        </ul>
      </div>
      </nav>

      <div class="container_collapse">
        <div class="collapse" id="collapseExample">
          <div class="card card-body" id="result"> </div>
        </div>
      </div>
      
      <script>
          $(document).ready(function(){
          load_data();
              function load_data(query){
                  $.ajax({
                  url:"<?php echo base_url(); ?>ajax/fetch",
                  method:"GET",
                  data:{query:query},
                  success:function(response){
                      $('#result').html("");
                      if (response == "" ) {
                          $('#result').html(response);
                      }else{
                          var obj = JSON.parse(response);
                          if (obj.length > 0) {
                              var items=[];
                              $.each(obj, function(i,val){
                                  contents = [];
                                  contents.push($("<h4 style='margin-top: 30px'>").text(val.title));
                                  contents.push($("<p>").text(val.content));
                                  var category = val.category + "/";
                                  var post_id = val.id;
                                  var result = '<?php echo base_url(); ?>Post/open_post/' + category + post_id;
                                  items.push($("<a style='text-decoration: none; color: #000;'>").attr('href', result).append(contents));
                          });
                          console.log(items);
                          $('#result').append.apply($('#result'), items);         
                          } else {
                          $('#result').html("Not Found!");
                          }; 
                      };
                  }
              });
              }
              $('#search_text').keyup(function(){
                  var search = $(this).val();
                  if(search != ''){
                      load_data(search);
                  }else{
                      load_data();
                  }
              });

          });
      </script>
<style>

.container_collapse {
  position: absolute;
  z-index: 9999999;
}
</style>

       
</header>


  


