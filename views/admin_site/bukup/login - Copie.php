<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Admin</title>
<meta name="description" content="Admin, Dashboard" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- for ios 7 style, multi-resolution icon of 152x152 -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
<?php /*?>  <link rel="apple-touch-icon" href="../assets/images/logo.png"><?php */?>
<meta name="apple-mobile-web-app-title" content="Web-graphique">
<!-- for Chrome on Android, multi-resolution icon of 196x196 -->
<meta name="mobile-web-app-capable" content="yes">
<?php /*?><link rel="shortcut icon" sizes="196x196" href="../assets/images/logo.png"><?php */?>

<!-- style -->
<?php echo admin_assests('assets/animate.css/animate.min.css','css') ?>
<?php echo admin_assests('assets/glyphicons/glyphicons.css','css') ?>
<?php echo admin_assests('assets/font-awesome/css/font-awesome.min.css','css') ?>
<?php echo admin_assests('assets/material-design-icons/material-design-icons.css','css') ?>
<?php echo admin_assests('assets/bootstrap/dist/css/bootstrap.min.css','css') ?>
<?php echo admin_assests('assets/styles/app.css','css') ?>
<?php echo admin_assests('assets/styles/font.css','css') ?>
</head>
<body>
  <div class="app" id="app">

<!-- ############ LAYOUT START-->
  <div class="center-block w-xxl w-auto-xs p-y-md">
    <div class="navbar">
      <div class="pull-center">
         <!-- brand -->

<!-- / brand -->
      </div>
    </div>
    <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
      <div class="m-b text-sm">
         Connectez avec votre compte Admin
      </div>
        <form  action="<?php echo admin_url('login'); ?>" method="post">
        <div class="md-form-group float-label">
          <input type="email" class="md-input"  required name="username">
          <label>Email</label>
        </div>
        <div class="md-form-group float-label">
          <input type="password" class="md-input"  required name="password">
          <label>Password</label>
        </div>
            
               <br>
        <div class="m-b-md">        
          <label class="md-check">
            <input type="checkbox" name="remember"><i class="primary"></i> Keep me signed in
          </label>
        </div>
        <input type="hidden" value="<?php echo $redirect; ?>" name="redirect"/>
        <input type="hidden" value="submitted" name="submitted"/>
        <button type="submit" class="btn primary btn-block p-x-md">Sign in</button>
      </form>
    </div>

   <?php /*?> <div class="p-v-lg text-center">
      <div class="m-b"><a ui-sref="access.forgot-password" href="#/access/forgot-password" class="text-primary _600">Forgot password?</a></div>
    </div><?php */?>
  </div>

<!-- ############ LAYOUT END-->

  </div>
<!-- build:js scripts/app.html.js -->
<!-- jQuery -->
 <script>
var theme_url= '<?php echo site_url('themes/admin_site')?>';
</script>
<!-- jQuery -->
<?php echo admin_assests('libs/jquery/jquery/dist/jquery.js', 'js') ?>

<!-- Bootstrap -->
<?php echo admin_assests('libs/jquery/tether/dist/js/tether.min.js', 'js') ?>
<?php echo admin_assests('libs/jquery/bootstrap/dist/js/bootstrap.js', 'js') ?>
<!-- core -->
<?php echo admin_assests('libs/jquery/underscore/underscore-min.js', 'js') ?>
<?php echo admin_assests('libs/jquery/jQuery-Storage-API/jquery.storageapi.min.js', 'js') ?>
<?php echo admin_assests('libs/jquery/PACE/pace.min.js', 'js') ?>
<?php echo admin_assests('scripts/config.lazyload.js', 'js') ?>
<?php echo admin_assests('scripts/palette.js', 'js') ?>
<?php echo admin_assests('scripts/ui-load.js', 'js') ?>
<?php echo admin_assests('scripts/ui-jp.js', 'js') ?>
<?php echo admin_assests('scripts/ui-include.js', 'js') ?>
<?php echo admin_assests('scripts/ui-device.js', 'js') ?>
<?php echo admin_assests('scripts/ui-form.js', 'js') ?>
<?php echo admin_assests('scripts/ui-nav.js', 'js') ?>
<?php echo admin_assests('libs/jquery/screenfull/dist/screenfull.min.js', 'js') ?>
<?php echo admin_assests('scripts/ui-screenfull.js', 'js') ?>
<?php echo admin_assests('scripts/ui-scroll-to.js', 'js') ?>
<?php echo admin_assests('scripts/ui-toggle-class.js', 'js') ?>
<?php echo admin_assests('scripts/app.js', 'js') ?>
 <!-- ajax -->
<?php echo admin_assests('libs/jquery/jquery-pjax/jquery.pjax.js', 'js') ?>
<?php echo admin_assests('scripts/ajax.js', 'js') ?>
<!-- endbuild -->
</body>
</html>
