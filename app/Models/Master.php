<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'creator_id'];

    public function getTitleLinkAttribute()
    {
        $title = __('app.show_detail_title', [
            'title' => $this->title, 'type' => __('master.master'),
        ]);
        $link = '<a href="'.route('masters.show', $this).'"';
        $link .= ' title="'.$title.'">';
        $link .= $this->title;
        $link .= '</a>';

        return $link;
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
