<?php
class image{


	function upload_image($image_temp,$image_ext=false,$album_name=false){
    // $rand();
    $album_name=substr(sha1(uniqid('moreentropyhere')),0,10);
		$image_file=$album_name.'.csv';
    $cwd= str_replace('\\','/',getcwd());
    $path=$cwd."/csv_upload/upload_csv/uploads/csv/".$image_file;
   
    // move_uploaded_file($image_temp, 'uploads/images/'.$image_file);
    move_uploaded_file($image_temp, $path);
    // $this->create_thumbs('uploads/images/',$image_file,'uploads/thumbs/');

    return $path;
	}


}//end class

?>