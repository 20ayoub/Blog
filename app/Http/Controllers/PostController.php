<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Session;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //create variable and store all the blog posts from database
        $posts = Post::orderBy('id','desc')->paginate(5);

        //return a view

        return view('posts.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate data
        $this->validate($request,array(
                'title'=>'required|max:255',
                'slug'=>'required|alpha_dash|max:255|min:5|unique:posts,slug',
                'body'=>'required'
            ));

        //store in the database
        $post = new Post;

        $post->title=$request->title;
        $post->slug=$request->slug;
        $post->body=$request->body;

        $post->save();

        Session::flash('success','Blog post successfully saved');
        //redirect to another page
        return redirect()->route('posts.show',$post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //find the post in the database
        $post =Post::find($id);
        //return the view
        return view('posts.edit')->withPost($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate data
        $post=Post::find($id);
        if($request->slug == $post->slug ){
             $this->validate($request,array(
            'title'=>'required|max:255',
            'slug'=>'required|alpha_dash|max:255|min:5',
            'body'=>'required'
            ));
        }
        else{
        $this->validate($request,array(
            'title'=>'required|max:255',
            'slug'=>'required|alpha_dash|max:255|min:5|unique:posts,slug',
            'body'=>'required'
            ));
    }
        //save data

        $post->title=$request->title;
//      $post->title=$request->input('title');

        $post->slug=$request->slug;

        $post->body=$request->body;

        $post->save();

        //redirect with flash data to postsshow

        Session::flash('success','Changes saved successfully');

        return redirect()->route('posts.show',$post->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::find($id);

        $post->delete();

        Session::flash('success','Post Deleted');
        return redirect()->route('posts.index');
    }
}
