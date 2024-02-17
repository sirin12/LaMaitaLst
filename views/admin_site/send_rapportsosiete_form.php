<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Envoie email</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Envoie email</li>
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
                                <strong>Envoie email</strong></h2>
                         
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Rapport_societe/send_email/'.$id);?>" enctype="multipart/form-data">
							
								<?php $rapport_id=$this->md_commun->get_row('rapport_projet_societe',array('id'=>$id));
								$societes_email=$this->md_commun->fetch('rapport_projet_societes',array('rapport_id'=>$id),'asc',1000,0);
								$email_lists='';if($societes_email){
									foreach($societes_email as $emailsos) {
									$societes_contactemail=$this->md_commun->fetch('contacts',array('societe_id'=>$emailsos->societe_id),'asc',1000,0);
									if($societes_contactemail){foreach($societes_contactemail as $contact){$email_lists .=$contact->email.'; ';}}
									}?>
									<div class="form-group form-float col-md-12">
										<div class="form-line">
											<input type="text" class="form-control" name="email" value="<?php echo $email_lists;?>" required>
											<label class="form-label">Email(separer par ;)</label>
										</div>
									</div>
								<?php }?>
									
									<div class="form-group form-float col-md-12"> 
										<div class="form-line">
											<input type="file" class="form-control" name="file" value="" >
											<label class="form-label">Rapports</label>
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
    