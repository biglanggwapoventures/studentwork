<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'authors',
        'abtract',
        'adviser_id',
        'area_id',
        'call_number',
        'date_submitted',
        'keywords',
        'pages',
        'year_published',
        'uploaded_file_path'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function adviser()
    {
        return $this->belongsTo(User::class, 'adviser_id');
    }

    public function panel()
    {
        return $this->belongsToMany(User::class, 'project_panel', 'project_id', 'panel_id');
    }
}
