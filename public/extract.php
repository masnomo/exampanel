<?php
/**
 * Automated ZIP Extractor for GitHub Actions Deployment
 */
$token = "deploy_token_99122"; 
if (!isset($_GET['token']) || $_GET['token'] !== $token) { die("Unauthorized access."); }

$zipFile = '../deploy.zip';
$extractTo = '../';

if (!file_exists($zipFile)) { die("Error: deploy.zip not found."); }

$zip = new ZipArchive;
if ($zip->open($zipFile) === TRUE) {
    $zip->extractTo($extractTo);
    $zip->close();
    unlink($zipFile);
    echo "Success: Project extracted successfully!";
} else {
    echo "Error: Failed to open zip file.";
}
