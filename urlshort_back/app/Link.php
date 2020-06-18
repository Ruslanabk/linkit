<?php
    namespace App;
    use Illuminate\Database\Eloquent\Model;

    class Link extends Model
    {
       //
       protected $table = 'links';
       protected $fillable = ['route','url','user_id','description'];
    }