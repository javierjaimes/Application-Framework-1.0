<script type="text/javascript">
$(document).ready(function(){ 
	$("#mes").change(function(){
		var mes = $(this).val();
		$('#dia').empty();
		$("#dia").load("<?= $this->app['siteurl'] ?>/request.php?get=getDias&params="+mes);
	});
});
</script>