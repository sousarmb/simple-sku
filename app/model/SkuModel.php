<?php

namespace app\model;

use framework\base\bModel;

class SkuModel extends bModel
{
    public function __construct($unprotect = false)
    {
        $this->unprotect = $unprotect;
        $this->table = 'tbl_sku';
        $this->columns = [
            'sku' => '',
            'description' => '',
            'pk' => '',
            'created_at' => '',
            'updated_at' => '',
        ];
        $this->access['public'] = ['sku', 'description'];
        $this->columns['created_at'] = date('Y-m-d H:i:s');
    }

    public function getSku()
    {
        return $this->columns['sku'];
    }

    public function setSku($string = '')
    {
        $this->columns['sku'] = trim($string);
        return $this;
    }

    public function getDescription()
    {
        return $this->columns['description'];
    }

    public function setDescription($string = '')
    {
        $this->columns['description'] = trim($string);
        return $this;
    }
}