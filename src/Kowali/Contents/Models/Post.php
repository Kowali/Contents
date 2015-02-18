<?php namespace Kowali\Contents\Models;

class Post extends Content {

    /**
     * Return the previous item with the same parent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function prev()
    {
        return $this->hasOne('Kowali\Contents\Models\Post', 'content_id', 'content_id')
            ->where('created_at', '<', $this->attributes['created_at'])
            ->orderBy('created_at', 'desc');
    }

    /**
     * Return the next item with the same parent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function next()
    {
        return $this->hasOne('Kowali\Contents\Models\Post', 'content_id', 'content_id')
            ->where('created_at', '>', $this->attributes['created_at'])
            ->orderBy('created_at', 'asc');
    }
}

