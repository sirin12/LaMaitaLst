<script type="text/javascript">
    function areyousure()
    {
        return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');
    }
</script>
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
                            <li class="breadcrumb-item active">Projets</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Projets</strong>
								<?php $current_admin = $this->session->userdata('admin');?>
								<?php if($current_admin['super_admin']==1){?>
								<a href="<?php echo admin_url('Projets/form/');?>" class="btn bg-blue waves-effect" style="float:right"><i class="fa fa-plus" style="padding-top: 5px;font-size: 16px;"></i> Ajouter</a>
								<?php }?>
							</h2>
                           
                        </div>
						<!--<button  onclick="Export2Doc(window.docx)">Export</button>-->
                        <div class="body" id="docx">
                            <div class="table-responsive WordSection1" style="min-height:250px">
								
                               <table id="tableExport" class="display table table-hover table-checkable order-column m-t-20 width-per-100">
                                    <?php $id_admin=$current_admin['id'];?>
									<thead>
                                        <tr>
                                            <th>Projets</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if($projets){foreach($projets as $projet){
										
										
										if($current_admin['super_admin']==1){?>
										<tr>
                                            <td><?php echo $projet->projets;?></td>
											
                                            <td width="70%">
											<?php if($projet->etat==1){?>
											<a href="<?php echo admin_url('pv/index/'.$projet->id);?>" class="btn bg-info waves-effect" style="float:right;"><i class="fas fa-address-card"></i> <span class="btn_desctopp">PV</span></a>
											<div class="btn-group dropright" style="float:right;">
												<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="fas fa-download"></i> <span class="btn_desctopp">Rapport</span>
												</button>
												<ul class="dropdown-menu" style="">
													<li>
														<a href="<?php echo admin_url('Projets/rapports/'.$projet->id);?>" target="_blank">Toutes</a>
													</li>
													<li>
														<a href="<?php echo admin_url('Projets/rapports_creer/'.$projet->id);?>" target="_blank">Crées</a>
													</li>
													<li>
														<a href="<?php echo admin_url('Projets/rapports_en_cours/'.$projet->id);?>" target="_blank">En cours</a>
													</li>
													
													<li>
														<a href="<?php echo admin_url('Projets/rapports_valider/'.$projet->id);?>" target="_blank">Validées</a>
													</li>
													<li>
														<a href="<?php echo admin_url('Projets/rapports_urgent/'.$projet->id);?>" target="_blank">Urgentes</a>
													</li>
												</ul>
											</div>
											<?php }?>
											<?php if($projet->etat==1){?>
											<a href="<?php echo admin_url('Projets/delete/'.$projet->id);?>" class="btn bg-red waves-effect" style="float:right;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')"><i class="fas fa-trash-alt"></i> <span class="btn_desctopp">Supprimer</span></a>
											<?php }else{?>
											<a href="<?php echo admin_url('Projets/deleterejoint/'.$projet->id);?>" class="btn bg-red waves-effect" style="float:right;" onclick="return areyousure();"><i class="fas fa-trash-alt"></i> <span class="btn_desctopp">Rejoindre</span></a>
											<?php }?>
											<?php if($projet->etat==1){?>
											<a href="<?php echo admin_url('Projets/form/'.$projet->id);?>" class="btn bg-teal waves-effect" style="float:right;"><i class="fas fa-pen"></i> <span class="btn_desctopp">Modifier</span></a>
											<a href="<?php echo admin_url('Projets/blocs/'.$projet->id);?>" class="btn bg-amber waves-effect" style="float:right;"><i class="fas fa-tasks"></i> <span class="btn_desctopp">Bloc</span></a>
											<a href="<?php echo admin_url('Projets/affectations/'.$projet->id);?>" class="btn bg-info waves-effect" style="float:right;"><i class="fas fa-list"></i> <span class="btn_desctopp">Affect</span></a>
											<a href="<?php echo admin_url('Projets/form_correction_ajout/'.$projet->id);?>" class="btn bg-success waves-effect" style="float:right;"><i class="fas fa-list"></i> <span class="btn_desctopp">Correction</span></a>

											<?php }?>
											</td>
                                        </tr>
										<?php }else{
										if($current_admin['type_admin']!=3){
											$admin_projet=$this->md_commun->get_row('projets_admin',array('projet_id'=>$projet->id,'admin_id'=>$id_admin));
										}else{
											$admin_projet=$this->md_commun->get_row('projets_societe_admin',array('projet_id'=>$projet->id,'admin_id'=>$id_admin));	
										}?>
                                        <?php if($admin_projet){?>
										<tr>
                                            <td><?php echo $projet->projets;?></td>
											<?php if($current_admin['type_admin']==1){?>
                                            <td width="70%">
											<?php }else{?>
											<td width="10%">
											<?php }?>
											<div class="btn-group " style="float:right;">
												<a href="<?php echo admin_url('Projets/rapports/'.$projet->id);?>" target="_blank" class="btn bg-orange
												waves-effect" style="color:#fff;">Rapports</a>
											</div>
											<?php if($current_admin['type_admin']==1){?>
											<a href="<?php echo admin_url('Projets/form/'.$projet->id);?>" class="btn bg-teal waves-effect" style="float:right;"><i class="fas fa-pen"></i> <span class="btn_desctopp">Modifier</span></a>
											<a href="<?php echo admin_url('Projets/blocs/'.$projet->id);?>" class="btn bg-amber waves-effect" style="float:right;"><i class="fas fa-tasks"></i> <span class="btn_desctopp">Bloc</span></a>
											<a href="<?php echo admin_url('Projets/affectations/'.$projet->id);?>" class="btn bg-info waves-effect" style="float:right;"><i class="fas fa-list"></i> <span class="btn_desctopp">Affect</span></a>
											<?php }?>
											</td>
                                        </tr>
										<?php }?>
										<?php }?>
                                    <?php }}?>    
                                    </tbody>
                                  
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>
    </section>
   