<html lang="en">
<head>
	<meta charset="utf-8">
	  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta charset="utf-8">     
	<style>
	table{width:100%;margin-top:15px;float:left;border-collapse: collapse;}
	table th {border: 1px solid red;padding: 5px;}
	table td{border: 1px solid red;padding: 8px;}
	body {background-image: url(<?php echo admin_img('entete.jpg');?>) ;}
	</style>
	</head>           
          
<body>

<h2 style="text-align:center;border:solid 3px #ccc;width:50%;float:right;height:70px;padding:10px;"><?php echo $projet->projets;?></h2><br>
<div style="float:left;width:100%">
	<div style="float:left;width:60%">
	<h4 style="text-align:left">PROCÈS VERBAL DE RÉUNION DE CHANTIER</h4>
	</div>
	<div style="float:left;width:40%">
		<div style="float:left;width:50%">
		<b>PV N° <hr><?php echo $pv->numero;?></b><br>
		</div>
		<div style="float:left;width:50%">
		<b>Mise à jour du <hr><?php echo $pv->date;?></b>
		</div>
	</div>
</div>
<br>

<style>
.table_presence th{background:#365F91;color:#fff;}
.table_presence th,.table_presence td{border:solid 1px #333;text-align:center}
</style>
<table width="100%" border="0" class="table_presence">
	<tr>
		<th>Societe</th>
		<th>REPRESENTANTS</th>
		<th>PRESENCE</th>
		<th>N° TEL</th>
		<th>E-mail</th>
	</tr>
	<?php $pv_societes=$this->md_commun->fetch('societes_admin_pv',array('pv_id'=>$pv_id),'asc',10000,0);?>
	<?php if($pv_societes){foreach($pv_societes as $pv_soc){
		$sos_id=$this->md_commun->get_row('societes',array('id'=>$pv_soc->societe_id));?>
		<?php $pv_contacts=$this->md_commun->fetch('societes_admin_pv_contact',array('pv_id'=>$pv_id,'societe_id'=>$pv_soc->societe_id),'asc',10000,0);
			$count_contacts=$this->md_commun->count('societes_admin_pv_contact',array('pv_id'=>$pv_id,'societe_id'=>$pv_soc->societe_id));?>
		<tr>
		<?php $ic=0;if($pv_contacts){foreach($pv_contacts as $pv_con){$ic++;
		$con_id=$this->md_commun->get_row('contacts',array('id'=>$pv_con->contact_id));?>
		
			<?php if($ic==1){?><td rowspan="<?php echo $count_contacts;?>"><?php echo $sos_id->societes;?></td><?php }?>
			<td><?php echo $con_id->nom;?></td>
			<td><?php if($pv_con->etat==1) echo 'P';else '-';?></td>
			<td><?php echo $con_id->phone;?></td>
			<td><?php echo $con_id->email;?></td>
		
		<?php }}?>
		</tr>
	<?php }}?>
</table>
<table width="100%" border="0" class="table_presence">
	<tr>
		<th style="width:20%">Societe</th>
		<th>DECISIONS ET MISE A JOUR DES DOCUMENTS</th>
	</tr>
	<?php $pvv_id=$this->md_commun->get_row('pv',array('id'=>$pv_soc->pv_id));?>
	<tr>
			<td></td>
			<td align="left"><?php echo $pvv_id->content;?></td>
		</tr>
	<?php $pv_societes=$this->md_commun->fetch('societes_admin_pv',array('pv_id'=>$pv_id),'asc',10000,0);?>
	<?php if($pv_societes){foreach($pv_societes as $pv_soc){
		$sos_id=$this->md_commun->get_row('societes',array('id'=>$pv_soc->societe_id));?>
		<?php $con_id=$this->md_commun->get_row('pv_decisions',array('pv_id'=>$pv_soc->pv_id,'societe_id'=>$pv_soc->societe_id));?>
		<?php if($con_id->content){?>
		<tr>
			<td><?php echo $sos_id->societes;?></td>
			<td align="left"><?php echo $con_id->content;?></td>
		</tr>
		<?php }?>
	<?php }}?>
</table>
<?php //echo $pv->content;?>
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

		$mpdf->Output('rapport_pv.pdf', 'I');
		?>
