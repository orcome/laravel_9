@if (Request::get('action') == 'create')
@can('create', new App\Models\Sister)
    {{ Form::open(['route' => 'sisters.store']) }}
    {!! FormField::text('title', ['required' => true, 'label' => __('sister.title')]) !!}
    {!! FormField::textarea('description', ['label' => __('sister.description')]) !!}
    {{ Form::submit(__('app.create'), ['class' => 'btn btn-success']) }}
    {{ link_to_route('sisters.index', __('app.cancel'), [], ['class' => 'btn btn-link']) }}
    {{ Form::close() }}
@endcan
@endif
@if (Request::get('action') == 'edit' && $editableSister)
@can('update', $editableSister)
    {{ Form::model($editableSister, ['route' => ['sisters.update', $editableSister], 'method' => 'patch']) }}
    {!! FormField::text('title', ['required' => true, 'label' => __('sister.title')]) !!}
    {!! FormField::textarea('description', ['label' => __('sister.description')]) !!}
    @if (request('q'))
        {{ Form::hidden('q', request('q')) }}
    @endif
    @if (request('page'))
        {{ Form::hidden('page', request('page')) }}
    @endif
    {{ Form::submit(__('sister.update'), ['class' => 'btn btn-success']) }}
    {{ link_to_route('sisters.index', __('app.cancel'), Request::only('page', 'q'), ['class' => 'btn btn-link']) }}
    @can('delete', $editableSister)
        {{ link_to_route(
            'sisters.index',
            __('app.delete'),
            ['action' => 'delete', 'id' => $editableSister->id] + Request::only('page', 'q'),
            ['id' => 'del-sister-'.$editableSister->id, 'class' => 'btn btn-danger float-end']
        ) }}
    @endcan
    {{ Form::close() }}
@endcan
@endif
@if (Request::get('action') == 'delete' && $editableSister)
@can('delete', $editableSister)
    <div class="card">
        <div class="card-header">{{ __('sister.delete') }}</div>
        <div class="card-body">
            <label class="control-label text-primary">{{ __('sister.title') }}</label>
            <p>{{ $editableSister->title }}</p>
            <label class="control-label text-primary">{{ __('sister.description') }}</label>
            <p>{{ $editableSister->description }}</p>
            {!! $errors->first('sister_id', '<span class="form-error small">:message</span>') !!}
        </div>
        <hr style="margin:0">
        <div class="card-body text-danger">{{ __('sister.delete_confirm') }}</div>
        <div class="card-footer">
            {!! FormField::delete(
                ['route' => ['sisters.destroy', $editableSister]],
                __('app.delete_confirm_button'),
                ['class' => 'btn btn-danger'],
                [
                    'sister_id' => $editableSister->id,
                    'page' => request('page'),
                    'q' => request('q'),
                ]
            ) !!}
            {{ link_to_route('sisters.index', __('app.cancel'), Request::only('page', 'q'), ['class' => 'btn btn-link']) }}
        </div>
    </div>
@endcan
@endif
