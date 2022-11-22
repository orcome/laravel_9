<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sister extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'creator_id'];

    public function getTitleLinkAttribute()
    {
        return link_to_route('sisters.show', $this->title, [$this], [
            'title' => __(
                'app.show_detail_title',
                ['title' => $this->title, 'type' => __('sister.sister')]
            ),
        ]);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
