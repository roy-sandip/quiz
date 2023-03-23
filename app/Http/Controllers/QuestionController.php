<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::paginate(100);
        return view('admin.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.questions.create');
    }

    public function import()
    {
        //  $file = \Storage::get('public/ar_qbank.txt');
        //  $lines = explode(PHP_EOL, $file);
        // \Storage::put('public/ar_qbank.json', json_encode($lines));exit;
        
          // $source = json_decode(\Storage::get('public/ar_qbank.json'));
          // $this->groupQuestions($source);exit;


        // $source = json_decode(\Storage::get('public/questions_group.json'));
        // return $this->sanitizeQuestions($source);exit;

        
        //$this->validateQuestions();exit;

        $source = json_decode(\Storage::get('public/question_bank.json'));

        $data = [];
        $now = now();
        foreach($source as $item)
        {
            $data[] = [
                'id'            => $item->id,
                'question'      => $item->q,
                'type'          => $item->type,
                'options'       => json_encode($item->options),
                'answer'        => $item->ans,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }


        //Question::insert($data);

    }


    protected function validateQuestions()
    {

        $file = \Storage::get('public/question_bank.json');
        
        $lines = json_decode($file, true);
        $allwed_options = ['a', 'b', 'c', 'd', 'e', 'f', 1,2,3,4];
        $ids = [];
        //validate
        foreach ($lines as $item)
        {
            if(in_array($item['id'], $ids))
            {
                echo "duplicate id ".$item['id'];
                dump($item);
            }
            $ids[] = $item['id'];

            if($item['type'] == 'mcq')
            {
                $options = array_keys($item['options']);

                if(array_diff($options, $allwed_options) || !in_array($item['ans'], $allwed_options))
                {
                    echo "options does not match: ".$q_no+1;
                    dump($item);
                }elseif (count($item['options']) == 0) {
                    echo "no options given for ".$q_no;
                }

            }

           

            if($item['type'] == 'boolean')
            {
                if(!in_array($item['ans'], [true, false]))
                {
                    echo "No boolean anser given";
                    dump($item);
                }
            }


        }
    }

    protected function groupQuestions($source)
    {
        $questions = [];
        $i = 0;

        
        $current_question = [];
        foreach ($source as $single)
        {   
            //question start
            if(is_numeric($single))
            {   
                $q_no = (int) $single;
                array_unshift($current_question, ($q_no-1));
                $questions[] = $current_question;
                $current_question = [];
                $i++;
            }else{
                $current_question[] = $single;
            }



            

            
           
        }
        array_unshift($current_question, ($q_no));
        $questions[] = $current_question;

        array_shift($questions);
        \Storage::put('public/questions_group.json',  json_encode($questions));
        return $questions;
    }

    public function sanitizeQuestions($source)
    {
        $question_bank = [];
        foreach($source as $key => $single)
        {   
            $item = [];
            //1st line question number
            $item['id'] = array_shift($single);

            //2nd line actual question
            $item['q'] = array_shift($single);
            //last line answer
            $ans = str_replace(" ", "", array_pop($single));

            $ans = strtolower(trim(str_replace('Answer:', "",  str_replace(";", "",$ans))));

            if(count($single))
            {
                $item['type'] = 'mcq';
                //create option index
                $options = [];
                foreach ($single as $opt){
                    $key = strtolower(substr($opt, 0, 1));
                    $options[trim($key)] = trim(substr($opt, 2));
                }
                $single = $options;
            }else{
                $ans = filter_var($ans, FILTER_VALIDATE_BOOLEAN);
                $item['type'] = 'boolean';
            }

            
            $item['ans'] = $ans;
            $item['options'] = $single;
            $question_bank[] = $item;
        }

        \Storage::put('public/question_bank.json', json_encode($question_bank));
        return $question_bank;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        
        return view('admin.questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
