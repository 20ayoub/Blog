<?php

namespace App\Http\Controllers;
use App\Post;

class PagesController extends Controller {

	public function getIndex(){
		$posts=Post::orderBy('created_at','desc')->limit(4)->get();
		return view('Pages.welcome')->withPosts($posts);
	}
	public function getAbout(){
		$first ='Ayoub';
		$last='El Berrahoui';
		$full=$first . " " . $last;
		$email='ayoub@gmail.com';
		$data=[];
		$data['email']=$email;
		$data['fullname']=$full;
		return view('Pages.about')->with("fullname",$full)->withEmailme($email)->withData($data);
	}
	public function getContact(){
		return view('Pages.contact');
	}
}

?>