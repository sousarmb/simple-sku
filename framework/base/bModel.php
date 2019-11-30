<?php

namespace framework\base;

use framework\interfaces\iModel;

abstract class bModel implements iModel
{
    protected $unprotect = false;
    protected $table = '';
    protected $columns = [];
    protected $access = [
        'public' => [],
        'protected' => ['pk', 'created_at', 'updated_at'],
    ];

    public function __get($name)
    {
        if (array_key_exists($name, $this->columns)) {
            return $this->columns[$name];
        }
    }

    public function __set($name, $value)
    {
        if ($this->unprotect || array_key_exists($name, $this->access['public'])) {
            $this->columns[$name] = trim($value);
        } else {
            throw new \Exception('Cannot set protected model property');
        }

        return $this;
    }

    public function getPk()
    {
        return $this->columns['pk'];
    }

    public function getCreatedAt()
    {
        return $this->columns['created_at'];
    }

    public function getUpdatedAt()
    {
        return $this->columns['updated_at'];
    }

    public function getModelTable()
    {
        return $this->table;
    }

    public function getModelColumns()
    {
        return array_keys($this->columns);
    }

    public function unprotect($opt = false)
    {
        $this->unprotect = $opt;
    }

}