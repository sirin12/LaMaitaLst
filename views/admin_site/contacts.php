<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Societes</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
							<li class="breadcrumb-item bcrumb-1">
							<?php $societerow=$this->md_commun->get_row('societes',array('id'=>$societe_id));?>
							<a href="<?php echo admin_url('Societes');?>"><?php echo $societerow->societes;?></a>
                            </li>
                            <li class="breadcrumb-item active">Contacts</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Contacts</strong>
								<a href="<?php echo admin_url('Societes/form_contacts/'.$societe_id);?>" class="btn bg-blue waves-effect" style="float:right"><i class="fa fa-plus" style="padding-top: 5px;font-size: 16px;"></i> Ajouter</a>
							</h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="tableExport"
                                    class="display table table-hover table-checkable order-column m-t-20 width-per-100">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
											<th>Téléphone</th>
											<th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if($contacts){foreach($contacts as $contact){?>
                                        <tr>
                                            <td><?php echo $contact->nom;?></td>
											<td><?php echo $contact->phone;?></td>
											<td><?php echo $contact->email;?></td>
                                            <td width="230">
											<a href="<?php echo admin_url('Societes/form_contacts/'.$societe_id.'/'.$contact->id);?>" class="btn bg-teal waves-effect"><i class="fas fa-pen"></i> <span class="btn_desctopp">Modifier</span></a>
											<a href="<?php echo admin_url('Societes/delete_contact/'.$societe_id.'/'.$contact->id);?>" class="btn bg-red waves-effect"><i class="fas fa-trash-alt"></i> <span class="btn_desctopp" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')">Supprimer</span></a>
											</td>
                                        </tr>
                                    <?php }}?>    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nom</th>
											<th>Téléphone</th>
											<th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>
    </section>
   