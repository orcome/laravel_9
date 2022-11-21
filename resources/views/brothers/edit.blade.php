@extends('layouts.app')

@section('title', __('brother.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $brother)
        @can('delete', $brother)
            <div class="card">
                <div class="card-header">{{ __('brother.delete') }}</div>
                <div class="card-body">
                    <label class="control-label text-primary">{{ __('brother.title') }}</label>
                    <p>{{ $brother->title }}</p>
                    <label class="control-label text-primary">{{ __('brother.description') }}</label>
                    <p>{{ $brother->description }}</p>
                    {!! $errors->first('brother_id', '<span class="form-error small">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('brother.delete_confirm') }}</div>
                <div class="card-footer">
                    {!! FormField::delete(
                        ['route' => ['brothers.destroy', $brother]],
                        __('app.delete_confirm_button'),
                        ['class' => 'btn btn-danger'],
                        ['brother_id' => $brother->id]
                    ) !!}
                    {{ link_to_route('brothers.edit', __('app.cancel'), [$brother], ['class' => 'btn btn-link']) }}
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">{{ __('brother.edit') }}</div>
            {{ Form::model($brother, ['route' => ['brothers.update', $brother], 'method' => 'patch']) }}
            <div class="card-body">
                {!! FormField::text('title', ['required' => true, 'label' => __('brother.title')]) !!}
                {!! FormField::textarea('description', ['label' => __('brother.description')]) !!}
            </div>
            <div class="card-footer">
                {{ Form::submit(__('brother.update'), ['class' => 'btn btn-success']) }}
                {{ link_to_route('brothers.show', __('app.cancel'), [$brother], ['class' => 'btn btn-link']) }}
                @can('delete', $brother)
                    {{ link_to_route('brothers.edit', __('app.delete'), [$brother, 'action' => 'delete'], ['class' => 'btn btn-danger float-right', 'id' => 'del-brother-'.$brother->id]) }}
                @endcan
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endif
@endsection
