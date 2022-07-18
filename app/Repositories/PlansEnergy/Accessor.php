<?php
namespace App\Repositories\PlansEnergy;

trait Accessor
{
    public function getIdAttribute($value){
        return encryptGdprData($value);
    }

}
