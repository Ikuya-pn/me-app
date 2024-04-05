<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Work;

class Customer extends Model
{
    use HasFactory;

    public function scopeSearchCustomers($query, $input = null)
    {
        if(!empty($input)){
            if(Customer::where('name', 'like', '%' .  $input . '%')
                ->orWhere('phone', 'like', '%' . $input . '%')
                ->orWhere('address', 'like', '%' . $input . '%')
                ->orWhere('memo', 'like', '%' .  $input . '%')
                ->exists())
            {
                return $query->where('name', 'like', '%' .  $input  . '%')
                    ->orWhere('phone', 'like', '%' . $input . '%')
                    ->orWhere('address', 'like', '%' . $input . '%')
                    ->orWhere('memo', 'like', '%' .  $input . '%');
            }
        }
    }

    public function work()
    {
        return $this->hasMany(Work::class);
    }

    protected $fillable = [
        'name',
        'phone',
        'postcode',
        'address',
        'memo',

    ];
}
