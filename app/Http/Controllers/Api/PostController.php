<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use JWTAuth;
class PostController extends Controller
{

  public function getPost($id)
  {
    $post = Post::find($id);
    if (!$post) {
      return response()->json(['message' => 'Post not found'],404);
    }
    return response()->json(['post' => $post],200);
  }

  public function getAllPost()
  {
    $user = $this->getUser();
    $posts = Post::where('user_id','=',$user->id)->get();
    return response()->json([
      'posts' => $posts
    ],200);
  }

  public function createPost(Request $request)
  {
    $this->validate($request,[
      'title' => 'required',
      'description' => 'required'
    ]);
    $user = $this->getUser();
    $post = Post::create([
      'title' => $request->title,
      'description' => $request->description,
      'user_id' => $user->id
    ]);
    return response()->json([
      'message' => 'Post created',
      'post' => $post
    ],201);
  }

  public function updatePost(Request $request,$id)
  {
    $this->validate($request,[
      'title' => 'required',
      'description' => 'required'
    ]);

    $post = Post::find($id);
    $data = $request->only('title','description');
    $post = $post->update($data);

    return response()->json([
      'message' => 'Post updated'
    ],200);
  }

  public function deletePost($id)
  {
    Post::destroy($id);
    return response()->json([
      'message' => 'Post deleted'
    ],200);
  }

  protected function getUser()
  {
    return JWTAuth::parseToken()->toUser();
  }
}
