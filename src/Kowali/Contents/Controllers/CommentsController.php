<?php namespace Kowali\Contents\Controllers;

use Input;
use Redirect;
use Kowali\Contents\Models\Comment;
use URL;

class CommentsController extends \Controller {

    /**
     * The validator used to validate comments
     *
     * @param Validators\CommentValidator
     */
    protected $validator;

    /**
     * Initialize the instance
     *
     *User::getId() @param Validator\CommentValidator
     */
    public function __construct(Validators\CommentValidator $validator)
    {
        $this->validator = $validator;
    }

	/**
	 * Store a newly created resource in storage.
	 * POST /comments
	 *User::getId()User::getId()
	 * @return Response
        if(user_can('comment.create'))
        {
	 */
	public function store()
	{
        if($this->validator->validate(Input::all()))
        {
            $comment = Comment::create([
                'commentable_type'  => Input::get('commentable_type'),
                'commentable_id'    => \Input::get('commentable_id'),
                'content'           => \Input::get('content'),
                'user_id'           => \Auth::user()->id,
            ]);

            return Redirect::to(URL::previous() . "#comment-{$comment->id}");
        }
        return Redirect::back()->withErrors($this->validator->errors());
    }

    /**
     * Update the specified resource in storage.
     * PUT /comments/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /comments/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
