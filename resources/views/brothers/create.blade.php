@extends('layouts.app')

@section('title', __('brother.create'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('brother.create') }}</div>
            {{ Form::open(['route' => 'brothers.store']) }}
            <div class="card-body">
                {!! FormField::text('title', ['required' => true, 'label' => __('brother.title')]) !!}
                {!! FormField::textarea('description', ['label' => __('brother.description')]) !!}
            </div>
            <div class="card-footer">
                {{ Form::submit(__('app.create'), ['class' => 'btn btn-success']) }}
                {{ link_to_route('brothers.index', __('app.cancel'), [], ['class' => 'btn btn-link']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
