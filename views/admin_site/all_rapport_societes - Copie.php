<script type="text/javascript">
    function areyousure()
    {
        return confirm('Êtes-vous sûr de vouloir supprimer cet rapport ?');
    }
</script>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">All rapports </h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">All rapports </li>
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
                                <strong>All rapports </strong>
								<a href="<?php echo admin_url('Rapport_societe/form/');?>" class="btn bg-blue waves-effect" style="float:right"><i class="fa fa-plus" style="padding-top: 5px;font-size: 16px;"></i> Ajouter</a>
							</h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="tableExport"
                                    class="display table table-hover table-checkable order-column m-t-20 width-per-100">
                                    <thead>
                                        <tr>
											<th>Sujet</th>
											<th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if($rapports){foreach($rapports as $rapport){?>
                                        <tr>
											<td><?php echo $rapport->sujet;?></td>
                                            <td><?php echo $rapport->date_time;?></td>
											<td width="390">
												<a href="<?php echo admin_url('Rapport_societe/send_email/'.$rapport->id);?>" class="btn bg-amber waves-effect"><i class="fas fa-envelope"></i> <span class="btn_desctopp">Contacts </span>(<?php echo $rapport->nb_envoie;?>)</a>
												<a href="<?php echo admin_url('Rapport_societe/rapports_pdf/'.$rapport->id);?>" target="_blank" class="btn bg-orange waves-effect"><i class="fas fa-download"></i> <span class="btn_desctopp">Rapports</span></a>
												<a href="<?php echo admin_url('Rapport_societe/delete/'.$rapport->id);?>" class="btn bg-red waves-effect" onclick="return areyousure();"><i class="fas fa-trash-alt"></i> <span class="btn_desctopp" >Supprimer</span></a>
											</td>
                                        </tr>
                                    <?php }}?>    
                                    </tbody>
                                    <tfoot>
                                        <tr>
											<th>Sujet</th>
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
   