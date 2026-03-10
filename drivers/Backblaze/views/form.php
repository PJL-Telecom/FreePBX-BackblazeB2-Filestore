<?php
$disabled = (isset($readonly) && !empty($readonly)) ? ' disabled ' : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (empty($displayname)) {
	$displayname = $bucket ?? '';
}
include 'modal.testconnection.php';
?>
<div class="container-fluid">
	<h1><?php echo _('Backblaze B2 Storage') ?></h1>
	<div class="display full-border">
		<div class="row">
			<div class="col-sm-12">
				<div class="fpbx-container">
					<div class="display full-border">
						<form class="fpbx-submit" action="?display=filestore" method="post" id="server_form" name="server_form" data-fpbx-delete="?display=filestore&action=delete&id=<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
							<input type="hidden" name="action" value="<?php echo empty($id) ? 'add' : 'edit' ?>">
							<input type="hidden" name="id" value="<?php echo $id ?>">
							<input type="hidden" name="driver" value="Backblaze">
							<!--Enabled-->
							<div class="element-container">
								<div class="row">
									<div class="form-group">
										<div class="col-md-3">
											<label class="control-label" for="enabled"><?php echo _("Enabled") ?></label>
											<i class="fa fa-question-circle fpbx-help-icon" data-for="enabled"></i>
										</div>
										<div class="col-md-9">
											<span class="radioset">
												<input type="radio" name="enabled" id="enabledyes" value="yes" <?php echo (isset($enabled) && $enabled != "no") ? "CHECKED" : "" ?>>
												<label for="enabledyes"><?php echo _("Yes"); ?></label>
												<input type="radio" name="enabled" id="enabledno" value="no" <?php echo (!isset($enabled) || $enabled == "no") ? "CHECKED" : "" ?>>
												<label for="enabledno"><?php echo _("No"); ?></label>
											</span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<span id="enabled-help" class="help-block fpbx-help-block"><?php echo _("Enable or disable this storage location.") ?></span>
									</div>
								</div>
							</div>
							<!--END Enabled-->
							<!--Local Display Name-->
							<div class="element-container">
								<div class="row">
									<div class="form-group">
										<div class="col-md-3">
											<label class="control-label" for="name"><?php echo _("Local Display Name") ?></label>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" id="name" name="name" value="<?php echo isset($name) ? $name : '' ?>" <?php echo $disabled ?>>
										</div>
									</div>
								</div>
							</div>
							<!--Bucket Name-->
							<div class="element-container">
								<div class="row">
									<div class="form-group">
										<div class="col-md-3">
											<label class="control-label" for="bucket"><?php echo _("Bucket Name") ?></label>
											<i class="fa fa-question-circle fpbx-help-icon" data-for="bucket"></i>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" id="bucket" name="bucket" value="<?php echo isset($bucket) ? $bucket : '' ?>" <?php echo $disabled ?>>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<span id="bucket-help" class="help-block fpbx-help-block"><?php echo _("The name of your Backblaze B2 bucket.") ?></span>
									</div>
								</div>
							</div>
							<!--Description-->
							<div class="element-container">
								<div class="row">
									<div class="form-group">
										<div class="col-md-3">
											<label class="control-label" for="desc"><?php echo _("Description") ?></label>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" id="desc" name="desc" value="<?php echo isset($desc) ? $desc : '' ?>" <?php echo $disabled ?>>
										</div>
									</div>
								</div>
							</div>
							<!--END Description-->
							<!--B2 Region-->
							<div class="element-container">
								<div class="row">
									<div class="form-group">
										<div class="col-md-3">
											<label class="control-label" for="region"><?php echo _("B2 Region") ?></label>
											<i class="fa fa-question-circle fpbx-help-icon" data-for="region"></i>
										</div>
										<div class="col-md-9">
											<select class="form-control" id="region" name="region">
												<?php
												foreach ($regions as $value => $key) {
													$selected = (isset($region) && $key == $region) ? 'SELECTED' : '';
													echo '<option value = "' . $key . '" ' . $selected . '>' . $value . ' [' . $key . ']</option>';
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<span id="region-help" class="help-block fpbx-help-block"><?php echo _("The region where your B2 bucket is located. Check your Backblaze dashboard for this.") ?></span>
									</div>
								</div>
							</div>
							<!--END B2 Region-->
							<!--Application Key ID-->
							<div class="element-container">
								<div class="row">
									<div class="form-group">
										<div class="col-md-3">
											<label class="control-label" for="b2keyid"><?php echo _("Application Key ID") ?></label>
											<i class="fa fa-question-circle fpbx-help-icon" data-for="b2keyid"></i>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" id="b2keyid" name="b2keyid" value="<?php echo isset($b2keyid) ? $b2keyid : '' ?>" <?php echo $disabled ?>>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<span id="b2keyid-help" class="help-block fpbx-help-block"><?php echo _("Your Backblaze B2 Application Key ID (keyID).") ?></span>
									</div>
								</div>
							</div>
							<!--END Application Key ID-->
							<!--Application Key-->
							<div class="element-container">
								<div class="row">
									<div class="form-group">
										<div class="col-md-3">
											<label class="control-label" for="b2appkey"><?php echo _("Application Key") ?></label>
											<i class="fa fa-question-circle fpbx-help-icon" data-for="b2appkey"></i>
										</div>
										<div class="col-md-9">
											<input type="password" class="form-control" id="b2appkey" name="b2appkey" value="<?php echo isset($b2appkey) ? $b2appkey : '' ?>" <?php echo $disabled ?>>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<span id="b2appkey-help" class="help-block fpbx-help-block"><?php echo _("Your Backblaze B2 Application Key (applicationKey). This is only shown once when created.") ?></span>
									</div>
								</div>
							</div>
							<!--END Application Key-->
							<!--Path-->
							<div class="element-container">
								<div class="row">
									<div class="form-group">
										<div class="col-md-3">
											<label class="control-label" for="path"><?php echo _("Path") ?></label>
											<i class="fa fa-question-circle fpbx-help-icon" data-for="path"></i>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" id="path" name="path" value="<?php echo isset($path) ? $path : '' ?>" <?php echo $disabled ?>>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<span id="path-help" class="help-block fpbx-help-block"><?php echo _("Optional path prefix within the bucket (e.g. backups/freepbx).") ?></span>
									</div>
								</div>
							</div>
							<!--END Path-->
							<br>
							<div class="element-container">
								<div class="row">
									<div class="col-md-12">
										<button type='button' class='btn btn-default pull-right' id='testconn'><?php echo _("Test Connection Settings"); ?></button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var immortal = <?php echo (isset($immortal) && !empty($immortal)) ? 'true' : 'false'; ?>;
	$('#server_form').on('submit', function(e) {
		if ($("#bucket").val().length === 0) {
			warnInvalid($("#bucket"), _("The bucket name cannot be empty"));
			return false;
		}
		if ($("#b2keyid").val().length === 0) {
			warnInvalid($("#b2keyid"), _("The Application Key ID cannot be empty"));
			return false;
		}
		if ($("#b2appkey").val().length === 0) {
			warnInvalid($("#b2appkey"), _("The Application Key cannot be empty"));
			return false;
		}
		return true;
	});

	function testconn() {
		var req = {
			module: 'filestorebackblaze',
			command: 'testconnection',
			driver: "Backblaze",
			bucket:  $('#bucket').val(),
			region:  $('#region').val(),
			b2keyid: $('#b2keyid').val(),
			b2appkey: $('#b2appkey').val(),
			path: $('#path').val(),
		};
		$.ajax({
			url: FreePBX.ajaxurl,
			data: req,
			success:function(data){
				if(data.message == "Connect failed") {
					$('#b2apiconnection').text("Connection to B2 API failed. Please check network settings and that no firewall is blocking access.");
					$('#b2credentials').text("Aborted");
					$('#b2write').text("Aborted");
				}
				else if(data.message == "Access denied") {
					$('#b2apiconnection').text("OK");
					$('#b2credentials').text("Login failed. Please check Application Key ID and Application Key.");
					$('#b2write').text("Aborted");
				}
				else if(data.message == "Bucket not found") {
					$('#b2apiconnection').text("OK");
					$('#b2credentials').text("OK");
					$('#b2write').text("Bucket not found. Please verify the bucket name and that your key has access.");
				}
				else if(data.message == "OK") {
					$('#b2apiconnection').text("OK");
					$('#b2credentials').text("OK");
					$('#b2write').text("OK");
				}
				else {
					$('#b2apiconnection').text("OK");
					$('#b2credentials').text("OK");
					$('#b2write').text(data.message);
				}
			},
		});
	}

	$("#testconn").click(function(e) {
		e.preventDefault();
		$('#b2apiconnection').text("");
		$('#b2credentials').text("");
		$('#b2write').text("");
		$("#custmodal").modal('show');
		testconn();
	});

	$('#testcon_close').click(function(e) {
		e.preventDefault();
		$('#b2apiconnection').text("");
		$('#b2credentials').text("");
		$('#b2write').text("");
		$("#custmodal").modal('hide');
	});
</script>
