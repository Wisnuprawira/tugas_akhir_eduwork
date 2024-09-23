<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

        // Menentukan bahwa primary key adalah ms_id
    protected $primaryKey = 'ms_id';


    protected $fillable = ['ms_name',"ms_email","ms_password","ms_phone_number","ms_address"];

}
