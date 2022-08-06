@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li {{ (isset($list)) ? 'class=active' : '' }}>
                <a href="{{ route('admin.page.index').qString() }}">
                    <i class="fa fa-list" aria-hidden="true"></i> {{ __('lang.Page') }}
                </a>
            </li>

            @can('add page') 
            <li {{ (isset($create)) ? 'class=active' : '' }}>
                <a href="{{ route('admin.page.create').qString() }}">
                    <i class="fa fa-plus" aria-hidden="true"></i> {{ __('lang.Page') }}
                </a>
            </li>
            @endcan

            @if (isset($edit))
            <li class="active">
                <a href="#">
                    <i class="fa fa-edit" aria-hidden="true"></i> {{ __('lang.Page') }}
                </a>
            </li>
            @endif

            @if (isset($show))
            <li class="active">
                <a href="#">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> {{ __('lang.Page') }}
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
                            <th>{{ __('lang.Content') }}({{ __('lang.En') }})</th>
                            <th>:</th>
                            <td>{!! $data->content_en !!}</td>
                        </tr>
                        <tr>
                            <th>{{ __('lang.Content') }}({{ __('lang.Bn') }})</th>
                            <th>:</th>
                            <td>{!! $data->content_bn !!}</td>
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
                    <form method="POST" action="{{ isset($edit) ? route('admin.page.update', $edit) : route('admin.page.store') }}{{ qString() }}" id="are_you_sure" class="form-horizontal" enctype="multipart/form-data">
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

                                <div class="form-group{{ $errors->has('content_en') ? ' has-error' : '' }}">
                                    <label class="control-label col-sm-3 required">{{ __('lang.Content') }}({{ __('lang.En') }}):</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control summernote" name="content_en" required>{{ old('content_en', isset($data) ? $data->content_en : '') }}</textarea>

                                        @if ($errors->has('content_en'))
                                            <span class="help-block">{{ $errors->first('content_en') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('content_bn') ? ' has-error' : '' }}">
                                    <label class="control-label col-sm-3 required">{{ __('lang.Content') }}({{ __('lang.Bn') }}):</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control summernote" name="content_bn" required>{{ old('content_bn', isset($data) ? $data->content_bn : '') }}</textarea>

                                        @if ($errors->has('content_bn'))
                                            <span class="help-block">{{ $errors->first('content_bn') }}</span>
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
                <form method="GET" action="{{ route('admin.page.index') }}" class="form-inline">
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
                                <a class="btn btn-custom btn-flat" href="{{ route('admin.page.index') }}"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover dataTable">
                        <thead>
                            <tr>
                                <th>{{ __('lang.Name') }}({{ __('lang.En') }})</th>
                                <th>{{ __('lang.Name') }}({{ __('lang.Bn') }})</th>
                                <th>{{ __('lang.Content') }}({{ __('lang.En') }})</th>
                                <th>{{ __('lang.Content') }}({{ __('lang.Bn') }})</th>
                                <th>{{ __('lang.Status') }}</th>
                                <th class="col-action">{{ __('lang.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $val)
                            <tr>
                                <td>{{ $val->name_en }}</td>
                                <td>{{ $val->name_bn }}</td>
                                <td>{{ excerpt($val->content_en) }}</td>
                                <td>{{ excerpt($val->content_bn) }}</td>
                                <td>{{ $val->status }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-default btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">{{ __('lang.Action') }} <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            @can('show page') 
                                            <li><a href="{{ route('admin.page.show', $val->id).qString() }}"><i class="fa fa-eye"></i> {{ __('lang.Show') }}</a></li>
                                            @endcan

                                            @can('edit page') 
                                            <li><a href="{{ route('admin.page.edit', $val->id).qString() }}"><i class="fa fa-pencil"></i> {{ __('lang.Edit') }}</a></li>
                                            @endcan

                                            @can('delete page') 
                                            <li><a onclick="deleted('{{ route('admin.page.destroy', $val->id).qString() }}')"><i class="fa fa-trash"></i> {{ __('lang.Delete') }}</a></li>
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