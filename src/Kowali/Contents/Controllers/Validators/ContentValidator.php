<?php namespace Kowali\Contents\Controllers\Validators;

class ContentValidator extends Validator {

    protected $rules = [

        'user_id'       => 'required|exists:users,id',
        '_slug'         => '',
        '_title'        => '',
        '_content'      => '',
        'content_type'  => '',
        'status'        => '',

    ];

}
