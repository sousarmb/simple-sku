<?php

namespace framework\interfaces;

interface iRepository
{
    public function getAll();

    public function delete($model);

    public function findBy($pk);

    public function update($model);
}