<h1>{{ $question->title }}</h1>
<p>{{ $question->content }}</p>

<div>
    @foreach($answers as $answer)
        <h3>{{ $answer->user }}</h3>
        <p>{{ $answer->content }}</p>
    @endforeach
</div>
