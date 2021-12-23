<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingType extends Model
{
    use HasFactory;

    public const table = 'training_type';
    public const table_as = 'training_type as tt';

    use HasFactory;

    protected $table = 'training_type';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
    ];

    public function academicYears () : HasMany
    {
        return $this->hasMany(AcademicYear::class, 'id_training_type', 'id');
    }

}
