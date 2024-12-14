<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
     // If your table name is not 'admins', specify it explicitly
     protected $table = 'admin'; 

     // List the fillable fields (optional but recommended)
     protected $fillable = [
         'username', 
         'email', 
         'password', 

     ];
 
     // Hidden fields that won't be visible in queries (like password)
     protected $hidden = [
         'password'
     ];
}
