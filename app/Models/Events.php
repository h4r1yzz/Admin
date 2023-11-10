<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Events extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'live_streaming_contest';
    protected $primaryKey = '_id';
    
    protected $fillable = [
        'contest_id',
        'title',
        'title_locale',
        'contest_start_at',
        'contest_end_at',
        'contest_display_start_at',
        'contest_display_end_at',
        'contest_type',   
        'sorting',    
        'is_countdown_required',    
        'auto_enrollment',
        'gifts_bounded',
        'gifts_bounded.*.id',
        'gifts_bounded.*.pricing_id',
        'graphics',
        'graphics.*.type',
        'graphics.*.asset_url',
        'graphics.*.reference',
        'graphics.*.url',  
        'graphics.*.text',
        'graphics.*.targeted_audiences',
        'graphics.*.is_countdown_required',
        'graphics.*.countdown_font_color',
        'graphics.*.title_font_color',
        'graphics.*.cta',
        'graphics.*.tier',
        'graphics.*.template',
        ];
}
