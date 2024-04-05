<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'break_time',
        'result_time',
        'date',
        'worker_id',
        'customer_id',
        'necessity',
        'salary'
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function customer()
    {
        return $this->belongsTo(Worker::class);
    }
}
