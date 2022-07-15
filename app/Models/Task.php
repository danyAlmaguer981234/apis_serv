<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $connection = 'oracle';
    protected $primaryKey = 'po_nbr';
    protected $fillable = [
        "po_nbr"
        ,"po_vend"
        ,"po_ship"
        ,"po_ord_date"
        ,"po_buyer"
      ];

}
