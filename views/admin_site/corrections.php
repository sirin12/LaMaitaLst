<script type="text/javascript">
    function areyousure()
    {
        return confirm('Êtes-vous sûr de vouloir supprimer cet local ?');
    }
</script>
<?php $current_admin = $this->session->userdata('admin');?>
<style>.btn_desctopp{display:block !important; top:-7px;}.btn{min-height:40px;}</style>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Corrections</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Corrections</li>
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
                                <strong>Corrections</strong>
								<a href="<?php echo admin_url('Corrections/form/');?>" class="btn bg-blue waves-effect" style="float:right"><i class="fa fa-plus" style="padding-top: 5px;font-size: 16px;"></i> Ajouter</a>
							</h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="tableExport"
                                    class="display table table-hover table-checkable order-column m-t-20 width-per-100">
                                    <thead>
                                        <tr>
											<th width="60">Date</th>
                                            <th width="60">id</th>
                                            <th>Corrections</th>
											<th>Urgence</th>
											<th width="65">Etat </th>
                                            <th width="350">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if($corrections){foreach($corrections as $cor){
										$projrow=$this->md_commun->get_row('projets',array('id'=>$cor->projet_id)); $projet_name='';if($projrow) $projet_name=$projrow->projets;
										$approw=$this->md_commun->get_row('appartements',array('id'=>$cor->appartements_id));$app_name='';if($approw) $app_name=$approw->appartements;?>
                                        <tr>
											<td><?php echo $cor->date_time;?></td>
                                            <td><?php echo $cor->id;?></td>
                                            <td><?php echo $cor->intitile.'<br><b>'.$projet_name.' -> '.$app_name.'</b>';?></td>
											<td><?php if($cor->etat_urgent==1){?><span class="label bg-green shadow-style">Non</span><?php }else{?><span class="label bg-red shadow-style">Oui</span><?php }?></td>
											<td><?php if($cor->etat_correction==1){?><span class="feedLblStyle lblFileStyle">Crée</span><?php }elseif($cor->etat_correction==4){?><span class="feedLblStyle lblReplyStyle">En-cours</span><?php }elseif($cor->etat_correction==2){?><span class="feedLblStyle lblCommentStyle">Corrigée</span><?php }elseif($cor->etat_correction==3){?><span class="feedLblStyle lblTaskStyle" style="color:blue;border-color:blue">Validé</span><?php }?></td>
                                            <td>
											<a href="<?php echo admin_url('Corrections/send_email/'.$cor->id);?>" class="btn bg-amber waves-effect"><i class="fas fa-envelope"></i> <span class="btn_desctopp">Email(<?php echo $cor->nb_envoie?>)</span></a>
											<?php /*<a href="<?php echo admin_url('Corrections/historiques/'.$cor->id);?>" class="btn bg-blue  waves-effect"><i class="fas fa-history"></i> <span class="btn_desctopp">Historique</span></a>*/?>
											<a href="<?php echo admin_url('Corrections/form/'.$cor->id);?>" class="btn bg-teal waves-effect"><i class="fas fa-pen"></i> <span class="btn_desctopp">Modifier</span></a>
											<a href="<?php echo admin_url('Corrections/delete/'.$cor->id);?>" class="btn bg-red waves-effect" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')"><i class="fas fa-trash-alt"></i> <span class="btn_desctopp">Supprimer</span></a>
											</td>
                                        </tr>
                                    <?php }}?>    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th width="60">Date</th>
                                            <th>Corrections</th>
											<th>Urgence</th>
											<th>Etat </th>
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
   