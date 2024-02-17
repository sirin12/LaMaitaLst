<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Affectations contact</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
							<li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('Pv/index/'.$pv_id);?>"> PV  N° <?php echo $numero;?></a>
                            </li>
							
                            <li class="breadcrumb-item active">Affectations contact</li>
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
                                <strong>Affectations contact</strong></h2>
                         
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Pv/affectation_contact/'.$projet_id.'/' . $pv_id.'/'. $societe_id);?>">
								<div class="form-group default-select select2Style">
                                        <select class="form-control select2" multiple="" data-placeholder="Select" name="contact_id[]">
										<?php if($pv_contacts){foreach($pv_contacts as $trav){
											$contact=$this->md_commun->get_row('contacts',array('id'=>$trav->contact_id));?>
                                            <option value="<?php echo $trav->contact_id;?>" <?php if($contact_id){ if(in_array($trav->contact_id, $contact_id)) echo 'selected'; }?>>
												<?php echo $contact->nom;?>
											</option>
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
    