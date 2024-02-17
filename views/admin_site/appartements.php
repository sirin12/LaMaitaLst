<script type="text/javascript">
    function areyousure()
    {
        return confirm('Êtes-vous sûr de vouloir supprimer cet local ?');
    }
</script>
<?php $current_admin = $this->session->userdata('admin');?>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Locaux</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                <i class="fas fa-home"></i> Dashboard</a>
                            </li>
							<li class="breadcrumb-item bcrumb-1">
								<?php $pr_id=$this->md_commun->get_row('projets',array('id'=>$projet_id));?>
                                <a href="<?php echo admin_url('Projets');?>"><?php echo $pr_id->projets;?></a>
                            </li>
							<li class="breadcrumb-item bcrumb-1">
								<?php $bl_id=$this->md_commun->get_row('blocs',array('id'=>$blocs_id));?>
                                <a href="<?php echo admin_url('Projets/blocs/'.$projet_id);?>"><?php echo $bl_id->blocs;?></a>
                            </li>
							<li class="breadcrumb-item bcrumb-1">
								<?php $et_id=$this->md_commun->get_row('etages',array('id'=>$etages_id));?>
                                <a href="<?php echo admin_url('Projets/Etages/'.$projet_id.'/'.$blocs_id);?>"><?php echo $et_id->etages;?></a>
                            </li>
                            <li class="breadcrumb-item active">Locaux</li>
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
                                <strong>Locaux</strong>
								<a href="<?php echo admin_url('Projets/form_appartements/'.$projet_id.'/'.$blocs_id.'/'.$etages_id);?>" class="btn bg-blue waves-effect" style="float:right"><i class="fa fa-plus" style="padding-top: 5px;font-size: 16px;"></i> Ajouter</a>
							</h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="tableExport"
                                    class="display table table-hover table-checkable order-column m-t-20 width-per-100">
                                    <thead>
                                        <tr>
											<th>Projets</th>
											<th>Blocs</th>
											<th>Etages</th>
                                            <th>Locaux</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if($appartements){foreach($appartements as $app){?>
                                        <tr>
											<td><?php echo $pr_id->projets;?></td>
											<td><?php echo $bl_id->blocs;?></td>
											<td><?php echo $et_id->etages;?></td>
                                            <td><?php echo $app->appartements;?></td>
                                            <td width="500">
											<?php if($app->etat==1){?>
                                                <a href="<?php echo admin_url('Projets/corrections/'.$projet_id.'/'.$blocs_id.'/'.$etages_id.'/'.$app->id);?>" class="btn bg-info waves-effect"><i class="fas fa-list"></i> <span class="btn_desctopp">Corrections</span></a>

											<a href="<?php echo admin_url('Projets/corrections_archive/'.$projet_id.'/'.$blocs_id.'/'.$etages_id.'/'.$app->id);?>" class="btn bg-secondary waves-effect"><i class="fas fa-list"></i> <span class="btn_desctopp">Corrections Archivées</span></a>
											<a href="<?php echo admin_url('Projets/form_appartements/'.$projet_id.'/'.$blocs_id.'/'.$etages_id.'/'.$app->id);?>" class="btn bg-teal waves-effect"><i class="fas fa-pen"></i> <span class="btn_desctopp">Modifier</span></a>
											<a href="<?php echo admin_url('Projets/delete_appartements/'.$projet_id.'/'.$blocs_id.'/'.$etages_id.'/'.$app->id);?>" class="btn bg-red waves-effect" onclick="return areyousure();"><i class="fas fa-trash-alt"></i> <span class="btn_desctopp">Supprimer</span></a>
											<a href="<?php echo admin_url('Projets/rapports_tt/'.$projet_id.'/'.$blocs_id.'/'.$etages_id.'/'.$app->id);?>"  class="btn btn-warning waves-effect" target="_blank"><i class="fas fa-download"></i> <span class="btn_desctopp">Rapport</span></a>
											<?php }else{ if($current_admin['super_admin']==1){?>
											<a href="<?php echo admin_url('Projets/delete_appartements_joint/'.$projet_id.'/'.$blocs_id.'/'.$etages_id.'/'.$app->id);?>" class="btn bg-red waves-effect" onclick="return areyousure();"><i class="fas fa-trash-alt"></i> <span class="btn_desctopp" >Rejoindre</span></a>
											<?php }}?>
											</td>
                                        </tr>
                                    <?php }}?>    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Locaux</th>
											<th>Projets</th>
											<th>Blocs</th>
											<th>Etages</th>
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
   