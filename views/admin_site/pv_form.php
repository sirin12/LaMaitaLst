<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">PV Rénion</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">PV Rénion</li>
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
                                <strong>PV Rénion</strong></h2>
                         
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Pv/form/'.$projet_id.'/'. $id);?>">
                                <div class="form-group form-float">
									<label class="form-label"><b>Projet</b></label>
                                    <div class="form-line">
                                        <div class="form-group default-select select2Style">
											<?php $projets=$this->md_commun->fetch('projets',array('etat'=>1,'id'=>$projet_id),'asc',10000,0);?>
											<select class="form-control select2" data-placeholder="Select" name="projet_id" onchange="fetch_blocs(this.value)">
												<option value="">Seclectionner projet</option>
												<?php if($projets){foreach($projets as $proj){?>
												<option value="<?php echo $proj->id;?>" <?php if($proj->id==$projet_id) echo 'selected';?>><?php echo $proj->projets;?></option>
												<?php }}?>
											</select>
										</div>
                                    </div>
                                </div>
								<div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="numero" value="<?php echo $numero;?>" required>
                                        <label class="form-label">Numéro</label>
                                    </div>
                                </div>
								<div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea class="form-control" name="content" id="ckeditor" required><?php echo $content;?></textarea>
                                        <label class="form-label">Content</label>
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
    