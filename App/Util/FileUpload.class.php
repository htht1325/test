<?php
class FileUpload {


    private $fileName;
    private $filePath;

    function __construct($filepath)

    {

        $this->filePath = $filepath;

    }

    public function upload(){

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {


            $tempFile = $_FILES['uploadify']['tmp_name'];

            $targetPath = $this->filePath;

            $targetPath = rtrim($targetPath,'/').date('Y-m-d').'/';

            if(!file_exists($targetPath)){
                mkdir($targetPath);
                chmod($targetPath,0777);
            }

            $targetFile = rtrim($targetPath,'/') . '/' . $_FILES['uploadify']['name'];

            // Validate the file type
            $fileTypes = array('jpg','jpeg','gif','png','pdf');
            // File extensions
            $fileParts = pathinfo($_FILES['uploadify']['name']);

            if (in_array($fileParts['extension'],$fileTypes)) {
                move_uploaded_file($tempFile,$targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }


    }




}