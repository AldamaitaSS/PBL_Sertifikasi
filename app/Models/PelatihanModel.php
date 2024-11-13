<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelatihanModel extends Model
{
    protected $table = 'm_pelatihan';
    protected $primaryKey = 'pelatihan_id';
    protected $fillable = [
        'nama_pelatihan',
        'deskripsi',
        'tanggal',
        'bidang_id',
        'level_pelatihan_id',
        'vendor_id'
    ];

    public function level()
{
    return $this->belongsTo(LevelPelatihanModel::class, 'level_pelatihan_id');
}

}
