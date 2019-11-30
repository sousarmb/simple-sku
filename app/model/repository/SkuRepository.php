<?php

namespace app\model\repository;

use framework\base\bRepository;
use app\model\SkuModel;
use framework\interfaces\iRepository;

class SkuRepository extends bRepository implements iRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll($page = 0, $limit = 10)
    {
        if ($page > 0) {
            $start = $page * $limit;
        } else {
            $start = $page;
        }

        $this->models['store'] = $this->conn
            ->query("SELECT * FROM tbl_sku ORDER BY pk LIMIT $start , $limit")
            ->fetchAll();
        $c = $this->conn
            ->query("SELECT COUNT(1) FROM tbl_sku")
            ->fetchColumn();

        return [$this->models['store'], $page, round($c / $limit, \PHP_ROUND_HALF_UP)];
    }

    public function delete($model)
    {
        if (!($model instanceof SkuModel)) {
            throw new \Exception('Invalid model for repository!');
        }
        $this->models['delete'][] = $model;
    }

    public function findBy($pk)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_sku WHERE pk = ? LIMIT 1");
        $stmt->execute([$pk]);
        $models = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, SkuModel::class, [true]);
        $model = array_pop($models);
        $this->models['store'][] = $model;
        return $model;
    }

    public function findBySku($sku)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_sku WHERE sku = ? LIMIT 1");
        $stmt->execute([$sku]);
        $models = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, SkuModel::class, [true]);
        $model = array_pop($models);
        $this->models['store'][] = $model;
        return $model;
    }

    public function update($model)
    {
        if (!($model instanceof SkuModel)) {
            throw new \Exception('Invalid model for repository!');
        }
        $this->models['update'][] = $model;
    }

    public function createSku()
    {
        $model = new SkuModel();
        $this->models['create'][] = $model;
        return $model;
    }

}