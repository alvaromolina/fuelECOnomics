<?php
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
?>
<link type="text/css" href="fb/stylesheet.css" rel="stylesheet">

<div class="imagecomments">
	
    <img src="<?php echo @$_REQUEST['uls']?>" width="520" alt="Loading..."/>
    <br />
    <span>	
        <a href="javascript: void(0)" >Comment</a> - <a href="javascript: void(0)" >Like</a>&nbsp;&nbsp;&nbsp;<span style="color:#063">This functionality is not available in this version.</span>
    </span>
    
    
    <div id="CommentPosted4">
     
     <div id="loadComments4" style="display:none"></div>
		<div class="commentPanel" align="left">
						
						<a href="javascript:;">
							<img src="pics/99points.jpg" style="float:left; padding-right:9px;" width="40" height="40" border="0" alt="">
						</a>
						
					   <label class="name">
                       <b>
                           <a href="javascript:;">
                            Rocking Demo                           </a>
                       </b>
	                  <div class="name" style="text-align:justify;float:left;">
                       <em>
					   Dance classes is starting...Don't forget to register this Spring 2011.Speacial student discount.</em>
						</div>
						<br>
                        <div style="width:350px;float:right;">
                        <div style="float:left; padding-top:3px;">
							<span class="timeanddate">
														</span>
														&nbsp;<a href="javascript:void(0)">Delete</a>
													-
						<span>
													
							<a href="javascript: void(0)" id="post_id9" >Like</a>
												</span>
						</div>
						<div id="ppl_clike_div_9" style="float:left;padding-top:3px;">
                             - <a class="t" href="javascript:;" >
                            <span > 1 person</span> 
                               </a></div>
                            <span></span>
                        </div>
						<br clear="all">
                    </label>
					</div>
        <div class="commentPanel" align="left">
						
						<a href="javascript:;">
							<img src="pics/99points.jpg" style="float:left; padding-right:9px;" width="40" height="40" border="0" alt="">
						</a>
						
					   <label class="name">
                       <b>
                           <a href="javascript:;">
                            Rocking Demo                           </a>
                       </b>
	                  <div class="name" style="text-align:justify;float:left;">
                       <em>
					   Dance classes is starting...Don't forget to register this Spring 2011.Speacial student discount.</em>
						</div>
						<br>
                        <div style="width:350px;float:right;">
                        <div style="float:left; padding-top:3px;">
							<span class="timeanddate">
														</span>
														&nbsp;<a href="javascript:void(0)">Delete</a>
													-
						<span>
													
							<a href="javascript: void(0)" id="post_id9" >Like</a>
												</span>
						</div>
						<div id="ppl_clike_div_9" style="float:left;padding-top:3px;">
                             - <a class="t" href="javascript:;" >
                            <span > 1 person</span> 
                               </a></div>
                            <span></span>
                        </div>
						<br clear="all">
                    </label>
					</div>
					
    </div>
                                
    <div class="commentBox" align="right">
                    
        <img src="pics/99points-4.jpg" style="float:left; padding-right:9px;" width="40" height="40" border="0" alt="" class="CommentImg" />
       
        <label>
            <textarea class="commentMarkDemo"  onblur="if (this.value=='') this.value = 'Write a comment'" onfocus="if (this.value=='Write a comment') this.value = ''" onKeyPress="return SubmitComment(this,event)" wrap="hard" name="commentMark" style=" background-color:#fff; overflow: hidden;" cols="60">Write a comment</textarea>
        </label>
        <br clear="all" />
    </div>

</div>