@extends('layouts.app')

@section('title', __('master.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('master.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('master.title') }}</td><td>{{ $master->title }}</td></tr>
                        <tr><td>{{ __('master.description') }}</td><td>{{ $master->description }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $master)
                    <a href="{{ route('masters.edit', $master) }}" id="edit-master-{{ $master->id }}" class="btn btn-warning">{{ __('master.edit') }}</a>
                @endcan
                <a href="{{ route('masters.index') }}" class="btn btn-link">{{ __('master.back_to_index') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
