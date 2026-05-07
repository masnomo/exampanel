<?php
/**
 * Automated ZIP Extractor & Cache Cleaner
 */
$token = "deploy_token_99122"; 
if (!isset($_GET['token']) || $_GET['token'] !== $token) { die("Unauthorized access."); }

$zipFile = '../deploy.zip';
$extractTo = '../';

if (!file_exists($zipFile)) {
    die("Error: deploy.zip tidak ditemukan di " . realpath('../'));
}

$zip = new ZipArchive;
if ($zip->open($zipFile) === TRUE) {
    $zip->extractTo($extractTo);
    $zip->close();
    unlink($zipFile);
    
    // PEMBERSIHAN CACHE PAKSA
    $files = glob('../storage/framework/views/*');
    foreach($files as $file){ if(is_file($file)) unlink($file); }
    
    echo "SUCCESS_EXTRACTED_AND_CLEANED";
} else {
    echo "ERROR_FAILED_TO_OPEN_ZIP";
}
