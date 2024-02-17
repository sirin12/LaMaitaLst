<script type="text/javascript">
    function areyousure()
    {
        return confirm('Êtes-vous sûr de vouloir rejoindre ce projet ?');
    }
</script>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Projets achevés</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Projets achevés</li>
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
                                <strong>Projets achevés</strong>
								<?php $current_admin = $this->session->userdata('admin');?>
							
							</h2>
                           
                        </div>
						<!--<button  onclick="Export2Doc(window.docx)">Export</button>-->
                        <div class="body" id="docx">
                            <div class="table-responsive WordSection1" style="min-height:250px">
								
                               <table id="tableExport" class="display table table-hover table-checkable order-column m-t-20 width-per-100">
                                    <?php $id_admin=$current_admin['id'];?>
									<thead>
                                        <tr>
                                            <th>Projets achevés</th>
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
											<a href="<?php echo admin_url('Projets/delete/'.$projet->id);?>" class="btn bg-red waves-effect" style="float:right;" onclick="return areyousure();"><i class="fas fa-trash-alt"></i> <span class="btn_desctopp">Supprimer</span></a>
											<?php }else{?>
											<a href="<?php echo admin_url('Projets/deleterejoint/'.$projet->id);?>" class="btn bg-red waves-effect" style="float:right;" onclick="return areyousure();"><i class="fas fa-trash-alt"></i> <span class="btn_desctopp">Rejoindre</span></a>
											<?php }?>
											
											</td>
                                        </tr>
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
   