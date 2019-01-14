@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('forms.report')
            </div>
            <div class="col-sm-9">
                @if(isset($links) && $links->count())
                    <table class="table table-responsive-sm" size="1">
                        <thead>
                        <tr>
                            <th>Validate</th>
                            <th>Site</th>
                            <th>Link</th>
                            <th>Created at</th>
                            <th>Created by</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($links as $k=>$link)
                            @if(Auth::user()->email==$link->creator || Auth::user()->role=='superuser')
                                <tr>
                                    <td>
                                        @include('report.validate')
                                    </td>
                                    <td>{{ $link->name }}</td>
                                    <td style="max-width: 450px;overflow-x: auto;"><a @if(!$link->ahref) class="text-danger"
                                    @endif
                                    href="{{ $link->link }}">{{ $link->link }}</a></td>
                                    <td>{{ $link->created_at }}</td>
                                    <td class="text-muted">{{ $link->creator }}</td>
                                    {{--<td>--}}
                                    {{--@include('report.moz')--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                    {{--@include('report.ahref')--}}
                                    {{--</td>--}}
                                </tr>
                            @endif
                        @endforeach
                        <!-- Trigger the modal with a button -->
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
