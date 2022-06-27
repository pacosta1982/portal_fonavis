<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'document_id',
        'category_id',
        'project_type_id',
        'stage_id',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];
    protected $with = ['projectType','category','document'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/assignments/'.$this->getKey());
    }

    public function projectType() {
        return $this->belongsTo('App\Models\ProjectType');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    public function document() {
        return $this->belongsTo('App\Models\Document');
    }
}
