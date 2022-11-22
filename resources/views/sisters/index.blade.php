@extends('layouts.app')

@section('title', __('sister.list'))

@section('content')
<div class="mb-3">
    <div class="float-end">
        @if (!Request::get('action'))
            @can('create', new App\Models\Sister)
                {{ link_to_route('sisters.index', __('sister.create'), ['action' => 'create'], ['class' => 'btn btn-success']) }}
            @endcan
        @endif
    </div>
    <h1 class="page-title">{{ __('sister.list') }} <small>{{ __('app.total') }} : {{ $sisters->total() }} {{ __('sister.sister') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                {{ Form::open(['method' => 'get']) }}
                <div class="row g-2">
                    <div class="col-auto">
                        <label for="q" class="col-form-label">{{ __('sister.search') }}</label>
                    </div>
                    <div class="col-auto">
                        {!! FormField::text('q', ['label' => false, 'placeholder' => __('sister.search_text')]) !!}
                    </div>
                    <div class="col-auto">
                        {{ Form::submit(__('sister.search'), ['class' => 'btn btn-secondary']) }}
                        {{ link_to_route('sisters.index', __('app.reset'), [], ['class' => 'btn btn-link']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('sister.title') }}</th>
                        <th>{{ __('sister.description') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sisters as $key => $sister)
                    <tr>
                        <td class="text-center">{{ $sisters->firstItem() + $key }}</td>
                        <td>{{ $sister->title }}</td>
                        <td>{{ $sister->description }}</td>
                        <td class="text-center">
                            @can('update', $sister)
                                {{ link_to_route(
                                    'sisters.index',
                                    __('app.edit'),
                                    ['action' => 'edit', 'id' => $sister->id] + Request::only('page', 'q'),
                                    ['id' => 'edit-sister-'.$sister->id]
                                ) }}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $sisters->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
    <div class="col-md-4">
        @if(Request::has('action'))
        @include('sisters.forms')
        @endif
    </div>
</div>
@endsection
