@extends('layouts.app')

@section('title', __('master.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $master)
        @can('delete', $master)
            <div class="card">
                <div class="card-header">{{ __('master.delete') }}</div>
                <div class="card-body">
                    <label class="form-label text-primary">{{ __('master.title') }}</label>
                    <p>{{ $master->title }}</p>
                    <label class="form-label text-primary">{{ __('master.description') }}</label>
                    <p>{{ $master->description }}</p>
                    {!! $errors->first('master_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('master.delete_confirm') }}</div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('masters.destroy', $master) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-end" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="master_id" type="hidden" value="{{ $master->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    <a href="{{ route('masters.edit', $master) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </div>
        @endcan
        @else
            <div class="card">
                <div class="card-header">{{ __('master.edit') }}</div>
                <form method="POST" action="{{ route('masters.update', $master) }}" accept-charset="UTF-8">
                    {{ csrf_field() }} {{ method_field('patch') }}
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label fw-bolder">{{ __('master.title') }} <span class="form-required">*</span></label>
                            <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $master->title) }}" required>
                            {!! $errors->first('title', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label fw-bolder">{{ __('master.description') }}</label>
                            <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="4">{{ old('description', $master->description) }}</textarea>
                            {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" value="{{ __('master.update') }}" class="btn btn-success">
                        <a href="{{ route('masters.show', $master) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                        @can('delete', $master)
                            <a href="{{ route('masters.edit', [$master, 'action' => 'delete']) }}" id="del-master-{{ $master->id }}" class="btn btn-danger float-end">{{ __('app.delete') }}</a>
                        @endcan
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>

@endsection
