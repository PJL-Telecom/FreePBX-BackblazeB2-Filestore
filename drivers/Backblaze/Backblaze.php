<?php

namespace FreePBX\modules\Filestore\drivers\Backblaze;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;
use \FreePBX\modules\Filestore\drivers\FlysystemBase;

class Backblaze extends FlysystemBase
{
	protected static $path = __DIR__;
	protected static $validKeys = [
		"b2keyid" => '',
		"b2appkey" => '',
		"desc" => '',
		"name" => '',
		"bucket" => '',
		"region" => 'us-west-002',
		'immortal' => '',
		'path' => '',
		'enabled' => 'yes',
	];

	public static function getDisplay($freepbx, $config)
	{
		$regions = [
			'US West (Sacramento)' => 'us-west-002',
			'US West (Phoenix)' => 'us-west-004',
			'EU Central (Amsterdam)' => 'eu-central-003',
		];
		if (empty($_GET['view'])) {
			return load_view(__DIR__ . '/views/grid.php');
		} else {
			$config['regions'] = $regions;
			return load_view(__DIR__ . '/views/form.php', $config);
		}
	}

	public function methodSupported($method)
	{
		$permissions = array(
			'all',
			'read',
			'write',
			'backup',
			'general'
		);
		return in_array($method, $permissions);
	}

	public function getHandler()
	{
		if (isset($this->handler)) {
			return $this->handler;
		}

		$region = $this->config['region'];
		$endpoint = 'https://s3.' . $region . '.backblazeb2.com';

		$config = [
			'region' => $region,
			'version' => 'latest',
			'endpoint' => $endpoint,
			'credentials' => [
				'key'    => $this->config['b2keyid'],
				'secret' => trim($this->config['b2appkey']),
			],
		];

		$client = new S3Client($config);
		$this->config['path'] = $this->config['path'] === '/' ? '' : $this->config['path'];
		$adapter = new AwsS3V3Adapter($client, $this->config['bucket'], $this->config['path']);
		$this->handler = new Filesystem($adapter);
		return $this->handler;
	}
}
