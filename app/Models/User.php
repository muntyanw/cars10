<?php

namespace App;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;

/**

 * 
 * 
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $id
 * @property string $photo
 *  */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'geo_data' => 'array',
    ];
    
    
    public function getResizedImage(){
        if($this->photo){
            $tmpPath = getcwd() . '/images/uploads/users/' . $this->photo;
            $savePath = getcwd() . '/images/uploads/users/50x50_' . $this->photo;

            if($this->photo && is_file($tmpPath) && !is_file($savePath)){
                $img = Image::make($tmpPath)->resize(50,50);
                $img->save($savePath);
            }

            return  '/images/uploads/users/50x50_' . $this->photo;
        }
        
        return null;
    }
    
    public function geodata(){    
        return $this->hasOne(GeoData::class,'user_id');
    }
    
}
