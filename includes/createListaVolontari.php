
<?php
function createListaVolontari($db, $profilo, $k) {
  $volontari = $db->getVolontari($_GET['id']);
  $result = '';
  foreach ($volontari as $volontario) {
    $v = file_get_contents("includes/volontario.html");
    $v = str_replace("<volontario />", $volontario["nome"], $v);
    $v = str_replace("<linkProfilo />", $profilo . $volontario["id"], $v);
    $v = str_replace("<img_path />", $volontario["img_path"], $v);
    $v = str_replace('<tabIndex />', $k, $v);
    $result .= $v;
    $k += 1;
  }
  $blob['k'] = $k;
  $blob['html'] = $result;

  return $blob;

}
?>
