<?php $sose_id=$this->md_commun->get_row('societes',array('id'=>$societe_id));?>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Rapports societe</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Rapports societe(<?php echo $sose_id->societes?>)</li>
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
                                <strong>Rapports societe(<?php echo $sose_id->societes?>)</strong>
							</h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="tableExport"
                                    class="display table table-hover table-checkable order-column m-t-20 width-per-100">
                                    <thead>
                                        <tr>
                                            <th>Entreprises</th>
											<th>Projets</th>
											<th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if($rapports){foreach($rapports as $rapport){?>
                                        <tr>
                                            <td><?php $sos_id=$this->md_commun->get_row('societes',array('id'=>$rapport->societe_id)); if($sos_id) echo $sos_id->societes; else '-';?></td>
											<td><?php $proj_id=$this->md_commun->get_row('projets',array('id'=>$rapport->projet_id)); if($proj_id) echo $proj_id->projets; else '-';?></td>
                                            <td><?php echo $rapport->date_time;?></td>
											<td width="27%">
												<a href="<?php echo admin_url('Societes/send_email/'.$rapport->societe_id.'/'.$rapport->id);?>" class="btn bg-amber waves-effect"><i class="fas fa-envelope"></i> <span class="btn_desctopp">Email </span>(<?php echo $rapport->nb_envoie;?>)</a>
												<a href="<?php echo admin_url('Societes/rapports_pdf/'.$rapport->societe_id.'/'.$rapport->id);?>" target="_blank" class="btn bg-orange waves-effect"><i class="fas fa-download"></i> <span class="btn_desctopp">Rapports</span></a>
											</td>
                                        </tr>
                                    <?php }}?>    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Entreprises</th>
											<th>Projets</th>
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
   