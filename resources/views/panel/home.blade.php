@extends('panel.layouts.default')

@section('content')
    @include('panel.components.kanban-column')

    @include('panel.components.create-column-button')
@endsection
