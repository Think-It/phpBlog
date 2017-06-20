<?php
namespace Natinho68\Services;
use Natinho68\Models\Post as Post;

/** 
 * Class Notification is an alerts handler
 */
Class Notification{
    
    /**
     * Construct 
     * start session
     */
    public function __construct(){
        if(!isset($_SESSION)){ 
            session_start(); 
        } 
    }
    
    /**
     * Set the message and the bootstrap class to display in notifications
     * 
     * @param string $message the message you want to display
     * @param string $type the bootstrap class you want to display, by default = danger
     */
    public function setFlash($message, $type = 'danger'){
        $_SESSION['flash'] = array(
            'message' => $message,
            'type'    => $type
            );
    }
    
    /**
     * Display the notifications 
     */
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



