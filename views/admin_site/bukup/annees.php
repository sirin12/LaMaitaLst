<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
			      <div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
							<h5 class="text-uppercase">Années</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="<?php echo admin_url('Dashboard');?>">Dashboard</a></li>
								<li class="list-inline-item"> Années</li>
							</ul>
						</div>
					</div>
				</div>
                 <div class="row">
                    <div class="col-sm-5 col-5">
                       
                    </div>
                    <div class="col-sm-7 col-7 text-right m-b-30">
                        <a class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#add_annee"><i class="fa fa-plus"></i> Ajouter annee</a>
                    </div>
                </div>
				<div class="content-page">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <table class="table table-striped custom-table m-b-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Années</th>
										<th>Année scolaire</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php if($annees){foreach($annees as $anne){?>
                                    <tr>
                                        <td><?php echo $anne->annee;?></td>
										<td><?php echo $anne->annes_scolaire;?></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="<?php echo '#edit_annee'.$anne->id;?>" title="Edit"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="<?php echo '#delete_annee'.$anne->id;?>" title="Delete"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
		<div id="add_annee" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter annee</h4>
						 <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart($this->config->item('admin_folder') . '/Annees/form/'); ?>
							<div class="form-group custom-mt-form-group">
								<input type="text" name="annee" required />
								<label class="control-label">Annees <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
							<div class="form-group custom-mt-form-group">
								<input type="text" name="annes_scolaire" required />
								<label class="control-label">Annees scolaires <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary btn-lg">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		<?php if($annees){foreach($annees as $annee){?>
        <div id="<?php echo 'edit_annee'.$annee->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Modifier class</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart($this->config->item('admin_folder') . '/Annees/form/'.$annee->id); ?>
							<div class="form-group custom-mt-form-group">
								<input type="text" name="annee" required value="<?php echo $annee->annee;?>" />
								<label class="control-label">Annees <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
							<div class="form-group custom-mt-form-group">
								<input type="text" name="annes_scolaire" required value="<?php echo $annee->annes_scolaire;?>"/>
								<label class="control-label">Annees scolaires <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary btn-lg mb-3">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="<?php echo 'delete_annee'.$annee->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Effacer annee</h4>
                    </div>
                    <div class="modal-body card-box">
                        <p>Voulez-vous vraiment supprimer cela?</p>
                        <div class="m-t-20 text-left">
                            <a href="#" class="btn btn-white" data-dismiss="modal">Fermer</a>
                            <a href="<?php echo admin_url('Annees/delete/'.$annee->id);?>" class="btn btn-danger">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php }}?>