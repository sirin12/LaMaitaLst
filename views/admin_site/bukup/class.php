<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
			      <div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
							<h5 class="text-uppercase">Class</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="<?php echo admin_url('Dashboard');?>">Dashboard</a></li>
								<li class="list-inline-item"> Class</li>
							</ul>
						</div>
					</div>
				</div>
                 <div class="row">
                    <div class="col-sm-5 col-5">
                       
                    </div>
                    <div class="col-sm-7 col-7 text-right m-b-30">
                        <a href="<?php echo admin_url('Classs/form');?>" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#add_filiere"><i class="fa fa-plus"></i> Ajouter class</a>
                    </div>
                </div>
				<div class="content-page">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <table class="table table-striped custom-table m-b-0 datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom du Class</th>
										<th>Filière</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php if($classs){foreach($classs as $class){?>
                                    <tr>
                                        <td><?php echo $class->id;?></td>
                                        <td><?php echo $class->name;?></td>
										<td><?php $filiere_id = $this->Filieres_model->get($class->filiere);echo $filiere_id->name;?></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="<?php echo admin_url('Classs/matieres/'.$class->id);?>" title="Matière"><i class="fa fa-pencil m-r-5"></i> Matière</a>
													<a class="dropdown-item" href="#" data-toggle="modal" data-target="<?php echo '#edit_class'.$class->id;?>" title="Edit"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="<?php echo '#delete_class'.$class->id;?>" title="Delete"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
		<div id="add_filiere" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter class</h4>
						 <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart($this->config->item('admin_folder') . '/Classs/form/'); ?>
							<div class="form-group custom-mt-form-group">
								<input type="text" name="name" required />
								<label class="control-label">Nom class <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
							<div class="form-group custom-mt-form-group">
								<select name="filiere">
									<?php $filieres = $this->Filieres_model->get();
									if($filieres){foreach($filieres as $filiere){?>
										<option value="<?php echo $filiere->id;?>"><?php echo $filiere->name;?></option>
									<?php }}?>
								</select>
								<label class="control-label">Filière <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary btn-lg">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		<?php if($classs){foreach($classs as $class){?>
        <div id="<?php echo 'edit_class'.$class->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Modifier class</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart($this->config->item('admin_folder') . '/Classs/form/'.$class->id); ?>
							<div class="form-group custom-mt-form-group">
								<input type="text" name="name" value="<?php echo $class->name;?>" required />
								<label class="control-label">Nom class <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
							<div class="form-group custom-mt-form-group">
								<select name="filiere">
									<?php $filieres = $this->Filieres_model->get();
									if($filieres){foreach($filieres as $fil){?>
										<option value="<?php echo $fil->id;?>" <?php if($filiere==$fil->id) echo 'selected';?>><?php echo $fil->name;?></option>
									<?php }}?>
								</select>
								<label class="control-label">Filière <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary btn-lg mb-3">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="<?php echo 'delete_class'.$class->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Effacer class</h4>
                    </div>
                    <div class="modal-body card-box">
                        <p>Voulez-vous vraiment supprimer cela?</p>
                        <div class="m-t-20 text-left">
                            <a href="#" class="btn btn-white" data-dismiss="modal">Fermer</a>
                            <a href="<?php echo admin_url('Classs/delete/'.$class->id);?>" class="btn btn-danger">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php }}?>