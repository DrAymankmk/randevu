<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Traits\HasMediaRetrieval;

class CmsSection extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasMediaRetrieval;

    protected $table = 'cms_sections';

    protected $fillable = [
        'cms_page_id',
        'name',
        'type',
        'template',
        'settings',
        'order',
        'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the page that owns the section
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(CmsPage::class, 'cms_page_id');
    }

    /**
     * Get all translations for the section
     */
    public function translations(): HasMany
    {
        return $this->hasMany(CmsSectionTranslation::class, 'cms_section_id');
    }

    /**
     * Get all items for the section
     */
    public function items(): HasMany
    {
        return $this->hasMany(CmsItem::class, 'cms_section_id');
    }

    /**
     * Get all links for the section (polymorphic)
     */
    public function links()
    {
        return $this->morphMany(CmsLink::class, 'linkable');
    }

    /**
     * Get translation for a specific locale
     */
    public function translation(string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations()->where('locale', $locale)->first();
    }

    /**
     * Get translated attribute with fallback
     */
    public function getTranslatedAttribute(string $attribute, string $locale = null, string $fallbackLocale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $fallbackLocale = $fallbackLocale ?? config('app.fallback_locale', 'en');

        $translation = $this->translation($locale);
        
        if ($translation && !empty($translation->$attribute)) {
            return $translation->$attribute;
        }

        if ($locale !== $fallbackLocale) {
            $fallbackTranslation = $this->translation($fallbackLocale);
            if ($fallbackTranslation && !empty($fallbackTranslation->$attribute)) {
                return $fallbackTranslation->$attribute;
            }
        }

        return null;
    }

    /**
     * Scope to get only active sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by the order column
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Register media collections for sections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
            ->singleFile();

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    /**
     * Register media conversions for sections
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->performOnCollections('images', 'gallery');

        $this->addMediaConversion('preview')
            ->width(800)
            ->height(600)
            ->performOnCollections('images', 'gallery');
    }
}
