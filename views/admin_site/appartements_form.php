<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Etages</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
								<?php $pr_id=$this->md_commun->get_row('projets',array('id'=>$projet_id));?>
                                <a href="<?php echo admin_url('Projets');?>"><?php echo $pr_id->projets;?></a>
                            </li>
							<li class="breadcrumb-item bcrumb-1">
								<?php $bl_id=$this->md_commun->get_row('blocs',array('id'=>$blocs_id));?>
                                <a href="<?php echo admin_url('Projets/blocs/'.$projet_id);?>"><?php echo $bl_id->blocs;?></a>
                            </li>
							<li class="breadcrumb-item bcrumb-1">
								<?php $et_id=$this->md_commun->get_row('etages',array('id'=>$etages_id));?>
                                <a href="<?php echo admin_url('Projets/Etages/'.$projet_id.'/'.$blocs_id);?>"><?php echo $et_id->etages;?></a>
                            </li>
							<li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('Projets/appartements/'.$projet_id.'/'.$blocs_id.'/'.$etages_id);?>">Appartemaents</a>
                            </li>
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
                                <strong>Locaux</strong></h2>
                         
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Projets/form_appartements/'.$projet_id.'/'.$blocs_id.'/'.$etages_id.'/' . $id);?>" enctype="multipart/form-data">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="appartements" value="<?php echo $appartements;?>" required>
                                        <label class="form-label">Locaux</label>
                                    </div>
                                </div>
								<div class="row">
									<div class="form-group form-float col-md-6">
										<div class="form-line">
											<input type="file" class="form-control" name="image" value="<?php echo $image;?>" >
											<label class="form-label">Image</label>
										</div>
										<?php if ($id && $image != ''){ ?>
						                <div class="featured-image" style="text-align:center; padding:5px; border:1px solid #ddd"><img src="<?php echo base_url('uploads/images/full/' . $image); ?>" alt="current" height="157" width="100%" style="object-fit:contain !important"/><br/>
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
    