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
                            <li class="breadcrumb-item "><a href="<?php echo admin_url('Corrections');?>">Corrections</a></li>
							<li class="breadcrumb-item active">Observations</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
							<?php $journalid=$this->md_commun->get_row('corrections',array('id'=>$cor_id));?>
                            <h2>
                                <strong>Observations "<?php echo $journalid->intitile;?>"</strong>
								<a href="<?php echo admin_url('Corrections/historiques_form/'.$cor_id);?>" class="btn bg-blue waves-effect" style="float:right"><i class="fa fa-plus" style="padding-top: 5px;font-size: 16px;"></i> Ajouter</a>
							</h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="tableExport"
                                    class="display table table-hover table-checkable order-column m-t-20 width-per-100">
                                    <thead>
                                        <tr>
                                            <th>Observations</th>
											<th>Date</th>
											<th>Admin</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if($corrections){foreach($corrections as $cor){?>
                                        <tr>
                                            <td><?php echo $cor->observation_leve;?></td>
											<td><?php echo $cor->date_leve;?></td>
											<td><?php $admin_id=$this->md_commun->get_row('admin',array('id'=>$cor->user));echo $admin_id->firstname.' '.$admin_id->lastname;?></td>
                                            <td width="100">
												<a href="<?php echo admin_url('Corrections/historiques_form/'.$cor_id.'/'.$cor->id);?>" class="btn bg-teal waves-effect"><i class="fas fa-pen"></i> <span class="btn_desctopp">Modifier</span></a>
											</td>
                                        </tr>
                                    <?php }}?>    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Observations</th>
											<th>Date</th>
											<th>Admin</th>
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
   