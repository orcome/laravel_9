@extends('layouts.app')

@section('title', __('brother.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Models\Brother)
            {{ link_to_route('brothers.create', __('brother.create'), [], ['class' => 'btn btn-success']) }}
        @endcan
    </div>
    <h1 class="page-title">{{ __('brother.list') }} <small>{{ __('app.total') }} : {{ $brothers->total() }} {{ __('brother.brother') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                {{ Form::open(['method' => 'get', 'class' => 'form-inline']) }}
                {!! FormField::text('q', ['label' => __('brother.search'), 'placeholder' => __('brother.search_text'), 'class' => 'mx-sm-2']) !!}
                {{ Form::submit(__('brother.search'), ['class' => 'btn btn-secondary']) }}
                {{ link_to_route('brothers.index', __('app.reset'), [], ['class' => 'btn btn-link']) }}
                {{ Form::close() }}
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('brother.title') }}</th>
                        <th>{{ __('brother.description') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brothers as $key => $brother)
                    <tr>
                        <td class="text-center">{{ $brothers->firstItem() + $key }}</td>
                        <td>{{ $brother->title_link }}</td>
                        <td>{{ $brother->description }}</td>
                        <td class="text-center">
                            @can('view', $brother)
                                {{ link_to_route(
                                    'brothers.show',
                                    __('app.show'),
                                    [$brother],
                                    ['id' => 'show-brother-' . $brother->id]
                                ) }}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $brothers->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection
