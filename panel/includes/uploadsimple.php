<script type="text/javascript">
var swfu;
var respuesta;

$(document).ready(function(){
	//alert($('preloader'));
	//alert($("#form-upload").attr('action'));
	var url = "<?= $this->app['panelurl']?>/" +  $('#form-upload').attr('action');	
	var settings = {
		flash_url : "<?= $this->app['siteurl'] ?>/includes/js/swfupload/flash/swfupload.swf",
		upload_url: url,
		post_params: {"PHPSESSID" : "<?= $this->session['id'] ?>", "id" : "<?= $_GET['id'] ?>"},
		file_size_limit : "100 MB",
		file_types : "*.*",
		file_types_description : "Todos los archivos",
		file_upload_limit : 100,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : "preloader",
			cancelButtonId : "btn-cancelar"
		},
		debug: false,

		prevent_swf_caching: true,
		
		// Button settings
		button_image_url: "<?= $this->app['siteurl'] ?>/includes/js/swfupload/btn.png",
		button_width: "65",
		button_height: "29",
		button_placeholder_id: "btn-upload",
		button_text: '<span class="theFont">Archivo</span>',
		button_text_style: ".theFont { font-family: Arial; color: #144D6B; font-size: 12; }",
		button_text_left_padding: 12,
		button_text_top_padding: 3,
		button_cursor : SWFUpload.CURSOR.HAND,

		//moving_average_history_size: 40,
		
		
		// The event handler functions are defined in handlers.js
		file_queued_handler : fileQueued,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete
	};
	
	swfu = new SWFUpload(settings);
		
})

function fileQueued(file){
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("Pending...");
		progress.toggleCancel(true, this);

	} catch (ex) {
		this.debug(ex);
	}
	
}

function fileDialogComplete(){
	this.startUpload();
}

function uploadStart(file){
	try {
		//$('#preloader').html('<small>Porcentaje: 0%</small>');
		$('#preloader').html('<div id="bar">&nbsp;</div>');
	} catch (ex) {
		this.debug(ex);
	}
}
function uploadProgress(file, bytesLoaded, bytesTotal){
	try {
		//$('#preloader').html('<small>Porcentaje: '+SWFUpload.speed.formatPercent(file.percentUploaded)+'%</small>');
		//var porcetaje =  SWFUpload.speed.formatPercent(file.percentUploaded)+'%'; SWFUpload.speed.formatPercent(file.percentUploaded)
		//alert(SWFUpload.speed.formatPercent(file.percentUploaded));
		$('#bar').css("width", file.percentUploaded + "%");
	} catch (ex) {
		this.debug(ex);
	}
	
}

function uploadSuccess(file, serverData){
	//archivo = "";
	respuesta = serverData;
	try {
		$('#preloader').html('<small>Porcentaje: '+SWFUpload.speed.formatPercent(file.percentUploaded)+'%</small>');
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadComplete(file){
	alert(respuesta);	
	$('#preloader').html('<small>' + this.getStats().successful_uploads + ' archivo cargado</small>');
	$('#respuesta').prepend(respuesta);
	self.parent.tb_remove();
	
}
</script>