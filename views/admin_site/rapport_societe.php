<?php require_once('vendor/autoload.php');
$mpdf = new \Mpdf\Mpdf([
        'default_font' => 'FreeSerif',
        'mode' => 'utf-8',
        'margin_top'=>35,
        'margin_buttom'=>5,
		'margin_left'=>10,
        'margin_right'=>15,
    ]);
ob_start();
?>
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
<h2 style="text-align:center"><?php echo $projet->projets;?></h2><br>
<h2 style="text-align:center">Constat d’avancement et Programmes des travaux</h2><br>
<b>Mise à jour du <?php echo $date_raport;?>.</b>
<br><br>
<?php if($societes_projet){foreach($societes_projet as $sos_proj){
$trav_id=$sos_proj->travaux_id;
$projetid=$this->md_commun->get_row('projets',array('id'=>$sos_proj->projet_id,'etat'=>1));?>
<b><?php echo $projetid->projets;?></b><br>
<?php $blocs=$this->md_commun->fetch('blocs',array('projet_id'=>$sos_proj->projet_id,'etat'=>1),'asc',100,0);
$projet_id=$sos_proj->projet_id;
if($blocs){foreach($blocs as $bloc){
$corrections_bloc=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'etat'=>1,'etat_correction !='=>3,'afficher'=>1),'asc',100,0);
//correction bloc
if($corrections_bloc){?>
<b><u><?php echo $bloc->blocs;?></u></b>
<?php $etages=$this->md_commun->fetch('etages',array('projet_id'=>$projet_id,'blocs_id'=>$bloc->id,'etat'=>1),'asc',100,0);?>
<?php if($etages){foreach($etages as $etage){
$corrections_etage=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'societe_id'=>$societe_id,'date <='=>$date_raport,'etat'=>1,'etat_correction !='=>3,'afficher'=>1),'asc',100,0);
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
	if($trav_id=$trav->id){
	$corrections_travaux=$corrections=$this->md_commun->fetch('corrections',array('projet_id'=>$projet_id,'bloc_id'=>$bloc->id,'etage_id'=>$etage->id,'travaux_id'=>$trav->id,'date <='=>$date_raport,'societe_id'=>$societe_id,'etat'=>1,'etat_correction !='=>3,'afficher'=>1),'asc',100,0);
	//correction travaux
	if($corrections_travaux){?>
	<tr>
		<td align="left">
			<u><?php echo $trav->travaux;?></u>
			<?php if($corrections){foreach($corrections as $correction){
				$historiques=$this->md_commun->fetch('corrections_historiques',array('correction_id'=>$correction->id,'etat'=>1),'asc',100,0);
				if($correction->etat_correction==1){$etat='Crée';}elseif($correction->etat_correction==4){$etat='En cours';}elseif($correction->etat_correction==2){$etat='Corrigée';}elseif($correction->etat_correction==3){$etat='Validé';}?>
				<div style="list-style:square"><b><?php echo $correction->localisation;?></b> - <?php echo $correction->intitile;?> (<?php echo $etat;?>) <b style="color:red"><?php if($correction->etat_urgent==2) echo '(URGENT)';?></b>
				<?php if($historiques){foreach($historiques as $hit){echo '<br><span style="color:red;text-decoration:underline;margin-left-left:10px;">'.$hit->observation_leve.'</span>'; }}?>
				</div>
			<?php }}?>
		</td>
	</tr>
	<?php }}?>
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
<?php }}?>
</body>
</html>
<?php 
$html = ob_get_contents();
ob_end_clean();

	//$mpdf=new mpdf('en','a4','','',10,15,35,25,0,5); 	
	$mpdf->SetDirectionality('ltr');
	$mpdf->mirrorMargins = false;
	$mpdf->Addpage();
	$mpdf->setFooter("Page {PAGENO} sur {nb}");
	$mpdf->defaultheaderfontstyle='B';
	$mpdf->SetDefaultBodyCSS('background-image-resize', 6);
	$mpdf->WriteHTML($html);

	$mpdf->Output('rapport_projet_'.$date_r.'.pdf', 'I');
exit;
?>