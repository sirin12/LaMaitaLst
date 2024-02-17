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
                            <li class="breadcrumb-item bcrumb-1">
								<?php $app_id=$this->md_commun->get_row('appartements',array('id'=>$appartements_id));?>
                                <a href="<?php echo admin_url('Projets/appartements/'.$projet_id.'/'.$blocs_id.'/'.$etages_id);?>"><?php echo $app_id->appartements;?></a>
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
								<a href="<?php echo admin_url('projets/form_correction/'.$projet_id.'/'.$bloc_id.'/'.$etage_id.'/'.$appartements_id);?>" class="btn bg-blue waves-effect" style="float:right"><i class="fa fa-plus" style="padding-top: 5px;font-size: 16px;"></i> Ajouter</a>
							</h2>


                            
                           
                        </div>

                        <div class="body">
                        <form id="" action="<?php echo admin_url('Projets/corrections_search/'.$projet_id.'/'.$blocs_id.'/'.$etages_id.'/'.$appartements_id);?>" method="get">
                            <div class="row" >
                               
                                <div class="col-lg-4">
                                <label>Correction</label>
                                    <input type="text" class="input_header" name="correction" id="" placeholder="correction ..." />
                                </div>
                               
                                <div class="col-lg-4">
                                    <label>Lot</label>
                                    <select class="input_header" name="lot" id="">
                                    <option value=""></option>
                                        <?php foreach ($lots as $lot) : ?>
                                            <option value="<?php echo $lot->id; ?>"><?php echo $lot->travaux; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                
                                <div class="col-lg-4">
                                <label>Localisation</label>
                                    <input type="text" class="input_header" name="localisation" id="" placeholder="localisation ..." />
                                </div>
                            </div>
                           
                            <div class="row" >
                           
                                <div class="col-lg-4">
                                <label>Urgence</label>
                                <select class="input_header" name="urgence" id="">
                                <option value=""></option>
                                    <option value="1">Non</option>
                                    <option value="2">Oui</option>
                                </select>
                                </div>
                               
                                <div class="col-lg-4">
                                <label>Etat</label>
                                <select class="input_header" name="etat" id="">
                                <option value=""></option>
                                    <option value="1">Créé</option>
                                    <option value="2">Corrigé</option>
                                    <option value="3">Validé</option>
                                    <option value="4">En cours</option>
                                </select>
                                </div>
                                
                                <div class="col-lg-4">
                                <label>Date</label>
                                    <input type="date" class="input_header" name="date" id="" placeholder="date ..." />
                                </div>
                            </div>
                            
                          <button type="submit" title="Rechercher" class="btn_header"><i class="fa fa-search"></i></button>
                        </form>
                            <div class="table-responsive">
                                <table id="tableExport"
                                    class="display table table-hover table-checkable order-column m-t-20 width-per-100">
                                    <thead>
                                        <tr>
											<th width="60">Date</th>
                                            <th>id</th>
                                            <th>Corrections</th>
                                            <th>Lots</th>
                                            <th>Localisation</th>
											<th>Urgence</th>
											<th width="65">Etat </th>
                                            <th width="350">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if($corrections){foreach($corrections as $cor){
										$projrow=$this->md_commun->get_row('projets',array('id'=>$cor->projet_id)); $projet_name='';if($projrow) $projet_name=$projrow->projets;
										$approw=$this->md_commun->get_row('appartements',array('id'=>$cor->appartements_id));$app_name='';if($approw) $app_name=$approw->appartements;
                                        $lot=$this->md_commun->get_row('travaux',array('id'=>$cor->travaux_id)) ;?>
                                
                                        <tr>
											<td><?php echo $cor->date_time;?></td>
                                            <td><?php echo $cor->id;?></td>
                                            <td><?php echo $cor->intitile.'<br><b>'.$projet_name.' -> '.$app_name.'</b>';?></td>
                                            <td><?php echo $lot->travaux; ?></td>
                                            <td><?php echo $cor->localisation; ?></td>
											<td><?php if($cor->etat_urgent==1){?><span class="label bg-green shadow-style">Non</span><?php }else{?><span class="label bg-red shadow-style">Oui</span><?php }?></td>
											<td><?php if($cor->etat_correction==1){?><span class="feedLblStyle lblFileStyle">Crée</span><?php }elseif($cor->etat_correction==4){?><span class="feedLblStyle lblReplyStyle">En-cours</span><?php }elseif($cor->etat_correction==2){?><span class="feedLblStyle lblCommentStyle">Corrigée</span><?php }elseif($cor->etat_correction==3){?><span class="feedLblStyle lblTaskStyle" style="color:blue;border-color:blue">Validé</span><?php }?></td>
                                            <td>
											<a href="<?php echo admin_url('projets/form_correction/'.$projet_id.'/'.$bloc_id.'/'.$etage_id.'/'.$appartements_id.'/'.$cor->id);?>" class="btn bg-teal waves-effect"><i class="fas fa-pen"></i> <span class="btn_desctopp">Modifier</span></a>
											<a href="<?php echo admin_url('projets/delete_correction/'.$projet_id.'/'.$bloc_id.'/'.$etage_id.'/'.$appartements_id.'/'.$cor->id);?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')" class="btn bg-red waves-effect"><i class="fas fa-trash-alt"></i> <span class="btn_desctopp">Supprimer</span></a>
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
   