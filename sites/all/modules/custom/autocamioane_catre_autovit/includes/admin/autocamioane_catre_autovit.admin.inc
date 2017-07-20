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
    '#title' => t('Autovit settings'),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
    '#tree' => TRUE,
  );
  
  $form_state['node'] = $node;
  
  $client_id     = variable_get('autocamioane_catre_autovit_client_id', '');
  $client_secret = variable_get('autocamioane_catre_autovit_client_secret', '');
  $username      = variable_get('autocamioane_catre_autovit_username', '');
  $password      = variable_get('autocamioane_catre_autovit_password', '');
  $varible_name = "autovit_post_id_node_" . $node->nid;
  $post_id      = variable_get($varible_name, '');
  $response = autocamioane_catre_autovit_get_token($client_id, $client_secret, $username, $password);
  $post = autocamioane_catre_autovit_get_post($response, $post_id);
  $suffix = array();
  
  if(isset($post['id']) && $post['status'] != "removed_by_user") {
    $to_autovit_disabled = TRUE;
    $suffix = array('#suffix' => '<div><a target="_blank" href="' . $post['url'] . '">' . $post['url'] . '</a></div>');
  } else {
    $to_autovit_disabled = FALSE;
  };
  
  $form['autocamioan_catre_autovit']['to_autovit'] = array(
    '#type' => 'submit',
    '#value' => t('Post to Autovit'),
    '#submit' => array('autocamion_node_form_post_to_autovit'),
    '#disabled' => $to_autovit_disabled,
    '#suffix' => $suffix['#suffix'],
  );
  
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
  $post = autocamioane_catre_autovit_get_categories($response, $form_state['node']);
  
  if (isset($post['error'])) {
    drupal_set_message($post['error']['message'], 'error');
  } else {
    drupal_set_message(t("Successfully published"), 'status');
    
    $varible_name = "autovit_post_id_node_" . $form_state['node']->nid;
    variable_set($varible_name, $post["id"]);
  }
  
}

function autocamioane_catre_autovit_get_post($token_parameters, $post_id) {
  if (isset($post_id) && !empty($post_id)){
    $request       = "https://ssl.autovit.ro/api/open/account/adverts/" . $post_id . "/";
    $ch            = curl_init($request);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
    curl_setopt($ch, CURLOPT_FAILONERROR, false);  
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Accept: application/json',
      'Authorization:' . 'Bearer' . ' ' . $token_parameters['access_token']
    ));
    
    $response = curl_exec($ch);
    $responseData = json_decode($response, TRUE);

    return $responseData;
  }
}