<?php
class File_lib{
    public function __construct()
	{
		
	}

    public function upload(string $inputname, string $rename = "", string $uploads_folder=""){
        $filename = "";
        if($uploads_folder != "" && $uploads_folder != null){
            $filename = $uploads_folder."/";
        }
        switch(strtoupper($rename)){
            case null:
            case "": $filename = basename($_FILES[$inputname]["name"]);break;
            case $this->auto_rename_method(): $filename = $this->randomName($inputname); break;
            default: $filename = $rename.".".$this->getFileType($inputname);break;
        }
        $ret = [];
        if(file_exists(uploads($uploads_folder).$filename)){
            $ret = ['code' => '1062', 'message'=>'File already exist', 'filename' => $_FILES[$inputname]["name"], 'filesize' => $_FILES[$inputname]["size"]];
        }
        else{
            $mover = "";
            if($uploads_folder == ""){
                $mover = "public/uploads/";
            }
            else{
                $mover = "public/uploads/". $uploads_folder . "/";
            }
            if (move_uploaded_file($_FILES[$inputname]["tmp_name"], $mover.$filename)) {
                $ret = ['code' => '200', 'message'=>'File uploaded suuccessfully', 'original_filename' => $_FILES[$inputname]["name"], 'filesize' => $_FILES[$inputname]["size"], 'filename'=>$filename];
            } else {
                $ret = ['code' => '-1', 'message'=>'Failed to upload file', 'original_filename' => $_FILES[$inputname]["name"], 'filesize' => $_FILES[$inputname]["size"], 'filename'=>$filename];
            }
        }
        return $ret;
    }

    public function getFileType(string $inputname){
            $filename = $_FILES[$inputname]['name'];
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
            return $fileExtension;
    }

    public function randomName($inputfile){
        $arr = ["A","B","C","D","F","G","H","I","J","K","L","M","Z","X","Y","V","T","R","O"];
        shuffle($arr);
        $arr1 = ["T","Y","R","O","N","E","U","W","5","Q","P","H","A","B","C","D","F"];
        shuffle($arr1);
        $dt = date('Y-m-d-H-i-s');
        return $arr[0].$arr[1].$arr[2].$arr[3].$arr[4].$arr[5].$dt.$arr1[0].$arr1[1].$arr1[2].$arr1[3].$arr1[4].$arr1[5].".".$this->getFileType($inputfile);
    }

    public function auto_rename_method(){
        return "TRUE_CY_AUTO_RENAME_FILE_1001005";
    }

    public function get_file_path(string $inputname){
        return $_FILES[$inputname]["tmp_name"];
    }

    public function get_file(string $inputname){
        return $_FILES[$inputname];
    }

    public function get_file_name(string $input){
        return basename($_FILES[$input]["name"]);
    }

    public function get_file_size(string $inputname){
        return $_FILES[$inputname]["size"];
    }

    public function delete(string $filepath){
        return unlink($filepath);
    }

    public function download(string $path, bool $uploads_folder = true)
    {
        $file = $path;
        if($uploads_folder==true){
            $file = "public/uploads/".$path;
        }

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
        } else {
            return true;
        }
    }


   

}

?>