<?php

namespace app\components;

abstract class TabController extends BaseController
{
    public $layout = 'tabs';

    public $tabs = [];

    public $tabParams = [];

    protected $params;

    public function addTab($url, $id, $title)
    {
        $this->tabs[] = ['url' => $url, 'id' => $id, 'title' => $title];
    }

    public function setTabs($tabs)
    {
        foreach ($tabs as $tab)
        {
            $this->addTab($tab['url'], $tab['id'], $tab['title']);
        }
    }

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        foreach ($this->tabParams as $paramName)
        {
            $this->params[$paramName] = \Yii::$app->request->get($paramName);
        }
    }
}