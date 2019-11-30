<?php

namespace framework\base;

use framework\wrappers\wMySQL;
use framework\interfaces\iModel;

abstract class bRepository
{
    protected $conn;
    protected $models = [
        'store' => [],
        'create' => [],
        'update' => []
    ];

    public function __construct()
    {
        $this->conn = new wMySQL();
    }

    /**
     * Description of save()
     *
     * Persist the repository models to the database
     *
     */
    public function save()
    {
        if (!empty($this->models['create'])) {
            $this->persistCreated();
        }

        if (!empty($this->models['update'])) {
            $this->persistUpdated();
        }
    }

    private function persistCreated()
    {
        $model = reset($this->models['create']);
        if (!($model instanceof iModel)) {
            throw new \Exception('Repository can only handle implementations of iModel');
        }

        $table = $model->getModelTable();
        // throw away the pk and updated_at columns
        $columns = $model->getModelColumns();
        array_splice($columns, array_search('pk', $columns), 1);
        array_splice($columns, array_search('updated_at', $columns), 1);

        // ... and work with a "fresh" model string
        $placeholders = array_fill(0, count($columns), '?');
        $stmt_columns = implode(',', $columns);
        $placeholders = implode(',', $placeholders);

        $query = "INSERT INTO $table ($stmt_columns) VALUES ($placeholders)";

        $this->conn->beginTransaction();
        $stmt = $this->conn->prepare($query);
        foreach ($this->models['create'] as $model) {
            $values = [];
            foreach ($columns as $column) {
                $values[] = $model->$column;
            }
            $stmt->execute($values);
        }
        $this->conn->commit();
        $this->models['create'] = [];
    }

    private function persistUpdated()
    {
        $model = reset($this->models['update']);
        if (!($model instanceof iModel)) {
            throw new \Exception('Repository can only handle implementations of iModel');
        }

        $table = $model->getModelTable();
        // throw away the pk and updated_at columns
        $columns = $model->getModelColumns();
        array_splice($columns, array_search('pk', $columns), 1);
        array_splice($columns, array_search('created_at', $columns), 1);
        array_splice($columns, array_search('updated_at', $columns), 1);

        // ... and work with a "dirty" model string
        $placeholders = [];
        foreach ($columns as $column) {
            $placeholders[] = "$column = ?";
        }

        $query = "UPDATE $table SET ";
        $query .= implode(',', $placeholders);
        $query .= " WHERE pk = ?";

        $this->conn->beginTransaction();
        $stmt = $this->conn->prepare($query);
        foreach ($this->models['update'] as $model) {
            $values = [];
            foreach ($columns as $column) {
                $values[] = $model->$column;
            }
            $values[] = $model->pk;
            $stmt->execute($values);
        }
        $this->conn->commit();
        $this->models['update'] = [];
    }
}