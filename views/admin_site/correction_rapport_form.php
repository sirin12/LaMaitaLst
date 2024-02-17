<style>
<?php if($id){?>
#blocs_id,#etages_id,#appartements_id,#societes_id{display:block;}
<?php }else{?>
#blocs_id,#etages_id,#appartements_id,#societes_id{display:none;}
<?php }?>
#etages,#appartements,#societes{display:none;}
/* Style for the container holding both the selected apartments and the select */
#container {
    display: flex;
    flex-wrap: wrap; /* Allow items to wrap to the next line if necessary */
    align-items: flex-start; /* Align items at the start of the cross axis (top) */
}

/* Style for the selected apartments container */
#selected-apartments-container {
    display: flex;
    flex-wrap: wrap;
    overflow-x: auto;

/* Style for each selected apartment item */
.selected-apartment {
    display: flex;
    align-items: center;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    background-color: #fff;
}

/* Style for the remove button */
.remove-button {
    margin-left: 8px;
    cursor: pointer;
    color: #777;
    font-size: 18px;
}

.remove-button:hover {
    color: #d9534f;
}



</style>
<script>
	
function fetch_blocs(val)
{

	window.location.replace("<?php echo admin_url('Rapport_societe/form/'); ?>"+val);

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
	document.getElementById("etages").style.display = "block"; 
	document.getElementById("etages").innerHTML=response; 
 }
 });
}
var les9a = []; // Utiliser un tableau pour stocker les objets

function addappetage() {
    var etage = document.getElementById("etag_bloc").value;
    var appartement = document.getElementById("app_etage").value;

    // Créer un objet avec les valeurs de l'étage et de l'appartement
    var objet = {"app": appartement, "etage": etage};
    
    // Ajouter l'objet au tableau
    les9a.push(objet);

    // Afficher le tableau dans la console
    console.log(les9a);

    // Convertir le tableau en une chaîne JSON
    var jsonString = JSON.stringify(les9a);

    // Mettre la chaîne JSON dans le champ de texte
    document.getElementById("list").value = jsonString;

    // Update the selected apartments section
    updateSelectedApartments();
}
function fetchAppAndEtageValues(index, callback) {
    var appId = les9a[index].app;
    var etageId = les9a[index].etage;

    // Fetch app value using AJAX
    $.ajax({
        type: 'get',
        url: '<?php echo admin_url('Corrections/getApp/') ?>'+ appId,
     
        dataType: 'json',
        success: function (appResponse) {
            var appValue = appResponse.result;

            // Fetch etage value using AJAX
            $.ajax({
                type: 'get',
                url: '<?php echo admin_url('Corrections/getEtage/') ?>' +etageId ,
            
                dataType: 'json',
                success: function (etageResponse) {
                    var etageValue = etageResponse.result;

                    // Create apartmentInfo using the fetched values
                    var apartmentInfo = etageValue + " - " + appValue;

                    // Pass the apartmentInfo to the callback
                    callback(apartmentInfo);
                },
                error: function (error) {
                    console.error('Error fetching etage value:', error.statusText);
                    // Pass an error message to the callback
                    callback("Error fetching etage value");
                }
            });
        },
        error: function (error) {
            console.error('Error fetching app value:', error.statusText);
            // Pass an error message to the callback
            callback("Error fetching app value");
        }
    });
}


function updateSelectedApartments() {
    var selectedApartmentsDiv = document.getElementById("selected-apartments-container");
    selectedApartmentsDiv.innerHTML = ""; // Clear previous content

    var count = 0; // Counter to keep track of completed requests

    // Iterate through the selected apartments and display them
    for (var i = 0; i < les9a.length; i++) {
        // Use a closure to capture the current value of i
        (function (index) {
            fetchAppAndEtageValues(index, function (apartmentInfo) {
                // Create a div for each selected apartment with the "selected-apartment" class
                var apartmentDiv = document.createElement("div");
                apartmentDiv.className = "selected-apartment";

                // Add the apartment information
                apartmentDiv.innerHTML = apartmentInfo;

                // Create a remove button with the "remove-button" class
                var removeButton = document.createElement("span");
                removeButton.className = "remove-button";
                removeButton.innerHTML = "&times;";
                removeButton.onclick = createRemoveHandler(index); // Pass index to the handler function

                // Append the remove button to the apartment div
                apartmentDiv.appendChild(removeButton);

                // Append the apartment div to the selected apartments container
                selectedApartmentsDiv.appendChild(apartmentDiv);

                // Increment the counter
                count++;

                // Check if all requests are completed
                if (count === les9a.length) {
                    // All requests are completed, perform any additional actions here
                }
            });
        })(i);
    }
}


// Create a closure to capture the correct value of i
function createRemoveHandler(index) {
    return function() {
        removeApartment(index);
    };
}


function removeApartment(index) {
    // Remove the selected apartment at the specified index
    les9a.splice(index, 1);
    
    // Update the selected apartments section
    updateSelectedApartments();

    // Update the JSON string in the hidden field
    var jsonString = JSON.stringify(les9a);
    document.getElementById("list").value = jsonString;
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
	document.getElementById("appartements").style.display = "block"; 
	document.getElementById("appartements").innerHTML=response; 
 }
 });
}

var sirin = []; // Utiliser un tableau pour stocker les objets

function getList()
{


}

</script>
<?php $current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];?>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Rapports</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Rapports</li>
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
                                <strong>Rapports</strong></h2>
                         
                        </div>

                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Rapport_societe/form/' . $projet_id);?>" enctype="multipart/form-data">
								
								<div class="form-group form-float">
									<label class="form-label"><b>Projet</b></label>
                                    <div class="form-line">
                                        <div class="form-group default-select select2Style">
											<select class="form-control select2" data-placeholder="Select" name="projet_id" id="projet_id" onchange="fetch_blocs(this.value)">
												<option value="">Seclectionner projet</option>
												<?php if($current_admin['super_admin']==1){
													$projets=$this->md_commun->fetch('projets',array('etat'=>1),'asc',10000,0);?>
												<?php if($projets){foreach($projets as $proj){?>
												<option value="<?php echo $proj->id;?>" <?php if($proj->id==$projet_id) echo 'selected';?>><?php echo $proj->projets;?></option>
												<?php }}?>
												<?php }else{
													$projets_admin=$this->md_commun->fetch('projets_admin',array('admin_id'=>$id_admin),'asc',10000,0);
													?>
													<?php if($projets_admin){foreach($projets_admin as $proja){
														$proj=$this->md_commun->get_row('projets',array('id'=>$proja->projet_id));
														if($proj){?>
													<option value="<?php echo $proj->id;?>" <?php if($proj->id==$projet_id) echo 'selected';?>><?php echo $proj->projets;?></option>
													<?php }}}?>
												<?php }?>
											</select>
										</div>
                                    </div>
                                </div>
								
								<div class="row">
							
                                <div class="form-group form-float col-md-12" id="blocs">
									
									<label class="form-label"><b>Entreprise</b></label>
														<div class="form-line">
														<div class="form-group default-select select2Style">
															<select class="form-control select2" multiple="" data-placeholder="Select" name="societe_idx[]">
															<?php $soscs=$this->md_commun->fetch('travaux_societe',array('projet_id'=>$projet_id),'asc',10000,0);
																if($soscs){foreach($soscs as $sox){
																	$sos_id=$this->md_commun->get_row('societes',array('id'=>$sox->societe_id),'asc',10000,0);
																	if($sos_id){
																	$selected='';/*if($bloc->id==$bloc_id) $selected='selected';*/?>
																	<option value="<?php echo $sox->societe_id; ?>" <?php echo $selected;?>><?php echo $sos_id->societes;?></option>
																	<?php }}}?>
															</select>
														</div></div>
									<label class="form-label"><b>Bloc</b></label>
													<div class="form-line">
														<div class="form-group default-select">
														<?php $blocs=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id),'asc',10000,0);?>
														<select class="form-control " name="bloc_idx" onClick="fetch_etages(<?php echo $projet_id;?>,this.value)">
															<option value="">Seclectionner bloc</option>
															<?php if($blocs){foreach($blocs as $bloc){ $selected='';/*if($bloc->id==$bloc_id) $selected='selected';*/?>
															<option value="<?php echo $bloc->id;?>" <?php echo $selected;?>><?php echo $bloc->blocs;?></option>
															<?php }}?>
														</select>
													</div>
									</div>
		
                                </div>
								
								
								
								<div class="form-group form-float col-md-6" id="etages">
									
                                </div>
								
<!-- Add this section to your view to display selected apartments -->
<div id="container">
    <div id="selected-apartments-container">
        <!-- Selected apartments will be displayed here -->
    </div>

    <div class="form-group form-float col-md-6" id="appartements">
        <!-- Your existing code for the select element goes here -->
    </div>
</div>


								<input type="hidden" name="list[]" id="list">
								</div>
								
								<div class="row">
									<div class="form-group form-float col-md-12" >
										<div class="form-line">
												<textarea class="form-control" name="sujet" required></textarea>
												<label class="form-label">Sujet</label>
										</div>
									</div>
									<div class="form-group form-float col-md-12" >
										<div class="form-line">
												<textarea class="form-control" name="content" id="ckeditor" required></textarea>
												<label class="form-label">Remarque</label>
										</div>
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
    