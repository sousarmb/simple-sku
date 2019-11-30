<?php

namespace framework\base;

use framework\interfaces\iController;
use framework\interfaces\iRepository;

abstract class bController implements iController
{
    public $repository = [];

    public function pre()
    {

    }

    public function post()
    {
        if (!empty($this->repository)) {
            // (lazy) persist any data still in the repository to the db
            if (is_array($this->repository)) {
                foreach ($this->repository as $repository) {
                    if ($repository instanceof iRepository) {
                        $repository->save();
                    }
                }
            } elseif ($this->repository instanceof iRepository) {
                $this->repository->save();
            }
        }
    }
}