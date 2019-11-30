<?php
return [
    ['GET', '/', app\view\Sku::class, null],
//    ['GET', '/', app\controller\Sku::class, 'indexExampleFromFactory'],
//    ['GET', '/', app\controller\Sku::class, 'indexExampleNew'],
    ['GET', '/sku/list(\?page=\d+)?', app\controller\Sku::class, 'getAll'],
    ['GET', '/sku/edit', app\controller\Sku::class, 'getOne'],
    ['POST', '/sku/create', app\controller\Sku::class, 'create'],
    ['POST', '/sku/edit', app\controller\Sku::class, 'edit'],
];