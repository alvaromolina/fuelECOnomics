<?php 

class Car_m extends CI_Model {
 
  private $db;
  function __construct()
  {
      // Call the Model constructor
    parent::__construct();
    $this->load->library('mongo_db');
    $this->load->helper('session_helper');   
    //$m = new Mongo(); // connect
    #$this->db = $m->selectDB("green");

    $m = new MongoClient(); // connect
    $this->db = $m->green; // get the database named "foo"

  }
  function getYears(){
    $years = $this->db->command(array("distinct" => "cars", "key" => "year"));
    return $years['values'];
  }

  function getMakes($year){
    $makes = $this->db->command(array("distinct" => "cars", "key" => "make", "query"=>array("year"=>$year)));
    return $makes;
  }

  function getModels($year,$make){
    $models = $this->db->cars->find(array("year"=>$year,"make"=>$make));
    return $models;
  }
  
  function getModel($model){
    $model = $this->db->cars->findOne(array("_id"=>new MongoId($model)));
    return $model;
  }



  function getPosts($section='problem',$limit,$offset){
    $posts = $this->mongo_db->where(array('section'=>$section))->order_by(array('date_created'=> -1))->limit($limit)->offset($offset)->get('posts');
    return $posts;
  }

  function getPostsCount($section='problem'){
    $count = $this->mongo_db->where(array('section'=>$section))->count('posts');
    return $count;
  }


  function setPost($post){
    $post_default = array('post' =>'',
	                        'type' =>'comment',
                          'date_created' => new MongoDate(),
                          'uid' =>'',
                          'posted_by' =>'',
                          'likes' =>0,
                          'media' =>0,
                          'uip' =>'',
                          'title' =>'',
                          'description' =>'',
                          'url' =>'',
                          'post_type' =>1,
                          'file' => '',
                          'file_type' => '',
                          'num_comments' => 0,
                          'section' => '',
                          'f_user' => isFacebookUser(),
                          'name' => getUserName()
                        );
    $post = array_merge($post_default, $post);
    $id = $this->mongo_db->insert('posts',$post);
    $posts = $this->mongo_db->where(array('_id'=>$id))->get('posts');
    return $posts;
  }


  function setComment($post_id,$comment){
    $c_id = new MongoId();
    $comment_default = array('c_id' => $c_id,
                          'uid' =>'',
                          'comment' =>'',
                          'likes' =>0,
                          'date_created' => new MongoDate(),
                          'uip' =>'',
                          'f_user' => isFacebookUser(),
                          'name' => getUserName()                  
                        );
    $comment = array_merge($comment_default, $comment);
    $this->mongo_db->where(array('_id'=>new MongoId($post_id)))->inc('num_comments',1)->push('comments',$comment)->update('posts');
    $comments = array($comment);
    return $comments;
    
  }

  function getComments($post_id){
    $posts = $this->mongo_db->where(array('_id'=>new MongoId($post_id)))->get('posts');
    $comments = $comment = $posts[0]['comments'];
    return $comments;
    
  }



  function like($post_id, $uid){
    $this->mongo_db->where(array('_id'=>new MongoId($post_id)))->inc('likes',1)->push('likes_users',$uid)->update('posts');
    $post = $this->mongo_db->where(array('_id'=>new MongoId($post_id)))->get('posts');        
    return $post[0]['likes'];
  }

  function unlike($post_id, $uid){
    $this->mongo_db->where(array('_id'=>new MongoId($post_id)))->inc('likes',-1)->pull('likes_users',$uid)->update('posts');
    $post = $this->mongo_db->where(array('_id'=>new MongoId($post_id)))->get('posts');        
    return $post[0]['likes'];
  }

  function clike($c_id, $uid){
    $this->mongo_db->where(array('comments.c_id'=>new MongoId($c_id)))->inc('comments.$.likes',1)->push('comments.$.likes_users',$uid)->update('posts');
    $post = $this->mongo_db->where(array('comments.c_id'=>new MongoId($c_id)))->get('posts');
    foreach($post[0]['comments'] as  $comment){
      if($comment['c_id']->{'$id'}== $c_id)
        return $comment['likes'];
    }
    return 0;
  }

  function cunlike($c_id, $uid){
    $this->mongo_db->where(array('comments.c_id'=>new MongoId($c_id)))->inc('comments.$.likes',-1)->pull('comments.$.likes_users',$uid)->update('posts');
    $post = $this->mongo_db->where(array('comments.c_id'=>new MongoId($c_id)))->get('posts');
    foreach($post[0]['comments'] as  $comment){
      if($comment['c_id']->{'$id'} == $c_id)
        return $comment['likes'];
    }
    return 0;
  }

  function deletePost($post_id){
    $this->mongo_db->where(array('_id'=>new MongoId($post_id)))->delete('posts');
  }

  function deleteComment($c_id){
    $this->mongo_db->pull('comments',array('c_id'=>new MongoId($c_id)))->inc('num_comments',-1)->update('posts');
  }









}
?>
