@if (Request::get('action') == 'create')
@can('create', new App\Models\Mother)
    <form method="POST" action="{{ route('mothers.store') }}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title" class="col-form-label">{{ __('mother.title') }} <span class="form-required">*</span></label>
            <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required>
            {!! $errors->first('title', '<span class="invalid-feedback" role="alert">:message</span>') !!}
        </div>
        <div class="form-group">
            <label for="description" class="col-form-label">{{ __('mother.description') }}</label>
            <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="4">{{ old('description') }}</textarea>
            {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
        </div>
        <div class="form-group my-2">
            <input type="submit" value="{{ __('app.create') }}" class="btn btn-success">
            <a href="{{ route('mothers.index') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
        </div>
    </form>
@endcan
@endif
@if (Request::get('action') == 'edit' && $editableMother)
@can('update', $editableMother)
    <form method="POST" action="{{ route('mothers.update', $editableMother) }}" accept-charset="UTF-8">
        {{ csrf_field() }} {{ method_field('patch') }}
        <div class="form-group">
            <label for="title" class="col-form-label">{{ __('mother.title') }} <span class="form-required">*</span></label>
            <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $editableMother->title) }}" required>
            {!! $errors->first('title', '<span class="invalid-feedback" role="alert">:message</span>') !!}
        </div>
        <div class="form-group">
            <label for="description" class="col-form-label">{{ __('mother.description') }}</label>
            <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="4">{{ old('description', $editableMother->description) }}</textarea>
            {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
        </div>
        <input name="page" value="{{ request('page') }}" type="hidden">
        <input name="q" value="{{ request('q') }}" type="hidden">
        <div class="form-group my-2">
            <input type="submit" value="{{ __('mother.update') }}" class="btn btn-success">
            <a href="{{ route('mothers.index', Request::only('q', 'page')) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
            @can('delete', $editableMother)
                <a href="{{ route('mothers.index', ['action' => 'delete', 'id' => $editableMother->id] + Request::only('page', 'q')) }}" id="del-mother-{{ $editableMother->id }}" class="btn btn-danger float-end">{{ __('app.delete') }}</a>
            @endcan
        </div>
    </form>
@endcan
@endif
@if (Request::get('action') == 'delete' && $editableMother)
@can('delete', $editableMother)
    <div class="card">
        <div class="card-header">{{ __('mother.delete') }}</div>
        <div class="card-body">
            <label class="form-label text-primary">{{ __('mother.title') }}</label>
            <p>{{ $editableMother->title }}</p>
            <label class="form-label text-primary">{{ __('mother.description') }}</label>
            <p>{{ $editableMother->description }}</p>
            {!! $errors->first('mother_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
        </div>
        <hr style="margin:0">
        <div class="card-body text-danger">{{ __('mother.delete_confirm') }}</div>
        <div class="card-footer">
            <form method="POST" action="{{ route('mothers.destroy', $editableMother) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                {{ csrf_field() }} {{ method_field('delete') }}
                <input name="mother_id" type="hidden" value="{{ $editableMother->id }}">
                <input name="page" value="{{ request('page') }}" type="hidden">
                <input name="q" value="{{ request('q') }}" type="hidden">
                <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
            </form>
            <a href="{{ route('mothers.index', Request::only('q', 'page')) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
        </div>
    </div>
@endcan
@endif
