<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userCalidad extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        "usr_alias"
        ,"usr_firstname"
        ,"usr_lastname"
        ,"usr_name"
        ,"usr_title_index"
       

      ];
}
