<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Création rapports</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Création rapports</li>
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
                                <strong>Création rapports</strong></h2>
                         
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Societes/rapports/'.$societe_id);?>">
							
								<?php $societess=$this->md_commun->fetch('projets',array('etat'=>1),'asc',100,0);?>
								<div class="form-group default-select select2Style">
                                    <select class="form-control select2" multiple="" data-placeholder="Select" name="projet_id">
										<?php if($societess){foreach($societess as $soss){?>
                                            <option value="<?php echo $soss->id;?>"><?php echo $soss->projets;?></option>
										<?php }}?>
                                    </select>
                                </div>
								<div class="form-group form-float ">
										<div class="form-line">
											<textarea class="form-control" name="content"></textarea>
											<label class="form-label">Remarque</label>
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
    