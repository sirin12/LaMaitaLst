<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>La maitrise</title>
    <!-- Favicon-->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
	<!-- Colorpicker Css -->
	<?php echo admin_assests('assets/js/bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css','css') ?>
    <!-- Multi Select Css -->
	<?php echo admin_assests('assets/js/bundles/multiselect/css/multi-select.css','css') ?>
    <!-- Plugins Core Css -->
	<?php echo admin_assests('assets/css/app.min.css','css') ?>
	<?php echo admin_assests('assets/css/form.min.css','css') ?>
    <!-- Custom Css -->
	<?php echo admin_assests('assets/css/style.css','css') ?>
    <!-- Theme style. You can choose a theme from css/themes instead of get all themes -->
	<?php echo admin_assests('assets/css/styles/all-themes.css','css') ?>
	


</head>
<?php $current_admin = $this->session->userdata('admin');?>
<body class="light">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="<?php echo admin_img('loading_maitrise.jpg');?>" width="20" height="20" alt="admin">
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#" onClick="return false;" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="#" onClick="return false;" class="bars"></a>
                <a class="navbar-brand" href="<?php echo admin_url('');?>" style="padding:0 0 ;">
                    <img src="<?php echo admin_img('logo_chek.png');?>" alt="" style="height:45px;float:left;margin-left:15px;" />
                    <span class="logo-name" style="float:left;margin-left:10px;font-weight:bold;margin-top:13px;color:#525493;font-size:20px !important">CHECK-NOTES</span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="pull-left">
                    <li>
                        <a href="#" onClick="return false;" class="sidemenu-collapse">
                            <i class="material-icons">reorder</i>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <!-- Full Screen Button -->
                    <li class="fullscreen">
                        <a href="javascript:;" class="fullscreen-btn">
                            <i class="fas fa-expand"></i>
                        </a>
                    </li>
                    <!-- #END# Full Screen Button -->
                    <!-- #START# Notifications-->
                    <!--<li class="dropdown">
                        <a href="#" onClick="return false;" class="dropdown-toggle" data-toggle="dropdown"
                            role="button">
                            <i class="far fa-bell"></i>
                            <span class="label-count bg-orange"></span>
                        </a>
                        <ul class="dropdown-menu pullDown">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="#" onClick="return false;">
                                            <span class="table-img msg-user">
                                                <img src="<?php echo admin_img('logo.png');?>" alt="">
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">Elloumi amir</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> 14 mins ago
                                                </span>
                                                <span class="menu-desc">Please check your email.</span>
                                            </span>
                                        </a>
                                    </li>
                            
                        
                           
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#" onClick="return false;">View All Notifications</a>
                            </li>
                        </ul>
                    </li>-->
                    <!-- #END# Notifications-->
                    <li class="dropdown user_profile">
                        <a href="#" onClick="return false;" class="dropdown-toggle" data-toggle="dropdown"
                            role="button">
                            <img src="<?php echo admin_img('logo.png');?>" width="100" height="" alt="User">
                        </a>
                        <ul class="dropdown-menu pullDown">
                            <li class="body">
                                <ul class="user_dw_menu">
                                    <?php /*<li>
                                        <a href="<?php echo admin_url('Admin/form/'.$current_admin['id']);?>">
                                            <i class="material-icons">person</i>Profile
                                        </a>
                                    </li>*/?>
                                    <!--<li>
                                        <a href="#" onClick="return false;">
                                            <i class="material-icons">feedback</i>Feedback
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onClick="return false;">
                                            <i class="material-icons">help</i>Help
                                        </a>
                                    </li>-->
                                    <li>
                                        <a href="<?php echo admin_url('Login/logout');?>" >
                                            <i class="material-icons">power_settings_new</i>Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Tasks -->
                    <!--<li class="pull-right">
                        <a href="#" onClick="return false;" class="js-right-sidebar" data-close="true">
                            <i class="fas fa-cog"></i>
                        </a>
                    </li>-->
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <div>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="sidebar-user-panel active">
                        <div class="user-panel">
                            <div class=" image">
                                <img src="<?php echo admin_img('logo.png');?>" class=""
                                    alt="User Image" />
                            </div>
                        </div>
                        <div class="profile-usertitle">
						<?php $current_admin = $this->session->userdata('admin');
						$id_admin=$current_admin['id'];?>
                            <div class="sidebar-userpic-name"> <?php echo $current_admin['lastname'].' '.$current_admin['firstname'];?> </div>
                            <div class="profile-usertitle-job "><?php echo $current_admin['email'];?> </div>
                        </div>
                    </li>
					<?php $segment_uri=$this->uri->segment(2); $segment_uri2=$this->uri->segment(3);?>
                    <?php /*<li <?php if($segment_uri=='') echo 'class="active"';?>>
                        <a href="<?php echo admin_url('');?>">
                            <i class="far fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>*/?>
					<?php if(($current_admin['super_admin']==1)&&($current_admin['type_admin']==1)){?>
					<li <?php if($segment_uri=='Admin') echo 'class="active"';?>>
                        <a href="<?php echo admin_url('Admin');?>">
                            <i class="far fa-tachometer-alt"></i>
                            <span>Admin</span>
                        </a>
                    </li>
					<?php }?>
					<li <?php if(($segment_uri=='Projets')&&($segment_uri2!='acheves')) echo 'class="active"';?>>
                        <a href="<?php echo admin_url('Projets');?>">
                            <i class="far fa-tachometer-alt"></i>
                            <span>Projets</span>
                        </a>
                    </li>
					<?php if(($current_admin['type_admin']==1)){?>
					<li <?php if(($segment_uri=='Projets')&&($segment_uri2=='acheves')) echo 'class="active"';?>>
                        <a href="<?php echo admin_url('Projets/acheves');?>">
                            <i class="far fa-tachometer-alt"></i>
                            <span>Projets achevés</span>
                        </a>
                    </li>
					<li <?php if($segment_uri=='Societes') echo 'class="active"';?>>
                        <a href="<?php echo admin_url('Societes');?>">
                            <i class="far fa-tachometer-alt"></i>
                            <span>Entreprises</span>
                        </a>
                    </li>
					<li <?php if($segment_uri=='Travaux') echo 'class="active"';?>>
                        <a href="<?php echo admin_url('Travaux');?>">
                            <i class="far fa-tachometer-alt"></i>
                            <span>Lots</span>
                        </a>
                    </li>
					<li <?php if($segment_uri=='Clients') echo 'class="active"';?>>
                        <a href="<?php echo admin_url('Clients');?>">
                            <i class="far fa-tachometer-alt"></i>
                            <span>Clients</span>
                        </a>
                    </li>
                    <li <?php if ($segment_uri == 'Corrections' && empty($segment_uri2)) echo 'class="active"'; ?>>
    <a href="<?php echo admin_url('Corrections'); ?>">
        <i class="far fa-tachometer-alt"></i>
        <span>Corrections</span>
    </a>
</li>
<li <?php if ($segment_uri == 'Corrections' && $segment_uri2 == 'index_archive') echo 'class="active"'; ?>>
    <a href="<?php echo admin_url('Corrections/index_archive'); ?>">
        <i class="far fa-tachometer-alt"></i>
        <span>Corrections Archivées</span>
    </a>
</li>


					<li <?php if($segment_uri=='Rapports') echo 'class="active"';?>>
                        <a href="<?php echo admin_url('Rapports');?>">
                            <i class="far fa-tachometer-alt"></i>
                            <span>Rapports</span>
                        </a>
                    </li>
					<?php }?>
					<?php if(($current_admin['type_admin']!=2)){?>
					<li <?php if($segment_uri=='Rapport_societe') echo 'class="active"';?>>
                        <a href="<?php echo admin_url('Rapport_societe');?>">
                            <i class="far fa-tachometer-alt"></i>
                            <span>Rapports Societe</span>
                        </a>
                    </li>
					<?php }?>
                    <li >
                        
                            <span></span>
                       
                    </li>
         
                </ul>
            </div>
            <!-- #Menu -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation">
                    <a href="#skins" data-toggle="tab" class="active">SKINS</a>
                </li>
                <li role="presentation">
                    <a href="#settings" data-toggle="tab">SETTINGS</a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane in active in active stretchLeft" id="skins">
                    <div class="demo-skin">
                        <div class="rightSetting">
                            <p>GENERAL SETTINGS</p>
                            <ul class="setting-list list-unstyled m-t-20">
                                <li>
                                    <div class="form-check">
                                        <div class="form-check m-l-10">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="" checked> Save
                                                History
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <div class="form-check m-l-10">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="" checked> Show
                                                Status
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <div class="form-check m-l-10">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="" checked> Auto
                                                Submit Issue
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <div class="form-check m-l-10">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="" checked> Show
                                                Status To All
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="rightSetting">
                            <p>SIDEBAR MENU COLORS</p>
                            <button type="button"
                                class="btn btn-sidebar-light btn-border-radius p-l-20 p-r-20">Light</button>
                            <button type="button"
                                class="btn btn-sidebar-dark btn-default btn-border-radius p-l-20 p-r-20">Dark</button>
                        </div>
                        <div class="rightSetting">
                            <p>THEME COLORS</p>
                            <button type="button"
                                class="btn btn-theme-light btn-border-radius p-l-20 p-r-20">Light</button>
                            <button type="button"
                                class="btn btn-theme-dark btn-default btn-border-radius p-l-20 p-r-20">Dark</button>
                        </div>
                        <div class="rightSetting">
                            <p>SKINS</p>
                            <ul class="demo-choose-skin choose-theme list-unstyled">
                                <li data-theme="black" class="actived">
                                    <div class="black-theme"></div>
                                </li>
                                <li data-theme="white">
                                    <div class="white-theme white-theme-border"></div>
                                </li>
                                <li data-theme="purple">
                                    <div class="purple-theme"></div>
                                </li>
                                <li data-theme="blue">
                                    <div class="blue-theme"></div>
                                </li>
                                <li data-theme="cyan">
                                    <div class="cyan-theme"></div>
                                </li>
                                <li data-theme="green">
                                    <div class="green-theme"></div>
                                </li>
                                <li data-theme="orange">
                                    <div class="orange-theme"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="rightSetting">
                            <p>Disk Space</p>
                            <div class="sidebar-progress">
                                <div class="progress m-t-20">
                                    <div class="progress-bar l-bg-cyan shadow-style width-per-45" role="progressbar"
                                        aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="progress-description">
                                    <small>26% remaining</small>
                                </span>
                            </div>
                        </div>
                        <div class="rightSetting">
                            <p>Server Load</p>
                            <div class="sidebar-progress">
                                <div class="progress m-t-20">
                                    <div class="progress-bar l-bg-orange shadow-style width-per-63" role="progressbar"
                                        aria-valuenow="63" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="progress-description">
                                    <small>Highly Loaded</small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane stretchRight" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label>
                                        <input type="checkbox" checked>
                                        <span class="lever switch-col-green"></span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label>
                                        <input type="checkbox">
                                        <span class="lever switch-col-blue"></span>
                                    </label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label>
                                        <input type="checkbox" checked>
                                        <span class="lever switch-col-purple"></span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label>
                                        <input type="checkbox" checked>
                                        <span class="lever switch-col-cyan"></span>
                                    </label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label>
                                        <input type="checkbox" checked>
                                        <span class="lever switch-col-red"></span>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label>
                                        <input type="checkbox">
                                        <span class="lever switch-col-lime"></span>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </div>
	
  