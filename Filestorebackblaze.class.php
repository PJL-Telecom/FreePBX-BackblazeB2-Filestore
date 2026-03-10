<?php
namespace FreePBX\modules;

include_once __DIR__ . '/../filestore/vendor/autoload.php';

class Filestorebackblaze extends \FreePBX_Helpers implements \BMO {

	private $symlinkTarget;
	private $symlinkPath;

	public function __construct($freepbx = null) {
		if ($freepbx == null) {
			throw new \Exception("Not given a FreePBX Object");
		}
		$this->FreePBX = $freepbx;
		$this->db = $freepbx->Database;

		$this->symlinkTarget = __DIR__ . '/drivers/Backblaze';
		$this->symlinkPath = dirname(__DIR__) . '/filestore/drivers/Backblaze';
	}

	public function install() {
		$this->importSigningKey();

		// Create symlink in filestore's drivers directory so it discovers our driver
		if (!file_exists($this->symlinkPath)) {
			symlink($this->symlinkTarget, $this->symlinkPath);
		} elseif (is_link($this->symlinkPath) && readlink($this->symlinkPath) !== $this->symlinkTarget) {
			// Symlink exists but points elsewhere - fix it
			unlink($this->symlinkPath);
			symlink($this->symlinkTarget, $this->symlinkPath);
		}
		return true;
	}

	private function importSigningKey()
	{
		$keyfile = __DIR__ . '/assets/pjltelecom-signing-key.asc';
		$fingerprint = '214291C6ABB744F57F54604A4C8F5F89673D1120';
		if (!file_exists($keyfile)) {
			return;
		}
		try {
			$gpg = \FreePBX::GPG();
			$gpgdir = $gpg->getGpgLocation();

			$cmd = "/usr/bin/gpg --homedir " . escapeshellarg($gpgdir) . " --batch --yes --import " . escapeshellarg($keyfile) . " 2>&1";
			exec($cmd, $output, $rc);

			$trustCmd = "echo " . escapeshellarg($fingerprint . ":6:") . " | /usr/bin/gpg --homedir " . escapeshellarg($gpgdir) . " --batch --import-ownertrust 2>&1";
			exec($trustCmd);
		} catch (\Exception $e) {
			// Non-fatal
		}
	}

	public function uninstall() {
		// Remove the symlink from filestore's drivers directory
		if (is_link($this->symlinkPath)) {
			unlink($this->symlinkPath);
		}
		return true;
	}

	public function doConfigPageInit($page) {}
	public function showPage() { return ''; }

	public function ajaxRequest($req, &$setting) {
		return match ($req) {
			'testconnection' => true,
			default => false,
		};
	}

	public function ajaxHandler() {
		switch ($_REQUEST['command']) {
			case 'testconnection':
				include(__DIR__ . '/drivers/Backblaze/testconnection.php');
				$region = $_REQUEST['region'];
				$endpoint = 'https://s3.' . $region . '.backblazeb2.com';
				return check_backblaze_connect(
					$endpoint,
					$region,
					$_REQUEST['bucket'],
					$_REQUEST['b2keyid'],
					$_REQUEST['b2appkey'],
					$_REQUEST['path'] ?? ''
				);
		}
	}
}
