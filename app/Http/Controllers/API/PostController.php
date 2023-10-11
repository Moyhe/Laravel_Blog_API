<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Post as PostResources;
use App\Http\Controllers\API\BaseController as BaseController;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return $this->sendResponse(PostResources::collection($posts),
         'Posts Retrieved Successfully');
    }


    public function userPosts(Post $posts, $id)
    {

        $errorMessage = [];
        if ($posts->user_id != Auth::id()) {
            return $this->sendError(' you Dont have rights', $errorMessage);
        }
        $posts = Post::where('user_id', $id)->get();
            return $this->sendResponse(PostResources::collection($posts),
             'Posts Retrieved Successfully');



    }


   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [

            'title' => 'required',
            'description' => 'required',



        ]);

        if ($validator->fails()) {
            return $this->sendError(' Validate Error', $validator->errors());

        }

        $user = Auth::user();
        $input['user_id'] = $user->id;
        $posts = Post::create($input);
        return $this->sendResponse(new PostResources($posts), 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Postt  $postt
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        if (is_null($post)) {
            return $this->sendError('Post Not Found');

        }
        return $this->sendResponse(new PostResources($post), 'Post Found successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Postt  $postt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $input = $request->all();
        $validator = Validator::make($input, [

            'title' => 'required',
            'description' => 'required',



        ]);

        if ($validator->fails()) {
            return $this->sendError(' unAuthroized User', $validator->errors());

        }


        $errorMessage = [];
        if ($post->user_id != Auth::id()) {
            return $this->sendError(' you Dont have rights', $errorMessage);
        }

        $post->title = $input['title'];
        $post->description = $input['description'];
        $post->save();

        return $this->sendResponse(new PostResources($post), 'post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Postt  $postt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {


        $errorMessage = [];
        if ($post->user_id != Auth::id()) {
            return $this->sendError(' you Dont have rights', $errorMessage);
        }
        $post->delete();
        return $this->sendResponse(new PostResources($post), 'post deleted successfully');

    }
}
