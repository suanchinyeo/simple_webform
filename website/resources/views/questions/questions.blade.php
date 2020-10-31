
@extends('layout')

@section('title')
    <a href='/questions' class="colour3"><h1>{{ $header }}</h1></a>
@endsection('title')

@section('content')
    <form method="POST" action={{$type}}>
        @csrf
        <input name="q_id" type="hidden" value={{$q_id ?? ''}}>
        <div class="field">
            <div class="control">
            <textarea rows=5 cols=50 class="textarea" name="body" id="body" placeholder="<?php echo $placeholder_form ?>">{{ old('body') }}</textarea>
            @if ($errors->has('body'))
                <p class="error_message">{{ $errors->first('body') }}</p>
            @endif
            </div>
        </div>
        <div class="control">
            <button class="button4" style="background-color:#f14ebd">{{ $button }}</button>
        </div>
    </form>
    <?php
        use App\Models\Question;
        use App\Models\Answer;

        if ($type === "/questions"){
            $posts = Question::all()->sortByDesc("id");
            foreach($posts as $post){
                $address = '/'.strval($post->id);
                $count = Answer::where('q_id', $post->id)->get()->count();
                $count_text = strval($count).' answers';
                $colours = array("colour1", "colour2", "colour3", "colour4");
                $random = array_rand($colours, 1);
                $random_colour = $colours[$random];
                echo "<div class='questions'><a href=$address class=$random_colour>$post->body</a><br><div class='answer_count'>$count_text</div></div>";
            }
        }
        else{
           $question_post = Question::where('body', $header)->first();
           if(!is_null($question_post)){
               $posts = Answer::where('q_id', $question_post->id)->get()->sortBy("id");
               foreach($posts as $post){
                   echo "<div class='questions'>$post->body</div>";
               }
           }
            
        }
    ?>
@endsection('content')