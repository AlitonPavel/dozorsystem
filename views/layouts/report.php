<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\components\Button;
use app\widgets\Alert;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\components\TopMenu;
use app\components\Breadcrumbs;
use app\components\MenuController;
use yii\helpers\Url;
use app\assets\ReportAsset;

ReportAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/css/images/favicon_DS.png">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php
$user = Yii::$app->user->identity;
?>
<?php $this->beginBody() ?>
<div class="report">
    <div class="report_top">
        <div class="grid">
            <div class="row">
                <?php
                if (Yii::$app->request->referrer)
                {
                    echo '<div class="column">' . Button::widget([
                        'id' => 'btn_back',
                        'value' => 'Назад',
                        'href' => Yii::$app->request->referrer
                    ]) . '</div>';
                }
                ?>
                <div class="column">
                    <?= Button::widget([
                        'id' => 'btn_main',
                        'value' => 'На главную',
                        'href' => Url::to(['/'])
                    ]); ?>
                </div>
                <div class="column">
                    <?= Button::widget([
                        'id' => 'btn_print',
                        'value' => 'Печать',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="report_body">
    <?= $content ?>
</div>

<?php

$js = <<<EOF
        $(document).ready(function() {
            $("#btn_print").on('click', function() {
                print();
            });
        });
EOF;

$this->registerJs($js);

?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>




