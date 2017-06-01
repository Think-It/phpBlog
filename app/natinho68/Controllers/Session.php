<?php
namespace Natinho68\Controllers;
use Natinho68\Models\Post as Post;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Session{

    public function __construct(){
        if(!isset($_SESSION)){ 
            session_start(); 
        } 
    }
    
    public function setFlash($message, $type = 'danger'){
        $_SESSION['flash'] = array(
            'message' => $message,
            'type'    => $type
            );
    }
    
    public function flash(){
        if(isset($_SESSION['flash'])){
            ?>
            <div id="alert" class="alert alert-<?php echo $_SESSION['flash']['type'] ?>" role="alert">
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           
                <strong><?php print_r($_SESSION['flash']['message']); ?></strong>
            </div>
            <?php
            unset($_SESSION['flash']);
        }
    }
   
       
}



