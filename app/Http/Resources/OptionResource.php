<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Car;

class OptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $CR = $MGP = $odo = $color = $odoMax = $odoMin = $order = $engineVolume = $engineVolumeClass = null;
        
        if($this->options){
            $odo = $this->options->odo;
            $engineVolume = $this->options->engine_volume;
            
            if($engineVolume <= 1.2){
                $engineVolumeClass = Car::ENGINE_VOLUME_MICRO;
            }
            elseif($engineVolume > 1.2 && $this->options->engine_volume <=1.8){
                $engineVolumeClass = Car::ENGINE_VOLUME_SMALL;
            }
            elseif($engineVolume > 1.8 && $this->options->engine_volume <=3.5){
                $engineVolumeClass = Car::ENGINE_VOLUME_MEDIUM;
            }
            elseif($engineVolume > 3.5){
                $engineVolumeClass = Car::ENGINE_VOLUME_LARGE;
            }
        
            $order =  $this->options->odo < 1000 ? 100 : ($this->options->odo < 10000 ? 1000 : 10000);
            $odoMax = floor(($this->options->odo + $order) / $order) * $order;
            $odoMin = floor(($this->options->odo - $order) / $order) * $order;
            $color = $this->options->color;
            $MGP = $this->options->MGP;
            $CR = $this->options->CR;
        }
        
        return [
            'color' => $color,
            'engine_volume' => $engineVolume,
            'engine_volume_class' => $engineVolumeClass,
            'odo' => $odo,
            'odo_max' => $odoMax > 0 ? $odoMax : 0,
            'odo_min' => $odoMin > 0 ? $odoMin : 0,
            'mpg' => $MGP,
            'mpg_min' => $MGP ? $MGP - 5 : 0,
            'mpg_max' => $MGP ? $MGP + 5 : 0,
            'CR' => $CR,
            'manufacturer_id' => $this->manufacturer_id,  
        ];
    }
}
