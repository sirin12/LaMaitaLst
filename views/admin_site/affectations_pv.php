<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Affectations pv</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
							<li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('Pv');?>"> Pv N° <?php echo $numero;?></a>
                            </li>
                            <li class="breadcrumb-item active">Affectations pv</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Basic Validation -->
            <?php /*<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Affectations pv</strong></h2>
                         
                        </div>
                        <div class="body">
							<form id="form_validation" method="POST" action="<?php echo admin_url('Pv/affectations/'.$projet_id.'/'. $pv_id);?>">
								<div class="form-group default-select select2Style">
                                        <select class="form-control select2" multiple="" data-placeholder="Select" name="societe_id[]">
										<?php if($societes){foreach($societes as $trav){?>
                                            <option value="<?php echo $trav->id;?>" <?php if($societe_id){ if(in_array($trav->id, $societe_id)) echo 'selected'; }?>><?php echo $trav->societes;?></option>
										<?php }}?>
                                        </select>
                                </div>
								
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>*/?>
            <!-- #END# Basic Validation -->
			
			            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Lists des affectations</strong>
								<?php /*<a href="<?php echo admin_url('Projets/form/');?>" class="btn bg-blue waves-effect" style="float:right">Ajouter societe</a>*/?>
							</h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="tableExport"
                                    class="display table table-hover table-checkable order-column m-t-20 width-per-100">
                                    <thead>
                                        <tr>
                                            
											<th>Societe</th>
											<th>Contact</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if($pv_societes){foreach($pv_societes as $trav_sos){
										$trav_id=$this->md_commun->get_row('societes',array('id'=>$trav_sos->societe_id));
										if($trav_id){?>
                                        <tr>
                                            <td><?php if($trav_id) echo $trav_id->societes;?></td>
											<td>
											<?php $contacts_societes=$this->md_commun->fetch('contacts',array('societe_id'=>$trav_sos->societe_id,'etat'=>1),'asc',10000,0);
											if($contacts_societes){foreach($contacts_societes as $contact){
												$present=$this->md_commun->get_row('societes_admin_pv_contact',array('pv_id'=>$pv_id,'societe_id'=>$trav_sos->societe_id,'contact_id'=>$contact->id));
												$present_affich='';if($present->etat==1){$present_affich=' (P)';}
												echo $contact->nom.''.$present_affich.'<br>';
											}}?>
											</td>
                                            <td width="200">
												<a href="<?php echo admin_url('Pv/affectation_contact/'.$projet_id.'/'.$pv_id.'/'.$trav_sos->societe_id);?>" class="btn bg-teal waves-effect">Présence</a>
												<a href="<?php echo admin_url('Pv/decisions/'.$projet_id.'/'.$pv_id.'/'.$trav_sos->societe_id);?>" class="btn bg-teal waves-effect">Decisions</a>
											</td>
                                        </tr>
                                    <?php }}}?>    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Societe</th>
											<th>Contact</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>
    </section>
    