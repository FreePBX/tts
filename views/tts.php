<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
			<?php
				if ($id) {
			?>
					<h2>
						<?php echo _("Text To Speech").": ". $name; ?>
					</h2>
					<p>
						<a href="?<?php echo $_SERVER['QUERY_STRING']; ?>&action=delete">
							<?php echo _("Delete text to speech")?> '<?php echo $name; ?>'
						</a>
						<i style='font-size: x-small'>
							(<?php echo _("Note, does not delete the files from the server.")?><?php echo $tts_astsnd_path; ?>)
						</i>
					</p>
			<?php
				}
			?>
			<form class="popover-form" autocomplete="off" name="editTTS" action="" method="post">
				<input type="hidden" name="display" value="tts">
				<input type="hidden" name="action" value="<?php echo ($id ? 'edit' : 'add') ?>">
				<table>
					<tr>
						<td colspan="2">
							<h5><?php echo _("Main settings"); ?>:<hr></h5>
						</td>
					</tr>
					<?php if ($id){ ?>
						<tr>
							<td>
								<input type="hidden" name="id" value="<?php echo $id; ?>">
							</td>
						</tr>
					<?php		} ?>
					<tr>
						<td>
							<a href="#" class="info"><?php echo _("Name"); ?>:
								<span>
									<?php echo _("Give this TTS Destination a brief name to help you identify it.")?>
								</span>
							</a>
						</td>
						<td>
							<input type="text" name="name" value="<?php echo (isset($name) ? $name : ''); ?>">
						</td>
					</tr>
					<tr>
						<td>
							<a href="#" class="info"><?php echo _("Text"); ?>:
								<span>
									<?php echo _("Enter the text you want to synthetize.")?>
								</span>
							</a>
						</td>
						<td>
							<textarea name="text" cols=50 rows=5>
								<?php echo (isset($text) ? $text : ''); ?>
							</textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2"><br>
							<h5><?php echo _("TTS Engine"); ?>:<hr></h5>
						</td>
					</tr>
					<tr>
						<td>
							<a href="#" class="info">
								<?php echo _("Choose an engine")?>:
								<span>
									<?php echo _("List of TTS engines detected on the server. Choose the one you want to use for the current sentence.")?>
								</span>
							</a>
						</td>
						<td>
							<?php if( !isset($tts_agi_error) ) { ?>
								<select name="engine">
									<?php
										foreach ($engine_list as $e)
										{
											if ($e['name'] == $engine) {
												echo '<option value="' . $e['name'] . '" selected=1>' . $e['name'] . '</option>';
											} else {
												echo '<option value="' . $e['name'] . '">' . $e['name'] . '</option>';
											}
										}
									?>
								</select>
							<?php } else { ?>
								<i><?php echo $tts_agi_error; ?></i>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<td colspan="2"><br>
							<h5>
								<?php echo _("After the Text To Speech was played go to")?>:<hr>
							</h5>
						</td>
					</tr>
					<?php
					//draw goto selects
					if (isset($goto)) {
						echo drawselects($goto,0);
					} else {
						echo drawselects(null, 0);
					}
					?>
					<tr>
						<td colspan="2"><br><h6><input name="Submit" type="submit" <?php echo (isset($tts_agi_error) ? 'disabled="disabled"' : ''); ?> value="<?php echo _("Submit Changes")?>"></h6></td>
					</tr>
				</table>
			</form>
		</div>
		<div class="col-sm-3 hidden-xs">
			<div class="list-group">
				<a href="?display=tts" class="list-group-item <?php echo (empty($id)) ? 'active' : '';?>">
					<?php echo _("Add a Text to Speech item"); ?>
				</a>
				<?php
				if (isset($tts_list)) {
					foreach ($tts_list as $item) {
				?>
						<a href="config.php?display=tts&id=<?php echo urlencode($item['id']);?>" class="list-group-item <?php echo ($id == $item['id']) ? 'active' : '';?>">
							<?php echo $item['name']; ?>
						</a>
				<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
