<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'body', 'vehicle_id', 'injured_count', 'happened_at'];

    protected $with = ['user'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['created_date', 'body_html'];

    public function user() {
      return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value){
      $this->attributes['title'] = $value;
      $this->attributes['slug'] = \Str::slug($value);
    }

    public function getUrlAttribute() {
      return route("reports.show", $this->slug);
    }

    public function getCreatedDateAttribute() {
      return $this->created_at->diffForHumans();
    }


    public function getBodyHtmlAttribute()
    {
        return clean($this->bodyHtml());
    }

    public function reports(){
        return $this->hasMany(Report::class);
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    public function excerpt($length)
    {
        return \Str::limit(strip_tags($this->bodyHtml()), $length);
    }

    private function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }

}
