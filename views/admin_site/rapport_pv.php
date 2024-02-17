<html lang="en">
<head>
	<meta charset="utf-8">
	  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta charset="utf-8">     
	<style>
	table th {border: 1px solid #eee;padding: 5px;text-align:center}
	table td{border: 1px solid #eee;padding: 8px;text-align:center;line-height:1.5}
	.table_border0 th {border: 0px #fff;}
	.table_border0 td{border: 0px #fff}
	table td:first-child{background:#C6D9F1}
	body {background-image: url(<?php echo admin_img('entete.jpg');?>) ;}
	.table_presence{width:100%}
	.table_presence th{background-color:#365F91;color:#fff;}
	</style>
	</head>           
          
<body>

<br><br>
<table border="0" style="float:left;width:100%;" class="table_border0">
	<tr>
		<td></td>
		<td>
			<h2 style="text-align:center;border:solid 3px #ccc;float:right;min-height:70px;line-height:2;padding:10px;">
				<?php echo $projet->projets;?>
			</h2><br>
		</td>
	</tr>
<tr>
	<td style="float:left;width:65%">
		<h4 style="text-align:left;width:100%;text-transform:uppercase">PROCÈS VERBAL DE RÉUNION DE CHANTIER</h4>
	</td>
	<td style="float:right;width:35%">
		
		<b><span style="text-align:center;width:100%">PV N° <?php echo $pv->numero;?><hr>Mise à jour du</span> <?php echo getFrenchDate(date('Y-m-d'));$date_r=date('Y-m-d');?></b>
	</td>
</tr>
</table>
<br><br>

<table width="100%" border="1" class="table_presence" style="width:100%">
	<tr>
		<th style="width:20%">SOCIETE</th>
		<th style="width:30%">REPRESENTANTS</th>
		<th style="width:5%">P</th>
		<th style="width:15%">N° TEL</th>
		<th style="width:30%">E-mail</th>
	</tr>
	<?php $pv_societes=$this->md_commun->fetchsos('societes_admin_pv',array('pv_id'=>$pv_id),'asc',10000,0);?>
	<?php if($pv_societes){foreach($pv_societes as $pv_soc){
		$sos_id=$this->md_commun->get_row('societes',array('id'=>$pv_soc->societe_id));?>
		<?php $pv_contacts=$this->md_commun->fetch('societes_admin_pv_contact',array('pv_id'=>$pv_id,'societe_id'=>$pv_soc->societe_id),'asc',10000,0);
			$count_contacts=$this->md_commun->count('societes_admin_pv_contact',array('pv_id'=>$pv_id,'societe_id'=>$pv_soc->societe_id));?>
		<?php if($sos_id){?>
		<tr>
			<td style="background:#C6D9F1"><?php  echo $sos_id->societes;?></td>
			<td>
			<?php if($pv_contacts){foreach($pv_contacts as $pv_con){
			$con_id=$this->md_commun->get_row('contacts',array('id'=>$pv_con->contact_id,'etat'=>1));?>
			<?php if($con_id) echo $con_id->nom.'<br>';;?>
			<?php }}?></td>
			<td>
			<?php if($pv_contacts){foreach($pv_contacts as $pv_con){
				$con_id=$this->md_commun->get_row('contacts',array('id'=>$pv_con->contact_id,'etat'=>1));
				if($con_id) if($pv_con->etat==1) echo 'P<br>';else '-<br>'; }}?></td>
			<td><?php if($pv_contacts){foreach($pv_contacts as $pv_con){
				$con_id=$this->md_commun->get_row('contacts',array('id'=>$pv_con->contact_id,'etat'=>1));
				if($con_id) echo $con_id->phone.'<br>'; }}?></td>
			<td><?php if($pv_contacts){foreach($pv_contacts as $pv_con){
				$con_id=$this->md_commun->get_row('contacts',array('id'=>$pv_con->contact_id,'etat'=>1));
				if($con_id) echo $con_id->email.'<br>';}}?></td>
		
		
		</tr>
		<?php }?>
	<?php }}?>
</table>
<br><br>
<table width="100%" border="0" class="table_presence" style="width:100%">
	<tr>
		<th style="width:20%">Societe</th>
		<th style="width:80%">DECISIONS ET MISE A JOUR DES DOCUMENTS</th>
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
		<?php if($con_id){if($con_id->content){?>
		<tr>
			<td><?php echo $sos_id->societes;?></td>
			<td align="left"><?php echo $con_id->content;?></td>
		</tr>
		<?php }}?>
	<?php }}?>
</table>
<?php //echo $pv->content;?>
</body>
</html>