/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
           window.setTimeout(function() {
           $(".alert").fadeTo(500, 0).slideUp(500, function(){
           $(this).remove();
                });
            }, 4000);