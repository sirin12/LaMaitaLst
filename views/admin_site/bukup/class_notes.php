<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
			      <div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
							<h5 class="text-uppercase">Etudiants Matieres</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="<?php echo admin_url('Dashboard');?>">Dashboard</a></li>
								<li class="list-inline-item">Etudiants Matieres</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-5 col-5">
					
					<a href="<?php echo admin_url('Classs/matieres/'.$class);?>" class="btn btn-primary btn-rounded" > Retour </a>
					
					</div>
                    <div class="col-sm-7 col-7 text-right m-b-30">
						<button type="button" class="btn btn-primary btn-lg mb-1">Enseignants</button>
						<button type="button" class="btn btn-secondary btn-lg mb-1">Agent administratif	</button>
                    </div>
                </div>
				<div class="content-page">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <table class="table table-striped custom-table m-b-0 datatable">
                                <thead>
                                    <tr>
										<th>Etudiants</th>
                                        <th>Matiere</th>
                                        <th>Class</th>
										<?php if($coiefficient_id->td==1){?><th>Td</th><?php }?>
										<?php if($coiefficient_id->tp==1){?><th>Tp</th><?php }?>
										<?php if($coiefficient_id->principal==1){?><th>Principal</th><?php }?>
										
                                    </tr>
                                </thead>
                                <tbody>
									<?php if($notes){foreach($notes as $note){?>
									<?php $note_admin_id=$this->Etudiants_model->get_note_matiere_admin_etud_id('2020',$note->matiere_id,$note->class_id,$note->etudiants_id) ;?>
                                    <tr>
										<td><?php $enseigid=$this->Etudiants_model->get($note->etudiants_id);?><?php echo $enseigid->nom.' '.$enseigid->prenom;?></td>
										<td><?php $matierid=$this->Matieres_model->get($note->matiere_id);?><?php echo $matierid->name;?></td>
                                        <td><?php $clasid=$this->Class_model->get($note->class_id);?><?php echo $clasid->name;?></td>
										<?php if($coiefficient_id->td!=''){?><th><?php if($note->td!=''){?><button type="button" class="btn btn-primary btn-sm mb-1"><?php echo $note->td;?></button><?php }?><?php if($note_admin_id){?><button type="button" class="btn btn-secondary btn-sm mb-1"><?php echo $note_admin_id->td;?></button><?php }?></th><?php }?>
										<?php if($coiefficient_id->tp!=''){?><th><?php if($note->tp!=''){?><button type="button" class="btn btn-primary btn-sm mb-1"><?php echo $note->tp;?></button><?php }?><?php if($note_admin_id){?><button type="button" class="btn btn-secondary btn-sm mb-1"><?php echo $note_admin_id->tp;?></button><?php }?></th><?php }?>
										<?php if($coiefficient_id->principal!=''){?><th><?php if($note->principal!=''){?><button type="button" class="btn btn-primary btn-sm mb-1"><?php echo $note->principal;?></button><?php }?><?php if($note_admin_id){?><button type="button" class="btn btn-secondary btn-sm mb-1"><?php echo $note_admin_id->principal;?></button><?php }?></th><?php }?>
                                    </tr>
									<?php }}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
			</div>
            </div>
            </div>
        </div>
		
		<div id="add_note" class="modal" role="dialog">
            <div class="modal-dialog" style="max-width:75%">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter note</h4>
						 <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart($this->config->item('admin_folder') . '/Matiere_enseignants/form_note/'.$coiefficient_id->id); ?>
							
							<div class="table-responsive m-t-15">
                                <label class="control-label">Notes</label>
                                <table class="table table-striped custom-table">
                                    <thead>
                                        <tr>
											
                                            <th>Etudiants</th>
											<th>Matiere</th>
											<th>Class</th>
											<?php if($coiefficient_id->td==1){?><th>Td</th><?php }?>
											<?php if($coiefficient_id->tp==1){?><th>Tp</th><?php }?>
											<?php if($coiefficient_id->principal==1){?><th>Principal</th><?php }?>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php $i=0;if($etudiants){foreach($etudiants as $etudiant){$i++;?>
                                        <tr>
											<td><?php $enseigid=$this->Etudiants_model->get($etudiant->etudiant_id);?><?php echo $enseigid->nom.' '.$enseigid->prenom;?></td>
											<td><?php $matierid=$this->Matieres_model->get($coiefficient_id->matiere_id);?><?php echo $matierid->name;?></td>
											<td><?php $clasid=$this->Class_model->get($coiefficient_id->class_id);?><?php echo $clasid->name;?>
											<input type="hidden" name="etudiants_id<?php echo $i;?>" value="<?php echo $etudiant->etudiant_id;?>" >
											<input type="hidden" name="matiere_id<?php echo $i;?>" value="<?php echo $coiefficient_id->matiere_id;?>" >
											<input type="hidden" name="class_id<?php echo $i;?>" value="<?php echo $coiefficient_id->class_id;?>" >
											<input type="hidden" name="id_tr<?php echo $i;?>" value="<?php echo $i;?>" ></td>
											
                                            <?php if($coiefficient_id->td==1){?>
											<td class="text-center">
                                                <input type="number" name="td<?php echo $i;?>" required step=any >
                                            </td>
											<?php }?>
											<?php if($coiefficient_id->tp==1){?>
                                            <td class="text-center">
                                                <input type="number" name="tp<?php echo $i;?>" required step=any>
                                            </td>
											<?php }?>
											<?php if($coiefficient_id->principal==1){?>
                                            <td class="text-center">
                                                <input type="number" name="principal<?php echo $i;?>" required step=any>
                                            </td>
											<?php }?>
                                        </tr>
									<?php }}?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary btn-lg">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		
		<div id="edit_note" class="modal" role="dialog">
            <div class="modal-dialog" style="max-width:75%">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Modifier note</h4>
						 <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart($this->config->item('admin_folder') . '/Matiere_enseignants/form_note_edit/'.$coiefficient_id->id); ?>
							
							<div class="table-responsive m-t-15">
                                <label class="control-label">Notes</label>
                                <table class="table table-striped custom-table">
                                    <thead>
                                        <tr>
											
                                            <th>Etudiants</th>
											<th>Matiere</th>
											<th>Class</th>
											<?php if($coiefficient_id->td==1){?><th>Td</th><?php }?>
											<?php if($coiefficient_id->tp==1){?><th>Tp</th><?php }?>
											<?php if($coiefficient_id->principal==1){?><th>Principal</th><?php }?>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php $in=0;if($notes){foreach($notes as $note){$in++;?>
                                        <tr>
											<td><?php $enseigid=$this->Etudiants_model->get($note->etudiants_id);?><?php echo $enseigid->nom.' '.$enseigid->prenom;?></td>
											<td><?php $matierid=$this->Matieres_model->get($note->matiere_id);?><?php echo $matierid->name;?></td>
											<td><?php $clasid=$this->Class_model->get($note->class_id);?><?php echo $clasid->name;?>
											<input type="hidden" name="etudiants_id<?php echo $in;?>" value="<?php echo $note->etudiants_id;?>" >
											<input type="hidden" name="matiere_id<?php echo $in;?>" value="<?php echo $note->matiere_id;?>" >
											<input type="hidden" name="class_id<?php echo $in;?>" value="<?php echo $note->class_id;?>" >
											<input type="hidden" name="id_tr<?php echo $in;?>" value="<?php echo $in;?>" >
											<input type="hidden" name="id<?php echo $in;?>" value="<?php echo $note->id;?>" ></td>
											
                                            <?php if($coiefficient_id->td==1){?>
											<td class="text-center">
                                                <input type="number" name="td<?php echo $in;?>" required step=any value="<?php echo $note->td;?>" >
                                            </td>
											<?php }?>
											<?php if($coiefficient_id->tp==1){?>
                                            <td class="text-center">
                                                <input type="number" name="tp<?php echo $in;?>" required step=any value="<?php echo $note->tp;?>">
                                            </td>
											<?php }?>
											<?php if($coiefficient_id->principal==1){?>
                                            <td class="text-center">
                                                <input type="number" name="principal<?php echo $in;?>" required step=any value="<?php echo $note->principal;?>">
                                            </td>
											<?php }?>
                                        </tr>
									<?php }}?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary btn-lg">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		
		
		<div id="<?php echo 'validation'.$coiefficient_id->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Valider</h4>
                    </div>
                    <div class="modal-body card-box">
                        <p>Voulez-vous vraiment valider cela?</p>
                        <div class="m-t-20 text-left">
                            <a href="#" class="btn btn-white" data-dismiss="modal">Fermer</a>
                            <a href="<?php echo admin_url('Matiere_enseignants/valider/'.$coiefficient_id->id);?>" class="btn btn-danger">Valider</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>