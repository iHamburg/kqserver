
<script src="<?php echo base_url('public/js/jquery.hotkeys.js');?>"></script>
<script src="<?php echo base_url('public/js/google-code-prettify/prettify.js');?>"></script>
<script src="<?php echo base_url('public/js/bootstrap-wysiwyg.js');?>"></script>
<script>
  $(function(){
    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
    
	};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings();  
//	$('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
	$('#contenteditor').wysiwyg({ fileUploadError: showErrorAlert} );
//	$('#desceditor').wysiwyg({ fileUploadError: showErrorAlert} );
    window.prettyPrint && prettyPrint();
  });
</script>
<script>
//$('#desceditor').mouseout(function(){
//
//	var text = $(this).html();
//	$('#description').val(text);
//})
//
//$('#desceditor').blur(function(){
//
//	var text = $(this).html();
////	$('#alerts').text(text);
//	$('#description').val(text);
//})
$('#contenteditor').mouseout(function(){

		var text = $(this).html();
		$('#content').val(text);
		
	})

	$('#contenteditor').blur(function(){

		var text = $(this).html();
		$('#alerts').text(text);
		$('#content').val(text);
	})
//	$('#editor').mouseout(function(){
//
//		var text = $(this).html();
//		$('#wysiwyg').val(text);
//	})
//
//	$('#editor').blur(function(){
//
//		var text = $(this).html();
//		$('#alerts').text(text);
//		$('#wysiwyg').val(text);
//	})
	</script>