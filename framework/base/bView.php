<?php

namespace framework\base;

use framework\interfaces\iView;

abstract class bView implements iView
{
    protected $data;

    public function setViewData($data)
    {
        $this->data = $data;
    }

    public function render()
    {
    }
}