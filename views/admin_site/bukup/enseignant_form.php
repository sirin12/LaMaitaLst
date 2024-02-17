<?php 

function in_list($product,$products){

    $found= false;
    $i=0;
    while($i<sizeof($products))
    {
        if($product==$products[$i]->widget_id && !$found)
        {
            $found=true;
            return 'selected';
        }
        $i++;
    }
}?> 
 <div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
                <div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
							<h5 class="text-uppercase">Ajout Enseignant</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="<?php echo admin_url('Dashboard');?>">Dashboard</a></li>
								<li class="list-inline-item"><a href="<?php echo admin_url('Enseignants');?>">Enseignants</a></li>
								<li class="list-inline-item"> Ajouter Enseignant</li>
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
											<div class="page-title">Informations de base</div>
										</div>
										
									</div>
								</div>
								<div class="card-body">	
									<?php echo form_open_multipart($this->config->item('admin_folder') . '/Enseignants/form/' . $id); ?>
									<div class="row">
									
										<div class="col-lg-6 col-md-6 col-sm-6 col-12">
												<div class="form-group custom-mt-form-group">
													<?php $data = array('name' => 'nom', 'value' => set_value('nom', $nom));echo form_input($data);?>
													<label class="control-label">Nom</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<?php $data = array('name' => 'email', 'value' => set_value('email', $email));echo form_input($data);?>
													<label class="control-label">Email</label><i class="bar"></i>
												</div>
												
												<div class="form-group custom-mt-form-group">
													<?php $data = array('name' => 'subject', 'value' => set_value('subject', $subject));echo form_input($data);?>
													<label class="control-label">Subject</label><i class="bar"></i>
												</div>
												
												<div class="form-group custom-mt-form-group">
													 <input class="datetimepicker" type="text" name="date_naissance" value="<?php echo format_dmy($date_naissance);?>"> 
													<label class="control-label">Date de naissance</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<?php $data = array('name' => 'password', 'class' => 'form-control');echo form_password($data);?>
													<label class="control-label">Password</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<select class="form-control select2"  ui-jp="select2" ui-options="{theme: 'bootstrap'}" tabindex="-1" aria-hidden="true" name="matiere_id[]" multiple="multiple">
														<?php foreach ($matieres as $matiere) { ?>
														<option value="<?php echo $matiere->id ?>" <?php if($matiere_id){ if(in_array($matiere->id, $matiere_id)) echo 'selected'; }?>><?php echo $matiere->name ?></option>
														<?php } ?>
													</select>
													<label class="control-label">Matieres</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													
													<?php $input_image = array('name' => 'image', 'id' => 'image', 'class'=>'form-control'); ?>
													<?php echo form_upload($input_image); ?>
													<img class="avatar" src="<?php echo uploads('avatars/'.$image);?>" alt="" style="width:60px;height:60px;">
													<label class="control-label">Image</label><i class="bar"></i>
												</div>
												<!--<div class="form-group custom-mt-form-group">
													<input type="text"  />
													<label class="control-label">Class</label><i class="bar"></i>
												</div>-->
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-12">
											
												<div class="form-group custom-mt-form-group">
													<?php $data = array('name' => 'prenom', 'value' => set_value('prenom', $prenom));echo form_input($data);?>
													<label class="control-label">Prénom</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													 <input class="form-control floating datetimepicker" type="text" name="date_inscription" value="<?php echo format_dmy($date_inscription);?>" >
													<label class="control-label">Date inscription</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<?php $data = array('name' => 'phone', 'value' => set_value('phone', $phone));echo form_input($data);?>
													<label class="control-label">Téléphone</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<select name="gender">
														<option <?php if($gender=='Homme') echo 'Homme';?>>Homme</option>
														<option <?php if($gender=='Femme') echo 'Femme';?>>Femme</option>
													 </select>
													 <label class="control-label">Sexe</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<?php $data = array('name' => 'type', 'value' => set_value('type', $type));echo form_input($data);?>
													<label class="control-label">Type</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<?php $data = array('name' => 'matricule', 'value' => set_value('matricule', $matricule));echo form_input($data);?>
													<label class="control-label">Matricule</label><i class="bar"></i>
												</div>
												<!--<div class="form-group custom-mt-form-group">
													<select >
														<option>Computer</option>
														<option>Science</option>
														<option>Maths</option>
														<option>Tamil</option>
														<option>English</option>
														<option>Social Science</option>
													 </select>
													 <label class="control-label">Subject</label><i class="bar"></i>
												</div>	-->	
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										
												<div class="form-group text-center custom-mt-form-group">
													<button class="btn btn-primary mr-2" type="submit">Enregistrer</button>
												</div>
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
    