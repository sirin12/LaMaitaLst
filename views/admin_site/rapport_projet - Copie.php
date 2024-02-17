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
<?php if($blocs){foreach($blocs as $bloc){
$corrections_bloc=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etat'=>1,'etat_correction !='=>3),'asc',100,0);
//correction bloc
if($corrections_bloc){?>
<b><u><?php echo $bloc->blocs;?></u></b>
<?php $etages=$this->md_commun->fetch('etages',array('projet_id'=>$projet_id,'blocs_id'=>$bloc->id,'etat'=>1),'asc',100,0);?>
<?php if($etages){foreach($etages as $etage){
$corrections_etage=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'etat'=>1,'etat_correction !='=>3),'asc',100,0);
//correction etage
if($corrections_etage){?>
<table>
	<thead>
	<tr>
		<th align="left">- <?php echo $etage->etages;?></th>
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
		
	$corrections_travaux1=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'travaux_id'=>$trav->id,'etat'=>1,'etat_urgent'=>2,'etat_correction !='=>3),'asc',100,0);
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
	$corrections_travaux2=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'travaux_id'=>$trav->id,'etat'=>1,'etat_urgent'=>1,'etat_correction !='=>3),'asc',100,0);
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
	$corrections_travaux3=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'travaux_id'=>$trav->id,'etat'=>1,'etat_correction'=>3),'asc',100,0);
	//correction travaux
	if($corrections_travaux3){?>
	<tr>
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
	</tr>
	<?php }?>
	<!--end correction travaux-->
	<?php }}?>
	</tbody>
</table>
<?php }?>
<!--end correction etage-->
<?php }}?>
<?php }?>
<!--end correction bloc-->
<?php }}?>



<?php if($blocs){foreach($blocs as $bloc){
$corrections_bloc=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etat'=>1,'etat_correction !='=>3),'asc',100,0);
//correction bloc
if($corrections_bloc){?>
<?php $etages=$this->md_commun->fetch('etages',array('projet_id'=>$projet_id,'blocs_id'=>$bloc->id,'etat'=>1),'asc',100,0);?>
<?php if($etages){foreach($etages as $etage){
$corrections_etage=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'etat'=>1,'etat_correction !='=>3),'asc',100,0);
//correction etage
if($corrections_etage){?>
<table style="width:100%" class="table_img">

	<tbody>
	<?php $ic=0;?>
	<tr>
	<?php $current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id']; if ($current_admin['access'] == 'Admin') {
            $travaux = $this->md_commun->fetch('travaux', array('etat' => 1), 'asc', 100, 0);
        } else {
            $travaux = $this->md_commun->fetch('travaux', array('etat' => 1, 'user_id' => $id_admin), 'asc', 100, 0);
        }?>
	<?php if($travaux){foreach($travaux as $trav){
		
	$corrections_travaux1=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'travaux_id'=>$trav->id,'etat'=>1,'etat_urgent'=>2,'etat_correction !='=>3),'asc',100,0);
	//correction travaux
	if($corrections_travaux1){?>
	
		
			<?php /*if($corrections_travaux1){foreach($corrections_travaux1 as $correction){ 
				$historiques=$this->md_commun->fetch('corrections_historiques',array('correction_id'=>$correction->id,'etat'=>1),'asc',100,0);
				if($correction->etat_correction==1){$etat='Crée';}elseif($correction->etat_correction==4){$etat='En cours';}elseif($correction->etat_correction==2){$etat='Corrigée';}elseif($correction->etat_correction==3){$etat='Validé';}?>
				<?php if($correction->image){$ic++;?>
				<td  style="border:solid 1px #585499;width:33%;margin-right:1%;float:left;margin:15px">
					
					<div style="float:left;width:100%;height:500px;display:block">
						<img src="<?php echo uploads('images/full/'.$correction->image);?>" style="width:100%;height:500px;object-fit:cover">
					</div>
					<div align="left" style="border:solid 1px #585499;width:100%;height:100px;float:left;color:red;background:#e9e9e9;height:40px;font-size:30px;padding-top:15px;padding-bottom:15px;">
							<b><?php echo $correction->localisation;?></b> - <?php echo $correction->intitile;?> (<?php echo $etat;?>) <span style="color:red"><?php if($correction->etat_urgent==2) echo '<span class="label bg-red shadow-style">Urgent</span>';?></span>
					</div>	
				</td>
				<?php }?>
				<?php if($ic%3==0)echo '</tr><tr>';?>
			<?php }}*/?>
	
	<?php }
	$corrections_travaux2=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'travaux_id'=>$trav->id,'etat'=>1,'etat_urgent'=>1,'etat_correction !='=>3),'asc',100,0);
	//correction travaux
	if($corrections_travaux2){?>
			<?php if($corrections_travaux2){foreach($corrections_travaux2 as $correction){
				$historiques=$this->md_commun->fetch('corrections_historiques',array('correction_id'=>$correction->id,'etat'=>1),'asc',100,0);
				if($correction->etat_correction==1){$etat='Crée';}elseif($correction->etat_correction==4){$etat='En cours';}elseif($correction->etat_correction==2){$etat='Corrigée';}elseif($correction->etat_correction==3){$etat='Validé';}?>
				<?php if($correction->image){$ic++;?>
				<td align="left" style="width:33%;margin-right:1%;float:left;padding:15px;">
				
					<div style="float:left;width:100%;height:500px;display:block">
						<img src="<?php echo uploads('images/full/'.$correction->image);?>" style="width:100%;height:500px;object-fit:cover">
					</div>
					<div align="left" style="border:solid 1px #585499;width:100%;height:100px;float:left;background:#e9e9e9;height:40px;font-size:30px;padding-top:15px;padding-bottom:15px;">
						<b><?php echo $correction->localisation;?></b> - <?php echo $correction->intitile;?> (<?php echo $etat;?>) <span style="color:red"><?php if($correction->etat_urgent==2) echo '<span class="label bg-red shadow-style">Urgent</span>';?></span>
					</div>	
				</td>
				<?php }?>
				<?php if($ic%3==0)echo '</tr><tr>';?>
			<?php }}?>
	<?php }
	$corrections_travaux3=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'travaux_id'=>$trav->id,'etat'=>1,'etat_correction'=>3),'asc',100,0);
	//correction travaux
	if($corrections_travaux3){?>

			<?php if($corrections_travaux3){foreach($corrections_travaux3 as $correction){
				$historiques=$this->md_commun->fetch('corrections_historiques',array('correction_id'=>$correction->id,'etat'=>1),'asc',100,0);
				if($correction->etat_correction==1){$etat='Crée';}elseif($correction->etat_correction==4){$etat='En cours';}elseif($correction->etat_correction==2){$etat='Corrigée';}elseif($correction->etat_correction==3){$etat='Validé';}?>
				<?php if($correction->image){$ic++;?>
				<td align="left" style="width:33%;margin-right:1%;float:left;padding:15px;">
				
					<div style="float:left;width:100%;height:500px;display:block">
						<img src="<?php echo uploads('images/full/'.$correction->image);?>" style="width:100%;height:500px;object-fit:cover">
					</div>
					<div align="left" style="border:solid 1px #585499;width:100%;height:100px;float:left;color:blue;background:#e9e9e9;height:40px;font-size:30px;padding-top:15px;padding-bottom:15px;">
						<b><?php echo $correction->localisation;?></b> - <?php echo $correction->intitile;?> (<?php echo $etat;?>) <span style="color:red"><?php if($correction->etat_urgent==2) echo '<span class="label bg-red shadow-style">Urgent</span>';?></span>
					</div>
				</td>	
				<?php }?>
				<?php if($ic%3==0)echo '</tr><tr>';?>				
			<?php }}?>
	
	<?php }?>
	<!--end correction travaux-->
	<?php }}?>
		<?php $icmod=$ic % 3;
		
		if($icmod==2)
			echo '<td style="border:solid 1px transparent;width:33%;margin-right:1%;float:left;"></td>';
		elseif($icmod==1)
			echo '<td style="border:solid 1px transparent;width:33%;margin-right:1%;float:left;"></td><td style="border:solid 1px transparent;width:24%;margin-right:1%;float:left;"></td>';
		
		?>
		
	</tr>
	</tbody>
</table>
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
		$mpdf=new mpdf('en','a4','','',10,15,35,20,0,0); 
		
		$mpdf->SetDirectionality('ltr');
		$mpdf->mirrorMargins = false;
		$mpdf->Addpage();
		$mpdf->setFooter("Page {PAGENO} sur {nb}");
		$mpdf->defaultheaderfontstyle='B';
		$mpdf->SetDefaultBodyCSS('background-image-resize', 6);
		$mpdf->WriteHTML($HTMLoutput);

		$mpdf->Output('rapport_projet_'.$date_r.'.pdf', 'I');
		?>