<?php

namespace app\components;

use app\controllers\SiteController;
use Yii;

class MenuController
{
    public static function getMenu()
    {
        $user = Yii::$app->user->identity;

        if (Yii::$app->user->isGuest)
        {
            return [
                ['name' => 'Главная', 'url' => 'site/index', 'childs' => [
                    ['name' => 'Вход', 'url' => 'site/login'],
                ]],
            ];
        }

        return [
            ['name' => 'Главная', 'url' => 'site/index', 'childs' => [
                ['name' => 'Админка', 'url' => 'admin/admin', 'visible' => Yii::$app->user->can('admin'), 'classes' => ['components_topmenu_red']],
                Yii::$app->user->isGuest ?
                    ['name' => 'Вход', 'url' => 'site/login'] :
                    ['name' => 'Выход (' . $user->getFIO() . ')' , 'url' => 'site/logout'],
            ]],
            ['name' => 'Реестры', 'url' => '', 'childs' => [
                ['name' => 'Объекты', 'url' => '/object'],
                ['name' => 'Заявки', 'url' => '/demand'],
                ['name' => 'Сметы', 'url' => '/costcalc']
            ]],
            ['name' => 'Справочники', 'url' => 'site/about', 'childs' => [
                ['name' => 'Адрес ФИАС', 'url' => '/fias'],
                ['name' => 'Клиенты', 'url' => '/client'],
                ['name' => 'Банки', 'url' => '/bank'],
                ['name' => 'Типы заявок', 'url' => '/demandtype'],
                ['name' => 'Приоритеты заявок', 'url' => '/demandprior'],
                ['name' => 'Оборудование', 'url' => '/equip'],
            ]],
            ['name' => 'Поддрежка', 'url' => 'site/about', 'childs' => [
                ['name' => 'О программе', 'url' => 'site/about'],
                ['name' => SiteController::PAGE_TITLE_CHANGE, 'url' => 'site/change'],
            ]],
        ];
    }

    public static function getMenuHtmlForIndex()
    {
        return self::getMenuHtml(self::getMenu());
    }

    protected static function getMenuHtml($tree)
    {
        $str = '';
        foreach ($tree as $item) {
            $visible = isset($item['visible']) ? $item['visible'] : true;
            if ($visible) {
                $str .= self::itemToTemplate($item);
            }
        }
        return $str;
    }

    protected static function itemToTemplate($item)
    {
        ob_start();
        include __DIR__ . '/views/menuitem.php';
        return ob_get_clean();
    }
}