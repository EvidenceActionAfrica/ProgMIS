<?php
class image{

	function create_album($album_name)
	{
		$album_name=mysql_real_escape_string(htmlentities($album_name));

		mkdir(getcwd().'/'.'uploads/'.$album_name);
		mkdir(getcwd().'/uploads/thumbs/'.$album_name);
	}

	function upload_image($image_temp,$image_ext=false,$album_name=false){
    // $rand();
    $album_name=substr(sha1(uniqid('moreentropyhere')),0,10);
		$image_file=$album_name.'.csv';
    $cwd= str_replace('\\','/',getcwd());
    $path=$cwd."/uploads/csv/".$image_file;
    // move_uploaded_file($image_temp, 'uploads/images/'.$image_file);
    move_uploaded_file($image_temp, $path);
    // $this->create_thumbs('uploads/images/',$image_file,'uploads/thumbs/');

    return $path;
	}

  function delete_image($image_name)
  {
    unlink('uploads/images/'.$image_name);
    unlink('uploads/thumbs/'.$image_name);
  }

  function get_thumb($image_name)
  {
    
    $file="uploads/images/".$image_name;
    if(file_exists($file))
    {
      $path="uploads/thumbs/".$image_name;
    }
    else
    {
      $path="uploads/no_image.jpg";    
    }

    return $path;

  }

  function get_image($image_name)
  {
    
    $file="uploads/images/".$image_name;
    if(file_exists($file))
    {
      $path="uploads/images/".$image_name;
    }
    else
    {
      $path="uploads/no_image.jpg";    
    }

    return $path;

  }
      

	function create_thumbs($directory, $image, $destination) 
  {
    $image_file = $image;
    $image = $directory.$image;

    if (file_exists($image)) 
    {

      $source_size = getimagesize($image);

      if ($source_size !== false) 
      {

        $thumb_width = 100;
        $thumb_height = 100;

        switch($source_size['mime']) 
        {
          case 'image/jpeg':
               $source = imagecreatefromjpeg($image);
          break;
          case 'image/png':
               $source = imagecreatefrompng($image);
          break;
          case 'image/gif':
               $source = imagecreatefromgif($image);
          break;
        }


        list($width, $height) = getimagesize($image);
                      //$source_size=getimagesize(getcwd().$upload_image);
        $newwidth = $width*0.1; // This can be a set value or a percentage of original size ($width)
        $newheight = $height*0.1; // This can be a set value or a percentage of original size ($height)
        
        // Load the images
      
        $thumb_s = imagecreatetruecolor($newwidth, $newheight);

        imagecopyresized($thumb_s, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        //
        switch($source_size['mime']) 
        {
          case 'image/jpeg':
               imagejpeg($thumb_s, $destination.$image_file);
          break;
          case 'image/png':
                imagepng($thumb_s, $destination.$image_file);
          break;
          case 'image/gif':
               imagegif($thumb_s, $destination.$image_file);
          break;
        }


      }

  }
}






}//end class

?>