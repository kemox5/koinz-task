<?php

namespace App\Http\Dtos;

use Illuminate\Http\Request;

class Dto {
    public function toArray(){
        $vars = get_class_vars($this::class);
        $arr = [];

        foreach($vars as $key => $var){
            $arr[$key] = $this->$key;
        }

        return $arr;
    }
}

