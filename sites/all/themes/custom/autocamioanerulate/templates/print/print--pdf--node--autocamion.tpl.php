<?php

/**
 * @file
 * Default theme implementation to display a printer-friendly version page.
 *
 * This file is akin to Drupal's page.tpl.php template. The contents being
 * displayed are all included in the $content variable, while the rest of the
 * template focuses on positioning and theming the other page elements.
 *
 * All the variables available in the page.tpl.php template should also be
 * available in this template. In addition to those, the following variables
 * defined by the print module(s) are available:
 *
 * Arguments to the theme call:
 * - $node: The node object. For node content, this is a normal node object.
 *   For system-generated pages, this contains usually only the title, path
 *   and content elements.
 * - $format: The output format being used ('html' for the Web version, 'mail'
 *   for the send by email, 'pdf' for the PDF version, etc.).
 * - $expand_css: TRUE if the CSS used in the file should be provided as text
 *   instead of a list of @include directives.
 * - $message: The message included in the send by email version with the
 *   text provided by the sender of the email.
 *
 * Variables created in the preprocess stage:
 * - $print_logo: the image tag with the configured logo image.
 * - $content: the rendered HTML of the node content.
 * - $scripts: the HTML used to include the JavaScript files in the page head.
 * - $footer_scripts: the HTML  to include the JavaScript files in the page
 *   footer.
 * - $sourceurl_enabled: TRUE if the source URL infromation should be
 *   displayed.
 * - $url: absolute URL of the original source page.
 * - $source_url: absolute URL of the original source page, either as an alias
 *   or as a system path, as configured by the user.
 * - $cid: comment ID of the node being displayed.
 * - $print_title: the title of the page.
 * - $head: HTML contents of the head tag, provided by drupal_get_html_head().
 * - $robots_meta: meta tag with the configured robots directives.
 * - $css: the syle tags contaning the list of include directives or the full
 *   text of the files for inline CSS use.
 * - $sendtoprinter: depending on configuration, this is the script tag
 *   including the JavaScript to send the page to the printer and to close the
 *   window afterwards.
 *
 * print[--format][--node--content-type[--nodeid]].tpl.php
 *
 * The following suggestions can be used:
 * 1. print--format--node--content-type--nodeid.tpl.php
 * 2. print--format--node--content-type.tpl.php
 * 3. print--format.tpl.php
 * 4. print--node--content-type--nodeid.tpl.php
 * 5. print--node--content-type.tpl.php
 * 6. print.tpl.php
 *
 * Where format is the ouput format being used, content-type is the node's
 * content type and nodeid is the node's identifier (nid).
 *
 * @see print_preprocess_print()
 * @see theme_print_published
 * @see theme_print_breadcrumb
 * @see theme_print_footer
 * @see theme_print_sourceurl
 * @see theme_print_url_list
 * @see page.tpl.php
 * @ingroup print
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>">
  <head>
    <?php print $head; ?>
    <base href='<?php print $url ?>' />
    <title></title>
    <?php print $scripts; ?>
    <?php if (isset($sendtoprinter)) print $sendtoprinter; ?>
    <?php print $robots_meta; ?>
    <?php if (theme_get_setting('toggle_favicon')): ?>
      <link rel='shortcut icon' href='<?php print theme_get_setting('favicon') ?>' type='image/x-icon' />
    <?php endif; ?>
    <?php print $css; ?>
  </head>
  <body>
    <div class="container">
      <?php if (!empty($message)): ?>
        <div class="print-message"><?php print $message; ?></div><p />
      <?php endif; ?>
      <?php if ($print_logo): ?>
        <div class="print-logo"><?php print $print_logo; ?></div>
      <?php endif; ?>
      <hr class="print-hr" />
      <?php //if (!isset($node->type)): ?>
        <?php print render($content['field_marca']); ?>
        <h1 class="print-title page-header"><?php print $print_title; ?></h1>
      <?php //endif; ?>
      <div class="print-content print-content-pdf">
        <div style="float: left; width: 263px;"><?php print render($content['field_images']); ?></div>
        <div class="group-contact" style="float: right; width: 370px;">
          <div class="top">
            <div class="field field-name-field-telefon field-type-phone field-label-hidden">
              <div class="field-items">
                <div class="field-item even">
                  +40726.386.194
                </div>
              </div>
            </div>
            <?php
              print render($content['field_locatie_vehicul']);
            ?>
          </div>
        </div>
        <div style="float: right; width: 370px;">
          <div class="group-price-pdf">
            <?php
              $tva = round(intval($content['field_pret_autovehicul']['#items'][0]['value'])/100 * 19);
              $pret_cu_tva = intval($content['field_pret_autovehicul']['#items'][0]['value']) + $tva;
              $formated_tva = number_format($tva, 0, '', '.');
              $formated_pret_cu_tva = number_format($pret_cu_tva, 0, '', '.');
            ?>  
            <div class="field field-name-field-pret-total-cu-tva field-type-number-decimal field-label-inline clearfix">
              <div class="field-label">Preţ autovehicul cu TVA:&nbsp;</div>
              <div class="field-items">
                <div class="field-item even">
                  <?php print $formated_pret_cu_tva; ?> €
                </div>
              </div>
            </div>
            <div class="field field-name-field-20-tva field-type-number-decimal field-label-inline clearfix">
              <div class="field-label">19% TVA:&nbsp;</div>
              <div class="field-items">
                <div class="field-item even">
                  <?php print $formated_tva; ?> €
                </div>
              </div>
            </div>
            <?php  
              print render($content['field_pret_autovehicul']);
            ?>
          </div>
        </div>
        <div style="float: left; width: 263px;"><?php print render($content['body']); ?></div>
        <?php hide($content['body']); ?>
        <?php hide($content['field_telefon']); ?>
        <?php hide($content['field_locatie_vehicul']); ?>
        <?php hide($content['field_persoana_de_contact']); ?>
        <?php hide($content['field_pozitie']); ?>
        <?php hide($content['field_pret_autovehicul']); ?>
        <?php hide($content['field_20_tva']); ?>
        <?php hide($content['field_pret_total_cu_tva']); ?>
        <div style="float: right; width: 370px;"><p>&nbsp;</p><?php print render($content); ?></div>
      </div>
      <div class="print-footer"><?php print theme('print_footer'); ?></div>
      <hr class="print-hr" />
      <?php if ($sourceurl_enabled): ?>
        <div class="print-source_url">
          <?php print theme('print_sourceurl', array('url' => $source_url, 'node' => $node, 'cid' => $cid)); ?>
        </div>
      <?php endif; ?>
      <div class="print-links"><?php print theme('print_url_list'); ?></div>
      <?php print $footer_scripts; ?>
    </div>
  </body>
</html>
