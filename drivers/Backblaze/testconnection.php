<?php

use Aws\S3\S3Client;

function check_backblaze_connect($endpoint, $region, $bucket, $b2keyid, $b2appkey, $path)
{
	$curlInit = curl_init($endpoint);
	curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($curlInit, CURLOPT_HEADER, true);
	curl_setopt($curlInit, CURLOPT_NOBODY, true);
	curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curlInit);
	curl_close($curlInit);
	if (!$response) {
		return "Connect failed";
	}

	$client = new S3Client([
		'region' => $region,
		'endpoint' => $endpoint,
		'credentials' => [
			'key' => $b2keyid,
			'secret' => $b2appkey
		]
	]);

	// Skip listBuckets() - it fails with bucket-scoped keys.
	// Test credentials by writing directly to the bucket.
	$now = time();
	$file = "/tmp/freepbx_b2test$now.txt";
	file_put_contents($file, "Test");
	$key = basename($file);
	$remotePath = !empty($path) ? "$path/$key" : $key;

	try {
		$client->putObject([
			'Bucket' => $bucket,
			'Key' => $remotePath,
			'Body' => fopen($file, 'r')
		]);
	} catch (\Exception $error_save_file) {
		unlink($file);
		$error = $error_save_file->getMessage();
		if (str_contains($error, '403') || str_contains($error, 'Unauthorized') || str_contains($error, 'AccessDenied')) {
			return "Access denied";
		}
		if (str_contains($error, 'NoSuchBucket') || str_contains($error, 'not found')) {
			return "Bucket not found";
		}
		return "Write failed: " . $error;
	}

	try {
		$client->deleteObject([
			'Bucket' => $bucket,
			'Key' => $remotePath
		]);
	} catch (\Exception $error_delete_file) {
		// Non-critical
	}
	unlink($file);
	return "OK";
}
