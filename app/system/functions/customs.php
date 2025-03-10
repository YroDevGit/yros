<?php 
class customs{
    public function __construct()
	{
		
	}

    public function importjspost(){
        $fileUrl = "https://raw.githubusercontent.com/YroDevGit/yros/main/public/code/jspost.js";
        $outputDir = "public/code/";  
        $outputFile = $outputDir . "jspost.js"; 

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);  
        }

        $ch = curl_init($fileUrl);
        $fp = fopen($outputFile, "w");

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        if (file_exists($outputFile)) {
            echo "JSPOST imported Successfully ✅";
        } else {
            echo "Failed to download file.";
        }
    }


    public function importswal(){//https://github.com/YroDevGit/yros/blob/main/app/system/secret/yroswal.js
        $fileUrl = "https://raw.githubusercontent.com/YroDevGit/yros/main/app/system/secret/yroswal.js";
        $outputDir = "app/system/secret/";  
        $outputFile = $outputDir . "yroswal.js"; 

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        $ch = curl_init($fileUrl);
        $fp = fopen($outputFile, "w");

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        if (file_exists($outputFile)) {
            echo "Swal imported successfully ✅";
        } else {
            echo "Failed to download file.";
        }
    }
    
    public function importqrcode(){//https://github.com/YroDevGit/libraries/main/qrcode.js
        $fileUrl = "https://raw.githubusercontent.com/YroDevGit/libraries/main/qrcode.js";
        $outputDir = "app/system/secret/";  
        $outputFile = $outputDir . "jsqrcode.js"; 

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        $ch = curl_init($fileUrl);
        $fp = fopen($outputFile, "w");

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        if (file_exists($outputFile)) {
            echo "QR generator imported successfully ✅";
        } else {
            echo "Failed to download file.";
        }
    }

    public function importqrscanner(){//https://github.com/YroDevGit/libraries/main/scanner.js
        $fileUrl = "https://raw.githubusercontent.com/YroDevGit/libraries/main/scanner.js";
        $outputDir = "app/system/secret/";  
        $outputFile = $outputDir . "jsqrscanner.js"; 

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        $ch = curl_init($fileUrl);
        $fp = fopen($outputFile, "w");

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        if (file_exists($outputFile)) {
            echo "QR scanner imported successfully ✅";
        } else {
            echo "Failed to download file.";
        }
    }
}


?>