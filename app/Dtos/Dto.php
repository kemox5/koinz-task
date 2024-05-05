<?php

namespace App\Dtos;

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

