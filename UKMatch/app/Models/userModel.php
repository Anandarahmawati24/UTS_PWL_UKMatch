<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class authenticatable

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = ['username','nama','password','id_level','created_at','update_at',];

    protected $hidden = ['password',]; // jangan ditampilkan saat select

    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash

    /**
     * Relasi ke tabel level
     */
    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'id_level', 'id_level');
    }
      // Menentukan kolom yang digunakan untuk autentikasi
      public function getAuthIdentifierName()
      {
          return 'username'; // Menggunakan kolom username
      }
  
}