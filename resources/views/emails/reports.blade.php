@foreach($links as $key=>$link)
    <h2>Report for {{ $key }} for {{ date('Y-m-d') }}</h2>
    @foreach($link as $email=>$user)
        <h4>Created by {{ $email }} </h4>
        @foreach($user as $data)
            {{ $data->link }}<br>
        @endforeach
    @endforeach
@endforeach