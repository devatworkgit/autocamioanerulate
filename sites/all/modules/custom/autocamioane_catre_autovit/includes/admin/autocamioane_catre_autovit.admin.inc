<?php

/**
 * Menu callback; Autocamion to autovit tab page.
 */
function autocamioane_catre_autovit_node_tab_page($node) {
  drupal_set_title(t('@title <em>to Autovit or OLX</em>', array('@title' => $node->title)), PASS_THROUGH);
  return drupal_get_form('autocamioane_catre_autovit_form', $node);
}

/**
 * Form callback; Autocamion to autovit tab page form.
 */

function autocamioane_catre_autovit_form($form, &$form_state, $node) {
  $form['autocamioan_catre_autovit'] = array(
    '#type' => 'fieldset',
    '#title' => t('Autovit & OLX settings'),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
    '#tree' => TRUE,
  );
  
  $form_state['node'] = $node;
  
  $form['autocamioan_catre_autovit']['to_autovit'] = array(
    '#type' => 'submit',
    '#value' => t('Post to Autovit'),
    '#submit' => array('autocamion_node_form_post_to_autovit'),
  );
  //$form['#submit'][] = 'sms_newsletter_node_tab_send_form_submit';
  
  return $form;
} 

/**
 * To Autovit callback, post truck to Autovit.
 */
function autocamion_node_form_post_to_autovit($form, &$form_state) {
  $client_id     = variable_get('autocamioane_catre_autovit_client_id', '');
  $client_secret = variable_get('autocamioane_catre_autovit_client_secret', '');
  $username      = variable_get('autocamioane_catre_autovit_username', '');
  $password      = variable_get('autocamioane_catre_autovit_password', '');
  
  $response = autocamioane_catre_autovit_get_token($client_id, $client_secret, $username, $password); 
  $categories = autocamioane_catre_autovit_get_categories($response, $form_state['node']);
  dpm($categories);
  
}