<?php
/**
 * @var integer $value
 * @var string $name
 * @var bool $checked
 * @var string $label
 */
?>

<div class="checkbox">
    <input type="checkbox" class="filter_checkbox" id="material-<?= $value ?>" name="<?= $name; ?>"
           value="<?= $value ?>" <?= ($checked) ? "checked" : ""; ?>>
    <label class="filter_label check" for="material-<?= $value ?>">
        <span class="filter_point"></span>
        <span class="filter_point_text"><?= $label; ?></span>
    </label>
</div>