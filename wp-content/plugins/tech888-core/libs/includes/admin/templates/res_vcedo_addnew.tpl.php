<?php
if (!defined('ABSPATH')) {
    die;
}
?>
<div class="wrap bb_wrap bb_edo_settings" id="bb-edo-settings">
	<?php if($this->editMode == false): ?>
    	<h2 class="bb-headtitle"><?php esc_html_e('Responsive for WPBakery Page Builder - Add New Device', 't888-core') ?></h2>
	<?php else: ?>
		<h2 class="bb-headtitle"><?php esc_html_e('Responsive for WPBakery Page Builder - Edit Device', 't888-core') ?></h2>
	<?php endif ?>

	<form id="bb-form" method="post" action="">
		<div class="bb-form">
			<div class="bb-field-row">
				<div class="bb-label">
					<label><?php esc_html_e('ID slug (required)', 't888-core') ?></label>
				</div>
				<div class="bb-field">
					<input id="idSlugTxt" <?php echo ($this->editMode == true)?'disabled="disabled"':'' ?> type="text" name="idSlug" value="<?php if($this->idSlug) echo esc_attr($this->idSlug) ?>">
				</div>
				<div class="bb-desc">
					<?php if($this->editMode == false): ?>
						<?php esc_html_e("Slug of device is Unique. Only alphabet character and _", 't888-core') ?>
						<br/><?php esc_html_e("You can't edit in future.", 't888-core') ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="bb-field-row">
				<div class="bb-label">
					<label><?php esc_html_e(' Device Label', 't888-core') ?></label>
				</div>
				<div class="bb-field">
					<input type="text" name="label" value="<?php if($this->label) echo esc_attr($this->label) ?>">
				</div>
				<div class="bb-desc">
				</div>
			</div>
			<div class="bb-field-row">
				<div class="bb-label">
					<label><?php esc_html_e('Media Features', 't888-core') ?></label>
				</div>
				<div class="bb-field">
					<select name="mediafeature">
						<option value=""><?php esc_html_e('None', 't888-core') ?></option>
						<?php
						foreach ($this->mediaFeatures as $mediaFeature) {
							echo '<option '.( ($mediaFeature == $this->mediafeature)?'selected="selected"':'' ).' value="'.$mediaFeature.'">'.$mediaFeature.'</option>';
						}
						?>
					</select>
				</div>
				<div class="bb-desc">
					<?php esc_html_e('Condition to define a device.', 't888-core') ?>
					<a href="<?php echo esc_html('http://www.w3schools.com/cssref/css3_pr_mediaquery.asp') ?>" target="_blank"><?php esc_html_e('Read more.', 't888-core') ?></a>
					<br/>
					<?php esc_html_e('Recommended use Max-Width and Min-Width.', 't888-core') ?>
					<?php if($this->editMode == true): ?>
						<br/><?php esc_html_e("If you edit this field, you need to re-save all of posts", 't888-core') ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="bb-field-row">
				<div class="bb-label">
					<label><?php esc_html_e('Breakpoint (px)', 't888-core') ?></label>
				</div>
				<div class="bb-field">
					<input type="number" name="breakpoint" value="<?php if($this->breakpoint) echo esc_attr($this->breakpoint) ?>">
				</div>
				<div class="bb-desc">
					<?php esc_html_e('Value of Media Feature. The Breakpoint of screen', 't888-core') ?>
					<?php if($this->editMode == true): ?>
						<br/><?php esc_html_e("If you edit this field, you need to re-save all of posts", 't888-core') ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="bb-field-row">
				<div class="bb-label">
					<label><?php esc_html_e('Icon', 't888-core') ?></label>
				</div>
				<div class="bb-field">
					<select name="icon" id="bb_edo_icon">
						<option value="image_icon" <?php echo ($this->icon == 'image_icon')?'selected="selected"' : ''; ?>><?php esc_html_e('Image Icon', 't888-core') ?></option>
						<option value="class_icon" <?php echo ($this->icon == 'class_icon')?'selected="selected"' : ''; ?>><?php esc_html_e('Class Icon', 't888-core') ?></option>
					</select>

					<p id="bb_edo_class_icon" class="bb_edo_icon_depend">
						<input type="text" name="class_icon" value="<?php if($this->class_icon) echo esc_attr($this->class_icon); ?>"></p>
					<div id="bb_edo_image_icon" class="bb_edo_icon_depend">
						<p>
							<button type="button" id="bb_upload_image_icon" class="button primary">
								<span class="dashicons dashicons-upload"></span>
								<?php esc_html_e('Upload Icon', 't888-core') ?>
							</button>
							<button type="button" id="bb_delete_image_icon" class="button danger">
								<span class="dashicons dashicons-no"></span>
								<?php esc_html_e('Delete Icon', 't888-core') ?>
							</button>
						</p>
						<p>
							<div id="bb_custom_image_icon">
								<?php
									if($this->image_icon != '' && $this->icon == 'image_icon') {
										echo '<img src="'.$this->image_icon.'" alt="" />';
									}
								?>
							</div>
							<input id="bb_custom_image_icon_val" type="hidden" name="image_icon" value="<?php if($this->image_icon) echo esc_attr($this->image_icon) ?>"/>
						</p>
					</div>
				</div>
				<div class="bb-desc">
				</div>
			</div>
			<div class="bb-field-row">
				<div class="bb-label">
					<label><?php esc_html_e('Priority', 't888-core') ?></label>
				</div>
				<div class="bb-field">
					<input type="number" name="order" value="<?php if($this->order) echo esc_attr($this->order) ?>">
				</div>
				<div class="bb-desc">
				</div>
			</div>
		</div>

		<?php if($this->editMode == false): ?>
			<input type="hidden" name="tech888f_res_addnewdevice" value="1">
			<button type="submit" name="submit" class="button success"><span class="dashicons dashicons-plus-alt"></span><?php esc_html_e('Add device', 't888-core') ?></button>
		<?php else: ?>
			<input type="hidden" name="tech888f_res_updatedevice" value="1">
			<button type="submit" name="submit" class="button success"><span class="dashicons dashicons-admin-generic"></span><?php esc_html_e('Save changes', 't888-core') ?></button>
		<?php endif ?>

	</form>

</div>
