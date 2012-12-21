<?php

/**
 * Image's Manipulation and File's upload
 *
 * @author Rafael Â. Vieira
 * @version 1.0 
 */
class UpImage {
    var $image;
    var $error;
    var $size;
    var $name;
    var $type;
    var $path = 'Images'; //folder that will recept a resized image
    var $allow_type;
    var $final_name;
    
    //Function that check and organize the image to be resized.
    function Receive($image)
    {
        $this->size = $image['size'];
        $this->tmp = $image['tmp_name'];
        $this->name = $image['name'];
        $this->type = $image['type'];
        $this->error = $image['error'];
        
       // $this->error = array('');
        $this->allow_type = array('image/jpg',
            'image/jpeg',
            'image/pjpeg',
            'image/gif',
            'image/png',
            'text/plain',
            'text/pdf',
            'application/pdf',
            'application/x-pdf',
            'application/acrobat',
            'applications/vnd.pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/pdf',
            'text/x-pdf');
        
        if(!empty($this->name) && in_array($this->type,$this->allow_type))
        {
            $is_image = explode('/',$this->type)[0];
            
            if($is_image == 'image')
            {
                $final_name = explode('.',$this->name)[0].'-'.date('dmYhis').'.jpg';
                $this->resize($this->tmp, $final_name,$this->type,$this->size);
            }
            
            else
            {
                $final_name = explode('.',$this->name)[0].'('.date('dmY-his').')'.'.'.explode('.',$this->name)[1];
                move_uploaded_file($this->tmp, "$this->path/$final_name");
            }
            
            echo "<h2> Arquivo: " . $this->name . " enviado com sucesso</h2>";
        }
        
        elseif($this->size == 0)
        {
            echo '<h2>Selecione um arquivo que deseja guardar.</h2>';
        }
        
        elseif(!in_array($this->type,$this->allow_type))
        {
            echo '<h2> Por favor, selecione um arquivo do formato jpg.</h2>';
        }
               
        
    }
    
    function resize($tmp,$final_name,$type,$size)
    {
        echo $size;
        if($type == 'image/gif')
        {
            $image = imagecreatefromgif($tmp);
        }
        elseif($type == 'image/png')
        {
            $image = imagecreatefrompng($tmp);
        }
        
        else
        {
            $image = imagecreatefromjpeg($tmp);
        }
        
        $height_original = imagesy($image);
        $width_original = imagesx($image);
        $height = $height_original*0.5;//Here you change the height by the factor you want (ex: 0.5 -> 50% reduced)
        $width = $width_original*0.5;//Here you change the width by the factor you want (ex: 0.5 -> 50% reduced)
        $new_image = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($new_image,255,255,255); 
        imagecopyresampled($new_image, $image, 0,0,0,0, $width, $height, $width_original, $height_original);
        imagefill($new_image, 0, 0, $bg);
        imagejpeg($new_image,"$this->path/$final_name");
        imagedestroy($new_image);
        imagedestroy($image);
        return($final_name);  
    }
    
}

?>
