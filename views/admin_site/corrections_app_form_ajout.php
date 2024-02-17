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
function fetch_etages(projet_id, val) {
    $.ajax({
        type: 'post',
        url: '<?php echo admin_url('Corrections/fetch_etages/') ?>' + projet_id + '/' + val,
        data: {
            get_option: val
        },
        success: function (response) {
            document.getElementById("etage_id").style.display = "block"; // Update to the correct ID
            document.getElementById("etage_id").innerHTML = response; // Update to the correct ID
        }
    });
}

function fetch_appartements(projet_id, bloc_id, val) {
    $.ajax({
        type: 'post',
        url: '<?php echo admin_url('Corrections/fetch_appartements/') ?>' + projet_id + '/' + bloc_id + '/' + val,
        data: {
            get_option: val
        },
        success: function (response) {
            $('#appartements_id').css('display', 'block'); // Show the container
            $('#appartement_id').html(response); // Replace the content inside the container
        }
    });
}



function fetch_societes(proj_id,val)
{
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
							<li class="breadcrumb-item bcrumb-1">
								<?php $pr_id=$this->md_commun->get_row('projets',array('id'=>$projet_id));?>
                                <a href="<?php echo admin_url('Projets');?>"><?php echo $pr_id->projets;?></a>
                            </li>
		
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
                            <form id="form_validation" method="POST" action="<?php echo admin_url('projets/form_correction_ajout/'.$projet_id);?>" enctype="multipart/form-data">
							<div class="form-group form-float">
									
                                    <div class="row">
									
										<div class="col-sm-6 col-lg-6">
										<label class="form-label"><b>Bloc</b></label>
										<select class="input_header" name="bloc" id="" onchange="fetch_etages(<?php echo $projet_id;?>,this.value)">
												<?php $blocs=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id,'etat'=>1),'asc',10000,0);?>

													<option value=""></option>
													<?php foreach($blocs as $bloc) { ?>
													<option value="<?php echo $bloc->id?>"><?php echo $bloc->blocs;?></option>
													<?php } ?>
												</select>
										</div>

										<div class="col-sm-6 col-lg-6">
   
    <div class="input_header" data-placeholder="Select" name="etage" id="etage_id">
													</div>
</div>

										
										
									</div>
									<div class="row">
									
										<div class="col-sm-6 col-lg-6" id="appartements_id">
										<div class="input_header" data-placeholder="Select" name="appartements" id="appartement_id">
													</div>
										</div>


										
										
										
									</div>
                                </div>
								<div class="form-group form-float">
									<label class="form-label"><b>Etat</b></label>
                                    <div class="row">
										<div class="col-sm-6 col-lg-3">
											<div class="form-check form-check-radio">
												<label>
													<input name="etat_correction" type="radio" value="1" />
													<span>Crée</span>
												</label>
											</div>
										</div>
										<div class="col-sm-6 col-lg-3">
											<div class="form-check form-check-radio">
												<label>
													<input name="etat_correction" type="radio" value="4" />
													<span>En cours</span>
												</label>
											</div>
										</div>
										<div class="col-sm-6 col-lg-3">
											<div class="form-check form-check-radio disabled">
												<label>
													<input name="etat_correction" type="radio" value="3"  />
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
													<input name="etat_urgent" type="radio" value="1"  />
													<span>Tache n'est pas urgente</span>
												</label>
											</div>
										</div>
										<div class="col-sm-6 col-lg-3">
											<div class="form-check form-check-radio">
												<label>
													<input name="etat_urgent" type="radio" value="2"  />
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
													<input name="afficher" type="radio" value="1" />
													<span>Oui</span>
												</label>
											</div>
										</div>
										<div class="col-sm-6 col-lg-3">
											<div class="form-check form-check-radio">
												<label>
													<input name="afficher" type="radio" value="2"/>
													<span>Non</span>
												</label>
											</div>
										</div>
									</div>
                                </div>
							
								<input type="hidden" name="projet_id" value="<?php echo $projet_id;?>">
								<div class="form-group form-float">
									<label class="form-label"><b>Localisation</b></label>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="localisation" required>
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
											<select class="form-control select2" data-placeholder="Select" name="travaux_id" onchange="fetch_societes(<?php echo $projet_id;?>,this.value)">
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
											
											<select class="form-control select2" data-placeholder="Select" name="societe_id">
												<option value="">Seclectionner Entreprise</option>
												
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
                                        <input type="text" class="form-control" name="intitile"  required>
                                        <label class="form-label">Intitilé</label>
                                    </div>
                                </div>
								<div class="form-group form-float">
									<label class="form-label"><b>Observation</b></label>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="observation"  >
                                        <label class="form-label">Observation</label>
                                    </div>
                                </div>
								<div class="form-group form-float">
									<label class="form-label"><b>Date d'observation</b></label>
                                    <div class="form-line">
                                        <input type="disabled" class="form-control" name="date"  required>
                                        <label class="form-label">Date d'observation</label>
                                    </div>
                                </div>
								<div class="form-group form-float">
									<label class="form-label" style="display:none"><b>Levé de réserve</b></label>
                                    <div class="form-line">
                                        <input type="hidden" class="form-control" name="leve" >
                                        <label class="form-label" style="display:none">Levé de réserve</label>
                                    </div>
                                </div>
								<div class="form-group form-float" >
									<label class="form-label" style="display:none"><b>Observation levé</b></label>
                                    <div class="form-line">
                                        <input type="hidden" class="form-control" name="observation_leve">
                                        <label class="form-label" style="display:none">Observation levé</label>
                                    </div>
                                </div>
								<div class="form-group form-float">
									<label class="form-label" style="display:none"><b>Date Levé</b></label>
                                    <div class="form-line">
                                        <input type="hidden" class="form-control" name="date_leve"  >
                                        <label class="form-label" style="display:none">Date Levé</label>
                                    </div>
                                </div>
								<div class="row">
									<div class="form-group form-float col-md-6">
										<div class="form-line">
											<input type="file" class="form-control" name="image"  >
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
    