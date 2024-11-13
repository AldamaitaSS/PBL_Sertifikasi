<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSertifikasiModel extends Model
{
    protected $table = 'm_jenis_sertifikasi';
    protected $primaryKey = 'jenis_id';
    protected $fillable = [
        'jenis_kode',
        'jenis_nama',
    ];
}
