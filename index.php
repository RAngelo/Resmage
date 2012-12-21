<?php

require('UpImage_class.php');

if ( isset( $_POST['submit'] ) ){   
  
   $test = new UpImage;
   
   $test->Receive($_FILES['arquivo']);

}
?>

<form action="" method="post" enctype="multipart/form-data">
   <label for="arquivo">Arquivo:</label>
   <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
   <input type="file" name="arquivo" id="arquivo" /> 
   <br />
   <input type="submit" name="submit" value="Enviar" />
</form>
