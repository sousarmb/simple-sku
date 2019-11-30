<?php

namespace framework\wrappers;

use \PDO;

class wMySQL extends PDO
{
    public function __construct()
    {
        parent::__construct(DB_DSN, DB_USER, DB_PASS);
        parent::setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        parent::setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
    }

}
