<script type="text/javascript">
    function areyousure()
    {
        return confirm('Êtes-vous sûr de vouloir supprimer cet client ?');
    }
</script>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Clients</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo admin_url('');?>">
                                    <i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Clients</li>
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
                                <strong>Clients</strong>
								<a href="<?php echo admin_url('Clients/form/');?>" class="btn bg-blue waves-effect" style="float:right"><i class="fa fa-plus" style="padding-top: 5px;font-size: 16px;"></i> Ajouter</a>
							</h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="tableExport"
                                    class="display table table-hover table-checkable order-column m-t-20 width-per-100">
                                    <thead>
                                        <tr>
                                            <th>Clients</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php if($clients){foreach($clients as $client){?>
                                        <tr>
                                            <td><?php echo $client->clients;?></td>
                                            <td width="230">
											<a href="<?php echo admin_url('clients/form/'.$client->id);?>" class="btn bg-teal waves-effect"><i class="fas fa-pen"></i> <span class="btn_desctopp">Modifier</span></a>
											<a href="<?php echo admin_url('clients/delete/'.$client->id);?>" class="btn bg-red waves-effect" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fas fa-trash-alt"></i> <span class="btn_desctopp">Supprimer</span></a>
											</td>
                                        </tr>
                                    <?php }}?>    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Clients</th>
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
   