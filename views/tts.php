<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<?php
				if (!empty($id)) {
			?>
					<h2>
						<?php echo _("Text To Speech").": ". $name; ?>
					</h2>
			<?php
				}
			?>
			<div class="fpbx-container">
				<div class="display full-border">
					<form class="fpbx-submit popover-form" autocomplete="off" name="editTTS" action="" method="post"
					<?php echo !empty($id) ? 'data-fpbx-delete="config.php?display=tts&id='.$id.'&action=delete"' : ''; ?>>
					<input type="hidden" name="display" value="tts">
					<input type="hidden" name="action" value="<?php echo (!empty($id) ? 'edit' : 'add') ?>">
					<?php if (!empty($id)) { ?>
						<input type="hidden" name="id" value="<?php echo $id; ?>">
					<?php } ?>

					<?php //Main Settings ?>
					<div class="section-title" data-for="section1"><h3><i class="fa fa-minus"></i><?php echo _("Main settings"); ?></h3></div>
					<div class="section" data-id="section1">
						<div class="element-container">
							<div class="row">
								<div class="col-md-9">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="name"><?php echo _("Name"); ?></label>
												<i class="fa fa-question-circle fpbx-help-icon" data-for="name"></i>
											</div>
											<div class="col-md-9"><input type="text" class="form-control" name="name" value="<?php echo (isset($name) ? $name : ''); ?>" required></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<span id="name-help" class="help-block fpbx-help-block"><?php echo _("Give this TTS Destination a brief name to help you identify it"); ?></span>
								</div>
							</div>
						</div>
						<div class="element-container">
							<div class="row">
								<div class="col-md-9">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="name"><?php echo _("Text"); ?></label>
												<i class="fa fa-question-circle fpbx-help-icon" data-for="text"></i>
											</div>
											<div class="col-md-9">
												<textarea name="text" class="form-control" cols=50 rows=5 required><?php echo (isset($text) ? $text : ''); ?></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<span id="text-help" class="help-block fpbx-help-block"><?php echo _("Enter the text you want to synthetize."); ?></span>
								</div>
							</div>
						</div>
					</div>

					<?php //TTS Engine ?>
					<div class="section-title" data-for="section2"><h3><i class="fa fa-minus"></i><?php echo _("TTS Engines"); ?></h3></div>
					<div class="section" data-id="section2">
						<div class="element-container">
							<div class="row">
								<div class="col-md-9">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="engine"><?php echo _("Choose an Engine"); ?></label>
												<i class="fa fa-question-circle fpbx-help-icon" data-for="engine"></i>
											</div>
											<div class="col-md-9">
												<?php if( !isset($tts_agi_error) ) { ?>
													<select name="engine" class="form-control">
														<?php
															foreach ($engine_list as $e)
															{
																if ($e['name'] == $engine) {
																	echo '<option value="' . $e['name'] . '" selected>' . $e['name'] . '</option>';
																} else {
																	echo '<option value="' . $e['name'] . '">' . $e['name'] . '</option>';
																}
															}
														?>
													</select>
												<?php } else { ?>
													<i><?php echo $tts_agi_error; ?></i>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<span id="engine-help" class="help-block fpbx-help-block"><?php echo _("List of TTS engine detected on the server. Choose the one you want to use for the current sentence."); ?></span>
								</div>
							</div>
						</div>
						<div class="element-container">
							<div class="row">
								<div class="col-md-9">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="goto"><?php echo _("Destintation"); ?></label>
												<i class="fa fa-question-circle fpbx-help-icon" data-for="goto"></i>
											</div>
											<div class="col-md-9">
												<?php
												if (isset($goto)) {
													echo drawselects($goto,0,false,true,null,true);
												} else {
													echo drawselects(null, 0,false,true,null,true);
												}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<span id="goto-help" class="help-block fpbx-help-block"><?php echo _("After the Text to Speech was played go to"); ?></span>
								</div>
							</div>
						</div>
					</div>
					<?php //END TTS Engines ?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
