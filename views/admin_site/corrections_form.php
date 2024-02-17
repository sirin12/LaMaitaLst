<style>
<?php if($id){?>
#blocs_id,#etages_id,#appartements_id,#societes_id{display:block;}
<?php }else{?>
#blocs_id,#etages_id,#appartements_id,#societes_id{display:none;}
<?php }?>
#blocs,#etages,#appartements,#societes{display:none;}
</style>
<script>
function fetch_blocs(val)
{
 $.ajax({
 type: 'post',
 url: '<?php echo admin_url('Corrections/fetch_blocs/') ?>'+val,
 data: {
  get_option:val
 },
 success: function (response) {
	document.getElementById("appartements_id").style.display = "none"; 
	document.getElementById("blocs").style.display = "block";
	document.getElementById("blocs_id").style.display = "none";
	document.getElementById("etages_id").style.display = "none"; 
	document.getElementById("etages").style.display = "none"; 
	document.getElementById("appartements_id").style.display = "none"; 
	document.getElementById("appartements").style.display = "none"; 
	
	
	document.getElementById("blocs").innerHTML=response; 
 }
 });
}
function fetch_etages(projet_id,val)
{
 $.ajax({
 type: 'post',
 url: '<?php echo admin_url('Corrections/fetch_etages/') ?>'+projet_id+'/'+val,
 data: {
  get_option:val
 },
 success: function (response) {
	document.getElementById("etages_id").style.display = "none"; 
	document.getElementById("etages").style.display = "block"; 
	document.getElementById("appartements_id").style.display = "none"; 
	document.getElementById("appartements").style.display = "none"; 
	document.getElementById("etages").innerHTML=response; 
 }
 });
}
function fetch_appartements(projet_id,bloc_id,val)
{
 $.ajax({
 type: 'post',
 url: '<?php echo admin_url('Corrections/fetch_appartements/') ?>'+projet_id+'/'+bloc_id+'/'+val,
 data: {
  get_option:val
 },
 success: function (response) { 
	document.getElementById("appartements_id").style.display = "none"; 
	document.getElementById("appartements").style.display = "block"; 
	document.getElementById("appartements").innerHTML=response; 
 }
 });
}
function fetch_societes(val)
{
	var t = document.getElementById("projet_id");
	var proj_id = t.options[t.selectedIndex].value;
 $.ajax({
 type: 'post',
 url: '<?php echo admin_url('Corrections/fetch_societes/') ?>'+proj_id+'/'+val,
 data: {
  get_option:val
 },
 success: function (response) { 
	document.getElementById("societes_id").style.display = "none"; 
	document.getElementById("societes").style.display = "block"; 
	document.getElementById("societes").innerHTML=response; 
 }
 });
}

</script>

<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Corrections</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Corrections</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Corrections</strong></h2>
                         
                        </div>

                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Corrections/form/' . $id);?>" enctype="multipart/form-data">
								<div class="form-group form-float">
									<label class="form-label"><b>Etat</b></label>
                                    <div class="row">
										<div class="col-sm-6 col-lg-3">
											<div class="form-check form-check-radio">
												<label>
													<input name="etat_correction" type="radio" value="1" <?php if($etat_correction==1) echo 'checked';?>/>
													<span>Crée</span>
												</label>
											</div>
										</div>
										<div class="col-sm-6 col-lg-3">
											<div class="form-check form-check-radio">
												<label>
													<input name="etat_correction" type="radio" value="4" <?php if($etat_correction==4) echo 'checked';?> />
													<span>En cours</span>
												</label>
											</div>
										</div>
										<div class="col-sm-6 col-lg-3">
											<div class="form-check form-check-radio disabled">
												<label>
													<input name="etat_correction" type="radio" value="3"  <?php if($etat_correction==3) echo 'checked';?> />
													<span>Validée</span>
												</label>
											</div>
										</div>
									</div>
                                </div>
								<div class="form-group form-float">
									<label class="form-label"><b>Type de remarque</b></label>
                                    <div class="row">
										<div class="col-sm-6 col-lg-3">
											<div class="form-check form-check-radio">
												<label>
													<input name="etat_urgent" type="radio" value="1" <?php if($etat_urgent==1) echo 'checked';?> />
													<span>Tache n'est pas urgente</span>
												</label>
											</div>
										</div>
										<div class="col-sm-6 col-lg-3">
											<div class="form-check form-check-radio">
												<label>
													<input name="etat_urgent" type="radio" value="2" <?php if($etat_urgent==2) echo 'checked';?> />
													<span>Tache urgente</span>
												</label>
											</div>
										</div>
									</div>
                                </div>
								<div class="form-group form-float">
									<label class="form-label"><b>Afficher</b></label>
                                    <div class="row">
										<div class="col-sm-6 col-lg-3">
											<div class="form-check form-check-radio">
												<label>
													<input name="afficher" type="radio" value="1" <?php if($afficher==1) echo 'checked';?> />
													<span>Oui</span>
												</label>
											</div>
										</div>
										<div class="col-sm-6 col-lg-3">
											<div class="form-check form-check-radio">
												<label>
													<input name="afficher" type="radio" value="2" <?php if($afficher==2) echo 'checked';?> />
													<span>Non</span>
												</label>
											</div>
										</div>
									</div>
                                </div>
								<div class="form-group form-float">
									<label class="form-label"><b>Projet</b></label>
                                    <div class="form-line">
                                        <div class="form-group default-select select2Style">
											<?php $projets=$this->md_commun->fetch('projets',array('etat'=>1),'asc',10000,0);?>
											<select class="form-control select2" data-placeholder="Select" name="projet_id" id="projet_id" onchange="fetch_blocs(this.value)">
												<option value="">Seclectionner projet</option>
												<?php if($projets){foreach($projets as $proj){
													$current_admin = $this->session->userdata('admin');
													$id_admin=$current_admin['id'];
													$admin_projet=$this->md_commun->get_row('projets_admin',array('projet_id'=>$proj->id,'admin_id'=>$id_admin));?>
													<?php if($admin_projet){?>
												<option value="<?php echo $proj->id;?>" <?php if($proj->id==$projet_id) echo 'selected';?>><?php echo $proj->projets;?></option>
												<?php }}}?>
											</select>
										</div>
                                    </div>
                                </div>
								<div class="row">
								<div class="form-group form-float col-md-4" id="blocs_id">
									<label class="form-label"><b>Bloc</b></label>
									<div class="form-line">
										<div class="form-group default-select select2Style">
										<?php $blocs=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id),'asc',10000,0);?>
										<select class="form-control select2" data-placeholder="Select" name="bloc_id" onchange="fetch_etages(<?php echo $projet_id;?>,this.value)">
											<option value="">Seclectionner bloc</option>
											<?php if($blocs){foreach($blocs as $bloc){?>
											<option value="<?php echo $bloc->id;?>" <?php if($bloc->id==$bloc_id) echo 'selected';?>><?php echo $bloc->blocs;?></option>
											<?php }}?>
											</select>
										</div>
                                    </div>
                                </div>
								
                                <div class="form-group form-float col-md-4" id="blocs">
                                </div>
								
								<div class="form-group form-float col-md-4" id="etages_id">
									<label class="form-label"><b>Etage</b></label>
                                    <div class="form-line">
                                        <div class="form-group default-select select2Style">
											<?php $etages=$this->md_commun->fetch('etages',array('etat'=>1,'blocs_id'=>$bloc_id),'asc',10000,0);?>
											<select class="form-control select2" data-placeholder="Select" name="etage_id" onchange="fetch_appartements(<?php echo $projet_id;?>,<?php echo $bloc_id;?>,this.value)">
												<option value="">Seclectionner etage</option>
												<?php if($etages){foreach($etages as $etage){?>
												<option value="<?php echo $etage->id;?>" <?php if($etage->id==$etage_id) echo 'selected';?>><?php echo $etage->etages;?></option>
												<?php }}?>
											</select>
										</div>
                                    </div>
                                </div>
								
								<div class="form-group form-float col-md-4" id="etages">
									
                                </div>
								
								<div class="form-group form-float col-md-4" id="appartements_id">
									<label class="form-label"><b>Locaux</b></label>
                                    <div class="form-line">
                                        <div class="form-group default-select select2Style">
											<?php $appartements=$this->md_commun->fetch('appartements',array('etat'=>1,'etages_id'=>$etage_id),'asc',10000,0);?>
											<select class="form-control select2" data-placeholder="Select" name="appartements_id">
												<option value="">Seclectionner Locaux</option>
												<?php if($appartements){foreach($appartements as $app){?>
												<option value="<?php echo $app->id;?>" <?php if($app->id==$appartements_id) echo 'selected';?>><?php echo $app->appartements;?></option>
												<?php }}?>
											</select>
										</div>
                                    </div>
                                </div>
								
								<div class="form-group form-float col-md-4" id="appartements">
									
                                </div>
								</div>
								<div class="form-group form-float">
									<label class="form-label"><b>Localisation</b></label>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="localisation" value="<?php echo $localisation;?>" required>
                                        <label class="form-label">Localisation</label>
                                    </div>
                                </div>
								<div class="row">
								<div class="form-group form-float col-md-6">
									<label class="form-label"><b>Lots</b></label>
                                    <div class="form-line">
                                        <div class="form-group default-select select2Style">
										<?php $current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id']; if ($current_admin['access'] == 'Admin') {
            $travaux = $this->md_commun->fetch('travaux', array('etat' => 1), 'asc', 100, 0);
        } else {
            $travaux = $this->md_commun->fetch('travaux', array('etat' => 1, 'user_id' => $id_admin), 'asc', 100, 0);
        }?>
											<select class="form-control select2" data-placeholder="Select" name="travaux_id" onchange="fetch_societes(this.value)">
												<option value="">Seclectionner Lots</option>
												<?php if($travaux){foreach($travaux as $trav){?>
												<option value="<?php echo $trav->id;?>" <?php if($trav->id==$travaux_id) echo 'selected';?>><?php echo $trav->travaux;?></option>
												<?php }}?>
											</select>
										</div>
                                    </div>
                                </div>
								<div class="form-group form-float col-md-6" id="societes_id">
									<label class="form-label"><b>Entreprise</b></label>
                                    <div class="form-line">
                                        <div class="form-group default-select select2Style">
											<?php $societes=$this->md_commun->fetch('societes',array('travaux_id'=>$travaux_id,'etat'=>1),'asc',10000,0);?>
											<select class="form-control select2" data-placeholder="Select" name="societe_id">
												<option value="">Seclectionner Entreprise</option>
												<?php if($societes){foreach($societes as $societe){?>
												<option value="<?php echo $societe->id;?>" <?php if($societe->id==$societe_id) echo 'selected';?>><?php echo $societe->societes;?></option>
												<?php }}?>
											</select>
										</div>
                                    </div>
                                </div>
								<div class="form-group form-float col-md-6" id="societes">
									
                                </div>
								</div>
								<div class="form-group form-float">
									<label class="form-label"><b>Intitilé</b></label>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="intitile" value="<?php echo $intitile;?>" required>
                                        <label class="form-label">Intitilé</label>
                                    </div>
                                </div>
								<div class="form-group form-float">
									<label class="form-label"><b>Observation</b></label>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="observation" value="<?php echo $observation;?>" >
                                        <label class="form-label">Observation</label>
                                    </div>
                                </div>
								<div class="form-group form-float">
									<label class="form-label"><b>Date d'observation</b></label>
                                    <div class="form-line">
                                        <input type="disabled" class="form-control" name="date" value="<?php echo $date_time;?>" required>
                                        <label class="form-label">Date d'observation</label>
                                    </div>
                                </div>
								<div class="form-group form-float">
									<label class="form-label" style="display:none"><b>Levé de réserve</b></label>
                                    <div class="form-line">
                                        <input type="hidden" class="form-control" name="leve" value="<?php echo $leve;?>" >
                                        <label class="form-label" style="display:none">Levé de réserve</label>
                                    </div>
                                </div>
								<div class="form-group form-float" >
									<label class="form-label" style="display:none"><b>Observation levé</b></label>
                                    <div class="form-line">
                                        <input type="hidden" class="form-control" name="observation_leve" value="<?php echo $observation_leve;?>" >
                                        <label class="form-label" style="display:none">Observation levé</label>
                                    </div>
                                </div>
								<div class="form-group form-float">
									<label class="form-label" style="display:none"><b>Date Levé</b></label>
                                    <div class="form-line">
                                        <input type="hidden" class="form-control" name="date_leve" value="<?php echo $date_leve;?>" >
                                        <label class="form-label" style="display:none">Date Levé</label>
                                    </div>
                                </div>
								<div class="row">
									<div class="form-group form-float col-md-6">
										<div class="form-line">
											<input type="file" class="form-control" name="image" value="<?php echo $image;?>" >
											<label class="form-label">Image</label>
										</div>
										<?php if ($id && $image != ''){ ?>
						                <div class="featured-image" style="text-align:center; padding:5px; border:1px solid #ddd"><img src="<?php echo base_url('uploads/images/full/' . $image); ?>" alt="current" height="157" width="100%" style="object-fit:contain !important"/><br/>
						    			<?php echo lang('current_file'); ?></div>
										<?php }?>
									</div>
								</div>
								
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Validation -->
        </div>
    </section>
    