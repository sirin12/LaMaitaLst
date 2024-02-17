<html lang="en">
<head>
	<meta charset="utf-8">
	  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta charset="utf-8">     
	<style>
	table{width:100%;margin-top:15px;float:left}
	th,td{text-align:left;padding-left:15px;;}
	body {
		background-image: url(<?php echo admin_img('entete.jpg');?>) ;
	}
	.bg-red{border-radius: 10px !important; padding: 2px 10px !important;width:120px;background:red;color:#fff;font-weight:bold;}
	.table_img th,.table_img td{text-align:left;padding-left:0px;padding:0 !important}
	.leftsidebar{display:none !important}
	</style>
	</head>           
          
<body>

<h2 style="text-align:center;border:solid 3px #ccc;width:50%;float:right;height:70px;padding:10px;"><?php echo $projet->projets;?></h2><br>
<div style="float:left;width:100%">
	<div style="float:left;width:65%">
		<h4 style="text-align:left;width:100%;text-transform:uppercase">CONSTAT ET PROGRAMME DES TRAVAUX</h4>
		<h5 style="text-align:left;width:100%;text-transform:uppercase">Listes des observations et des remarques</h5>
	</div>
	<div style="float:right;width:35%">
		<div style="float:left;width:60%">
			&nbsp;
		</div>
		<div style="float:right;width:60%">
		<b><span style="text-align:center;width:100%">Mise à jour du</span> <hr><?php echo getFrenchDate(date('Y-m-d'));$date_r=date('Y-m-d');?></b>
		</div>
	</div>
</div>
<br><br>
<?php $blocs=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id,'id'=>$bloc_id,'etat'=>1),'asc',100,0);?>
<?php if($blocs){foreach($blocs as $bloc){
$corrections_bloc=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etat'=>1,'afficher'=>1),'asc',100,0);
//correction bloc
if($corrections_bloc){?>
<b><u><?php echo $bloc->blocs;?></u></b><br>
<?php $etages=$this->md_commun->fetch('etages',array('projet_id'=>$projet_id,'blocs_id'=>$bloc->id,'etat'=>1),'asc',100,0);?>
<?php if($etages){foreach($etages as $etage){
$corrections_etage=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'etat'=>1,'afficher'=>1),'asc',100,0);
//correction etage
if($corrections_etage){?>
<b><u>* <?php echo $etage->etages;?></u></b><br>
<?php $apps=$this->md_commun->fetch('appartements',array('projet_id'=>$projet_id,'blocs_id'=>$bloc->id,'etages_id'=>$etage->id,'etat'=>1),'asc',100,0);?>
<?php if($apps){foreach($apps as $app){
$corrections_app=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'appartements_id'=>$app->id,'etat'=>1,'afficher'=>1),'asc',100,0);
//correction etage
if($corrections_app){?>
<table>
	<thead>
	<tr>
		<th align="left">- <?php echo $app->appartements;?></th>
	</tr>
	</thead>
	<tbody>
	<?php $current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id']; if ($current_admin['access'] == 'Admin') {
            $travaux = $this->md_commun->fetch('travaux', array('etat' => 1), 'asc', 100, 0);
        } else {
            $travaux = $this->md_commun->fetch('travaux', array('etat' => 1, 'user_id' => $id_admin), 'asc', 100, 0);
        }?>
	<?php if($travaux){foreach($travaux as $trav){
		
	$corrections_travaux1=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'appartements_id'=>$app->id,'travaux_id'=>$trav->id,'etat'=>1,'afficher'=>1,'etat_urgent'=>2,'etat_correction !='=>3),'asc',100,0);
	//correction travaux
	if($corrections_travaux1){?>
	<tr>
		<td align="left">
			<u style="color:red;"><?php echo $trav->travaux;?></u>
			<?php if($corrections_travaux1){foreach($corrections_travaux1 as $correction){
				$historiques=$this->md_commun->fetch('corrections_historiques',array('correction_id'=>$correction->id,'etat'=>1),'asc',100,0);
				if($correction->etat_correction==1){$etat='Crée';}elseif($correction->etat_correction==4){$etat='En cours';}elseif($correction->etat_correction==2){$etat='Corrigée';}elseif($correction->etat_correction==3){$etat='Validé';}?>
				<li style="list-style:square;color:red"><b><?php echo $correction->localisation;?></b> - <?php echo $correction->intitile;?> (<?php echo $etat;?>) <span style="color:red"><?php if($correction->etat_urgent==2) echo '<span class="label bg-red shadow-style">Urgent</span>';?></span>
				<?php if($historiques){foreach($historiques as $hit){echo '<br><span style="color:red;text-decoration:underline;margin-left-left:10px;">'.$hit->observation_leve.'</span>'; }}?>
				</li>
			<?php }}?>
		</td>
	</tr>
	<?php }
	$corrections_travaux2=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'appartements_id'=>$app->id,'travaux_id'=>$trav->id,'etat'=>1,'afficher'=>1,'etat_urgent'=>1,'etat_correction !='=>3),'asc',100,0);
	//correction travaux
	if($corrections_travaux2){?>
	<tr>
		<td align="left">
			<u><?php echo $trav->travaux;?></u>
			<?php if($corrections_travaux2){foreach($corrections_travaux2 as $correction){
				$historiques=$this->md_commun->fetch('corrections_historiques',array('correction_id'=>$correction->id,'etat'=>1),'asc',100,0);
				if($correction->etat_correction==1){$etat='Crée';}elseif($correction->etat_correction==4){$etat='En cours';}elseif($correction->etat_correction==2){$etat='Corrigée';}elseif($correction->etat_correction==3){$etat='Validé';}?>
				<li style="list-style:square"><b><?php echo $correction->localisation;?></b> - <?php echo $correction->intitile;?> (<?php echo $etat;?>) <span style="color:red"><?php if($correction->etat_urgent==2) echo '<span class="label bg-red shadow-style">Urgent</span>';?></span>
				<?php if($historiques){foreach($historiques as $hit){echo '<br><span style="color:red;text-decoration:underline;margin-left-left:10px;">'.$hit->observation_leve.'</span>'; }}?>
				</li>
			<?php }}?>
		</td>
	</tr>
	<?php }
	//$corrections_travaux3=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'appartements_id'=>$app->id,'travaux_id'=>$trav->id,'etat'=>1,'afficher'=>1,'etat_correction'=>3),'asc',100,0);
	//correction travaux
	//if($corrections_travaux3){?>
<!--	<tr>
		<td align="left">
			<u style="color:blue;"><?php echo $trav->travaux;?></u>
			<?php if($corrections_travaux3){foreach($corrections_travaux3 as $correction){
				$historiques=$this->md_commun->fetch('corrections_historiques',array('correction_id'=>$correction->id,'etat'=>1),'asc',100,0);
				if($correction->etat_correction==1){$etat='Crée';}elseif($correction->etat_correction==4){$etat='En cours';}elseif($correction->etat_correction==2){$etat='Corrigée';}elseif($correction->etat_correction==3){$etat='Validé';}?>
				<li style="list-style:square;color:blue;"><b><?php echo $correction->localisation;?></b> - <?php echo $correction->intitile;?> (<?php echo $etat;?>) 
				<?php if($historiques){foreach($historiques as $hit){echo '<br><span style="color:blue;text-decoration:underline;margin-left-left:10px;">'.$hit->observation_leve.'</span>'; }}?>
				</li>
			<?php }}?>
		</td>
	</tr>-->
	<?php //}?>
	<!--end correction travaux-->
	<?php }}?>
	</tbody>
</table>
<?php }?>
<!--end correction app-->
<?php }}?>
<?php }?>
<!--end correction etage-->
<?php }}?>
<?php }?>
<!--end correction bloc-->
<?php }}?>





<?php $blocs=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id,'id'=>$bloc_id,'etat'=>1),'asc',100,0);?>
<?php if($blocs){foreach($blocs as $bloc){
$corrections_bloc=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etat'=>1,'afficher'=>1),'asc',100,0);
//correction bloc
if($corrections_bloc){?>
<?php $etages=$this->md_commun->fetch('etages',array('projet_id'=>$projet_id,'blocs_id'=>$bloc->id,'etat'=>1),'asc',100,0);?>
<?php if($etages){foreach($etages as $etage){
$corrections_etage=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'etat'=>1,'afficher'=>1),'asc',100,0);
//correction etage
if($corrections_etage){?>
<?php $apps=$this->md_commun->fetch('appartements',array('projet_id'=>$projet_id,'blocs_id'=>$bloc->id,'etages_id'=>$etage->id,'etat'=>1),'asc',100,0);?>
<?php if($apps){foreach($apps as $app){
$corrections_app=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'appartements_id'=>$app->id,'etat'=>1,'afficher'=>1),'asc',100,0);
//correction etage
if($corrections_app){?>
	<?php $ic=0;?>
	
	<?php $current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id']; if ($current_admin['access'] == 'Admin') {
            $travaux = $this->md_commun->fetch('travaux', array('etat' => 1), 'asc', 100, 0);
        } else {
            $travaux = $this->md_commun->fetch('travaux', array('etat' => 1, 'user_id' => $id_admin), 'asc', 100, 0);
        }?>
	<?php if($travaux){foreach($travaux as $trav){
		
	$corrections_travaux1=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'appartements_id'=>$app->id,'travaux_id'=>$trav->id,'etat'=>1,'afficher'=>1,'etat_urgent'=>2,'etat_correction !='=>3),'asc',100,0);
	//correction travaux
	if($corrections_travaux1){?>
	
		
			<?php if($corrections_travaux1){foreach($corrections_travaux1 as $correction){ 
				$historiques=$this->md_commun->fetch('corrections_historiques',array('correction_id'=>$correction->id,'etat'=>1),'asc',100,0);
				if($correction->etat_correction==1){$etat='Crée';}elseif($correction->etat_correction==4){$etat='En cours';}elseif($correction->etat_correction==2){$etat='Corrigée';}elseif($correction->etat_correction==3){$etat='Validé';}?>
				<?php if($correction->image){$ic++;?>
				<div align="left" style="width:220px;padding-right:10px;float:left; padding-bottom:10px;">
					
					<div style="float:left;width:100%;height:220px;display:block">
						<img src="<?php echo uploads('images/medium/'.$correction->image);?>" style="width:100%;height:220px;object-fit:cover">
					</div>
					<div align="left" style="border:solid 1px #585499;width:100%;float:left;background:#e9e9e9;height:30px;font-size:10px;padding-top:10px;">
							<b>[<?php echo $app->appartements;?>] <?php echo $correction->localisation;?></b> - <?php echo $correction->intitile;?> (<?php echo $etat;?>) <span style="color:red"><?php if($correction->etat_urgent==2) echo '<span class="label bg-red shadow-style">Urgent</span>';?></span>
					</div>	
				</div>
				<?php }?>
			<?php }}?>
	
	<?php }
	$corrections_travaux2=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'appartements_id'=>$app->id,'travaux_id'=>$trav->id,'etat'=>1,'afficher'=>1,'etat_urgent'=>1,'etat_correction !='=>3),'asc',100,0);
	//correction travaux
	if($corrections_travaux2){?>
			<?php if($corrections_travaux2){foreach($corrections_travaux2 as $correction){
				$historiques=$this->md_commun->fetch('corrections_historiques',array('correction_id'=>$correction->id,'etat'=>1),'asc',100,0);
				if($correction->etat_correction==1){$etat='Crée';}elseif($correction->etat_correction==4){$etat='En cours';}elseif($correction->etat_correction==2){$etat='Corrigée';}elseif($correction->etat_correction==3){$etat='Validé';}?>
				<?php if($correction->image){$ic++;?>
				<div align="left" style="width:220px;padding-right:10px;float:left; padding-bottom:10px;">
				
					<div style="float:left;width:100%;height:220px;display:block">
						<img src="<?php echo uploads('images/medium/'.$correction->image);?>" style="width:100%;height:220px;object-fit:cover">
					</div>
					<div align="left" style="border:solid 1px #585499;width:100%;float:left;background:#e9e9e9;height:30px;font-size:10px;padding-top:10px;">
						<b>[<?php echo $app->appartements;?>] <?php echo $correction->localisation;?></b> - <?php echo $correction->intitile;?> (<?php echo $etat;?>) <span style="color:red"><?php if($correction->etat_urgent==2) echo '<span class="label bg-red shadow-style">Urgent</span>';?></span>
					</div>	
				</div>
				<?php }?>
			<?php }}?>
	<?php }
	//$corrections_travaux3=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'appartements_id'=>$app->id,'travaux_id'=>$trav->id,'etat'=>1,'afficher'=>1,'etat_correction'=>3),'asc',100,0);
	//correction travaux
	//if($corrections_travaux3){?>
<!--
			<?php if($corrections_travaux3){foreach($corrections_travaux3 as $correction){
				$historiques=$this->md_commun->fetch('corrections_historiques',array('correction_id'=>$correction->id,'etat'=>1),'asc',100,0);
				if($correction->etat_correction==1){$etat='Crée';}elseif($correction->etat_correction==4){$etat='En cours';}elseif($correction->etat_correction==2){$etat='Corrigée';}elseif($correction->etat_correction==3){$etat='Validé';}?>
				<?php if($correction->image){$ic++;?>
				<div align="left" style="width:220px;padding-right:10px;float:left; padding-bottom:10px;">
					<div style="float:left;width:100%;height:220px;display:block">
						<img src="<?php echo uploads('images/medium/'.$correction->image);?>" style="width:100%;height:220px;object-fit:cover">
					</div>
					<div align="left" style="border:solid 1px #585499;width:100%;float:left;background:#e9e9e9;height:30px;font-size:10px;padding-top:10px;">
						<b>[<?php echo $app->appartements;?>] <?php echo $correction->localisation;?></b> - <?php echo $correction->intitile;?> (<?php echo $etat;?>) <span style="color:red"><?php if($correction->etat_urgent==2) echo '<span class="label bg-red shadow-style">Urgent</span>';?></span>
					</div>
				</div>	-->
				<?php //}?>				
			<?php }}?>
	
	<?php }?>
	<!--end correction travaux-->
	<?php }}?>
<?php }?>
<!--end correction app-->
<?php }}?>
<?php }?>
<!--end correction etage-->
<?php }}?>
<?php }?>
<!--end correction bloc-->
<?php }}?>
</body>
</html>
<?php
$HTMLoutput = ob_get_contents();
ob_end_clean();
		$mpdf=new mpdf('en','a4','','',10,15,35,25,0,5); 
		
		$mpdf->SetDirectionality('ltr');
		$mpdf->mirrorMargins = false;
		$mpdf->Addpage();
		$mpdf->setFooter("Page {PAGENO} sur {nb}");
		$mpdf->defaultheaderfontstyle='B';
		$mpdf->SetDefaultBodyCSS('background-image-resize', 6);
		$mpdf->WriteHTML($HTMLoutput);

		$mpdf->Output('rapport_bloc_'.$date_r.'.pdf', 'I');
		?>