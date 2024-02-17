    <style>
	@media (min-width: 576px){
		.modal-dialog {
			max-width:675px;
		}
	}
	</style>
	<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
			<div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
						<h5 class="text-uppercase">Users</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="<?php echo admin_url('Dashboard');?>">Dashboard</a></li>
								<li class="list-inline-item">Users</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-4 col-4">
                      
                    </div>
                    <div class="col-sm-8 col-8 text-right m-b-30">
                        <a href="#" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Ajouter User</a>
                    </div>
                </div>
				<div class="content-page">
					
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th style="width:30%;">Nom</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Matricule</th>
                                        <th>Role</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php if($users){foreach($users as $user){?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo admin_url('Users/form/'.$user->id);?>" class="avatar"><?php echo $user->prenom[0];?></a>
                                            <h2><a href="<?php echo admin_url('Users/form/'.$user->id);?>"><?php echo $user->prenom.' '.$user->nom;?></a></h2>
                                        </td>
                                        <td><?php echo $user->email;?></td>
                                        <td><?php echo $user->phone;?></td>
                                        <td><?php echo $user->matricule;?></td>
                                        <td>
											<?php if($user->role==1){?><span class="badge badge-danger-border">Administrateur</span>
											<?php }elseif($user->role==2){?><span class="badge badge-warning-border">Agent administratif</span>
											<?php }elseif($user->role==3){?><span class="badge badge-success-border">Secrétaire générale</span>
											<?php }elseif($user->role==4){?><span class="badge badge-info-border">Chef de départements</span><?php }?>
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="<?php echo '#edit_user'.$user->id;?>"><i class="fa fa-pencil m-r-5"></i> Modifier</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="<?php echo '#delete_user'.$user->id;?>"><i class="fa fa-trash-o m-r-5"></i> Effacer</a>
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
		<div id="add_user" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter User</h4>
						 <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="m-b-30">
						<?php echo form_open_multipart($this->config->item('admin_folder') . '/Users/form/'); ?>
                            <div class="row">
                                <div class="col-sm-6">
									<div class="form-group custom-mt-form-group">
										<input type="text" name="nom" required />
										<label class="control-label">Nom <span class="text-danger">*</span></label><i class="bar"></i>
									</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group custom-mt-form-group">
										<input type="text" name="prenom" required  />
										<label class="control-label">Prénom <span class="text-danger">*</span></label><i class="bar"></i>
									</div>
                                </div>
                                <div class="col-sm-6">
									<div class="form-group custom-mt-form-group">
										<input type="text" name="matricule" required />
										<label class="control-label">Matricule <span class="text-danger">*</span></label><i class="bar"></i>
									</div>
                                </div>
                                <div class="col-sm-6">
									<div class="form-group custom-mt-form-group">
										<input type="email" name="email" required />
										<label class="control-label">Email <span class="text-danger">*</span></label><i class="bar"></i>
									</div>
                                </div>
                                <div class="col-sm-6">
									<div class="form-group custom-mt-form-group">
										<input type="password" name="password" required />
										<label class="control-label">Password <span class="text-danger">*</span></label><i class="bar"></i>
									</div>
                                </div>
                                <div class="col-sm-6">
									<div class="form-group custom-mt-form-group">
										<input type="text" name="phone" required />
										<label class="control-label">Téléphone <span class="text-danger">*</span></label><i class="bar"></i>
									</div>
                                </div>
                                <div class="col-sm-6">
									<div class="form-group custom-mt-form-group">
										<select name="role">
											
											<option value="1">Administrateur</option>
                                            <option value="2">Agent administratif</option>
                                            <option value="3">Secrétaire générale</option>
											<option value="4">Chef de départements</option>
										 </select>
										 <label class="control-label">Role</label><i class="bar"></i>
									</div>	
                                </div>
                            </div>
                            <div class="table-responsive m-t-15">
                                <label class="control-label">Permission</label>
                                <table class="table table-striped custom-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Lecture</th>
                                            <th class="text-center">Écriture</th>
                                            <th class="text-center">Créeation</th>
                                            <th class="text-center">Suppression</th>
                                            <th class="text-center">Ticket</th>
											<th class="text-center">Note</th>
											<th class="text-center">Note2</th>
											<th class="text-center">Affectation</th>
                                            <th class="text-center">Exportation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="lecture" value="1">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="ecriture" value="1">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="creation" value="1">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="suppression" value="1">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="ticket" value="1">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="note" value="1">
                                            </td>
											<td class="text-center">
                                                <input type="checkbox" name="note2" value="1">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="affectation" value="1">
                                            </td>
											<td class="text-center">
                                                <input type="checkbox" name="export" value="1">
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
        </div>
		<?php if($users){foreach($users as $user){?>
        <div id="<?php echo 'edit_user'.$user->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit User</h4>
						 <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
						<div class="m-b-30">
						<?php echo form_open_multipart($this->config->item('admin_folder') . '/Users/form/'.$user->id); ?>
                            <div class="row">
                                <div class="col-sm-6">
									<div class="form-group custom-mt-form-group">
										<input type="text" name="nom" required value="<?php echo $user->nom;?>" />
										<label class="control-label">Nom <span class="text-danger">*</span></label><i class="bar"></i>
									</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group custom-mt-form-group">
										<input type="text" name="prenom" required value="<?php echo $user->prenom;?>" />
										<label class="control-label">Prénom <span class="text-danger">*</span></label><i class="bar"></i>
									</div>
                                </div>
                                <div class="col-sm-6">
									<div class="form-group custom-mt-form-group">
										<input type="text" name="matricule" required  value="<?php echo $user->matricule;?>"/>
										<label class="control-label">Matricule <span class="text-danger">*</span></label><i class="bar"></i>
									</div>
                                </div>
                                <div class="col-sm-6">
									<div class="form-group custom-mt-form-group">
										<input type="email" name="email" required  value="<?php echo $user->email;?>"/>
										<label class="control-label">Email <span class="text-danger">*</span></label><i class="bar"></i>
									</div>
                                </div>
                                <div class="col-sm-6">
									<div class="form-group custom-mt-form-group">
										<input type="text" name="phone" required  value="<?php echo $user->phone;?>"/>
										<label class="control-label">Téléphone <span class="text-danger">*</span></label><i class="bar"></i>
									</div>
                                </div>
                                <div class="col-sm-6">
									<div class="form-group custom-mt-form-group">
										<select name="role">
											<option value="1" <?php if($user->role==1){echo 'selected';}?>>Administrateur</option>
                                            <option value="2" <?php if($user->role==2){echo 'selected';}?>>Agent administratif</option>
                                            <option value="3" <?php if($user->role==3){echo 'selected';}?>>Secrétaire générale</option>
											<option value="4" <?php if($user->role==4){echo 'selected';}?>>Chef de départements</option>
										 </select>
										 <label class="control-label">Role</label><i class="bar"></i>
									</div>	
                                </div>
								<div class="col-sm-6">
									<div class="form-group custom-mt-form-group">
										<input type="password" name="password" />
										<label class="control-label">Password <span class="text-danger">*</span></label><i class="bar"></i>
									</div>
                                </div>
                            </div>
							
                            <div class="table-responsive m-t-15">
								<label class="control-label">Permission</label>
                                <table class="table table-striped custom-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Lecture</th>
                                            <th class="text-center">Écriture</th>
                                            <th class="text-center">Créeation</th>
                                            <th class="text-center">Suppression</th>
                                            <th class="text-center">Ticket</th>
											<th class="text-center">Note</th>
											<th class="text-center">Note2</th>
											<th class="text-center">Affectation</th>
                                            <th class="text-center">Exportation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="lecture" value="1" <?php if($user->lecture==1)echo 'checked';?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="ecriture" value="1" <?php if($user->ecriture==1)echo 'checked';?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="creation" value="1" <?php if($user->creation==1)echo 'checked';?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="suppression" value="1" <?php if($user->suppression==1)echo 'checked';?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="ticket" value="1" <?php if($user->ticket==1)echo 'checked';?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="note" value="1" <?php if($user->note==1)echo 'checked';?>>
                                            </td>
											<td class="text-center">
                                                <input type="checkbox" name="note2" value="1" <?php if($user->note2==1)echo 'checked';?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="affectation" value="1" <?php if($user->affectation)echo 'checked';?>>
                                            </td>
											<td class="text-center">
                                                <input type="checkbox" name="export" value="1" <?php if($user->export==1)echo 'checked';?>>
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
        </div>
        <div id="<?php echo 'delete_user'.$user->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Effacer user</h4>
                    </div>
                    <div class="modal-body card-box">
                        <p>Voulez-vous vraiment supprimer cela?</p>
                        <div class="m-t-20 text-left">
                            <a href="#" class="btn btn-white" data-dismiss="modal">Fermer</a>
                            <a href="<?php echo admin_url('Users/delete/'.$user->id);?>" class="btn btn-danger">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php }}?>