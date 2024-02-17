    <div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
			<div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
							<h5 class="text-uppercase">Vacances</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="#">Home</a></li>
								<li class="list-inline-item"> Vacances</li>
							</ul>
						</div>
					</div>
				</div>

			<div class="content-page">
                <div class="row">
                    <div class="col-sm-5 col-5">
                        <h4 class="page-title">Vacances</h4>
                    </div>
                    <div class="col-sm-7 col-7 text-right m-b-30">
                        <a href="#" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#add_holiday"><i class="fa fa-plus"></i> Ajouter Vacance</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table m-b-0">
                                <thead>
                                    <tr>
                                        <th>Nom </th>
                                        <th>Date début</th>
                                        <th>Date fin</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php if($holidays){foreach($holidays as $holiday){?>
                                  
									<tr <?php if($holiday->date_fin>=date('Y-m-d')) echo 'class="holiday-completed"';else echo 'class="holiday-upcoming"';?>>
                                        <td><?php echo $holiday->name;?></td>
                                        <td><?php echo $holiday->date_debut;?></td>
                                        <td><?php echo $holiday->date_fin;?></td>
                                        <td class="text-right">
											<?php if($holiday->date_fin>=date('Y-m-d')){?>
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="<?php echo '#edit_holiday'.$holiday->id;?>" title="Edit"><i class="fa fa-pencil m-r-5"></i> Modifier</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="<?php echo '#delete_holiday'.$holiday->id;?>" title="Delete"><i class="fa fa-trash-o m-r-5"></i> Effacer</a>
                                                </div>
                                            </div>
											<?php }?>
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
        <div id="add_holiday" class="modal" role="dialog">
            <div class="modal-dialog">
				
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter des vacances</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart($this->config->item('admin_folder') . '/Holidays/form/'); ?>
                            <div class="form-group custom-mt-form-group">
								<input type="text" name="name" />
								<label class="control-label">Nom <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="form-group custom-mt-form-group">
								<input class="form-control floating datetimepicker" type="text" name="date_debut">
								<label class="control-label">Date debut<span class="text-danger">*</span></label><i class="bar"></i>
							</div>
							<div class="form-group custom-mt-form-group">
								<input class="form-control floating datetimepicker" type="text" name="date_fin" >
								<label class="control-label">Date fin<span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary btn-lg">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		<?php if($holidays){foreach($holidays as $holiday){?>
        <div id="<?php echo 'edit_holiday'.$holiday->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Modifier les vacances</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart($this->config->item('admin_folder') . '/holidays/form/'.$holiday->id); ?>
							<div class="form-group custom-mt-form-group">
								<input type="text" name="name" value="<?php echo $holiday->name;?>" required />
								<label class="control-label">Nom <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="form-group custom-mt-form-group">
								<input class="form-control floating datetimepicker" type="text" name="date_debut" value="<?php echo format_dmy($holiday->date_debut);?>" required >
								<label class="control-label">Date debut<span class="text-danger">*</span></label><i class="bar"></i>
							</div>
							<div class="form-group custom-mt-form-group">
								<input class="form-control floating datetimepicker" type="text" name="date_fin" value="<?php echo format_dmy($holiday->date_fin);?>" required >
								<label class="control-label">Date fin<span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary btn-lg">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="<?php echo 'delete_holiday'.$holiday->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Supprimer les vacances</h4>
                    </div>
                    <form>
                        <div class="modal-body card-box">
                            <p>Voulez-vous vraiment supprimer cela?</p>
                            <div class="m-t-20 text-left">
                                <a href="#" class="btn btn-white" data-dismiss="modal">Fermer</a>
                                <a href="<?php echo admin_url('holidays/delete/'.$holiday->id);?>" class="btn btn-danger">Supprimer</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		<?php }}?>