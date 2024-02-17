<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
				<div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
							<h5 class="text-uppercase">Enseignants</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="<?php echo admin_url('Dashboard');?>">Dashboard</a></li>
								<li class="list-inline-item"> Enseignants</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="<?php echo admin_url('Enseignants/form');?>" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Ajouter Enseignant</a>
                      
                    </div>
                </div>
			<div class="content-page">
                <!--<div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<input type="text"  />
							<label class="control-label">Teacher ID</label><i class="bar"></i>
						</div>
                    </div>
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<input type="text"  />
							<label class="control-label">Teacher Name</label><i class="bar"></i>
						</div>
                    </div>
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<select class="">
								 <option>Maths</option>
                                <option>English</option>
                                <option>Science</option>
                                <option>Social Science</option>
                                <option>Finance</option>
							 </select>
							 <label class="control-label">Subject</label><i class="bar"></i>
						</div>	
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <a href="#" class="btn btn-success btn-block mt-4 mb-2"> Search </a>
                    </div>
                </div>-->
                <div class="row staff-grid-row">
					<?php if($enseignants){foreach($enseignants as $enseignant){?>
                    <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                        <div class="profile-widget">
                            <div class="profile-img">
                                <a href="<?php echo admin_url('Enseignants/form/'.$enseignant->id);?>">
									<?php if($enseignant->image){?>
									<img class="avatar" src="<?php echo uploads('avatars/'.$enseignant->image);?>" alt="">
									<?php }else{?>
									<img class="avatar" src="<?php echo admin_img('user.jpg');?>" alt="">
									<?php }?>
								</a>
                            </div>
                            <div class="dropdown profile-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="<?php echo admin_url('Enseignants/form/'.$enseignant->id);?>"><i class="fa fa-pencil m-r-5"></i> Modifier</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')" data-target="<?php echo '#delete_enseignant'.$enseignant->id;?>"><i class="fa fa-trash-o m-r-5"></i> Effacer</a>
                                </div>
                            </div>
                            <h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="<?php echo admin_url('Enseignants/form/'.$enseignant->id);?>"><?php echo $enseignant->nom.' '.$enseignant->prenom;?></a></h4>
                            <!--<div class="small text-muted">Maths</div>-->
                        </div>
                    </div>
					<?php }}?>
                </div>
            </div>
            </div>
        </div>
		<?php if($enseignants){foreach($enseignants as $enseignant){?>
		<div id="<?php echo 'delete_enseignant'.$enseignant->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Effacer Enseignant</h4>
                    </div>
                    <form>
                        <div class="modal-body card-box">
                            <p>Voulez-vous vraiment supprimer cela?</p>
                            <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Fermer</a>
                                <a href="<?php echo admin_url('Enseignants/delete/'.$enseignant->id);?>" class="btn btn-danger">Effacer</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		<?php }}?>