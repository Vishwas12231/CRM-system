<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'status', 'assigned_to', 'notes'];
    public function activities() {
        return $this->hasMany(LeadActivity::class);
    }
    public function assignedUser() {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
