<?php
class File_lib{
    public function __construct()
	{
		
	}

    public function upload(string $inputname, string $rename = "", string $uploads_folder=""){
        $filename = "";
        if(! isset($_FILES[$inputname])){
            show_error("Files not found.!");
        }
        if($_FILES[$inputname]["name"]==""||$_FILES[$inputname]["name"]==null){
            show_error("No filename found.!");
        }
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

    public function file_to_longblob(string $fileinput){
        if (isset($_FILES[$fileinput]) && isset($_FILES[$fileinput]['tmp_name'])) {
            $fileTmpPath = $_FILES[$fileinput]['tmp_name'];

            $fileData = file_get_contents($fileTmpPath);
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($fileTmpPath);
        
            $base64Data = base64_encode($fileData);
        
            return "data:$mimeType;base64,$base64Data";
        }else{
            return null;
        }
    }

    public function download_longblob(string $blob_data, string $file_name=""){
        $base64Data = $blob_data;
        $explodedData = explode(',', $base64Data);
        $dataHeader = $explodedData[0];  
        $base64Image = $explodedData[1]; 

        preg_match('/^data:(.*?);base64/', $dataHeader, $matches);
        $contentType = $matches[1];

        $imageData = base64_decode($base64Image);
        $filename = 'downloaded_file';
        if($file_name == null || $file_name == ""){
            $filename = "YrosFile_".date("y_m_d_H_i_s")."fl";
        }else{
            $filename = $file_name;
        }

        $extension = '';
        switch ($contentType) {
            case 'image/jpeg':
                $extension = 'jpg';
                break;
            case 'image/png':
                $extension = 'png';
                break;
            case 'video/mp4':
                $extension = 'mp4';
                break;
            case 'image/gif':
                $extension = 'gif'; 
                break;
            case 'video/webm':
                $extension = 'webm';
                break;
            case 'audio/mpeg':
                $extension = 'mp3';
                break;
            case 'audio/wav':
                $extension = 'wav';  
                break;
            case 'application/pdf':
                $extension = 'pdf';  
                break;
            case 'application/zip':
                $extension = 'zip'; 
                break;
            case 'application/msword':
                $extension = 'doc';  
                break;
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                $extension = 'docx';  
                break;
            case 'text/plain':
                $extension = 'txt';  
                break;
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                $extension = 'xlsx';  
                break;
            case 'application/vnd.ms-excel':
                $extension = 'xls'; 
                break;
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                $extension = 'pptx'; 
                break;
            case 'application/vnd.ms-powerpoint':
                $extension = 'ppt'; 
                break;
            default:
                $extension = 'bin'; 
                break;
        }

        $filename .= '.' . $extension;

        header('Content-Type: ' . $contentType); 
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($imageData));

        echo $imageData;
    }


   

}

?>