<?php namespace Kowali\Contents\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    protected $userModel     = 'User';
    protected $contentModel  = 'Kowali\Contents\Models\Content';
    protected $termModel     = 'Kowali\Contents\Models\Term';
    protected $taxonomyModel = 'Kowali\Contents\Models\Taxonomy';

    public function getUserModel()
    {
        return $this->userModel;
    }
}
