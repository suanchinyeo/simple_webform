
@extends('layout')

@section('content')
    <h1>{{ $header }}</h1>
    <form method="POST" action={{$type}}>
        @csrf
        <input name="q_id" type="hidden" value={{$q_id ?? ''}}>
        <div class="field">
            <div class="control">
                <textarea class="textarea" name="body" id="body">{{ $placeholder_form }}</textarea>
            </div>
        </div>
        <div class="control">
            <button class="button is-text">{{ $button }}</button>
        </div>
    </form>
    <?php
        use App\Models\Question;
        use App\Models\Answer;

        if ($type === "/questions"){
            $posts = Question::all();
            foreach($posts as $post){
                $address = '/'.strval($post->id);
                echo "<a href=$address>$post->body</a><br>";
            }
        }
        else{
           $question_post = Question::where('body', $header)->first();
           if(!is_null($question_post)){
               $posts = Answer::where('q_id', $question_post->id)->get();
               foreach($posts as $post){
                   echo "$post->body<br>";
               }
           }
            
        }
    ?>

@endsection('content')