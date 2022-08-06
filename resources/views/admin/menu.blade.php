@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li {{ (isset($list)) ? 'class=active' : '' }}>
                <a href="{{ route('admin.menu.index').qString() }}">
                    <i class="fa fa-list" aria-hidden="true"></i> {{ __('lang.Menu') }}
                </a>
            </li>

            @can('add menu') 
            <li {{ (isset($create)) ? 'class=active' : '' }}>
                <a href="{{ route('admin.menu.create').qString() }}">
                    <i class="fa fa-plus" aria-hidden="true"></i> {{ __('lang.Menu') }}
                </a>
            </li>
            @endcan

            @if (isset($edit))
            <li class="active">
                <a href="#">
                    <i class="fa fa-edit" aria-hidden="true"></i> {{ __('lang.Menu') }}
                </a>
            </li>
            @endif

            @if (isset($show))
            <li class="active">
                <a href="#">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> {{ __('lang.Menu') }}
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
                            <th style="width:120px;">{{ __('lang.Position') }})</th>
                            <th style="width:10px;">:</th>
                            <td>{{ ucwords($data->position) }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('lang.Parent Menu') }}</th>
                            <th>:</th>
                            <td>{{ $data->parent != null ? $data->parent->taggable->name_en . ' / '.$data->parent->taggable->name_bn : '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('lang.Menu') }}</th>
                            <th>:</th>
                            <td>{{ $data->taggable != null ? $data->taggable->name_en . ' / '.$data->taggable->name_bn : '-' }}</td>
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
                    <form method="POST" action="{{ isset($edit) ? route('admin.menu.update', $edit) : route('admin.menu.store') }}{{ qString() }}" id="are_you_sure" class="form-horizontal" enctype="multipart/form-data">
                        @csrf

                        @if (isset($edit))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                                    <label class="control-label col-sm-3 required">{{ __('lang.Position') }}:</label>
                                    <div class="col-sm-9">
                                        <select name="position" class="form-control" required>
                                            @php ($position = old('position', isset($data) ? $data->position : ''))
                                            @foreach(['header', 'footer', 'hamburger'] as $pos)
                                                <option value="{{ $pos }}" {{ ($position == $pos) ? 'selected' : '' }}>{{ ucwords($pos) }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('position'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('position') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                                    <label class="control-label col-sm-3">{{ __('lang.Parent Menu') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="parent_id">
                                            <option value="">{{ __('lang.SelectField', ['field' => __('lang.Parent Menu')]) }}</option>
                                            @php ($parent_id = old('parent_id', isset($data) ? $data->parent_id : ''))
                                            @foreach($parents as $mnu)
                                                <option value="{{  $mnu->id }}" {{ ( $mnu->id == $parent_id) ? 'selected' : '' }}>{{ $mnu->taggable->name_en }} ({{ $mnu->taggable->name_bn }})</option>
                                            @endforeach
                                        </select>
            
                                        @if ($errors->has('role'))
                                            <span class="help-block">{{ $errors->first('role') }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-group{{ $errors->has('taggable_type') ? ' has-error' : '' }}">
                                    <label class="control-label col-sm-3 required">{{ __('lang.Taggable Type') }}:</label>
                                    <div class="col-sm-9">
                                        <select name="taggable_type" id="taggable_type" class="form-control" required onchange="taggable()">
                                            @php ($taggable_type = old('taggable_type', isset($data) ? $data->taggable_type : ''))
                                            @foreach(['Category', 'Page'] as $tg)
                                                <option value="{{ $tg }}" {{ ($taggable_type == 'App/Models/'.$tg) ? 'selected' : '' }}>{{ $tg }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('taggable_type'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('taggable_type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-group{{ $errors->has('taggable_id') ? ' has-error' : '' }}">
                                    <label class="control-label col-sm-3 required">{{ __('lang.Taggable') }}:</label>
                                    <div class="col-sm-9">
                                        <select name="taggable_id" id="taggable_id" class="form-control" required>
                                            <option value="">{{ __('lang.SelectField', ['field' => __('lang.Taggable')]) }}</option>
                                            @php ($taggable_id = old('taggable_id', isset($data) ? $data->taggable_id : ''))
                                            @foreach(['header', 'footer', 'hamburger'] as $pos)
                                                <option value="{{ $pos }}" {{ ($taggable_id == $pos) ? 'selected' : '' }}>{{ ucwords($pos) }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('taggable_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('taggable_id') }}</strong>
                                            </span>
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
                <div class="box-body table-responsive">
                    @foreach ($records as $item)
                    <h4 style="margin-top: 20px;">{{ ucwords($item->position) }}</h4>
                    <table class="table table-bordered main-table" id="parent-box-{{ $item->position }}">
                        <thead>
                            <tr>
                                <th class="td-drag">&nbsp;</th>
                                <th>{{ __('lang.Name') }}</th>
                                <th class="td-status">{{ __('lang.Status') }}</th>
                                <th class="td-action">{{ __('lang.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="child-box-{{ $item->position }}">
                            @foreach($item->positions as $val)
                            <tr class="parent-tr-{{ $item->position }}" data-id="{{ $val->id }}">
                                <td colspan="4">
                                    <table class="sub-table">
                                        <tbody>
                                        <tr>
                                            <td class="td-drag">
                                                <div class="parent-tr-drag-handle-{{ $item->position }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="drag">
                                                        <title>Drag</title>
                                                        <path
                                                            d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                                    </svg>
                                                </div>
                                            </td>
                                            <td>{{ $val->taggable->name_en }} / {{ $val->taggable->name_bn }}</td>
                                            <td class="td-status">{{ $val->status }}</td>
                                            <td class="td-status">
                                                <div class="dropdown">
                                                    <a class="btn btn-default btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">{{ __('lang.Action') }} <span class="caret"></span></a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        @can('show menu') 
                                                        <li><a href="{{ route('admin.menu.show', $val->id).qString() }}"><i class="fa fa-eye"></i> {{ __('lang.Show') }}</a></li>
                                                        @endcan
                                                        
                                                        @can('edit menu') 
                                                        <li><a href="{{ route('admin.menu.edit', $val->id).qString() }}"><i class="fa fa-pencil"></i> {{ __('lang.Edit') }}</a></li>
                                                        @endcan
                                                        
                                                        @can('delete menu') 
                                                        <li><a onclick="deleted('{{ route('admin.menu.destroy', $val->id).qString() }}')"><i class="fa fa-trash"></i> {{ __('lang.Delete') }}</a></li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>

                                        @if ($val->childs->count() > 0)
                                            <tbody>
                                            @foreach($val->childs as $chld)
                                            <tr class="child-tr-{{ $item->position }}" data-id="{{ $chld->id }}">
                                                <td class="td-drag">
                                                    <div class="child-tr-drag-handle-{{ $item->position }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="drag">
                                                            <title>Drag</title>
                                                            <path
                                                                d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                                        </svg>
                                                    </div>
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $chld->taggable->name_en }} / {{ $chld->taggable->name_bn }}</td>
                                                <td class="td-status">{{ $chld->status }}</td>
                                                <td class="td-status">
                                                    <div class="dropdown">
                                                        <a class="btn btn-default btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">{{ __('lang.Action') }} <span class="caret"></span></a>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            @can('show menu') 
                                                            <li><a href="{{ route('admin.menu.show', $chld->id).qString() }}"><i class="fa fa-eye"></i> {{ __('lang.Show') }}</a></li>
                                                            @endcan
                                                            
                                                            @can('edit menu') 
                                                            <li><a href="{{ route('admin.menu.edit', $chld->id).qString() }}"><i class="fa fa-pencil"></i> {{ __('lang.Edit') }}</a></li>
                                                            @endcan
                                                            
                                                            @can('delete menu') 
                                                            <li><a onclick="deleted('{{ route('admin.menu.destroy', $chld->id).qString() }}')"><i class="fa fa-trash"></i> {{ __('lang.Delete') }}</a></li>
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
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@if(isset($edit) || isset($create))
    @section('scripts')
    <script>
        const categories = {!! json_encode($categories) !!};
        const pages = {!! json_encode($pages) !!};
        
        function taggable() {
            let options = '';
            let type = $('#taggable_type').val();
            if (type == 'Page') {
                pages.forEach(page => {
                    options += `<option value="${page.id}">${page.name_en}</option>`;
                });
            } else if (type == 'Category') {
                categories.forEach(cat => {
                    options += `<option value="${cat.id}">${cat.name_en}</option>`;

                    if (cat.childs.length > 0) {
                        cat.childs.forEach(cld => {
                            options += `<option value="${cld.id}">&nbsp;&nbsp;&nbsp;- ${cld.name_en}</option>`;
                        });
                    }
                });
            }

            $('#taggable_id').html(options);
        }

        taggable();
    </script>
    @endsection
@elseif (isset($list))
    @section('scripts')
    <script>
    @foreach ($records as $item)
    $(function () {
        $("#parent-box-{{ $item->position }}").sortable({
            placeholder: 'sort-highlight',
            forcePlaceholderSize: true,
            axis: 'y',
            items: "tr.parent-tr-{{ $item->position }}",
            cursor: 'move',
            handle: '.parent-tr-drag-handle-{{ $item->position }}',
            opacity: 0.6,
            update: function () {
                const ids = [];

                $('tr.parent-tr-{{ $item->position }}').each(function (index, element) {
                    ids.push($(this).attr('data-id'));
                });

                sort(ids);
            }
        });

        $("#child-box-{{ $item->position }}").sortable({
            placeholder: 'sort-highlight',
            forcePlaceholderSize: true,
            axis: 'y',
            items: "tr.child-tr-{{ $item->position }}",
            cursor: 'move',
            handle: '.child-tr-drag-handle-{{ $item->position }}',
            opacity: 0.6,
            update: function () {
                const ids = [];

                $('tr.child-tr-{{ $item->position }}').each(function (index, element) {
                    ids.push($(this).attr('data-id'));
                });

                sort(ids);
            }
        });
    });
    @endforeach

    function sort(ids) {
        $.ajax({
            type: 'POST',
            dataType: "JSON",
            data: {ids: ids},
            url: "{{ route('admin.menu.sort') }}",
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
    </script>
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
@endif