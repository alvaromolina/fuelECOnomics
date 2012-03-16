/* Wall+ script by 99Points.info 
 * Copyright (c) 2011 Zeeshan Rasool
 * Licensed under the GNU General Public License version 3.0 (GPLv3)
 * http://www.webintersect.com/license.php
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 * See the GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Date: January 1, 2012
 *------------------------------------------------------------------------------------------------*/

$(document).ready(function(){	

	$('a#upload_img').livequery("click", function(){
		
		$("#show_img_upload_div").fadeIn('');
	});	
	
});	

$(document).ready(function(){	
	
	$('#shareImageButton').livequery("click", function(){
		
		var keepID = $('#keepID').val();
		var posted_on = $('#posted_on').val();

    if ($("#file_url") && $("#file_url").val()!=""){
      file = $("#file_url").val();
      file_type = $("#file_type").val();      
    }else{
      file = "";
      file_type = "";
    }
    		
    var  a = $('#watermark').val();
		
		if( file != "")
		{
		 $.post(base_url+"wall/index/share", {'post': a, 'posted_by': keepID, 'uid':posted_on, 'file':file, 'file_type':file_type}         
			, function(response){
				$('#loadpage').prepend($(response).fadeIn('slow'));
				$("#current_image").val("");
				$('#file_url').remove();
				$("#showthumb").html("");
				$("#show_img_upload_div").fadeOut("");
				$("#shareImageDiv").fadeOut("");
				$("#watermark").val("");
				$('.main_bar').fadeIn();
			});
		}
	});	
	
});	
function shareposting( url,cur_image,title,description,pix )
{
	popup('popUpDiv');
	
	$('#popUpDiv div').html('');
	$("#save_reshare_pid").val("");
	$("#save_reshare_pid").val(pix);
	
	$('#popUpDiv div').html('Loading...');

	$.post("share-post.php?url="+url+'&cur_image='+cur_image+'&title='+title+'&description='+description, {
	}, function(response){
		
		$('#popUpDiv div').html(response);
		
	});
}

$(document).ready(function(){
	
	$('#ShowStatusBox').click(function() {
		
		$('#container_box').show();
		$('#Show-Status-Box').fadeIn();
		$('#Show-Photo-Box').hide();
		$('#Show-Link-Box').hide();
	});
	
	$('#ShowPhotoBox').click(function() {
		$('#container_box').show();
		$('#Show-Status-Box').hide();
		$('#Show-Photo-Box').fadeIn();
		$('#Show-Link-Box').hide();
	});
	
	$('#ShowLinkBox').click(function() {
		//$('#container_box').show();
		$('#show_img_upload_div').hide();
		//$('#Show-Photo-Box').hide();
		$('#Show-Link-Box').fadeIn();
	});
	
});



$(document).ready(function(){});


function showimgs( uls )
{
	popup('popUpDiv');
	$('#popUpDiv div span').html('');
	$('#comment_part').html('Loading...');
	
	$.post(base_url+"wall/showImage", {'image':uls

	}, function(response){
		$('#comment_part').html($(response).fadeIn(''));
				
	});
	
}



function isValidURL(url)
{
	var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
	
	if(RegExp.test(url)){
		return true;
	}else{
		return false;
	}
}
////



