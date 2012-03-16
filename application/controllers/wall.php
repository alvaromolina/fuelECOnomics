<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Wall extends CI_Controller {
 
    function __construct()
    {
      parent::__construct();
      $this->load->model('Wall_m');
      $this->load->helper('wall_helper');
      $this->load->helper('session_helper');
      
      
    }
 
    function index($mode="show",$section="problem",$limit=15,$page=1)
    {
      $count = 0;
      if($mode == "show"){
        $posts = $this->Wall_m->getPosts($section,$limit,($page-1)*$limit);
        $count = $this->Wall_m->getPostsCount($section);
      }
      elseif($mode == "share"){
        $_POST['post'] = sanitize($_POST['post']);
        $posts = $this->Wall_m->setPost($_POST);
      }      
      $data = array('posts' => $posts,'mode'=>$mode, 'pages'=>(intval(($count-1)/$limit))+1, 'page'=>$page);
      $this->load->view('wall2',$data);
    }

    function add_comment($post_id)
    {
      $_POST['comment'] = sanitize($_POST['comment']);      
      $comments = $this->Wall_m->setComment($post_id,$_POST); 
      $data = array('comments' => $comments, 'post_id' => $post_id,'comments_from'=>0);
      $this->load->view('comment',$data);
    }

    function collapsed($post_id)
    {
      $comments = $this->Wall_m->getComments($post_id); 
      $data = array('comments' => $comments, 'post_id' => $post_id,'comments_from'=>2);
      $this->load->view('comment',$data);
    }

    function like($post_id)
    {
      $likes = $this->Wall_m->like($post_id,$_POST['uid']); 
      echo $likes;
    }

    function unlike($post_id)
    {
      $likes = $this->Wall_m->unlike($post_id,$_POST['uid']); 
      echo $likes;
    }

    function clike($c_id)
    {
      $likes = $this->Wall_m->clike($c_id,$_POST['uid']); 
      echo $likes;
    }

    function cunlike($c_id)
    {
      $likes = $this->Wall_m->cunlike($c_id,$_POST['uid']); 
      echo $likes;
    }

    function deletePost($post_id)
    {
      $this->Wall_m->deletePost($post_id); 
    }

    function deleteComment($c_id)
    {
      $this->Wall_m->deleteComment($c_id);
    }

    function showImage()
    {
      $this->load->view('image',$_POST);

    }

    function setName()
    {
      $this->session->set_userdata('name', $_POST['name']);
    }

    function upload()
    {

      $path = "media/";

      $valid_formats_img = array("jpg", "jpeg", "gif","png");

      if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
      {
        $name = $_FILES['current_image']['name'];
        $size = $_FILES['current_image']['size'];

        if(strlen($name))
        {
          list($txt, $ext) = explode(".", $name);

            if($size<(1024*1024))
            {
              $actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
              $tmp = $_FILES['current_image']['tmp_name'];

              if(move_uploaded_file($tmp, $path.$actual_image_name))
              {
                echo "<input type='hidden' id='file_url' value='".$actual_image_name."'>";

                if(in_array($ext, $valid_formats_img)){
                  echo "<img src='media/".$actual_image_name."'  class='showthumb' width='150'>";
                  echo "<input type='hidden' id='file_type' value='image'>";
                  
                }else
                  echo "<input type='hidden' id='file_type' value='other'>";
              }
              else
                echo "Please try again.";
            } 
            else
              echo "Sorry, maximum file size should be 1MB";					
          /*}
          else
            echo "Invalid format, try again";	*/
        }
          else
            echo "Please select an image.";
      }
    } 
}
?>
