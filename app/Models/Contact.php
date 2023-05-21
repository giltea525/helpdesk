<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    //以下を追記
    protected $guarded = array('id');

    public static $rules = array(
        'contact_day' => 'required',
        'contact_division' => 'required',
        'contact_category' => 'required',
        'contact_case' => 'required',
        'contact_status' => 'required',
    );    
}
