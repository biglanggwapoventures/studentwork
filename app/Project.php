<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    const VIEWABLE_NUMBER_OF_PAGES = 5;

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


    public function getPreviewsFilePath()
    {
        $files = [];

        foreach (range(1,5) as $page) {
            $filePath = Str::replaceLast('.pdf', "-page-{$page}.jpg", $this->uploaded_file_path);
            if(Storage::disk('public')->exists($filePath)) {
                $files[] = asset("storage/{$filePath}");
            }
        }
        
        return $files;
    }
    
}
