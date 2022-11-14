@extends('layouts.app')

@section('title', __('master.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Models\Master)
            <a href="{{ route('masters.create') }}" class="btn btn-success">{{ __('master.create') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('master.list') }} <small>{{ __('app.total') }} : {{ $masters->total() }} {{ __('master.master') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="form-label">{{ __('master.search') }}</label>
                        <input placeholder="{{ __('master.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('master.search') }}" class="btn btn-secondary">
                    <a href="{{ route('masters.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('master.title') }}</th>
                        <th>{{ __('master.description') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($masters as $key => $master)
                    <tr>
                        <td class="text-center">{{ $masters->firstItem() + $key }}</td>
                        <td>{!! $master->title_link !!}</td>
                        <td>{{ $master->description }}</td>
                        <td class="text-center">
                            @can('view', $master)
                                <a href="{{ route('masters.show', $master) }}" id="show-master-{{ $master->id }}">{{ __('app.show') }}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $masters->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection
