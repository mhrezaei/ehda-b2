<?php

namespace App\Http\Requests\Front;

use App\Models\Comment;
use App\Models\Post;
use App\Providers\CommentServiceProvider;
use App\Providers\ValidationServiceProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (user()) {
            return true;
        }
        $data = $this->all();
        $post = Comment::find($data['post_id']);
        return $post->allow_anonymous_comment;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $postRules = CommentServiceProvider::getPostCommentRules($this->post_id);
        dd($postRules);

        return [
            'post_id' => 'required|exists:',
            'text' => 'required|persian:60',
        ];
    }

    public function all()
    {
        $value = parent::all();
        $purified = ValidationServiceProvider::purifier($value, [
            'text' => 'pd',
        ]);
        return $purified;

    }

}
