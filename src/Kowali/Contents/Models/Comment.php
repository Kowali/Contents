<?php namespace Kowali\Contents\Models;

class Comment extends \Eloquent {

    use Traits\CreatedTimeTrait;

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
	protected $fillable = ['commentable_type', 'commentable_id', 'content', 'user_id'];

    /**
     * Return the author of the comment.
     *
     * @return void
     */
    public function author()
    {
        return $this->belongsTo($this->getUserModel(), 'user_id');
    }

    /**
     * Return the parent of the comment.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function parent()
    {
        return $this->belongTo($this->getModel());
    }

    /**
     * Return the childrens of the comment.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function children()
    {
        return $this->hasMany($this->getModel());
    }
}
