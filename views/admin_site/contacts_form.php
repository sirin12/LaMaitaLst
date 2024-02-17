<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Contact</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
							<?php $societerow=$this->md_commun->get_row('societes',array('id'=>$societe_id));?>
							<a href="<?php echo admin_url('Societes');?>"><?php echo $societerow->societes;?></a>
                            </li>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url('societes/contacts/'.$societe_id);?>">Contact</a></li>
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
                                <strong>Contact</strong></h2>
                         
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="<?php echo admin_url('Societes/form_contacts/'.$societe_id.'/'. $id);?>">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="nom" value="<?php echo $nom;?>" required>
                                        <label class="form-label">Nom</label>
                                    </div>
                                </div>
								<div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="phone" value="<?php echo $phone;?>" required>
                                        <label class="form-label">Téléphone</label>
                                    </div>
                                </div><div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="email" class="form-control" name="email" value="<?php echo $email;?>" required>
                                        <label class="form-label">Email</label>
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
    