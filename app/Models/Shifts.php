<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\ShiftType;
use App\Enums\Taxable;
use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
    // The attributes that are mass assignable
    protected $fillable = [
        "date",
        "employee",
        "employer",
        "hours",
        "rate_per_hour",
        "taxable",
        "status",
        "shift_type",
        "paid_at"
    ];

    // Get the attributes that should be cast
    protected function casts(): array
    {
        return [
            "date" => "date:Y-m-d",
            "hours" => "integer",
            "rate_per_hour" => "decimal:2",
            "taxable" => Taxable::class,
            "status" => Status::class,
            "shift_type" => ShiftType::class,
            "paid_at" => "datetime:Y-m-d H:i:s",
        ];
    }
}
