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
                    <div class="col-sm-7 col-7 text-right m-b-30">
                        <a href="<?php echo admin_url('Matieres/form');?>" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#add_matiere"><i class="fa fa-plus"></i> Ajouter matiere</a>
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
                                        <th>Nom du matiere</th>
										<th>Semestre</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php if($matieres){foreach($matieres as $matiere){?>
                                    <tr>
                                        <td><?php echo $matiere->id;?></td>
                                        <td><?php echo $matiere->name;?></td>
										<td><?php $semestreid=$this->Annees_model->get_details($annee,$matiere->semestre_id);?><?php echo $semestreid->semestre;?></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="<?php echo '#edit_matiere'.$matiere->id;?>" title="Edit"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="<?php echo '#delete_matiere'.$matiere->id;?>" title="Delete"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
		<div id="add_matiere" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter matiere</h4>
						 <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart($this->config->item('admin_folder') . '/matieres/form/'); ?>
							<div class="form-group custom-mt-form-group">
								<input type="text" name="name" required />
								<label class="control-label">Nom matiere <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
							<div class="form-group custom-mt-form-group">
								<select name="semestre_id">
									<?php if($semestres){foreach($semestres as $semestre){?>
									<option value="<?php echo $semestre->id;?>"><?php echo $semestre->semestre;?></option>
									<?php }}?>
								</select>
								<label class="control-label">Semestre <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary btn-lg">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		<?php if($matieres){foreach($matieres as $matiere){?>
        <div id="<?php echo 'edit_matiere'.$matiere->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Modifier matiere</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart($this->config->item('admin_folder') . '/matieres/form/'.$matiere->id); ?>
							<div class="form-group custom-mt-form-group">
								<input type="text" name="name" value="<?php echo $matiere->name;?>" required />
								<label class="control-label">Nom matiere <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
							<div class="form-group custom-mt-form-group">
								<select name="semestre_id">
									<?php if($semestres){foreach($semestres as $semestre){?>
									<option value="<?php echo $semestre->id;?>" <?php if($semestre->id==$matiere->semestre_id)echo 'selected';?>><?php echo $semestre->semestre;?></option>
									<?php }}?>
								</select>
							</div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary btn-lg mb-3">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="<?php echo 'delete_matiere'.$matiere->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Effacer matiere</h4>
                    </div>
                    <div class="modal-body card-box">
                        <p>Voulez-vous vraiment supprimer cela?</p>
                        <div class="m-t-20 text-left">
                            <a href="#" class="btn btn-white" data-dismiss="modal">Fermer</a>
                            <a href="<?php echo admin_url('matieres/delete/'.$matiere->id);?>" class="btn btn-danger">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php }}?>