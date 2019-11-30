<?php

namespace framework\interfaces;

interface iModel
{
    public function getPk();

    public function getCreatedAt();

    public function getUpdatedAt();

    public function getModelTable();

    public function getModelColumns();
}