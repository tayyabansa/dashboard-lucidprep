@extends('admin.layouts.app')
@section('title', 'Luciderp | Result Test')
@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.4/dist/katex.min.css">
<style>
  body {
    background-color: #f1f3f5;
    font-family: 'Segoe UI', sans-serif;
  }

  .results-header {
    background: linear-gradient(90deg, #59a9da, #6610f2);
    color: white;
    border-radius: 10px;
    margin-bottom: 30px;
    padding: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .question-card {
    background-color: #ffffff;
    border-left: 6px solid #0d6efd;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    padding: 20px;
    margin-bottom: 20px;
    word-break: break-word;
  }

  .correct-answer {
    color: #198754;
    font-weight: 500;
  }

  .incorrect-answer {
    color: #dc3545;
    font-weight: 500;
  }

  .explanation-box {
    background-color: #f8f9fa;
    padding: 15px;
    border-left: 4px solid #0d6efd;
    border-radius: 5px;
    margin-top: 10px;
    font-style: italic;
  }

  .badge-correct {
    background-color: #198754;
  }

  .badge-wrong {
    background-color: #dc3545;
  }
</style>
@endpush

@section('content')

<div class="content-body">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-12">
        <!-- Header -->
        <div class="results-header text-center">
          <h2 class="fw-bold">Your Quiz Results</h2>
          <p class="mb-1">You got <strong>{{ $score }} out of {{ $total }}</strong> questions correct.</p>
          @php
            $percentage = $total > 0 ? round(($score / $total) * 100) : 0;
          @endphp
          <div class="progress mt-3" style="height: 20px;">
            <div class="progress-bar bg-success" style="width: {{ $percentage }}%;">{{ $percentage }}%</div>
          </div>
        </div>

        <!-- Questions Loop -->
        @foreach ($results as $index => $result)
          <div class="question-card">
            <h5 class="mb-4">Q{{ $index + 1 }}: {{ $result['title'] }}</h5>

            @if (!empty($result['quiz_options']) && collect($result['quiz_options'])->filter()->count() > 0)
               <ul class="list-group mb-2">
                                    @foreach ($result['quiz_options'] as $i => $option)
                                        @if (trim($option) !== '')
                                            <li class="list-group-item">
                                                @if (Str::contains($option, '<img'))
                                                    {!! chr(65 + $i) . '. ' . $option !!}
                                                @else
                                                    {{ chr(65 + $i) }}. {{ $option }}
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
            @endif 

            @if (!empty(trim($result['user_answer'])))
              <p class="mb-1 {{ $result['is_correct'] ? 'correct-answer' : 'incorrect-answer' }}">
                {{ $result['is_correct'] ? '✅' : '❌' }} Your Answer: {{ $result['user_answer'] }}
                <span class="badge {{ $result['is_correct'] ? 'badge-correct' : 'badge-wrong' }} text-white">
                  {{ $result['is_correct'] ? 'Correct' : 'Incorrect' }}
                </span>
              </p>
            @else
              <p class="text-warning mb-1">⚠️ You did not answer this question.</p>
            @endif

          @php
    $correctAnswer = $result['correct_answer'] ?? 'Not available';
    $isImageTag = Str::contains($correctAnswer, '<img');
    $isImageUrl = Str::contains($correctAnswer, ['.jpg', '.jpeg', '.png', '.gif', '.webp']);
@endphp

                            <p class="correct-answer">
                                ✅ Correct Answer:
                                @if ($isImageTag)
                                    {!! $correctAnswer !!}
                                @elseif ($isImageUrl)
                                    <img src="{{ $correctAnswer }}" alt="Correct Answer" style="max-width:200px;" />
                                @else
                                    {{ $correctAnswer }}
                                @endif
                            </p>

            @if ($result['explanation'])
              <div class="explanation-box">
                {{ $result['explanation'] }}
              </div>
            @endif

            <p class="text-muted small mt-2">⏱️ Time Spent: {{ $result['time_spent'] ?? 0 }} sec | 🎯 Accuracy: {{ $result['accuracy'] ?? '0%' }}</p>
          </div>
        @endforeach

        <!-- Button -->
        <div class="text-center mt-5">
            <a href="{{ route('test.result', ['user_id' => $user_id, 'test_id' => $test_id]) }}" class="btn btn-lg btn-primary">
            View results
        </a>

    </div>

      </div>
    </div>
  </div>
</div>
@endsection


@push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.4/dist/katex.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.4/dist/contrib/auto-render.min.js" onload="renderMathInElement(document.body, {
            delimiters: [
                {left: '$$', right: '$$', display: true},
                {left: '$', right: '$', display: false},
                {left: '\\(', right: '\\)', display: false},
                {left: '\\[', right: '\\]', display: true}
            ]
        });"></script>
@endpush

