<script type="text/javascript">
$(document).ready(function(){

	$('.botonenviar').click(function(){
		//alert($(this).val());
		//opciones.beforeSubmit($(this).val());
		var value = $(this).val();
		if(value == "publicar"){
			value = 1;
		}else{
			value = 0;
		}

		$("input[name=estado]").attr("value",value);

		$('#formulario').submit();
	})
})
</script>