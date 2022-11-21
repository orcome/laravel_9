@extends('layouts.app')

@section('title', __('brother.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('brother.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('brother.title') }}</td><td>{{ $brother->title }}</td></tr>
                        <tr><td>{{ __('brother.description') }}</td><td>{{ $brother->description }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $brother)
                    {{ link_to_route('brothers.edit', __('brother.edit'), [$brother], ['class' => 'btn btn-warning', 'id' => 'edit-brother-'.$brother->id]) }}
                @endcan
                {{ link_to_route('brothers.index', __('brother.back_to_index'), [], ['class' => 'btn btn-link']) }}
            </div>
        </div>
    </div>
</div>
@endsection
