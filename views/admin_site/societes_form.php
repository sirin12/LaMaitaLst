<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Entreprises</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Entreprises</li>
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
                                <strong>Entreprises</strong></h2>
                         
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Societes/form/' . $id);?>">
								<div class="row">
									<div class="form-group form-float col-md-6">
										<div class="form-line">
											<input type="text" class="form-control" name="societes" value="<?php echo $societes;?>" required>
											<label class="form-label">Entreprise</label>
										</div>
									</div>
									<div class="form-group form-float col-md-6">
										<div class="form-line">
											<input type="email" class="form-control" name="email" value="<?php echo $email;?>" required>
											<label class="form-label">Email</label>
										</div>
									</div>
									<div class="form-group default-select select2Style col-md-6">
										<div class="form-line">
											<select class="form-control  select2" data-placeholder="Select" name="type_id">
												<option value="0" <?php if(0==$type_id) echo 'selected';?>>MDO</option>
												<option value="1" <?php if(1==$type_id) echo 'selected';?>>Controles</option>
												<option value="2" <?php if(2==$type_id) echo 'selected';?>>Concepteurs</option>
												<option value="3" <?php if(3==$type_id) echo 'selected';?>>Entreprises</option>
											</select>
											<label class="form-label">Type </label>
										</div>
									</div>
									<div class="form-group default-select select2Style col-md-6">
										<div class="form-line">
											<select class="form-control select2" data-placeholder="Select" name="travaux_id">
												<option value="0">Selectionner Lots</option>
												<?php $current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id']; if ($current_admin['access'] == 'Admin') {
            $travaus = $this->md_commun->fetch('travaux', array('etat' => 1), 'asc', 100, 0);
        } else {
            $travaus = $this->md_commun->fetch('travaux', array('etat' => 1, 'user_id' => $id_admin), 'asc', 100, 0);
        }?>
												<?php if($travaus){foreach($travaus as $trav){?>
												<option value="<?php echo $trav->id;?>" <?php if($trav->id==$travaux_id) echo 'selected';?>><?php echo $trav->travaux;?></option>
												<?php }}?>
											</select>
											<label class="form-label">Lots </label>
										</div>
									</div>
									<div class="form-group default-select select2Style col-md-12">
										<?php $projetss=$this->md_commun->fetch('projets',array('etat'=>1),'asc',1000,0);?>
											<select class="form-control select2" multiple="" data-placeholder="Select" name="projet_id[]">
											<?php if($projetss){foreach($projetss as $proj){?>
												<option value="<?php echo $proj->id;?>" <?php if($projet_id){ if(in_array($proj->id, $projet_id)) echo 'selected'; }?>><?php echo $proj->projets;?></option>
											<?php }}?>
											</select>
									</div>
									<div class="form-group form-float col-md-6">
										<div class="form-line">
											<input type="password" class="form-control" name="password">
											<label class="form-label">Mot de passe</label>
										</div>
									</div>
									<div class="form-group form-float col-md-12">
										<button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
									</div>
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Validation -->
        </div>
    </section>
    