<?php

/**
 * @file
 * Administrative functions used for User Content Type.
 */

/**
 * Administration settings form for the user content type module configuration.
 */
function user_content_type_admin_settings($form, &$form_state) {
  $form = array();

  $user_fields = field_info_instances('user', 'user');
  $field_options = array();
  foreach ($user_fields as $field_name => $field_data) {
    $field_options[$field_name] = $field_data['label'];
  }

  $form['user_content_type_title'] = array(
    '#type' => 'select',
    '#title' => t('Data for title field'),
    '#options' => array('username' => t('Username'), 'title_builder' => t('Title builder')),
    '#default_value' => variable_get('user_content_type_title', 'username'),
    '#description' => t("What data shell be used as content title?"),
    '#required' => TRUE,
  );

  $form['user_content_type_title_builder'] = array(
    '#type' => 'fieldset',
    '#title' => t('Title builder'),
    '#description' => t('Build your preferred title here. (The fields are separated with spaces)'),
    '#states' => array(
      'visible' => array(
        ':input[name="user_content_type_title"]' => array('value' => 'title_builder'),
      ),
    ),
  );

  // Add fields for the title builder.
  for ($i = 1; $i <= 3; $i++) {
    $form['user_content_type_title_builder']['user_content_type_title_field_' . $i] = array(
      '#type' => 'select',
      '#title' => t('Field @fieldindex data', array('@fieldindex' => $i)),
      '#options' => $field_options,
      '#default_value' => variable_get('user_content_type_title_field_' . $i, ''),
      '#empty_option' => t('- No data -'),
    );
  }

  $form['user_content_type_body'] = array(
    '#type' => 'select',
    '#title' => t('Data for body field'),
    '#options' => $field_options,
    '#default_value' => variable_get('user_content_type_body', ''),
    '#empty_option' => '- No body field required -',
    '#description' => t('Insert any field-data additionally as a body-field.'),
  );

  $contenttypes = node_type_get_names();
  $form['user_content_type_operations'] = array(
    '#type' => 'fieldset',
    '#title' => t('Additional operations'),
  );

  $form['user_content_type_operations']['user_content_type_build_content'] = array(
    '#type' => 'submit',
    '#value' => ((!isset($contenttypes['user_node'])) ? t('Build user content') : t('Rebuild user content manually')),
    '#submit' => array('_user_content_type_build_all'),
  );

  // Content type exists, give the possibility to delete it.
  if (isset($contenttypes['user_node'])) {
    $form['user_content_type_operations']['user_content_type_delete_content'] = array(
      '#type' => 'submit',
      '#value' => t('Delete user content'),
      '#submit' => array('_user_content_type_delete_all'),
    );
  }

  $form['user_content_type_disable_hooks'] = array(
    '#type' => 'checkbox',
    '#title' => t('Disable Hooks'),
    '#description' => t("WARNING: This options disables all the content-update-hooks. Check this box, if you only want to rebuild the user-content manually."),
    '#default_value' => variable_get('user_content_type_disable_hooks', 0),
  );

  return system_settings_form($form);
}
