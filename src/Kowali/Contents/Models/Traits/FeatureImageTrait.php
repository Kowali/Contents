<?php namespace Kowali\Contents\Models\Traits;

use Hpkns\Picturesque\Picture;

trait FeatureImageTrait {

    public function featureImages()
    {
        return $this->metas()->whereIn('key', ['poster','feature']);
    }

    public function getFeatureImageAttribute()
    {
        $image = $this->featureImages->first();

        if( ! is_null($image))
        {
            return new Picture($image->value);
        }

        if(isset($this->defaultFeatureImage))
        {
            return new Picture($this->defaultFeatureImage);
        }
    }

    public function getPosterAttribute()
    {
        return $this->getFeatureImageAttribute();
    }
}
