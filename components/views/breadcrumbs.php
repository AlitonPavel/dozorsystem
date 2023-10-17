<?php
    /** @var array $links */
    use yii\helpers\Url;
    /** @var \app\components\BaseView $this */
    $this->registerCssFile('@web/css/components/breadcrumbs.css');
?>
<div class="breadcrumbs">
    <ul class="breadcrumbs_ul">
        <?php foreach ($links as $key => $link) {
            $url = [isset($link['url']) ? $link['url'] : ''];
            if (isset($link['params']))
            {
                $url = array_merge($url, $link['params']);
            }

            ?>
            <li><a href="<?= Url::to($url) ?>"><?= $key ?></a></li>
        <?php } ?>
        <?= $this->getClearFix(); ?>
    </ul>
</div>

