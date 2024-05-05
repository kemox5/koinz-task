<?php

namespace App\Interfaces\Repositories;

interface UserRepositoryInterface{
    public function getById(int $id);
}
