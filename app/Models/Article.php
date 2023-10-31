<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewArticleCreated;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'approver_id',
        'title',
        'brief',
        'content',
        'status',
        'published_at'
    ];

    public static function boot() {
        parent::boot();

        /**
         * after creating record
         *
         * @return response()
         */
        static::created(function($item) {
            $admins = User::role('Super Admin')->get();

            Mail::to($admins)->send(new NewArticleCreated());
        });
    }

    /**
     * Get image.
     */
    public function getImageAttribute()
    {
        return $this->attributes['image'] = asset('uploads/images/original') . '/' . $this->file->file;
    }

    /**
     * Get Thumbnail.
     */
    public function getImageThumbAttribute()
    {
        return $this->attributes['image'] = asset('uploads/images/thumbnail') . '/' . $this->file->file;
    }

    /**
     * Get file of article
     */
    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    /**
     * Get Status HTML.
     */
    public function getStatusHtmlAttribute()
    {
        if($this->status === 'PENDING_APPROVAL'){
            return "<span class='badge bg-info text-dark'>PENDING</span>";
        }

        return "<span class='badge bg-success'>Published</span>";
    }

    /**
     * Get the user that owns the article.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the admin user that approved the article.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    /**
     * The has Many Relationship
     *
     * @var array
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    /**
     * Scope a query to only include published articles.
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('status', 'PUBLISHED');
    }

    /**
     * Scope a query to only include articles of a given user.
     */
    public function scopeOwnedBy(Builder $query, string $author_id): void
    {
        $query->where('author_id', $author_id);
    }

     /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'brief' => $this->brief,
            'content' => $this->content
        ];
    }
}
