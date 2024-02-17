<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Envoie email</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Envoie email</li>
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
                                <strong>Envoie email</strong></h2>
                         
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Corrections/send_email/'.$corre_id);?>">
							
								<?php $corrections_id=$this->md_commun->get_row('corrections',array('id'=>$corre_id));
								$societess=$this->md_commun->fetch('societes',array('id'=>$corrections_id->societe_id),'asc',100,0);?>
								<div class="form-group default-select select2Style">
                                        <select class="form-control select2" multiple="" data-placeholder="Select" name="societe_id[]">
										<?php if($societess){foreach($societess as $soss){?>
                                            <option value="<?php echo $soss->id;?>"><?php echo $soss->email;?></option>
										<?php }}?>
                                        </select>
                                </div>
								<div class="form-group form-float col-md-12">
										<div class="form-line">
											<input type="text" class="form-control" name="email" value="" required>
											<label class="form-label">Email CC(separer par ;)</label>
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
    