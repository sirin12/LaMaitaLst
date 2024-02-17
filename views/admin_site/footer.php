  <!-- Plugins Js -->
	<?php echo admin_assests('assets/js/app.min.js','js') ?>
	<?php echo admin_assests('assets/js/table.js','js') ?>
	<?php echo admin_assests('assets/js/table.min.js','js') ?>
	<?php echo admin_assests('assets/js/chart.min.js','js') ?>
	
	
	
	    <!-- form Js -->
		
		<?php echo admin_assests('assets/js/form.min.js','js') ?>
		<?php echo admin_assests('assets/js/bundles/multiselect/js/jquery.multi-select.js','js') ?>
		<?php echo admin_assests('assets/js/bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js','js') ?>
		<?php echo admin_assests('assets/js/pages/forms/advanced-form-elements.js','js') ?>

	
    <!-- Custom Js -->
	<?php echo admin_assests('assets/js/admin.js','js') ?>
	<?php echo admin_assests('assets/js/pages/index.js','js') ?>
	<?php echo admin_assests('assets/js/pages/charts/jquery-knob.js','js') ?>
	<?php echo admin_assests('assets/js/pages/sparkline/sparkline-data','js') ?>
	<?php echo admin_assests('assets/js/pages/medias/carousel.js','js') ?>
	
	<?php echo admin_assests('assets/js/pages/forms/form-validation.js','js') ?>
	
	<!-- Carousel Js -->
	<?php echo admin_assests('assets/pages/medias/carousel.js','js') ?>
    <!-- Knob Js -->
	<?php echo admin_assests('assets/js/pages/charts/jquery-knob.js','js') ?>
	<?php echo admin_assests('assets/js/todo/todo.js','js') ?>
	<?php echo admin_assests('assets/js/pages/widgets/widget.js','js') ?>
    <!-- table Js -->
	<?php echo admin_assests('assets/js/bundles/export-tables/dataTables.buttons.min.js','js') ?>
	<?php echo admin_assests('assets/js/bundles/export-tables/buttons.flash.min.js','js') ?>
	<?php echo admin_assests('assets/js/bundles/export-tables/jszip.min.js','js') ?>
	<?php echo admin_assests('assets/js/bundles/export-tables/pdfmake.min.js','js') ?>
	<?php echo admin_assests('assets/js/bundles/export-tables/vfs_fonts.js','js') ?>
	<?php echo admin_assests('assets/js/bundles/export-tables/buttons.html5.min.js','js') ?>
	<?php echo admin_assests('assets/js/bundles/export-tables/buttons.print.min.js','js') ?>
	<?php echo admin_assests('assets/js/pages/tables/jquery-datatable.js','js') ?>
	
	<?php echo admin_assests('ckeditor/ckeditor.js', 'js') ?>
	<?php echo admin_assests('ckfinder/ckfinder.js', 'js') ?>
	<?php echo admin_assests('ckeditor/initckeditor.js', 'js') ?>
	<script type="text/javascript">
	   
		 CKEDITOR.replace( 'ckeditor',
		 {
		 filebrowserBrowseUrl : '<?php echo base_url() ?>themes/admin_site/ckfinder/ckfinder.html',
		 
		 } 
		 );
	</script>
    <!-- Demo Js -->
	<?php /*<script>
		function export2Word(element) {

		  var html, link, blob, url, css;

		  css = (
			'<style>' +
			'@page tableExport{size: 21cm 29.7cm;}' +
			'div#tableExport {page: tableExport;}' +
			'</style>'
		  );

		  html = element.innerHTML;
		  blob = new Blob(['\ufeff', css + html], {
			type: 'application/msword'
		  });
		  url = URL.createObjectURL(blob);
		  link = document.createElement('A');
		  link.href = url;
		  link.download = 'Document'; // default name without extension
		  document.body.appendChild(link);
		  if (navigator.msSaveOrOpenBlob) navigator.msSaveOrOpenBlob(blob, 'Document.doc'); // IE10-11
		  else link.click(); // other browsers
		  document.body.removeChild(link);
		};
	</script>*/?>
		
</body>


