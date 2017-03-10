<?php
/**
 * @file
 * CCK Field for Romanian phone numbers.
 */

define('PHONE_RO_REGEX', '/(\+40|0)([1-9](\d{8}|\d{9}))$/');

function phone_ro_metadata() {
  // These strings are translated using t() on output.
  return array(
    'label' => 'Phone Numbers - Romania',
    'error' => '"%value" is not a valid Romanian phone number<br>Romanian phone numbers should only contain numbers and spaces and be like 99 99 99 99 99',
  );
}

/**
 * Verification for Romanian Phone Numbers.
 *
 * @param string $phonenumber
 * @return boolean Returns boolean FALSE if the phone number is not valid.
 */
function valid_ro_phone_number($phonenumber) {

  //$phonenumber = trim($phonenumber);

  $phonenumber  = str_replace(array(' ','.','-','(',')'), '', $phonenumber);
  return (bool) preg_match(PHONE_RO_REGEX, $phonenumber);
}

/**
 * Formatting for Romanian Phone Numbers.
 *
 * @param string $phonenumber
 * @return string Returns a string containting the phone number with some formatting.
 */
function format_ro_phone_number($phonenumber, $field = FALSE) {
  $phone  = str_replace(array(' ','-','(',')'), '', $phonenumber);
  if (preg_match(PHONE_RO_REGEX, $phone, $matches) != 1) {
    return $phonenumber; // not a french phone number
  }

  return ($field && $field['phone_country_code'] ? '+40 ' : '0') . $matches[2];
}
