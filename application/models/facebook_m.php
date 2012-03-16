<?php
class Facebook_m extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        
        
        $fb_data = $this->session->userdata('fb_data');

        //if(!(isset($fb_data['uid']) and $fb_data['uid'])){

          $this->session->set_userdata('uid', '1234');
          $config = array(
                          'appId'  => '189985587751564',
                          'secret' => '5047ef171d44112ad674558e5a673a95',
                          'fileUpload' => true, // Indicates if the CURL based @ syntax for file uploads is enabled.
                          );
   
          $this->load->library('Facebook', $config);
   
          $user = $this->facebook->getUser();
   
          $profile = null;
          if($user)
          {
              try {
                $profile = $this->facebook->api('/me?fields=id,name,link,email');
                $this->session->set_userdata('name', $profile['name']);
                $this->session->set_userdata('uid', $profile['id']);        

              } catch (FacebookApiException $e) {
                  error_log($e);
                  $user = null;
              }
          }
          $fb_data = array(
                          'me' => $profile,
                          'name' => $profile['name'],
                          'uid' => $user,
                          'loginUrl' => $this->facebook->getLoginUrl(),
                          'logoutUrl' => $this->facebook->getLogoutUrl(array('next' => 'http://localhost/internet/')),
                          'appId' => '189985587751564'
                        );
          $this->session->set_userdata('fb_data', $fb_data);

        }
   
        
    //}
}
