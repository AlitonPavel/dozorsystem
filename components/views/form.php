<?php
    $this->registerCssFile('@web/css/components/form.css');
    /** @var \app\components\Form $widget */
    /** @var string $content */

    use yii\helpers\Html;
    use app\components\Button;
?>

<form class="form"
      id="<?= $widget->id ?>"
      action="<?= $widget->action ?>"
      method="<?= $widget->method ?>"
      <?= ($widget->enctype ? 'enctype="' . $widget->enctype . '"' : '') ?>
>
    <?php
        if (mb_strtoupper($widget->method) == 'POST') {
            echo Html:: hiddenInput(\Yii:: $app->getRequest()->csrfParam, \Yii:: $app->getRequest()->getCsrfToken(), []);
        }
    ?>
    <?= $content; ?>
    <?php
        if ($widget->button)
        {
            echo Button::widget(['id' => $widget->id . '_save', 'value' => $widget->submitName]);
        }
    ?>
</form>