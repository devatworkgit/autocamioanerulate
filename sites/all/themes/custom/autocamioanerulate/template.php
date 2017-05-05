<?php
/**
 * @file
 * The primary PHP file for this theme.
 */

/**
 * Pre-processes variables for the "page" theme hook.
 *
 * See template for list of available variables.
 *
 * @see page.tpl.php
 *
 * @ingroup theme_preprocess
 */
function autocamioanerulate_preprocess_page(&$variables) {
  // Add information about the number of sidebars.
  if (!empty($variables['page']['sidebar_first']) && !empty($variables['page']['sidebar_second'])) {
    $variables['content_column_class'] = ' class="col-sm-40 col-md-60 col-lg-60 col-mg-72"';
  }
  elseif (!empty($variables['page']['sidebar_first']) || !empty($variables['page']['sidebar_second'])) {
    $variables['content_column_class'] = ' class="col-sm-80 col-md-90 col-lg-90 col-mg-96"';
  }
  else {
    $variables['content_column_class'] = ' class="col-xs-120"';
  }

  if (bootstrap_setting('fluid_container') == 1) {
    $variables['container_class'] = 'container-fluid';
  }
  else {
    $variables['container_class'] = 'container';
  }

  // Primary nav.
  $variables['primary_nav'] = FALSE;
  if ($variables['main_menu']) {
    // Build links.
    $variables['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
    // Provide default theme wrapper function.
    $variables['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }

  // Secondary nav.
  $variables['secondary_nav'] = FALSE;
  if ($variables['secondary_menu']) {
    // Build links.
    $variables['secondary_nav'] = menu_tree(variable_get('menu_secondary_links_source', 'user-menu'));
    // Provide default theme wrapper function.
    $variables['secondary_nav']['#theme_wrappers'] = array('menu_tree__secondary');
  }

  $variables['navbar_classes_array'] = array('navbar');

  if (bootstrap_setting('navbar_position') !== '') {
    $variables['navbar_classes_array'][] = 'navbar-' . bootstrap_setting('navbar_position');
  }
  elseif (bootstrap_setting('fluid_container') == 1) {
    $variables['navbar_classes_array'][] = 'container-fluid';
  }
  if (bootstrap_setting('navbar_inverse')) {
    $variables['navbar_classes_array'][] = 'navbar-inverse';
  }
  else {
    $variables['navbar_classes_array'][] = 'navbar-default';
  }
  
  //Title mark
  if (isset($variables['node']) && $variables['node']->type == 'autocamion') {
    $node = node_view($variables['node']);
    $variables['title_prefix'] = $node['field_marca'];
    $variables['title_suffix'][] = $node['flag_like'];
    $variables['title_suffix'][] = $node['flag_compara'];
  }
  
  if (drupal_is_front_page() || arg(0) == 'autocamioane') {
    $favorite = "";
    $compara = "";
    if (arg(1) == 'favorite') { 
      $favorite = "active";
    } elseif (arg(1) == 'comparare') {
      $compara = "active";
    }
    $variables['accessibility'] = '<div class="autocamioane-btns">
      <div class="favorite"><a class="btn btn-favorite ' . $favorite . '" href="/autocamioane/favorite">Favorite</a></div>
      <div class="compara"><a class="btn btn-compara ' . $compara . '" href="/autocamioane/comparare">Compară</a></div>
    </div>';
  }
  
  if(isset($variables['node'])) {
    $block = _block_get_renderable_array(_block_render_blocks(array(block_load('text_resize', 0))));
    $variables['accessibility']['text_resize'] = $block;
    $block = _block_get_renderable_array(_block_render_blocks(array(block_load('sharethis', 'sharethis_block'))));
    $variables['accessibility']['sharethis'] = $block;
    if($variables['node']->type == 'autocamion') {
      $variables['accessibility']['print'] = array(
        'print_pdf_block' => array(
          '#markup' => '<section id="block-print-pdf-block" class="block block-print-pdf-block pull-right clearfix">
            <a title="Print PDF" class="print-node print-pdf" href="/printpdf/' . $variables['node']->nid . '"></a>
          </section>',
        ),
        /* 'print_block' => array(
          '#markup' => '<section id="block-print-block" class="block block-print-block pull-right clearfix">
            <a title="Print" class="print-node print" href="/print/' . $variables['node']->nid . '"></a>
          </section>',
        ), */
      );
    }
  }
}

/**
 * Pre-processes variables for the "node" theme hook.
 *
 * See template for list of available variables.
 *
 * @see page.tpl.php
 *
 * @ingroup theme_preprocess
 */
function autocamioanerulate_preprocess_node(&$variables) {
  if (isset($variables['node']) && $variables['node']->type == 'autocamion') {
    $block = _block_get_renderable_array(_block_render_blocks(array(block_load('webform', 'client-block-4'))));
    $variables['form'] = $block;
  }
}

/**
 * Implements theme_form_alter().
 */
function autocamioanerulate_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'simplenews_block_form_39') {
    $form['submit']['#value'] = t('❯');
  }
}

/**
 * Implements hook_preprocess_HOOK().
 */
function autocamioanerulate_preprocess_print(&$variables) {
  $node = $variables['node'];
  node_build_content($node, '');
  $variables['content'] = $node->content;
}