@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li {{ (isset($list)) ? 'class=active' : '' }}>
                <a href="{{ route('admin.category.index').qString() }}">
                    <i class="fa fa-list" aria-hidden="true"></i> {{ __('lang.Category') }}
                </a>
            </li>

            @can('add category') 
            <li {{ (isset($create)) ? 'class=active' : '' }}>
                <a href="{{ route('admin.category.create').qString() }}">
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

            <li {{ (isset($homeCategory)) ? 'class=active' : '' }}>
                <a href="{{ route('admin.category.home').qString() }}">
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ __('lang.Home Category') }}
                </a>
            </li>
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
                            <th>{{ __('lang.Main Category') }}</th>
                            <th>:</th>
                            <td>{{ $data->parent != null ? $data->parent->name_en . '('.$data->parent->name_bn.')' : '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('lang.Type') }}</th>
                            <th>:</th>
                            <td>{{ ucwords($data->type) }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('lang.Show In Home') }}</th>
                            <th>:</th>
                            <td>{{ $data->showInHome != null ? 'Yes' : 'No' }}</td>
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
                    <form method="POST" action="{{ isset($edit) ? route('admin.category.update', $edit) : route('admin.category.store') }}{{ qString() }}" id="are_you_sure" class="form-horizontal" enctype="multipart/form-data">
                        @csrf

                        @if (isset($edit))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                                    <label class="control-label col-sm-3">{{ __('lang.Main Category') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="parent_id" id="parent_id" onchange="setCatData()">
                                            <option value="">{{ __('lang.SelectField', ['field' => __('lang.Main Category')]) }}</option>
                                            @php ($parent_id = old('parent_id', isset($data) ? $data->parent_id : ''))
                                            @foreach($parents as $mnu)
                                                <option data-type="{{  $mnu->type }}" value="{{  $mnu->id }}" {{ ( $mnu->id == $parent_id) ? 'selected' : '' }}>{{ $mnu->name_en }} ({{ $mnu->name_bn }})</option>
                                            @endforeach
                                        </select>
            
                                        @if ($errors->has('parent_id'))
                                            <span class="help-block">{{ $errors->first('parent_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                    <label class="control-label col-sm-3 required">{{ __('lang.Type') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="type" id="type" required @if($parent_id > 0) style="pointer-events: none;" @endif>
                                            <option value="">{{ __('lang.SelectField', ['field' => __('lang.Type')]) }}</option>
                                            @php ($type = old('type', isset($data) ? $data->type : ''))
                                            @foreach(['news', 'gallery', 'video'] as $typ)
                                                <option value="{{  $typ }}" {{ ( $typ == $type) ? 'selected' : '' }}>{{ ucwords($typ) }}</option>
                                            @endforeach
                                        </select>
            
                                        @if ($errors->has('type'))
                                            <span class="help-block">{{ $errors->first('type') }}</span>
                                        @endif
                                    </div>
                                </div>

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

                                <div class="form-group{{ $errors->has('show_in_home') ? ' has-error' : '' }}">
                                    <label class="control-label col-sm-3 required">{{ __('lang.Show In Home') }}:</label>
                                    <div class="col-sm-9">
                                        <select name="show_in_home" class="form-control" required>
                                            @php ($show_in_home = old('show_in_home', (isset($data) && $data->showInHome != null) ? 'Yes' : 'No'))
                                            @foreach(['No', 'Yes'] as $sih)
                                                <option value="{{ $sih }}" {{ ($show_in_home == $sih) ? 'selected' : '' }}>{{ $sih }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('show_in_home'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('show_in_home') }}</strong>
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
                <form method="GET" action="{{ route('admin.category.index') }}" class="form-inline">
                    <div class="box-header text-right">
                        <div class="row">
                            <div class="form-group">
                                <select class="form-control" name="parent">
                                    <option value="">{{ __('lang.AnyField', ['field' => __('lang.Main Category')]) }}</option>
                                    @foreach($parents as $mnu)
                                        <option value="{{ $mnu->id }}" {{ (Request::get('parent') == $mnu) ? 'selected' : '' }}>{{ $mnu->name_en }} ({{ $mnu->name_bn }})</option>
                                    @endforeach
                                </select>
                            </div>

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
                                <a class="btn btn-custom btn-flat" href="{{ route('admin.category.index') }}"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="box-body table-responsive">
                    <table class="table table-bordered main-table" id="parent-box">
                        <thead>
                            <tr>
                                <th class="td-drag">&nbsp;</th>
                                <th>{{ __('lang.Name') }}</th>
                                <th class="td-status">{{ __('lang.Status') }}</th>
                                <th class="td-action">{{ __('lang.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="child-box">
                            @foreach($records as $val)
                            <tr class="parent-tr" data-id="{{ $val->id }}">
                                <td colspan="4">
                                    <table class="sub-table">
                                        <tbody>
                                        <tr>
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
                                            <td class="td-status">{{ $val->status }}</td>
                                            <td class="td-status">
                                                <div class="dropdown">
                                                    <a class="btn btn-default btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">{{ __('lang.Action') }} <span class="caret"></span></a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        @can('show category') 
                                                        <li><a href="{{ route('admin.category.show', $val->id).qString() }}"><i class="fa fa-eye"></i> {{ __('lang.Show') }}</a></li>
                                                        @endcan
                                                        
                                                        @can('edit category') 
                                                        <li><a href="{{ route('admin.category.edit', $val->id).qString() }}"><i class="fa fa-pencil"></i> {{ __('lang.Edit') }}</a></li>
                                                        @endcan
                                                        
                                                        @can('delete category') 
                                                        <li><a onclick="deleted('{{ route('admin.category.destroy', $val->id).qString() }}')"><i class="fa fa-trash"></i> {{ __('lang.Delete') }}</a></li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>

                                        @if ($val->childs->count() > 0)
                                            <tbody>
                                            @foreach($val->childs as $chld)
                                            <tr class="child-tr" data-id="{{ $chld->id }}">
                                                <td class="td-drag">
                                                    <div class="child-tr-drag-handle">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="drag">
                                                            <title>Drag</title>
                                                            <path
                                                                d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                                        </svg>
                                                    </div>
                                                </td>
                                                <td>&nbsp;&nbsp;{{ $chld->name_en }} / {{ $chld->name_bn }}</td>
                                                <td class="td-status">{{ $chld->status }}</td>
                                                <td class="td-status">
                                                    <div class="dropdown">
                                                        <a class="btn btn-default btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">{{ __('lang.Action') }} <span class="caret"></span></a>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            @can('show category') 
                                                            <li><a href="{{ route('admin.category.show', $chld->id).qString() }}"><i class="fa fa-eye"></i> {{ __('lang.Show') }}</a></li>
                                                            @endcan
                                                            
                                                            @can('edit category') 
                                                            <li><a href="{{ route('admin.category.edit', $chld->id).qString() }}"><i class="fa fa-pencil"></i> {{ __('lang.Edit') }}</a></li>
                                                            @endcan
                                                            
                                                            @can('delete category') 
                                                            <li><a onclick="deleted('{{ route('admin.category.destroy', $chld->id).qString() }}')"><i class="fa fa-trash"></i> {{ __('lang.Delete') }}</a></li>
                                                            @endcan
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        @endif
                                    </table>
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
            
            @elseif (isset($homeCategory))
            <div class="tab-pane active">
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="td-drag">&nbsp;</th>
                                <th>{{ __('lang.Category') }}</th>
                            </tr>
                        </thead>
                        <tbody id="home-cat-box">
                            @foreach($homeCategories as $val)
                            <tr class="home-cat-tr" data-id="{{ $val->id }}">
                                <td class="td-drag">
                                    <div class="home-cat-tr-drag-handle">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="drag">
                                            <title>Drag</title>
                                            <path
                                                d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                        </svg>
                                    </div>
                                </td>
                                <td>{{ $val->category->name_en }} / {{ $val->category->name_bn }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .main-table>tbody>tr>td {
        padding-left: 0;
        padding-right: 0;
    }
    .sub-table {
        width: 100%;
    }
    .sub-table>tbody>tr>td {
        padding: 5px;
    }

    .td-action {
        width: 80px;
    }
    .td-status {
        width: 80px;
    }
</style>
@endsection


@section('scripts')
<script>
function setCatData() {
    var parentId = $('#parent_id').val();
    var parentType = $('#parent_id').find(':selected').data("type");
    if (parentId > 0) {
        $('#type').val(parentType);
        $('#type').attr("style", "pointer-events: none;");
    } else {
        $('#type').attr("style", "pointer-events: inherit;");
    }
}

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

    $("#child-box").sortable({
        placeholder: 'sort-highlight',
        forcePlaceholderSize: true,
        axis: 'y',
        items: "tr.child-tr",
        cursor: 'move',
        handle: '.child-tr-drag-handle',
        opacity: 0.6,
        update: function () {
            const ids = [];

            $('tr.child-tr').each(function (index, element) {
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
            url: "{{ route('admin.category.sort') }}",
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

    $("#home-cat-box").sortable({
        placeholder: 'sort-highlight',
        forcePlaceholderSize: true,
        axis: 'y',
        items: "tr.home-cat-tr",
        cursor: 'move',
        handle: '.home-cat-tr-drag-handle',
        opacity: 0.6,
        update: function () {
            const ids = [];

            $('tr.home-cat-tr').each(function (index, element) {
                ids.push($(this).attr('data-id'));
            });

            homeCatSort(ids);
        }
    });

    function homeCatSort(ids) {
        $.ajax({
            type: 'POST',
            dataType: "JSON",
            data: {ids: ids},
            url: "{{ route('admin.category.home.sort') }}",
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