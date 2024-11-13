<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelPelatihanModel extends Model
{
    protected $table = 'm_level_pelatihan';
    protected $primaryKey = 'level_pelatihan_id';
    protected $fillable = [
        'level_pelatihan_kode',
        'level_pelatihan_nama',
    ];
}
