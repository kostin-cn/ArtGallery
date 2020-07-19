<?php
$current = str_split($item);
foreach ($current as $key=>$char) {
    $char = bin2hex($char);
    $current[$key] = 255 - hexdec($char);
}
$item = json_encode($current);
?>
<a class="hidden-ml" data-ml="<?= $item;?>" href="#">hidden</a>