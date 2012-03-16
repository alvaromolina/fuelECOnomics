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
	
		$('#watermark').bind('keyup', function() { 
			
			var a = $("#watermark").val();
			if(a != "")
			{				
				$('.gbutton').css('opacity', '1');
			}
			else
			{
				$('.gbutton').css('opacity', '.5');	 	
			}
		} );


    $('#nick').change(function(){
      
      $.post(base_url+"wall/setName", {'name': $('#nick').val()}         
        ,function(response){
					
      });
    });
		
		//$('.commentBox').hide();
		$('.commentMark').val("Write a comment");	
				
		$('#shareButtons').click(function(){

      if ($("#file_url") && $("#file_url").val()!=""){
        file = $("#file_url").val();
        file_type = $("#file_type").val();      
      }else{
        file = "";
        file_type = "";
      }
						
			var a = $("#watermark").val();
			var section = $("#section").val();
      
			if(a != "")
			{
				var keepID = $('#keepID').val();
				var posted_on = $('#posted_on').val();
				
			  $.post(base_url+"wall/index/share", {'post': a, 'posted_by': keepID, 'uid':posted_on, 'file':file, 'file_type':file_type, 'section': section}         
        ,function(response){
					
					//$('#loadpage').prepend($(response).fadeIn('slow'));

					$("#watermark").val("");
  				$('.gbutton').css('opacity', '.5');	 	
          
          if (file!=""){
            $("#current_image").val("");
            $('#file_url').remove();
            $("#showthumb").html("");
            $("#show_img_upload_div").fadeOut("");
            $("#shareImageDiv").fadeOut("");
            $('.main_bar').fadeIn();
          }
          $.post(base_url+"wall/index/show/"+section+"/15/1/", {
          }, function(response){
      
            $('#loadpage').html(response).fadeIn(500);
            $.scrollTo('#UIComposer_Box',800,{});
          });


				});
			}
		});	
 
 		$('.commentMark').livequery("focus", function(e){
			return;
			var parent  = $(this).parent();
			$(".commentBox").children(".commentMark").css('width','320px');
			$(".commentBox").children("a#SubmitComment").hide();
			$(".commentBox").children(".CommentImg").hide();			
		
			var getID =  parent.attr('id').replace('record-','');			
			$("#commentBox-"+getID).children("a#SubmitComment").show();
			$('.commentMark').css('width','300px');
			$("#commentBox-"+getID).children(".CommentImg").show();			
		});	
		
		
		// show collapsed comments
		
		$('.SlideOff').livequery("click", function(e){
			
			var pid = $(this).attr('id').replace('collapsed_','');	
			
			
			$('#loadComments'+pid).slideToggle('slow', function() {
													
			//if($('#loadComments'+pid).slideUp)showExpand('#collapsed_'+pid);
			
			//if($('#loadComments'+pid).slideDown)showCollapsed('#collapsed_'+pid);
			
			});	
			
		});	
		
		$('.clickOpen').livequery("click", function(e){
			
			var pid = $(this).attr('id').replace('collapsed_','');	
            
            var keepID = $('#keepID').val();
            //alert(pid);return false;
            showLoader(this);

            $.post(base_url+"wall/collapsed/"+pid, {

            }, function(response){
            	
				showCollapsed('#collapsed_'+pid);
				
                $('#loadComments'+pid).html($(response)).slideToggle(500);
				$('#collapsed_'+pid).removeClass('clickOpen').addClass('SlideOff');
                //$('#collapsed_'+pid).hide();
            });
			
		});	
		
		//SubmitComment
		$('a.comment').livequery("click", function(e){
			
			var getpID =  $(this).parent().attr('id').replace('commentBox-','');	
			var comment_text = $("#commentMark-"+getpID).val();
			var keepID = $('#keepID').val();
			
			if(comment_text != "Write a comment")
			{
				$.post("add_comment.php?comment_text="+comment_text+"&post_id="+getpID+'&x='+keepID, {
	
				}, function(response){
					
					$('#CommentPosted'+getpID).append($(response).fadeIn('slow'));
					//$("#commentMark-"+getpID).val("Write a comment");					
				});
			}
		});	
		
		//more records show
		$('a.more_records').livequery("click", function(e){
			
			var next =  $(this).attr('id').replace('more_','');
			var name =  $(this).attr('name');
			
			var file = 'wall';
			
			var keepID = $('#keepID').val();
			var posted_on = $('#posted_on').val();
			
			$.post(file+".php?show_more_post="+next+'&x='+keepID+'&p='+posted_on, {

			}, function(response){
				
				$('#bottomMoreButton').remove();
				$('#loadpage').append($(response).fadeIn('slow'));
			});
		});
		
		$(".commentMark").livequery("keydown", function(e){
										   //
			if (e.keyCode == 13 && e.shiftKey)
			{
				 //var comment_text = $(this).val();
				 //$(this).val(comment_text+"<br />");
				// alert($(this).val());
				//e.preventDefault();
			}
			else if ( e.which == 13 ) 
			{
			 
			  $(this).attr("disabled", "disabled");
			  var getpID =  $(this).parent().attr('id').replace('record-','');	
			  var comment_text = $("#commentMark-"+getpID).val();
			  
			  if(comment_text == "")
				return false;
				
				var keepID = $('#keepID').val();
				//$('.commentBox').hide();
				if(comment_text != "Write a comment")
				{
					$.post(base_url+"wall/add_comment/"+getpID, 
                 {'comment': comment_text, 'uid': keepID}, function(response){
						
						$('#CommentPosted'+getpID).append($(response).fadeIn('slow'));
					  //$('#CommentPosted'+getpID).append('Holassffff');
					  $("#commentMark-"+getpID).attr("disabled", "");
						$("#commentMark-"+getpID).focus();
						$("#commentMark-"+getpID).val("");					
					});
				}
		    }
		});
		
		$(".commentMark").keypress(function(event) {
					return;				   
		    if ( event.which == 13 ) {
			  
			  var getpID =  $(this).parent().attr('id').replace('record-','');	
			  var comment_text = $("#commentMark-"+getpID).val();
			  
			  var owner = $("#owner").val();
			  
			  if(comment_text == "")
				return false;
				
				var keepID = $('#keepID').val();
				//$('.commentBox').hide();
				if(comment_text != "Write a comment")
				{
					$.post("add_comment.php?comment_text="+comment_text+"&post_id="+getpID+'&x='+keepID+'&whose_photo='+owner, {
		
					}, function(response){
						
						$('#CommentPosted'+getpID).append($(response).fadeIn('slow'));
						$("#commentMark-"+getpID).val("");					
					});
				}
		    }
	    });
		//deleteComment
		$('a.c_delete').livequery("click", function(e){
			
			if(confirm('\u00BFEst\u00e1 seguro de borrar el comentario?')==false)

			return false;
	
			e.preventDefault();
			var parent  = $(this).parent();
			var c_id =  $(this).attr('id').replace('CID-','');	
			
			$.ajax({

				type: 'get',

				url: base_url+'wall/deleteComment/'+ c_id,

				data: '',

				beforeSend: function(){

				},

				success: function(){

					parent.fadeOut(200,function(){

						$('#record-'+c_id).remove();

					});
				}
			});
		});	
		
		/// hover show remove button
		$('.friends_area').livequery("mouseenter", function(e){
			$(this).children("a.delete").show();	
		});	
		$('.friends_area').livequery("mouseleave", function(e){
			$('a.delete').hide();	
		});	
		
		/// hover show remove button
		
		$('a.delete_p').livequery("click", function(e){

		if(confirm('\u00BFEst\u00e1 seguro que desea borrar el comentario?')==false)

		return false;
		e.preventDefault();

		var parent  = $(this).parent();

		var temp    = parent.attr('id').replace('record-','');

		var main_tr = $('#'+temp).parent();

			$.ajax({

				type: 'get',
				url: base_url+'wall/deletePost/'+parent.attr('id').replace('record-',''),
				data: '',
				beforeSend: function(){
				},

				success: function(){

					parent.fadeOut(200,function(){

						main_tr.remove();
					});
				}
			});
		});

		$('textarea').elastic();

		jQuery(function($){
		   //$("#watermark").Watermark("No que você está pensando agora?");
		  // $(".commentMark").Watermark("Write a comment");
		});

		jQuery(function($){
		   //$("#watermark").Watermark("watermark","#369");
		   //$(".commentMark").Watermark("watermark","#EEEEEE");
		});	

		function UseData(){
		   $.Watermark.HideAll();
		   //Do Stuff
		   $.Watermark.ShowAll();
		}
	});			
	/////#####################
	
	function likethis( base_url,member_id, post_id, action)
	{
		if(!action) action=1;
	  
    $('#like-panel-'+post_id).html('&nbsp;<img src="'+base_url+'img/loader.gif" alt="" />');
		
    if(action == 1)
      s_action = 'like';
    else
      s_action = 'unlike';

		  $.post(base_url+"wall/"+s_action+"/"+post_id, {'uid': member_id}, function(response){
			
			if(response > 0)
			{
				$('#ppl_like_div_'+post_id).show();
				$('#like-stats-'+post_id).html(response+' personas les gusta esto');
			}
			else if(response == 0)
			{
				$('#ppl_like_div_'+post_id).hide();
				$('#like-stats-'+post_id).html(response+' personas les gusta esto');
			}
			
			if(action == 2)
			{
				$('#like-panel-'+post_id).html('&nbsp;<a href="javascript: void(0)" id="post_id'+post_id+'" onclick="javascript: likethis(\''+base_url+'\',\''+member_id+'\',\''+post_id+'\', 1);">Me gusta</a>');
			}
			else
			{
				$('#like-panel-'+post_id).html('&nbsp;<a href="javascript: void(0)" id="post_id'+post_id+'" class="Unlike" onclick="javascript: likethis(\''+base_url+'\',\''+member_id+'\',\''+post_id+'\', 2);">Ya no me gusta</a>');
			}
		});
	}
	
	function showLoader(thi){
		
		$(thi).find('.Ss').css('background-image', 'url(img/load.gif)');
		$(thi).find('.Ss').css('background-position', '0');
		$(thi).find('.Ss').css('width', '17px');
		$(thi).find('.Ss').css('height', '12px');
			
	}
	
	function showCollapsed(thi){
		
		$(thi).find('.Ss').css('background-image', 'url(img/collapse.png)');
		$(thi).find('.Ss').css('background-position', '0 5px');
		$(thi).find('.Ss').css('width', '7px');
		$(thi).find('.Ss').css('height', '8px');
	}
	
	function showExpand(thi){
		
		$(thi).find('.Ss').css('background-image', 'url(img/expand.png)');
		$(thi).find('.Ss').css('background-position', '0 5px');
		$(thi).find('.Ss').css('width', '7px');
		$(thi).find('.Ss').css('height', '8px');
	}

////

function Clikethis( base_url, member_id, comment_id, action, post_id)
{
 
  if(!action)action=1;

	$('#clike-panel-'+comment_id).html('&nbsp;<img src="'+base_url+'img/loader.gif" alt="" />');

  if(action == 1)
    s_action = 'clike';
  else
    s_action = 'cunlike';

  $.post(base_url+"wall/"+s_action+"/"+comment_id, {'uid': member_id}, function(response){
  if(response > 0)
		{
			
      $('#ppl_clike_div_'+comment_id).show();
			$('#clike-stats-'+comment_id).html(response+' personas les gusta esto');
			
		}
		else if(response == 0)
		{
			$('#ppl_clike_div_'+comment_id).hide();
			$('#clike-stats-'+comment_id).html(response+' personas les gusta esto');
		}
		
		if(action == 2)
		{
			$('#clike-panel-'+comment_id).html('&nbsp;<a href="javascript: void(0)" id="comment_id'+comment_id+'" onclick="javascript: Clikethis(\''+base_url+'\',\''+member_id+'\',\''+comment_id+'\', 1,\''+post_id+'\');">Me gusta</a>');
		}
		else
		{
			$('#clike-panel-'+comment_id).html('&nbsp;<a href="javascript: void(0)" id="comment_id'+comment_id+'" class="Unlike" onclick="javascript: Clikethis(\''+base_url+'\',\''+member_id+'\',\''+comment_id+'\', 2,\''+post_id+'\');">Ya no me gusta</a>');
		}
	});
}

function showCList( post_id )
{
	popup('popUpDiv');
	$('#popUpDiv div span').html('');
	$('#comment_part').html('');
	$('#popUpDiv div span').html('Loading...');
	
	$.post("clikes.php?post_id="+post_id+'&action=3', {
	}, function(response){
		
		$('#popUpDiv div span').html(response);
		
	});
}

function SubmitComment(myfield,e)
{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13)
	{
		
	}
	else
	return true;
}

///////////


/////////////////////////////////////////////// OPEN POPUP
