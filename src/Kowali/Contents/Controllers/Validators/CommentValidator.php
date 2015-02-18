<?php namespace Kowali\Contents\Controllers\Validators;

class CommentValidator extends Validator {

    protected $rules = [
        'content'           => 'required|min:3',
        'user_id'           => 'required',
        'commentable_type'  => 'required',
        'commentable_id'    => 'required',
    ];

}


