<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Pv</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Pv</li>
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
                                <strong>Pv</strong>
								<?php $current_admin = $this->session->userdata('admin');?>

								<?php if($current_admin['super_admin']==1){?>
								<a href="<?php echo admin_url('pv/form/'.$projet_id);?>" class="btn bg-blue waves-effect" style="float:right"><i class="fa fa-plus" style="padding-top: 5px;font-size: 16px;"></i> Ajouter</a>
								<?php }?>
							</h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="tableExport"
                                    class="display table table-hover table-checkable order-column m-t-20 width-per-100">
                                    <thead>
                                        <tr>
											<th>PV N°</th>
											<th>Projet</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if($pvs){foreach($pvs as $pv){?>
                                        <tr>
											<td><?php echo $pv->numero;?></td>
											<td><?php $projid=$this->md_commun->get_row('projets',array('id'=>$pv->projet_id));echo $projid->projets;?></td>
                                            <td><?php echo $pv->date;?></td>
                                            <td width="400">
											<?php if($current_admin['super_admin']==1){?>
											<a href="<?php echo admin_url('pv/form/'.$projet_id.'/'.$pv->id);?>" class="btn bg-teal waves-effect">Modifier</a>
											<a href="<?php echo admin_url('pv/affectations/'.$projet_id.'/'.$pv->id);?>" class="btn bg-amber waves-effect">Affect</a>
											<a href="<?php echo admin_url('pv/delete/'.$projet_id.'/'.$pv->id);?>" class="btn bg-red waves-effect" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')">Supprimer</a>
											<?php }?>
											<a href="<?php echo admin_url('pv/rapports/'.$projet_id.'/'.$pv->id);?>" class="btn btn-warning waves-effect" target="_blank">Rapports</a>
											
											</td>
                                        </tr>
                                    <?php }}?>    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>PV N°</th>
											<th>Projet</th>
                                            <th>Date</th>
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
   