@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li {{ (isset($list)) ? 'class=active' : '' }}>
                <a href="{{ route('admin.classified.category.index').qString() }}">
                    <i class="fa fa-list" aria-hidden="true"></i> {{ __('lang.Category') }}
                </a>
            </li>

            @can('add category') 
            <li {{ (isset($create)) ? 'class=active' : '' }}>
                <a href="{{ route('admin.classified.category.create').qString() }}">
                    <i class="fa fa-plus" aria-hidden="true"></i> {{ __('lang.Category') }}
                </a>
            </li>
            @endcan

            @if (isset($edit))
            <li class="active">
                <a href="#">
                    <i class="fa fa-edit" aria-hidden="true"></i> {{ __('lang.Category') }}
                </a>
            </li>
            @endif

            @if (isset($show))
            <li class="active">
                <a href="#">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> {{ __('lang.Category') }}
                </a>
            </li>
            @endif
        </ul>

        <div class="tab-content">
            @if(isset($show))
            <div class="tab-pane active">
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width:120px;">{{ __('lang.Name') }}({{ __('lang.En') }})</th>
                            <th style="width:10px;">:</th>
                            <td>{{ $data->name_en }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('lang.Name') }}({{ __('lang.Bn') }})</th>
                            <th>:</th>
                            <td>{{ $data->name_bn }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('lang.Sorting') }}</th>
                            <th>:</th>
                            <td>{{ $data->sorting }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('lang.Status') }}</th>
                            <th>:</th>
                            <td>{{ $data->status }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('lang.CreatedBy') }}</th>
                            <th>:</th>
                            <td>{{ $data->creator != null ? $data->creator->name : 'N/A' }}</td>
                        </tr> 
                    </table>
                </div>
            </div>

            @elseif(isset($edit) || isset($create))
            <div class="tab-pane active">
                <div class="box-body">
                    <form method="POST" action="{{ isset($edit) ? route('admin.classified.category.update', $edit) : route('admin.classified.category.store') }}{{ qString() }}" id="are_you_sure" class="form-horizontal" enctype="multipart/form-data">
                        @csrf

                        @if (isset($edit))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group{{ $errors->has('name_en') ? ' has-error' : '' }}">
                                    <label class="control-label col-sm-3 required">{{ __('lang.Name') }}({{ __('lang.En') }}):</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name_en" value="{{ old('name_en', isset($data) ? $data->name_en : '') }}" required>

                                        @if ($errors->has('name_en'))
                                            <span class="help-block">{{ $errors->first('name_en') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('name_bn') ? ' has-error' : '' }}">
                                    <label class="control-label col-sm-3 required">{{ __('lang.Name') }}({{ __('lang.Bn') }}):</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name_bn" value="{{ old('name_bn', isset($data) ? $data->name_bn : '') }}" required>

                                        @if ($errors->has('name_bn'))
                                            <span class="help-block">{{ $errors->first('name_bn') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                    <label class="control-label col-sm-3 required">{{ __('lang.Status') }}:</label>
                                    <div class="col-sm-9">
                                        <select name="status" class="form-control" required>
                                            @php ($status = old('status', isset($data) ? $data->status : ''))
                                            @foreach(['Active', 'Deactivated'] as $sts)
                                                <option value="{{ $sts }}" {{ ($status == $sts) ? 'selected' : '' }}>{{ $sts }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('status'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('status') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-success btn-flat btn-lg">{{ isset($edit) ? __('lang.Update') : __('lang.Create') }}</button>
                                    <button type="reset" class="btn btn-custom btn-flat btn-lg">{{ __('lang.Reset') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @elseif (isset($list))
            <div class="tab-pane active">
                <form method="GET" action="{{ route('admin.classified.category.index') }}" class="form-inline">
                    <div class="box-header text-right">
                        <div class="row">
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="">{{ __('lang.AnyField', ['field' => __('lang.Status')]) }}</option>
                                    @foreach(['Active', 'Deactivated'] as $sts)
                                        <option value="{{ $sts }}" {{ (Request::get('status') == $sts) ? 'selected' : '' }}>{{ $sts }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="{{ __('lang.SearchInputPlaceholder') }}">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-custom btn-flat"><i class="fa fa-search"></i></button>
                                <a class="btn btn-custom btn-flat" href="{{ route('admin.classified.category.index') }}"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="td-drag">&nbsp;</th>
                                <th>{{ __('lang.Name') }}</th>
                                <th>{{ __('lang.Status') }}</th>
                                <th class="col-action">{{ __('lang.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="parent-box">
                            @foreach($records as $val)
                            <tr class="parent-tr" data-id="{{ $val->id }}">
                                <td class="td-drag">
                                    <div class="parent-tr-drag-handle">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="drag">
                                            <title>Drag</title>
                                            <path
                                                d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                        </svg>
                                    </div>
                                </td>
                                <td>{{ $val->name_en }} / {{ $val->name_bn }}</td>
                                <td>{{ $val->status }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-default btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">{{ __('lang.Action') }} <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            @can('show category') 
                                            <li><a href="{{ route('admin.classified.category.show', $val->id).qString() }}"><i class="fa fa-eye"></i> {{ __('lang.Show') }}</a></li>
                                            @endcan
                                            
                                            @can('edit category') 
                                            <li><a href="{{ route('admin.classified.category.edit', $val->id).qString() }}"><i class="fa fa-pencil"></i> {{ __('lang.Edit') }}</a></li>
                                            @endcan
                                            
                                            @can('delete category') 
                                            <li><a onclick="deleted('{{ route('admin.classified.category.destroy', $val->id).qString() }}')"><i class="fa fa-trash"></i> {{ __('lang.Delete') }}</a></li>
                                            @endcan
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-sm-4 pagi-msg">{!! pagiMsg($records) !!}</div>

                    <div class="col-sm-4 text-center">
                        {{ $records->appends(Request::except('page'))->links() }}
                    </div>

                    <div class="col-sm-4">
                        <div class="pagi-limit-box">
                            <div class="input-group pagi-limit-box-body">
                                <span class="input-group-addon">{{ __('lang.Show') }}:</span>

                                <select class="form-control pagi-limit" name="limit">
                                    @foreach(paginations() as $pag)
                                        <option value="{{ qUrl(['limit' => $pag]) }}" {{ ($pag == Request::get('limit')) ? 'selected' : '' }}>{{ $pag }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
$(function () {
    $("#parent-box").sortable({
        placeholder: 'sort-highlight',
        forcePlaceholderSize: true,
        axis: 'y',
        items: "tr.parent-tr",
        cursor: 'move',
        handle: '.parent-tr-drag-handle',
        opacity: 0.6,
        update: function () {
            const ids = [];

            $('tr.parent-tr').each(function (index, element) {
                ids.push($(this).attr('data-id'));
            });

            sort(ids);
        }
    });

    function sort(ids) {
        $.ajax({
            type: 'POST',
            dataType: "JSON",
            data: {ids: ids},
            url: "{{ route('admin.classified.category.sort') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                console.log(res.message);
            },
            error: function (err) {
                alert(err.responseJSON.message);
            }
        });
    }
});
</script>
@endsection