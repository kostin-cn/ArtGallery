<?php

/* @var $this yii\web\View */
/* @var $contacts \common\entities\Contacts[] */

?>

<div>
    <?php foreach ($contacts as $contact): ; ?>
        <?= $contact->type; ?>
        <?= $contact->value; ?>
    <?php endforeach; ?>
</div>
