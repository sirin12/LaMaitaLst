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
 $.ajax({
 type: 'post',
 url: '<?php echo admin_url('Corrections/fetch_societes/') ?>'+val,
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
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Corrections/historiques_form/'.$cor_id.'/'. $id);?>" enctype="multipart/form-data">
								
								<div class="form-group form-float">
									<label class="form-label"><b>Observation </b></label>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="observation_leve" value="<?php echo $observation_leve;?>" >
                                        <label class="form-label">Observation </label>
                                    </div>
                                </div>
								<div class="form-group form-float">
									<label class="form-label"><b>Date </b></label>
                                    <div class="form-line">
                                        <input type="date" class="form-control" name="date_leve" value="<?php echo $date_leve;?>" required>
                                        <label class="form-label">Date </label>
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
    