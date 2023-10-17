<?php


namespace app\components;

use app\models\CostCalc;
use app\models\CostCalcEquip;
use app\models\CostCalcWork;

class CostCalcRender
{
    /** @var int */
    protected $calc_id;
    /** @var CostCalc */
    protected $calc;
    /** @var CostCalcEquip[] */
    protected $equips = [];
    /** @var CostCalcWork[] */
    protected $works = [];

    public function __construct(int $calc_id)
    {
        $this->calc = CostCalc::findOne($calc_id);

        if (!$this->calc)
        {
            throw new \Exception("Не удалось найти смету");
        }
    }

    /**
     * подготовка перед рендером
     */
    protected function selectFor_renderClient()
    {
        // получаем оборудование по смете
        $this->equips = $this->calc->costCalcEquips;
        // получаем работы по смете
        $this->works = $this->calc->costCalcWorks;
    }

    protected function renderEquips()
    {
        include 'views/costcalcequips.phtml';
    }

    protected function renderWorks()
    {
        include 'views/costcalcworks.phtml';
    }

    protected function renderRow(array $item)
    {
        include 'views/costcalcrow.phtml';
    }

    public function renderClient()
    {
        $this->selectFor_renderClient();

        include "views/costcalc.phtml";
    }
}