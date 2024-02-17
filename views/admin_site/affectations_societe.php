<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Affectations travaux</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
							<li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('projets');?>">
                                    <i class="fas fa-home"></i> projets</a>
                            </li>
                            <li class="breadcrumb-item active">Affectations travaux</li>
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
                                <strong>Affectations travaux</strong></h2>
                         
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Projets/affectation_societe/' . $projet_id.'/'.$travaux_id);?>">
								
								<div class="form-group default-select select2Style">
                                        <select class="form-control select2" multiple="" data-placeholder="Select" name="societe_id[]">
										<?php if($societes){foreach($societes as $sos){?>
                                            <option value="<?php echo $sos->id;?>" <?php if($societe_id){ if(in_array($sos->id, $societe_id)) echo 'selected'; }?>><?php echo $sos->societes;?></option>
										<?php }}?>
                                        </select>
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
    