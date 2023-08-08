<div class="wrap " style="background-color: #fff">

  <style>
    .nav-tabs {
      float: left;
      width: 100%;
      margin: 0;
      border-bottom: 1px solid transparent;
      border-bottom: 1px solid #c3c4c7;
      margin: 0;
      padding-top: 9px;
      padding-bottom: 0;
      line-height: inherit;
      padding: 10px 0 0 10px;
    }

    .nav-tabs>li {
      float: left;
      margin-bottom: -1px;
    }

    .nav-tabs>li>a {
      margin-right: 2px;
      line-height: 1.5;
      padding: 10px;
      border: 1px solid transparent;
      border-radius: 4px 4px 0 0;
      float: left;
      color: #626262;
      background-color: #5555;
      text-decoration: none;
      border-color: #F6F8FA #F6F8FA #ddd;
    }

    .nav-tabs>li>a:hover {}


    .nav-tabs>li.active>a,
    .nav-tabs>li.active>a:hover,
    .nav-tabs>li.active>a:focus {
      color: #555;
      cursor: default;
      background-color: #ffffff;
      border-color: #ddd;
      border-bottom-color: transparent;
    }

    .tab-content>.tab-pane {
      float: left;
      width: 100%;
      display: none;
      padding-top: 20px;
      min-height: 80vh;
    }

    .tab-content p {
      font-size: 14px;
      font-weight: 500;
    }

    .tab-content>.tab-pane.active {
      display: block;
      padding: 10px;
      background-color: #ffffff;
      box-shadow: 0 5px 4px -2px rgba(0, 0, 0, 0.15);
      font-size: 16px;
      padding: 10px 10px 20px 20px;
    }

    .ib_box_tab {
      display: flex;
      flex-direction: row;
      width: 100%;
    }
  </style>


  <div class="d-flex flex-row  align-items-center  justify-content-between p-3">
    <div class="d-flex">
      <div class="breadcome-menu">
        <span class="bread-blod ariane">
          <?php _e(get_admin_page_title())?>
        </span>
      </div>
    </div>
  </div>

  <?php settings_errors(); ?>
  <?php // esc_html_e( get_admin_page_title() ); ?>
  <ul class="nav nav-tabs " style="background-color: #fff">
    <li class="active"><a href="#tab-1">
        <?php _e('General')?>
      </a></li>
    <li><a href="#tab-2">
        <?php _e('Paiement')?>
      </a></li>
    <li><a href="#tab-3">
        <?php _e('Reservation')?>
      </a></li>
    <li><a href="#tab-4">
        <?php _e('Design')?>
      </a></li>
  </ul>

  <div class="tab-content">

    <div class="tab-pane active" id="tab-1">

      <form method="post" action="options.php">
        <!-- Display necessary hidden fields for settings -->
        <?php 
              settings_fields( 'insapp_general_settings' );
              // Display the settings sections for the page 
              do_settings_sections( 'insapp_general' );
            
              submit_button( null,'primary','submit',true,['id'=>'pw_button'] );
            ?>
      </form>
  
    </div>

    <div class="tab-pane " id="tab-2">
        <form method="post" action="options.php">
          <!-- Display necessary hidden fields for settings -->
          <?php 
              settings_fields( 'insapp_Payments_Settings' );
              // Display the settings sections for the page 
              do_settings_sections( 'insapp_Payments' );
            
              submit_button( null,'primary','submit',true,['id'=>'pw_button'] );
            ?>
        </form>
    </div>

    <div class="tab-pane " id="tab-3">
      <form method="post" action="options.php">

      </form>
    </div>

    <div class="tab-pane " id="tab-4">
      <form method="post" action="options.php">

      </form>
    </div>

  </div>

</div>