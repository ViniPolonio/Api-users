<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRegister extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'laravel.user_register';    
    
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'cpf',
        'address',
        'password',
        'cellphone',
        'cep',
        'date_birth',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ]; 
    
    protected $dateFormat = 'Y-m-d H:i:s';
}
