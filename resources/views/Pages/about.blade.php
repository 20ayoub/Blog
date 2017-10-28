@extends('layouts.app')
@section('title','| About')

@section('content')


      <div class="row">
        <div class="col-md-12">
          <h1>About Me</h1>
          <p>About {{$data['fullname']}} !!
            Email at {{$data['email']}}
            About again {{$fullname}} !!</p>
        </div>
      </div>
@endsection
    




