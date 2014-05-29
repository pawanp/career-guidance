<?php

App::uses('Sanitize', 'Utility');

class GeneralFunctionsComponent extends Component {

    public $components = array('Cookie', 'Paginator', 'GeneralFunctions', 'Paginator', 'Session','Email');
    public $helpers = array('Html');

    public function GenerateRamdomePassword() {

        $randome_string = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 8)), 0, 8);
        return $randome_string;
    }

    function uploadImage($image = array(), $uploadpath = '', $image_prefix = '', $edit = false, $old_image = '') {
        $image_name = '';
        if (empty($image) || empty($uploadpath)) {
            return $image_name;
        }
        if (is_uploaded_file($image['tmp_name'])) {
            $image_prefix = $image_prefix . rand(0, 999999999) . $this->getCurrentTime();
            $ext = strtolower(substr($image['name'], strpos($image['name'], ".") + 1));
            $image_name = $image_prefix . '.' . $ext;
            move_uploaded_file($image['tmp_name'], $uploadpath . $image_name);
            if ($edit) {
                if ($old_image != '' && $old_image != 'default.jpg') {
                    @unlink($uploadpath . $old_image);
                }
            }
        } else {
            if ($edit) {
                $image_name = $old_image;
            }
        }
        return $image_name;
    }
    
    function getCurrentTime(){
		return time();
    }
	
    

}

?>