<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Classes\CodeGenerator;

class Url extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'user_id'
    ];

    public $timestamps = false;

    public function user () 
    {
       return $this->belongsTo('App\Models\User');
    }

    public function short_url($long_url)
    {
        // crear la URL
        $url = self::create([
            'url' => $long_url,
            'user_id' => auth()->user()->id
        ]);

        // generacion de codigo
        $code = (new CodeGenerator())->get_code($url->id);

        //actualizar el codigo en la $url
        $url->code = $code;
        $url->save();

        return $url->code;
    }
}
