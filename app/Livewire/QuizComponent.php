<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quiz;

class QuizComponent extends Component
{
    public $quizzes;

    public function mount()
    {
        $this->quizzes = Quiz::all();
    }

    public function render()
    {
        return view('livewire.quiz-component');
    }
}
