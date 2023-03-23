<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $casts = [
            'options'   => 'collection',
    ];

    public function getAnswer()
    {
        return $this->type == 'boolean' 
                                        ? ($this->answer ? 'True' : 'False')
                                        :$this->options->get($this->answer, 'unknown') ;
    }

    public function isCorrect($answer)
    {
        $answer = strtolower(trim($answer));
        if($this->isBoolean())
        {
            $answer = ($answer == 'true' || $answer === true) ? true : false;
        }
        return strtolower($this->answer) == $answer;
    }

    public function getOptions($shuffle = false)
    {
        if($this->isBoolean())
        {
            return collect(['true' => 'True', 'false' => 'False']);
        }

        if($this->isMCQ())
        {
            return $shuffle ? $this->shuffleOptions()->options : $this->options;
        }
    }


    public function isMCQ()
    {
        return $this->type == 'mcq';
    }

    public function isBoolean()
    {
        return $this->type == 'boolean';
    }


    public function shuffleOptions()
    {
        $keys = $this->options->keys()->shuffle();
        $shuffled = collect([]);
        foreach ($keys as $key)
        {
            $shuffled->put($key, $this->options->get($key));
        }
        $this->options = $shuffled;
        return $this;
    }

}
