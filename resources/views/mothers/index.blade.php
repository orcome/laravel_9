@extends('layouts.app')

@section('title', __('mother.list'))

@section('content')
<div class="mb-3">
    <div class="float-end">
        @if (!Request::get('action'))
            @can('create', new App\Models\Mother)
                <a href="{{ route('mothers.index', ['action' => 'create']) }}" class="btn btn-success">{{ __('mother.create') }}</a>
            @endcan
        @endif
    </div>
    <h1 class="page-title">{{ __('mother.list') }} <small>{{ __('app.total') }} : {{ $mothers->total() }} {{ __('mother.mother') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8">
                    <div class="row g-2">
                        <div class="col-auto">
                            <label for="q" class="col-form-label">{{ __('mother.search') }}</label>
                        </div>
                        <div class="col-auto">
                            <input placeholder="{{ __('mother.search_text') }}" name="q" type="text" id="q" class="form-control" value="{{ request('q') }}">
                        </div>
                        <div class="col-auto">
                            <input type="submit" value="{{ __('mother.search') }}" class="btn btn-secondary">
                            <a href="{{ route('mothers.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('mother.title') }}</th>
                        <th>{{ __('mother.description') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mothers as $key => $mother)
                    <tr>
                        <td class="text-center">{{ $mothers->firstItem() + $key }}</td>
                        <td>{{ $mother->title }}</td>
                        <td>{{ $mother->description }}</td>
                        <td class="text-center">
                            @can('update', $mother)
                                <a href="{{ route('mothers.index', ['action' => 'edit', 'id' => $mother->id] + Request::only('page', 'q')) }}" id="edit-mother-{{ $mother->id }}">{{ __('app.edit') }}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $mothers->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
    <div class="col-md-4">
        @if(Request::has('action'))
        @include('mothers.forms')
        @endif
    </div>
</div>
@endsection
