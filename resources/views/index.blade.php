@extends ('layout')

@section ('content')
    <div>
        <h1>Schools</h1>
            @foreach ($schools as $school)
            <p>{{ $school->name }}</p>
            @endforeach

        <h1>Students</h1>
            @foreach ($students as $student)
                <p>{{ $student->number }}</p>
            @endforeach

        <h1>Projects</h1>
            @foreach ($projects as $project)
                <p>{{ $project->title }}</p>
            @endforeach

        <h1>Readings</h1>
            @foreach ($readings as $reading)
                <p>{{ $reading->name }} : {{ $reading->type }}</p>
            </tr>
            @endforeach
        </table>
    </div>
    @if(DB::table('schools')->get()->isNotEmpty())
    <div id="viz"></div>
    @endif()
@endsection

@section('javascript')
<script src="https://cdn.neo4jlabs.com/neovis.js/v1.2.1/neovis.js"></script>
<script src="{{ mix('js/app.js')}}"></script>
@endsection
