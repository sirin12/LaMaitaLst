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
	.bg-red{border-radius: 10px !important; padding: 2px 10px;width:100px;background:red;color:#fff;}
	.table_img th,.table_img td{text-align:left;padding-left:0px;padding:0 !important}
	.leftsidebar{display:none !important}
	</style>
	</head>           
          
<body>
<?php $date_raport=$rapport_societe->date;?>
<?php $list_societe = $this->md_commun->fetch('rapport_projet_societes',array('rapport_id'=>$rapport_societe->id),'asc',100,0); $i=0;
//var_dump($list_societe);exit;
$i = count($this->md_commun->fetch('rapport_projet_societes',array('rapport_id'=>$rapport_societe->id),'asc',100,0)) ;  
//var_dump($list_societe);exit;
if($i == 1){
	$soc =$this->md_commun->get_row('societes',array('id'=>$list_societe[0]->societe_id)); 
	
}


//var_dump($projet);exit;
?>
<h2 style="text-align:center;border:solid 3px #ccc;width:50%;float:right;height:70px;padding:10px;"><?php echo $projet->projets ; ?><br><?php echo $rapport_societe->sujet ; ?><br> <?php if($i == 1){ ?><span><?php echo $soc->societes;  ?></span><?php } ?></h2><br>

<div style="float:left;width:100%">
	<div style="float:left;width:65%">
		<h4 style="text-align:left;width:100%;text-transform:uppercase">Liste Entreprises : </h4>

		<?php 
		if($list_societe){
		foreach ($list_societe as $list){
		//echo $list->societe_id;
				$societe_n=$this->md_commun->get_row('societes',array('id'=>$list->societe_id)); 
		?>
		<span><?php echo $societe_n->societes;  ?></span><br>
		<?php }}?>

		<h5 style="text-align:left;width:100%;text-transform:uppercase">Listes des observations et des remarques</h5>
	</div>
	<div style="float:right;width:35%">
		<div style="float:left;width:60%">
			&nbsp;
		</div>
		<div style="float:right;width:60%">
		<b><span style="text-align:center;width:100%">Mise à jour du</span> <hr><?php echo getFrenchDate($date_raport);$date_r=$date_raport;?></b>
		</div>
	</div>
</div>
<br><br>
<?php if($societes_projet){foreach($societes_projet as $sos_proj){
$sos_id==$societe_id=$sos_proj->societe_id;
$projetid=$this->md_commun->get_row('projets',array('id'=>$rapport_societe->projet_id,'etat'=>1));?>

<?php $blocs=$this->md_commun->fetch('blocs',array('projet_id'=>$rapport_societe->projet_id,'etat'=>1),'asc',100,0);
$projet_id=$rapport_societe->projet_id;
if($blocs){foreach($blocs as $bloc){
if($rapport_societe->bloc_id==0){
	$corrections_bloc=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'afficher'=>1,'etat'=>1),'asc',100,0);
}else{
	if($rapport_societe->bloc_id==$bloc->id){
	$corrections_bloc=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'afficher'=>1,'etat'=>1),'asc',100,0);
	}else{$corrections_bloc='';}
}
//correction bloc
		
if($corrections_bloc){?>
<b><u><?php echo $bloc->blocs;?></u></b><br>
<?php $etages=$this->md_commun->fetch('etages',array('projet_id'=>$projet_id,'blocs_id'=>$bloc->id,'etat'=>1),'asc',100,0);?>
<?php if($etages){foreach($etages as $etage){
if($rapport_societe->etage_id==0){
	$corrections_etage=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'afficher'=>1,'etat'=>1),'asc',100,0);
}else{
	if($rapport_societe->etage_id==$etage->id){
		$corrections_etage=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'afficher'=>1,'etat'=>1),'asc',100,0);
	}else{$corrections_etage='';}
}
//correction etage
if($corrections_etage){?>
<b>- <?php echo $etage->etages;?></b>
<?php $apps=$this->md_commun->fetch('appartements',array('projet_id'=>$projet_id,'blocs_id'=>$bloc->id,'etages_id'=>$etage->id,'etat'=>1),'asc',100,0);?>
<?php if($apps){foreach($apps as $app){
if($rapport_societe->appartements_id==0){
	$corrections_app=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'afficher'=>1,'etat'=>1),'asc',100,0);
}else{
	if($rapport_societe->appartements_id==$app->id){
		$corrections_app=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'appartements_id'=>$app->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'afficher'=>1,'etat'=>1),'asc',100,0);
	}else{$corrections_app='';}
}
//correction etage
if($corrections_app){
	$corrections_travaux=$corrections=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'appartements_id'=>$app->id,'etage_id'=>$etage->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'societe_id'=>$societe_id,'afficher'=>1,'etat'=>1),'asc',100,0);
	?>
	<?php if($corrections_travaux){?>
<table>
	
	<thead>
	<tr>
		<th align="left">- <?php echo $app->appartements;?></th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td align="left">
			<?php $sosid=$this->md_commun->get_row('societes',array('id'=>$societe_id));?>
			<u><?php echo $sosid->societes;?></u>
			<?php if($corrections){foreach($corrections as $correction){
				$historiques=$this->md_commun->fetch('corrections_historiques',array('correction_id'=>$correction->id,'etat'=>1),'asc',100,0);
				if($correction->etat_correction==1){$etat='Crée';}elseif($correction->etat_correction==4){$etat='En cours';}elseif($correction->etat_correction==2){$etat='Corrigée';}elseif($correction->etat_correction==3){$etat='achevé';}?>
				<li style="list-style:square">
					<span style="<?php if($correction->etat_correction==3){?>color:green<?php }?>">
					<b><?php echo $correction->localisation;?></b> - <?php echo $correction->intitile;?> (<?php echo $etat;?>) 
					</span>
					<?php if($correction->etat_correction!=3){?>
					<span style="color:red"><?php if($correction->etat_urgent==2) echo '<span class="label bg-red shadow-style">Urgent</span>';?></span>
					<?php }?>
				<?php if($historiques){foreach($historiques as $hit){echo '<br><span style="color:red;text-decoration:underline;margin-left-left:10px;">'.$hit->observation_leve.'</span>'; }}?>
				</li>
			<?php }}?>
		</td>
	</tr>
	<?php }?>
	<!--end correction travaux-->
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
<?php }}?>




<?php if($societes_projet){foreach($societes_projet as $sos_proj){
$sos_id==$societe_id=$sos_proj->societe_id;
$projetid=$this->md_commun->get_row('projets',array('id'=>$rapport_societe->projet_id,'etat'=>1));?>

<?php $blocs=$this->md_commun->fetch('blocs',array('projet_id'=>$rapport_societe->projet_id,'etat'=>1),'asc',100,0);
$projet_id=$rapport_societe->projet_id;
if($blocs){foreach($blocs as $bloc){
if($rapport_societe->bloc_id==0){
	$corrections_bloc=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'afficher'=>1,'etat'=>1),'asc',100,0);
}else{
	if($rapport_societe->bloc_id==$bloc->id){
	$corrections_bloc=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'afficher'=>1,'etat'=>1),'asc',100,0);
	}else{$corrections_bloc='';}
}
//correction bloc
		
if($corrections_bloc){?>

<?php $etages=$this->md_commun->fetch('etages',array('projet_id'=>$projet_id,'blocs_id'=>$bloc->id,'etat'=>1),'asc',100,0);?>
<?php if($etages){foreach($etages as $etage){
if($rapport_societe->etage_id==0){
	$corrections_etage=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'afficher'=>1,'etat'=>1),'asc',100,0);
}else{
	if($rapport_societe->etage_id==$etage->id){
		$corrections_etage=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'afficher'=>1,'etat'=>1),'asc',100,0);
	}else{$corrections_etage='';}
}
//correction etage
if($corrections_etage){?>
<?php $apps=$this->md_commun->fetch('appartements',array('projet_id'=>$projet_id,'blocs_id'=>$bloc->id,'etages_id'=>$etage->id,'etat'=>1),'asc',100,0);?>
<?php if($apps){foreach($apps as $app){
if($rapport_societe->appartements_id==0){
	$corrections_app=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'afficher'=>1,'etat'=>1),'asc',100,0);
}else{
	if($rapport_societe->appartements_id==$app->id){
		$corrections_app=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'appartements_id'=>$app->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'afficher'=>1,'etat'=>1),'asc',100,0);
	}else{$corrections_app='';}
}
//correction etage
if($corrections_app){?>
	<?php $corrections_travaux=$corrections=$this->md_commun->fetch('corrections',array('archive'=>0,'projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'appartements_id'=>$app->id,'etage_id'=>$etage->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'societe_id'=>$societe_id,'afficher'=>1,'etat'=>1),'asc',100,0);
	//correction travaux
	if($corrections_travaux){?>
			<?php if($corrections_travaux){foreach($corrections_travaux as $correction){
				$historiques=$this->md_commun->fetch('corrections_historiques',array('correction_id'=>$correction->id,'etat'=>1),'asc',100,0);
				if($correction->etat_correction==1){$etat='Crée';}elseif($correction->etat_correction==4){$etat='En cours';}elseif($correction->etat_correction==2){$etat='Corrigée';}elseif($correction->etat_correction==3){$etat='Achevé';}?>
				
				<?php if($correction->image){$ic++;?>
				<?php if($correction->etat_correction!=3){?>
					<div align="left" style="width:220px;padding-right:10px;float:left; padding-bottom:10px;">
					<div style="float:left;width:100%;height:220px;display:block">
						<img src="<?php echo uploads('images/medium/'.$correction->image);?>" style="width:100%;height:220px;object-fit:cover">
					</div>
					<div align="left" style="border:solid 1px #585499;width:100%;float:left;background:#e9e9e9;height:30px;font-size:10px;padding-top:10px;">
						<span style="<?php if($correction->etat_correction==3){?>color:green<?php }?>">
						<b>[<?php echo $app->appartements;?>] <?php echo $correction->localisation;?></b> - <?php echo $correction->intitile;?> (<?php echo $etat;?>) 
						</span>
						<?php if($correction->etat_correction!=3){?>
						<span style="color:red"><?php if($correction->etat_urgent==2) echo '<span class="label bg-red shadow-style">Urgent</span>';?></span>
						<?php }?>
					</div>
				</div>	
				<?php }}?>	
			<?php }}?>

	<?php }?>
	<!--end correction travaux-->

<?php }?>
<!--end correction etage-->
<?php }}?>
<?php }?>
<!--end correction etage-->
<?php }}?>
<?php }?>
<!--end correction bloc-->
<?php }}?>
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

		$mpdf->Output('rapport_societe.pdf', 'I');
		?>