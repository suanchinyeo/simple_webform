<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;

class MainPageController extends Controller
{
    public function show($type){
        if ($type === "questions" or is_null($type)){
            $sample_questions = array(
                'Where do you get your protein?',
                'Cheese tho',
                'Can you eat fish?',
                'Food deserts?',
                "If you're on a desert island with a chicken and nothing else to eat, would you eat the chicken?",
                "If I hold a gun to a chicken and either you eat it or I kill it would you eat it?",
                "If I hold a gun to your head and either you eat a chicken or I kill you, would you eat it?"
            );
            $random = array_rand($sample_questions, 1);
            $mapping = [
                "header" => "Questions",
                "placeholder_form" => $sample_questions[$random],
                "button" => "Ask",
                "type" => "/questions",
                "q_id" => null
            ];
        }else{
            $mapping = [
                "header" => Question::where('id', $type)->first()->body,
                "placeholder_form" => "Have an answer?",
                "button" => "Answer",
                "type" => "/answers",
                "q_id" => $type
            ];
        }

        return view("questions.questions", $mapping);

    }

    public function home(){
        return $this->show("questions");
    }

    public function validate_form($request, $input_type){
        if ($input_type === "questions"){
            $validation = $request->validate(
                ['body' => ['required', 'min:5', 'ends_with:?']]
            );
        }else{
            $validation = $request->validate(
                ['body' => ['required', 'min:5']]
            );
        }
        return $validation;
    }

    public function storequestion(){

        $this->validate_form(request(), "questions");

        $question = new Question();
        $new_question = request('body');
        $exists = Question::where('body', $new_question)->first();
        if(is_null($exists)){
            $question->body = request('body');

            $question->save();
        }
        
        return redirect('/questions');
    }

    public function storeanswer(){

        $this->validate_form(request(), "answers");

        $answer = new Answer();
        $new_answer = request('body');
        $q_id = request('q_id');
        $exists = Answer::where('body', $new_answer)->first();

        if(is_null($exists)){
            $answer->body = request('body');
            $answer->q_id = $q_id;
            $answer->save();
        }

        return redirect('/'.'q_id');

    }
}
