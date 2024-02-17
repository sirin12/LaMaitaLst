    <div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
			<div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
							<h5 class="text-uppercase">Examen</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="<?php echo admin_url('Dashboard');?>">Dashboard</a></li>
								<li class="list-inline-item"><a href="#">Examen</a></li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                      
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="<?php echo admin_url('Examen/form');?>" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> ajouter Examen</a>
                    </div>
                </div>
			<div class="content-page">
                <!--<div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<input type="text"  />
							<label class="control-label">Exam Name</label><i class="bar"></i>
						</div>
                    </div>
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<input type="text"  />
							<label class="control-label">Class</label><i class="bar"></i>
						</div>
                    </div>
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<select >
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th style="min-width:70px;">Nom </th>
                                        <th style="min-width:50px;">Type</th>
										<th style="min-width:50px;">Class</th>
										<th style="min-width:50px;">Filière</th>
										<th style="min-width:50px;">Time</th>
										<th style="min-width:50px;">Date</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php if($examens){foreach($examens as $examen){?>
                                    <tr>
                                        <td>
                                            <h2><a href="exam-detail.html" class="avatar text-white">C</a></h2>
                                            <h2><a href="exam-detail.html"><?php echo $examen->name;?></a></h2>
                                        </td>
                                        <td><?php echo $examen->type;?></td>
                                        <td><?php $class_exs=$this->Class_model->get($examen->class);?><?php echo $class_exs->name;?></td>
                                        <td><?php $filiere_exs=$this->Filieres_model->get($examen->filiere);?><?php echo $filiere_exs->name;?></td>
                                        <td><?php echo $examen->time;?></td>
                                        <td><?php echo $examen->date;?></td>
                                        <td class="text-right" >
											<a href="<?php echo admin_url('Examen/form/'.$examen->id);?>" class="btn btn-primary btn-sm mb-1">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</a>
											<button type="submit" data-toggle="modal" data-target="<?php echo '#delete_examen'.$examen->id;?>" class="btn btn-danger btn-sm mb-1">
											<i class="fa fa-trash" aria-hidden="true"></i>
											</button>
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
		<?php if($examens){foreach($examens as $examen){?>
		 <div id="<?php echo 'delete_examen'.$examen->id;?>" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Effacer Examen</h4>
                    </div>
                    <form>
                        <div class="modal-body card-box">
                            <p>Voulez-vous vraiment supprimer cela?</p>
                            <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Fermer</a>
                                <a href="<?php echo admin_url('Examen/delete/'.$examen->id);?>" class="btn btn-danger">Effacer</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		<?php }}?>
    