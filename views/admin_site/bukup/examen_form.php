    <div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
                <div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
							<h5 class="text-uppercase"><?php if($id)echo 'Modifier Examen';else echo 'Ajout Examen';?></h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="<?php echo admin_url('Dashboard');?>">Dashboard</a></li>
								<li class="list-inline-item"><a href="<?php echo admin_url('Examen');?>">Examen</a></li>
								<li class="list-inline-item"> <?php if($id)echo 'Modifier Examen';else echo 'Ajout Examen';?></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="page-content">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="page-title">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-12">
											<div class="page-title"><?php if($id)echo 'Modifier Examen';else echo 'Ajout Examen';?></div>
										</div>
										
									</div>
								</div>
								<div class="card-body">	
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-12">
											<?php echo form_open_multipart($this->config->item('admin_folder') . '/Examen/form/' . $id); ?>
												<div class="form-group custom-mt-form-group">
													<input type="text" name="name" value="<?php echo $name;?>" />
													<label class="control-label w-100">Nom</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<select name="type">
														<option value="">-</option>
														<option value="TD" <?php if($type=="TD")echo 'selected';?>>TD</option>
														<option value="TP" <?php if($type=="TP")echo 'selected';?>>TP</option>
														<option value="Principal" <?php if($type=="Principal")echo 'selected';?>>Principal</option>
													 </select>
													 <label class="control-label">Type</label><i class="bar"></i>
												</div>	
												<div class="form-group custom-mt-form-group">
													<?php $class_exs=$this->Class_model->get();?>
													<select name="class">
														<option> -</option>
														<?php if($class_exs){foreach($class_exs as $cls){?>
														<option value="<?php echo $cls->id;?>" <?php if($class==$cls->id)echo 'selected';?>><?php echo $cls->name;?></option>
														<?php }}?>
													 </select>
													 <label class="control-label">Class</label><i class="bar"></i>
												</div>	
												<div class="form-group custom-mt-form-group">
													<?php $filiere_exs=$this->Filieres_model->get();?>
													<select name="filiere">
														<option> -</option>
														<?php if($filiere_exs){foreach($filiere_exs as $fil){?>
														<option value="<?php echo $fil->id;?>" <?php if($filiere==$fil->id)echo 'selected';?>><?php echo $fil->name;?></option>
														<?php }}?>
													 </select>
													 <label class="control-label">Filière</label><i class="bar"></i>
												</div>	
												<div class="form-group custom-mt-form-group">
													 <input class="datetimepicker" type="text" name="date" value="<?php echo $date;?>"> 
													<label class="control-label w-100">Date</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<input type="text" name="time" value="<?php echo $time;?>" />
													<label class="control-label w-100">Time</label><i class="bar"></i>
												</div>
										
											<div class="col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="form-group text-center custom-mt-form-group">
													<button class="btn btn-primary mr-2" type="submit">Submit</button>
													<button class="btn btn-secondary" type="reset">Cancel</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    