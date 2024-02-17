<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Projets</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
							<li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('Projets');?>">Projets</a>
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
                                <strong>Projets</strong></h2>
                         
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Projets/form/' . $id);?>" enctype="multipart/form-data">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="projets" value="<?php echo $projets;?>" required>
                                        <label class="form-label">Projets</label>
                                    </div>
                                </div>
								<div class="row">
									<div class="form-group form-float col-md-6">
										<div class="form-line">
											<select class="form-control" name="clients_id">
												<option value="0">Selectionner intervenant</option>
												<?php $clients=$this->md_commun->fetch('clients',array('etat'=>1),'asc',1000,0);?>
												<?php if($clients){foreach($clients as $client){?>
												<option value="<?php echo $client->id;?>" <?php if($client->id==$clients_id) echo 'selected';?>><?php echo $client->clients;?></option>
												<?php }}?>
											</select>
											<label class="form-label">Intervenant </label>
										</div>
									</div>
									<div class="form-group form-float col-md-6">
										<div class="form-line">
											<input type="text" class="form-control" name="adresse" value="<?php echo $adresse;?>" required>
											<label class="form-label">Adresse</label>
										</div>
									</div>
									<div class="form-group form-float col-md-4">
										<div class="form-line">
											<input type="date" class="form-control" name="date_debut" value="<?php echo $date_debut;?>" required>
											<label class="form-label">Date</label>
										</div>
									</div>
									<div class="form-group form-float col-md-4">
										<div class="form-line">
											<input type="text" class="form-control" name="aire" value="<?php echo $aire;?>" required>
											<label class="form-label">Aire</label>
										</div>
									</div>
									<div class="form-group form-float col-md-4">
										<div class="form-line">
											<input type="text" class="form-control" name="cout" value="<?php echo $cout;?>" required>
											<label class="form-label">Cout</label>
										</div>
									</div>
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
    