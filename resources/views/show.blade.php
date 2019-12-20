@extends ('layout')

@section ('content')
    <!-- Schools tab -->
    <div id="schools">
        <h2>
            <a href="/schools/{{ $school->id }}">{{ $school->name }}</a>
        </h2>
    </div>

    <p>
        @foreach($relationships as $relationship)
            {{ $relationship->number }}
        @endforeach
    </p>
@endsection
