<?php
/** @var array $item */
/** @var \app\components\topmenu\TopMenu $this */

use yii\helpers\Url;

?>

<li>
    <a href="<?= Url::to([$item['url']])?>" class="<?= isset($item['classes']) ? implode(' ', $item['classes']) : '' ?>"><?= $item['name'] ?></a>

    <?php if (isset($item['childs'])) { ?>
        <ul>
            <?= $this->getMenuHtml($item['childs']) ?>
        </ul>
    <?php } ?>
</li>
