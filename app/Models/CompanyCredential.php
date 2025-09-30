<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class CompanyCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_slug', 'category', 'label', 'username', 'password_encrypted', 'notes'
    ];

    protected $appends = ['password'];

    public function getPasswordAttribute(): string
    {
        try { return Crypt::decryptString($this->password_encrypted); } catch (\Exception $e) { return '[erro]'; }
    }

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password_encrypted'] = Crypt::encryptString($value);
    }
}
