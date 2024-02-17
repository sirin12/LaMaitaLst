<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
			      <div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
							<h5 class="text-uppercase">Matieres</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="<?php echo admin_url('Dashboard');?>">Dashboard</a></li>
								<li class="list-inline-item"> Matieres</li>
							</ul>
						</div>
					</div>
				</div>
                 <div class="row">
                    <div class="col-sm-5 col-5">
                       
                    </div>
                </div>
				<div class="content-page">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <table class="table table-striped custom-table m-b-0 datatable">
                                <thead>
                                    <tr>
										<th>Matiere</th>
                                        <th>Class</th>
                                        <th>Coefficient</th>
										<th>Valider</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php if($coefficients){foreach($coefficients as $coefficient){?>
                                    <tr>
										<td><?php $matierid=$this->Matieres_model->get($coefficient->matiere_id);?><?php echo $matierid->name;?></td>
                                        <td><?php $clasid=$this->Class_model->get($coefficient->class_id);?><?php echo $clasid->name;?></td>
										<td><?php echo $coefficient->coefficient;?></td>
										<td><?php if($coefficient->valide==0)echo 'Non';else echo 'Oui';?></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="<?php echo admin_url('Matiere_enseignants/notes/'.$coefficient->id);?>"><i class="fa fa-pencil m-r-5"></i> Notes</a>
                                                </div>
                                            </div>
                                        </td>
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
		<div id="add_coefficient" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter coefficient</h4>
						 <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart($this->config->item('admin_folder') . '/Classs/form_matiere/'.$class); ?>
							<div class="form-group custom-mt-form-group">
								<?php $matieres=$this->Matieres_model->get();?>
								<select name="matiere_id">
									<?php if($matieres){foreach($matieres as $matiere){?>
									<option value="<?php echo $matiere->id;?>"><?php echo $matiere->name;?></option>
									<?php }}?>
								</select>
								<label class="control-label">Matiere <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
							<div class="form-group custom-mt-form-group">
								<input type="hidden" name="class" value="<?php echo $class;?>" />
								<input type="number" name="coefficient" required step=any />
								<label class="control-label">Coefficient <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
							<div class="table-responsive m-t-15">
                                <label class="control-label">Notes</label>
                                <table class="table table-striped custom-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">TD</th>
                                            <th class="text-center">TP</th>
                                            <th class="text-center">Principal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="td" value="1">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="tp" value="1">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="principal" value="1">
                                            </td>
                                            </td>
                                        </tr>
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
		<?php if($coefficient){foreach($coefficients as $coefficient){?>
        <div id="<?php echo 'edit_coefficient'.$coefficient->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Modifier coefficient</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart($this->config->item('admin_folder') . '/Classs/form_matiere/'.$class.'/'.$coefficient->id); ?>
							<div class="form-group custom-mt-form-group">
								<?php $matieres=$this->Matieres_model->get();?>
								<select name="matiere_id">
									<?php if($matieres){foreach($matieres as $matiere){?>
									<option value="<?php echo $matiere->id;?>" <?php if($coefficient->matiere_id==$matiere->id) echo 'selected';?>><?php echo $matiere->name;?></option>
									<?php }}?>
								</select>
								<label class="control-label">Matiere <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
							<div class="form-group custom-mt-form-group">
								<input type="hidden" name="class" value="<?php echo $class;?>" />
								<input type="number" name="coefficient" required step=any value="<?php echo $coefficient->coefficient;?>" />
								<label class="control-label">Coefficient <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
							<div class="table-responsive m-t-15">
                                <label class="control-label">Notes</label>
                                <table class="table table-striped custom-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">TD</th>
                                            <th class="text-center">TP</th>
                                            <th class="text-center">Principal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="td" value="1" <?php if($coefficient->td==1)echo 'checked';?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="tp" value="1" <?php if($coefficient->tp==1)echo 'checked';?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="principal" value="1" <?php if($coefficient->principal==1)echo 'checked';?>>
                                            </td>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary btn-lg mb-3">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		
		<div id="<?php echo 'enseignants_coefficient'.$coefficient->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Modifier Enseignants</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart($this->config->item('admin_folder') . '/Classs/form_enseignant/'.$class.'/'.$coefficient->id); ?>
							<div class="form-group custom-mt-form-group">
								<?php $users=$this->Class_model->get_users_matiere($coefficient->matiere_id);?>
								<select name="enseignants_id">
									<?php if($users){foreach($users as $user){?>
									<?php $user_id=$this->Enseignants_model->get($user->user_id);?>
									<option value="<?php echo $user->user_id;?>" ><?php echo $user_id->nom.' '.$user_id->prenom;?></option>
									<?php }}?>
								</select>
								<label class="control-label">Enseignants <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
				
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary btn-lg mb-3">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		
		
        <div id="<?php echo 'delete_coefficient'.$coefficient->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Effacer coefficient</h4>
                    </div>
                    <div class="modal-body card-box">
                        <p>Voulez-vous vraiment supprimer cela?</p>
                        <div class="m-t-20 text-left">
                            <a href="#" class="btn btn-white" data-dismiss="modal">Fermer</a>
                            <a href="<?php echo admin_url('Classs/delete_matiere/'.$class.'/'.$coefficient->id);?>" class="btn btn-danger">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php }}?>