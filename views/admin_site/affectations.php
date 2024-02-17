<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Affectations lots</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
							<li class="breadcrumb-item bcrumb-1">
								<?php $pr_id=$this->md_commun->get_row('projets',array('id'=>$projet_id));?>
                                <a href="<?php echo admin_url('Projets');?>"><?php echo $pr_id->projets;?></a>
                            </li>
                            <li class="breadcrumb-item active">Affectations lots</li>
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
                                <strong>Affectations lots</strong></h2>
                         
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Projets/affectations/' . $projet_id);?>">
								
								<div class="form-group default-select select2Style">
                                        <select class="form-control select2" multiple="" data-placeholder="Select" name="travaux_id[]">
										<?php if($traveaus){foreach($traveaus as $trav){?>
                                            <option value="<?php echo $trav->id;?>" <?php if($travaux_id){ if(in_array($trav->id, $travaux_id)) echo 'selected'; }?>><?php echo $trav->travaux;?></option>
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
                                            <th>Lots</th>
											<th>Entreprises</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if($traveaux_societes){foreach($traveaux_societes as $trav_sos){?>
                                        <tr>
                                            <td><?php $trav_id=$this->md_commun->get_row('travaux',array('id'=>$trav_sos->travaux_id));echo $trav_id->travaux;?></td>
											<td>
											<?php $travaux_societes=$this->md_commun->fetch('travaux_societe',array('travaux_id'=>$trav_sos->travaux_id,'projet_id'=>$trav_sos->projet_id),'asc',10000,0);
											if($travaux_societes){foreach($travaux_societes as $trsos){
												$soc_id=$this->md_commun->get_row('societes',array('id'=>$trsos->societe_id));if($soc_id)echo $soc_id->societes.'-';
											}}?>
											</td>
                                            <td width="100">
											<a href="<?php echo admin_url('Projets/affectation_societe/'.$projet_id.'/'.$trav_id->id);?>" class="btn bg-teal waves-effect">Modifier</a></td>
                                        </tr>
                                    <?php }}?>    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Lots</th>
											<th>Entreprises</th>
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
    