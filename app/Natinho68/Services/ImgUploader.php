<?php
namespace Natinho68\Services;
use Natinho68\Services\Notification;

/**
 * Upload images service for post 
 */
class ImgUploader {

    /**
     * Create a folder, move images in, rename image, and return the path as a string
     * 
     * @return string path to img
     */
    public function uploadImg(){
        // folder for uploading
        $folder = 'img/uploads';
        $file = basename($_FILES['image']['name']);
        // image size max
        $sizeMax = 4000000;
        $size = filesize($_FILES['image']['tmp_name']);
        // allowed extensions
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['image']['name'], '.'); 
        //Security verification
        
        // if empty file
            if(empty($file)){
                $notification = new Notification();
                // set the error message
                $notification->setFlash("No featured image uploaded ...", "warning");
                // display the message
                $notification->flash();
                
            } else {
            // if extension not allowed
            if(!in_array($extension, $extensions))
            {
                 $erreur = new Notification();
                 // set the error message
                 $erreur->setFlash("You must upload a file of type png, gif, jpg or jpeg ...");
                 // display the message
                 $erreur->flash();
                 die();
                 
            }
            // if image too heavy
            if($size>$sizeMax)
            {
                 $erreur = new Notification();
                 // set the error message
                 $erreur->setFlash("File too large...");
                 // display the message
                 $erreur->flash();
                 die();
                 
            }
            //if no errors, upload
            if(!isset($erreur)) 
            {
                 //file name formating by a random number + extension
                 $file = rand().$extension;
                 //if true, upload ok
                 if(move_uploaded_file($_FILES['image']['tmp_name'], $folder.'/'.$file))
                {
                      $path = $folder.'/'.$file;
                      return $path;
                 }
                 else
                 // if it's not working
                 {
                      $erreur = new Notification();
                      // set message
                      $erreur->setFlash("Fail to upload !");
                      // display message
                      $erreur->flash();
                      die();
                 }
            }
        }        
    }


    
}
