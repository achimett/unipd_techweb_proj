<?php
function createFormErrors($errorList) {
  $result = "<ul class=\"error\">\n";

  foreach ($errorList as $line) {
    $result .= "<li>$line</li>\n";
  }

  return $result . "</ul>\n";
}
?>
