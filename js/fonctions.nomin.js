function doIt(){
	var aff = "#json";
	$(aff).load("up.php?reset "+aff, function success(data){
		$(aff).html(data);
		$(aff).slideDown();
		$("#progressbar2").slideUp();
		$("#return").slideDown();
	});
	 return false;
}
function checkSessions(){
	var aff = "#during";
	$.getJSON("sessions.php", function(json){
		var echo = 'Itérations : '+json.it+'<br />Count : '+json.count+'<br />Pointer : '+json.ftell+'<br />filesize: '+json.filesize;
		if(json.it == 'undefined' || json.count == 'undefined'){
			json.ftell = 0; json.filesize = 1;
		}
		var c = Math.floor(parseInt(json.ftell)*100 / parseInt(json.filesize));
		$("#progressbar2").progressBar(c);
		if(c == 100)
			$("#return").slideDown();
 	});
	return false;
}
function repeatChecking(){
	checkSessions();
	var repeat = function() { repeatChecking(); };
	setTimeout (repeat, 1000);
}

/*
if (screen.width>=1024)
	backgr="img/back1024.jpg";
if (screen.width>=1280)
	backgr="img/backg1280.jpg";
if (screen.width>=1440)
	backgr="img/backg1440.jpg";
if (screen.width>=1650)
	backgr="img/backg1650.jpg";
if (screen.width>=1920)
	backgr="img/backg1920.jpg";
*/
function upload(uid){
	$(function(){
	$('#uploadprogressbar').swfupload({
		upload_url: "/upload.php",
		file_size_limit : "20000",
		file_types : "*.xml",
		file_post_name : "file",
		file_types_description : "Cherchez iTunes Music Library.xml",
		file_upload_limit : "1",
		flash_url : "up/vendor/swfupload/swfupload.swf",
		button_image_url : 'img/uploader-icon.png',
		button_width : 89,
		button_height : 23,
		button_placeholder : $('#button')[0],
		debug: false,
		post_params : uid,
		custom_settings : {something : "here"}
	})
		.bind('swfuploadLoaded', function(event){
			$('#uploadstatut').append('<li>Loaded</li>');
		})
		.bind('fileQueued', function(event, file){
			$('#uploadstatut').append('<li>File queued - '+file.name+'</li>');
			// start the upload since it's queued
			$(this).swfupload('startUpload');
		})
		.bind('fileQueueError', function(event, file, errorCode, message){
			$('#uploadstatut').append('<li>File queue error - '+message+'</li>');
		})
		.bind('fileDialogStart', function(event){
			$('#uploadstatut').append('<li>File dialog start</li>');
		})
		.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
			$('#uploadstatut').append('<li>File dialog complete</li>');
		})
		.bind('uploadStart', function(event, file){
			//$('#uploadstatut').append('<li>Upload start - '+file.size+'</li>');
		})
		.bind('uploadProgress', function(event, file, bytesLoaded){
			var c = Math.floor( 100 * parseInt(bytesLoaded) / parseInt(file.size));
			$("#progressbar").progressBar(c);
			//$('#uploadstatut').append('<li>Upload progress - '+bytesLoaded+'</li>');
		})
		.bind('uploadSuccess', function(event, file, serverData){
			$('#bbb').slideUp();
			$("#progressbar").slideUp();
			$("#suivant").slideDown();
		})
		.bind('uploadComplete', function(event, file){
			$('#uploadstatut').append('<li>Upload complete - '+file.name+'</li>');
			// upload has completed, lets try the next one in the queue
			//$(this).swfupload('startUpload');
			$('#bbb').slideUp();
			$("#progressbar").slideUp();
			$("#suivant").slideDown();
		})
		.bind('uploadError', function(event, file, errorCode, message){
			$('#error').slideDown();
			$('#uploadstatut').append('<li>Upload error - '+message+'</li>');
			
		});
	});
}	
function checkMail(){
		
		$("#mail").focus(function(){
			if($("#ok:visible").length !=0)
				$("#ok").slideUp();
			if($("#new:visible").length != 0)
				$("#new").slideUp();
			if($("#wrongmail:visible").length != 0)
				$("#wrongmail").slideUp();
		});
		
		var aff = "#aff";
		var verifMail = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{1,7}$/;
		$("#mail").blur(function(e){
			var val = $(this).val();

			if(!$(this).val().match(verifMail) && $(this).val() != ''){
				$("#wrongmail").slideDown('normal');
			}
			else{
				$(aff).load("a.val.php?mail "+aff,{mail:val}, function success(data){
					if(data == 0)
						$("#new").slideDown("normal");
					else{
						$("#pseudodeja").html(data);
						$("#formpseudo").val(data);
						$("#ok").slideDown("normal");
					}
				});
			}
		});
		$("#mail").keypress(function(e){
			if($("#ok:visible").length !=0)
				$("#ok").slideUp();
			if($("#new:visible").length != 0)
				$("#new").slideUp();
			if($("#wrongmail:visible").length != 0)
				$("#wrongmail").slideUp();
		
		//*/
		
			var va = $(this).val();
			var ev = String.fromCharCode(e.which);
			var val = va+ev;
			if($(this).val().match(verifMail) && $(this).val() != ''){
				$(aff).load("a.val.php?mail "+aff,{mail:val}, function success(data){
					if(data == 0)
						$("#new").slideDown("normal");
					else{
						$("#pseudodeja").html(data);
						$("#formpseudo").val(data);
						$("#ok").slideDown("normal");
					}
				});
			}
		});
}
function checkPseudo(){
		$("#pseudo").keypress(function(e){
			var va = $(this).val();
			var ev = String.fromCharCode(e.which);
			var val = va+ev;
			var aff = '#explication_pseudo';
			if(val.length > 3 && val.length <= 15 && e.which != 0 && e.which != 8 && e.which != 13){
				$(aff).load("a.val.php?pseudo "+aff,{pseudo:val}, function success(data){
					$(aff).html(data);
					//$(aff).fadeIn("normal");
					if(data == '<div style="color:#BBBBBB;font-size:13px;">'+val+' n\'est pas disponible !</div>'){
						if($("#valid_pseudo:visible").length !=0)
							$("#valid_pseudo").hide();
						$("#not_valid_pseudo").fadeIn("normal");
						$("#explication_pseudo").slideDown("normal");
					}
					else if(data == '<div style="color:#BBBBBB;font-size:13px;">N\'utiliser que des lettres et des chiffres</div>'){
						if($("#valid_pseudo:visible").length !=0)
							$("#valid_pseudo").hide();
						$("#not_valid_pseudo").fadeIn("normal");
						$("#explication_pseudo").slideDown("normal");
					}
					else if(data == '<div style="color:#333333;font-size:13px;">'+val+' est disponible.</div>'){
						if($("#not_valid_pseudo:visible").length !=0)
							$("#not_valid_pseudo").hide();
						$("#valid_pseudo").fadeIn("normal");
						$("#explication_pseudo").slideDown("normal");
						if($("#bsuivanthidden:visible").length ==0)
							$("#bsuivanthidden").slideDown("normal");
					}
				});
			}
			else if(val.length > 15 && e.which != 0 && e.which != 8 && e.which != 13){
				var maxPseudo = '<div style="color:#BBBBBB;font-size:13px;">Ce pseudo est trop long !</div>';
				if($("#valid_pseudo:visible").length !=0)
					$("#valid_pseudo").hide();
				$("#explication_pseudo").html(maxPseudo);
				$("#explication_pseudo").fadeIn("normal");
				$("#not_valid_pseudo").fadeIn("normal");
			}
		});
		$("#pseudo").blur(function(e){
			var val = $(this).val();
			//$("#explication_pseudo").fadeIn("normal");
			if(val.length < 4 && val.length != 0 && e.which != 9){
				if($("#valid_pseudo:visible").length !=0)
					$("#valid_pseudo").hide();
				var minPseudo = '<div style="color:#BBBBBB;font-size:13px;">Ce pseudo est trop court !</div>';
				$("#explication_pseudo").html(minPseudo);
				$("#explication_pseudo").fadeIn("normal");
				$("#not_valid_pseudo").fadeIn("normal");
			}
			else if(val.length > 15 && e.which != 9){
				if($("#valid_pseudo:visible").length !=0)
					$("#valid_pseudo").hide();
				var maxPseudo = '<div style="color:#BBBBBB;font-size:13px;">Ce pseudo est trop long !</div>';
				$("#explication_pseudo").html(maxPseudo);
				$("#explication_pseudo").fadeIn("normal");
				$("#not_valid_pseudo").fadeIn("normal");
			}
		});
}