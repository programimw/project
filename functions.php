<?php
function uploadFile($file_name, $old_path,$new_path){
    $allowed_types = array('png', 'jpg','PNG', 'JPG','jpeg','JPEG');
    $name_array = explode(".", $file_name);
    $type = end($name_array);

    if (!in_array($type, $allowed_types)){
       return false;
    }

    if (!move_uploaded_file($old_path, $new_path)) {
        return false;
    }
    return true;
}
