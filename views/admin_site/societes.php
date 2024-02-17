<script type="text/javascript">
    function areyousure()
    {
        return confirm('Êtes-vous sûr de vouloir supprimer cet entreprise ?');
    }
</script>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Entreprises</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Entreprises</li>
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
                                <strong>Entreprises</strong>
								<a href="<?php echo admin_url('Societes/form/');?>" class="btn bg-blue waves-effect" style="float:right"><i class="fa fa-plus" style="padding-top: 5px;font-size: 16px;"></i> Ajouter</a>
							</h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="tableExport"
                                    class="display table table-hover table-checkable order-column m-t-20 width-per-100">
                                    <thead>
                                        <tr>
                                            <th>Entreprises</th>
											<th>Lots</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if($societes){foreach($societes as $societe){?>
                                        <tr>
                                            <td><?php echo $societe->societes;?></td>
											<td><?php $trav_id=$this->md_commun->get_row('travaux',array('id'=>$societe->travaux_id)); if($trav_id) echo $trav_id->travaux; else '-';?></td>
                                            <td width="370">
												<a href="<?php echo admin_url('Societes/contacts/'.$societe->id);?>" class="btn bg-amber waves-effect"><i class="fas fa-user-friends"></i> <span class="btn_desctopp">Contacts</span></a>
												<a href="<?php echo admin_url('Societes/form/'.$societe->id);?>" class="btn bg-teal waves-effect"><i class="fas fa-pen"></i> <span class="btn_desctopp">Modifier</span></a>
												<a href="<?php echo admin_url('Societes/delete/'.$societe->id);?>" class="btn bg-red waves-effect"onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')"><i class="fas fa-trash-alt"></i> <span class="btn_desctopp">Supprimer</span></a>
												<?php /*<a href="<?php echo admin_url('Societes/rapports/'.$societe->id);?>" target="_blank" class="btn bg-orange waves-effect"><i class="fas fa-download"></i> <span class="btn_desctopp">Rapports</span></a>
												<a href="<?php echo admin_url('Societes/all_rapports/'.$societe->id);?>" target="_blank" class="btn bg-warning waves-effect"><i class="fas fa-list"></i> <span class="btn_desctopp">Tous Rapports</span></a>
												*/?>
											</td>
                                        </tr>
                                    <?php }}?>    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Entreprises</th>
											<th>Lots</th>
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
   