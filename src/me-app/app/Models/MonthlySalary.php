<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Worker;

class MonthlySalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'worker_id',
        'year',
        'month',
        'days',
        'salary',
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
