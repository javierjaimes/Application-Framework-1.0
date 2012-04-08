<script type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	language: "es",
	theme : "advanced",
	theme_advanced_buttons1 : "add,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,image",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	
	theme_advanced_resizing : true,
	theme_advanced_resize_horizontal : false,

	relative_urls : false,
	remove_script_host : false,
	document_base_url : "<?= $this->app['siteurl'] ?>",
		
	
	plugins : 'inlinepopups',
	//file_browser_callback : 'myFileBrowser',
	
	setup : function(ed) {
	
	// Add a custom button
	
	ed.addButton('add', {
	
		title : 'Cargar Archivos',
		
		image : '<?= $this->app["siteurl"] ?>/includes/js/tinymce/themes/advanced/skins/default/img/add.gif',
		
		onclick : function() {
		
		// Add you own code to execute something on click
		tinyMCE.activeEditor.windowManager.open({
			   url : '<?= $this->app['panelurl'] ?>/?url=noticias_archivos',
			   title : 'Cargar Archivos',
			   width : 640,
			   height : 420,
			   resizable : "yes",
			   popup_css : false,
			   inline: true
		},{
			window : window,
			editor_id : tinyMCE.selectedInstance.editorId
		})
		//ed.selection.setContent('<strong>Hello world!</strong>');
		
		}
	
	});
	
	}

});
</script>