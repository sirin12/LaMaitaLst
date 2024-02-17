<script type="text/javascript">
    function areyousure()
    {
        return confirm('<?php echo lang('confirm_delete'); ?>');
    }
</script>
<?php $current_admin = $this->session->userdata('admin');?>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Admins</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Admins</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="col-xs-12 col-sm-6">
                                <h2>Admins</h2>
                            </div>
							<?php if($current_admin['access']!='Consultant'){?>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="#" onclick="return false;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="<?php echo admin_url('Admin/form');?>">Ajouter</a>
                                        </li>
                                       
                                    </ul>
                                </li>
                            </ul>
							<?php }?>
                        </div>
                        <div class="body">
                            <div class="row">
							<?php foreach ($admins as $admin):
							if($admin->type_admin==1){?>
                                <div class="col-md-4">
                                    <div class="card border-apply">
                                        <div class="m-b-20">
                                            <div class="contact-grid">
                                                <div class="profile-header bg-dark">
                                                    <div class="user-name"><?php echo $admin->firstname.' '.$admin->lastname;  ?></div>
                                                    <div class="name-center"><?php echo $admin->access;?></div>
                                                </div>
												<?php if($admin->avatar) $avatar=uploads('avatars/'.$admin->avatar);else $avatar=admin_img('loading_maitrise.jpg');?>
                                                <img src="<?php echo $avatar;?>" class="user-img" alt="">
                                                <p>
                                                    <?php echo $admin->email;?>
                                                </p>
                                               
                                                <div class="profile-userbuttons">
                                                    <a href="<?php echo admin_url('Admin/form/'.$admin->id);?>" class="btn btn-info btn-border-radius waves-effect">Modifier</a>
													<?php //if (($current_admin['id'] != $admin->id)&&($current_admin['access']=='Admin')):?>
                                                        <a href="<?php echo admin_url('Admin/delete/'.$admin->id);?>" class="btn btn-danger btn-border-radius waves-effect" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')">Effacer</a>

													<?php //endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							<?php }?>
							<?php endforeach; ?>
                            </div>
                        </div>
                    </div>
					<div class="card">
                        <div class="header">
                            <div class="col-xs-12 col-sm-6">
                                <h2>Clients</h2>
                            </div>
                        </div>
                        <div class="body">
                            <div class="row">
							<?php foreach ($admins as $admin):
								if($admin->type_admin==2){?>
                                <div class="col-md-4">
                                    <div class="card border-apply">
                                        <div class="m-b-20">
                                            <div class="contact-grid">
                                                <div class="profile-header bg-dark">
                                                    <div class="user-name"><?php echo $admin->firstname.' '.$admin->lastname;  ?></div>
                                                </div>
												<?php if($admin->avatar) $avatar=uploads('avatars/'.$admin->avatar);else $avatar=admin_img('loading_maitrise.jpg');?>
                                                <img src="<?php echo $avatar;?>" class="user-img" alt="">
                                                <p>
                                                    <?php echo $admin->email;?>
                                                </p>
                                               
                                                <div class="profile-userbuttons">
                                                    <a href="<?php echo admin_url('Admin/form/'.$admin->id);?>" class="btn btn-info btn-border-radius waves-effect">Modifier</a>
													<?php //if (($current_admin['id'] != $admin->id)&&($current_admin['access']=='Admin')):?>
													<a href="<?php echo admin_url('Admin/delete/'.$admin->id);?>" class="btn btn-danger btn-border-radius waves-effect" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')">Effacer</a>
													<?php //endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<?php }?>
							<?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>