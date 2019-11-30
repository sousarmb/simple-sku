<?php

namespace framework\interfaces;

interface iView
{
    public function setViewData($data);

    public function render();
}