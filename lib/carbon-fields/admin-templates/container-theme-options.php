<div class="wrap carbon-container <?php echo $container_tag_class_name ?>"  data-type="<?php echo $container_type ?>">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2><?php echo $this->title ?></h2>
	
	<?php
	if ( !empty($this->errors) ) {
		echo '<div class="error settings-error">';
		
		foreach ($this->errors as $error) {
			echo '<p><strong>' . $error . '</strong></p>';
		}
	} else if ( !empty($this->notifications) ) {
		foreach ($this->notifications as $notification) {
			?>
			<div class="settings-error updated">
				<p><strong><?php echo $notification ?></strong></p>
			</div>
			<?php
		}
	}
	?>

	<form method="post" class="" enctype="multipart/form-data" action="<?php echo remove_query_arg(array('settings-updated')) ?>">
		<table border="0" cellspacing="0" cellpadding="0" class="form-table">
			<?php
			foreach ($this->fields as $field) {
				$field->load();
				$help_text = $field->get_help_text();
				
				if ( $field->type == 'Separator' || $field->type == 'Html' ) {
					?>
					<tr class="carbon-separator">
						<th colspan="2">
							<?php 
							echo $field->get_label(); 
							if( $field->type == 'Html' ) {
								$field->render();
							} else {
								if( !empty( $help_text ) ) {
									?>
									<em class="help-text"><?php echo $help_text; ?></em>
									<?php 
								}
							}
							?>
						</th>
					</tr>
					<?php
				} else {
					$default_value = $field->get_default_value();
					if (is_array($default_value)) {
						$default_value = implode(',', $default_value);
					}
					?>
					<tr>
						<th scope="row">
							<label for="<?php echo $field->get_id(); ?>"><?php 
							echo $field->get_label();
							
							if ( $field->is_required() ) {
								echo ' <span class="carbon-required">*</span>';
							}
							?></label>
						</th>
						<td>
							<div class="carbon-field carbon-<?php echo implode(' carbon-', $field->get_html_class()); ?>" data-type="<?php echo $field->type ?>" data-name="<?php echo $field->get_name() ?>" data-default-value="<?php echo esc_attr($default_value); ?>">
								<?php echo $field->render(); ?>
							</div>
							<?php
							if ( !empty( $help_text ) ) {
								echo '<em class="help-text">' . $help_text . '</em>';
							}
							?>
						</td>
					</tr>
					<?php
				}
			}
			?>
		</table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'crb'); ?>"></p>
		<?php wp_nonce_field('carbon_panel_' . $this->id . '_nonce', $this->get_nonce_name(), /*referer?*/ false, /*echo?*/ true); ?>
	</form>
</div>