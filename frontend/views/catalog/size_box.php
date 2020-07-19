<?php
/**
 * @var integer $value
 * @var string $name
 * @var bool $checked
 * @var string $label
 */
?>

<div class="radio">
    <input type="radio" class="filter_radio"
           id="size-<?= trim(str_replace(' ', '', $value)) ?>" name="<?= $name; ?>"
           value="<?= $value ?>" <?= ($checked) ? "checked" : ""; ?>>
    <label class="filter_label check" for="size-<?= trim(str_replace(' ', '', $value)) ?>">
        <span class="filter_point"></span>
        <span class="filter_point_text"><?= $label; ?></span>
    </label>
</div>