<div>
    <h1>Liste des Quiz</h1>
    <ul>
        @foreach($quizzes as $quiz)
            <li>{{ $quiz->title }}</li>
        @endforeach
    </ul>
</div>
