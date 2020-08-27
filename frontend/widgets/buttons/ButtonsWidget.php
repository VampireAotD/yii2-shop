<?php

namespace frontend\widgets\buttons;

use yii\jui\Widget;

class ButtonsWidget extends Widget
{
    public $id;

    public function run()
    {
        if ($id = $this->id) {
            return $this->render('block', compact('id'));
        }
    }
}