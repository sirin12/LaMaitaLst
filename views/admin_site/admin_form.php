<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Admin</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Admin</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Admin</strong> </h2>
                            
                        </div>
						
                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Admin/form/' . $id);?>" enctype="multipart/form-data">
                               
								
								<div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="firstname" value="<?php echo $firstname;?>" required>
                                        <label class="form-label">Nom</label>
                                    </div>
                                </div>
								<div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="lastname" value="<?php echo $lastname;?>" required>
                                        <label class="form-label">Prenom</label>
                                    </div>
                                </div>
								<div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="email" value="<?php echo $email;?>" required>
                                        <label class="form-label">Email</label>
                                    </div>
                                </div>
								<div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="password">
                                        <label class="form-label">Mot de passe</label>
                                    </div>
                                </div>
								<div class="form-group default-select select2Style">
									<?php $projetss=$this->md_commun->fetch('projets',array('etat'=>1),'asc',1000,0);?>
                                        <select class="form-control select2" multiple="" data-placeholder="Select" name="projet_id[]">
										<?php if($projetss){foreach($projetss as $proj){?>
                                            <option value="<?php echo $proj->id;?>" <?php if($projet_id){ if(in_array($proj->id, $projet_id)) echo 'selected'; }?>><?php echo $proj->projets;?></option>
										<?php }}?>
                                        </select>
                                </div>
								<div class="row">
									<div class="form-group form-float col-md-12">
										<div class="form-line">
											<input type="file" class="form-control" name="image" value="<?php echo $image;?>" >
											<label class="form-label">Image</label>
										</div>
										<?php if ($id && $image != ''){ ?>
						                <div class="featured-image" style="text-align:center; padding:5px; border:1px solid #ddd"><img src="<?php echo base_url('uploads/avatars/' . $image); ?>" alt="current" height="157" width="100%" style="object-fit:contain !important"/><br/>
						    			<?php echo lang('current_file'); ?></div>
										<?php }?>
									</div>
								</div>
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Validation -->
        </div>
    </section>
    