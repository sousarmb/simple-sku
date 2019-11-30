<?php

namespace app\controller;

use framework\base\bController;
use app\model\repository\SkuRepository;
use app\view\Sku as vSku;
use framework\Factory;

class Sku extends bController
{
    public function __construct(SkuRepository $repository)
    {
        $this->repository = $repository;
    }

    function indexExampleFromFactory()
    {
        return Factory::getInstance(vSku::class);
    }

    function indexExampleNew()
    {
        return new vSku();
    }

    public function getAll()
    {
        $page = 0;
        if (array_key_exists('page', $_GET)) {
            $page = intval($_GET['page']);
        }

        return $this->repository->getAll($page);
    }

    public function create()
    {
        $err = ['err' => []];
        $post = json_decode(file_get_contents("php://input"));
        if (is_null($post)) {
            $err['err'][] = 'body';
            return $err;
        }
        if (!is_string($post->sku) || empty($post->sku)) {
            $err['err'][] = 'sku';
        }
        if (!is_string($post->description) || empty($post->description)) {
            $err['err'][] = 'description';
        }
        if (!empty($err['err'])) {
            return $err;
        }

        $sku = $this->repository->createSku();
        $sku->setSku($post->sku);
        $sku->setDescription($post->description);

        return $err;
    }

    public function edit()
    {
        $err = ['err' => []];
        $post = json_decode(file_get_contents("php://input"));
        if (is_null($post)) {
            $err['err'][] = 'body';
            return $err;
        }
        if (!is_int($post->pk)) {
            $err['err'][] = 'pk';
        }
        if (!is_string($post->sku) || empty($post->sku)) {
            $err['err'][] = 'sku';
        }
        if (!is_string($post->description) || empty($post->description)) {
            $err['err'][] = 'description';
        }
        if (!empty($err['err'])) {
            return $err;
        }

        $sku = $this->repository->findBySku($post->sku);
        if (!is_null($sku)) {
            // duplicate sku, do not proceed
            $err['err'][] = 'duplicate';
        }

        $sku = $this->repository->findBy($post->pk);
        $sku->setSku($post->sku);
        $sku->setDescription($post->description);

        $this->repository->update($sku);

        return $err;
    }
}