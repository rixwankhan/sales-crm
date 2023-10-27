<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Deal extends Model implements HasMedia
{
    use SoftDeletes, MultiTenantModelTrait, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'deals';

    protected $appends = [
        'attachments',
    ];

    protected $dates = [
        'closing_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'deal_name',
        'contact_name_id',
        'source_id',
        'stage_id',
        'amount',
        'closing_date',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function contact_name()
    {
        return $this->belongsTo(CrmContact::class, 'contact_name_id');
    }

    public function source()
    {
        return $this->belongsTo(DealSource::class, 'source_id');
    }

    public function stage()
    {
        return $this->belongsTo(DealStage::class, 'stage_id');
    }

    public function getClosingDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setClosingDateAttribute($value)
    {
        $this->attributes['closing_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getAttachmentsAttribute()
    {
        return $this->getMedia('attachments');
    }

    public function products()
    {
        return $this->belongsToMany(CrmProduct::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
