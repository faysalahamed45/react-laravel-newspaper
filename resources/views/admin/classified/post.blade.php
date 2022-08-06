@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li {{ (isset($list)) ? 'class=active' : '' }}>
                <a href="{{ route('admin.classified.post.index').qString() }}">
                    <i class="fa fa-list" aria-hidden="true"></i> {{ __('lang.Post') }}
                </a>
            </li>

            @can('add post') 
            <li {{ (isset($create)) ? 'class=active' : '' }}>
                <a href="{{ route('admin.classified.post.create').qString() }}">
                    <i class="fa fa-plus" aria-hidden="true"></i> {{ __('lang.Post') }}
                </a>
            </li>
            @endcan

            @if (isset($edit))
            <li class="active">
                <a href="#">
                    <i class="fa fa-edit" aria-hidden="true"></i> {{ __('lang.Post') }}
                </a>
            </li>
            @endif

            @if (isset($show))
            <li class="active">
                <a href="#">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> {{ __('lang.Post') }}
                </a>
            </li>
            @endif
        </ul>

        <div class="tab-content">
            @if(isset($show))
            <div class="tab-pane active">
                <div class="box-body table-responsive">
                    <div class="post">
                        <div class="user-block">
                            <a href="javascript:void(0);">{{ $data->category != null ? $data->category->name_en . ' / ' . $data->category->name_bn : '-' }}</a>
                            <div>{{ __('lang.Publish Date') }} - {{ dateFormat($data->published_date) }} | {{ __('lang.Editor') }} - {{ $data->editor != null ? $data->editor->name : 'N/A' }} | {{ __('lang.Status') }} - {{ $data->status }}</div>
                        </div>
                        
                        {!! $data->content_en !!}

                        <hr >
                        
                        {!! $data->content_bn !!}

                        <hr >
                        <div class="user-block">
                            <div>{{ __('lang.Expire Date') }} - {{ dateFormat($data->expired_date) }} | {{ __('lang.Approve') }} - {{ $data->approved_at != null ? 'Yes: ' . dateFormat($data->approved_at, 1) : 'No' }} | {{ __('lang.Premium') }} - {{ $data->is_premium }}</div>
                        </div>
                    </div>
                </div>
            </div>

            @elseif(isset($edit) || isset($create))
            <div class="tab-pane active">
                <div class="box-body">
                    <form method="POST" action="{{ isset($edit) ? route('admin.classified.post.update', $edit) : route('admin.classified.post.store') }}{{ qString() }}" id="are_you_sure" enctype="multipart/form-data">
                        @csrf

                        @if (isset($edit))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                    <label class="required">{{ __('lang.Category') }}</label>
                                    <select name="category_id" class="form-control" required>
                                        <option value="">{{ __('lang.SelectField', ['field' => __('lang.Category')]) }}</option>
                                        @php ($category_id = old('category_id', isset($data) ? $data->category_id : ''))
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ ($category_id == $cat->id) ? 'selected' : '' }}>{{ $cat->name_en }} / {{ $cat->name_bn }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('category_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('published_date') ? ' has-error' : '' }}">
                                    <label class="required">{{ __('lang.Publish Date') }}:</label>
                                    <input type="text" class="form-control datepicker" name="published_date" value="{{ old('published_date', isset($data) ? $data->published_date : '') }}" required>

                                    @if ($errors->has('published_date'))
                                        <span class="help-block">{{ $errors->first('published_date') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('expired_date') ? ' has-error' : '' }}">
                                    <label>{{ __('lang.Expire Date') }}:</label>
                                    <input type="text" class="form-control datepicker" name="expired_date" value="{{ old('expired_date', isset($data) ? $data->expired_date : '') }}">

                                    @if ($errors->has('expired_date'))
                                        <span class="help-block">{{ $errors->first('expired_date') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('editor_id') ? ' has-error' : '' }}">
                                    <label>{{ __('lang.Editor') }}:</label>
                                    <select name="editor_id" class="form-control">
                                        <option value="">{{ __('lang.SelectField', ['field' => __('lang.Editor')]) }}</option>
                                        @php ($editor_id = old('editor_id', isset($data) ? $data->editor_id : Auth::user()->id))
                                        @foreach($admins as $adm)
                                            <option value="{{ $adm->id }}" {{ ($editor_id == $adm->id) ? 'selected' : '' }}>{{ $adm->name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('editor_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('editor_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                    <label class="required">{{ __('lang.Status') }}:</label>
                                    <select name="status" class="form-control" required>
                                        @php ($status = old('status', isset($data) ? $data->status : ''))
                                        @foreach(['Draft', 'Published'] as $sts)
                                            <option value="{{ $sts }}" {{ ($status == $sts) ? 'selected' : '' }}>{{ $sts }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('status'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('is_premium') ? ' has-error' : '' }}">
                                    <label class="required">{{ __('lang.Premium') }}:</label>
                                    <select name="is_premium" class="form-control" required>
                                        @php ($is_premium = old('is_premium', isset($data) ? $data->is_premium : ''))
                                        @foreach(['No', 'Yes'] as $pre)
                                            <option value="{{ $pre }}" {{ ($is_premium == $pre) ? 'selected' : '' }}>{{ $pre }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('is_premium'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('is_premium') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-success btn-flat btn-lg">{{ isset($edit) ? __('lang.Update') : __('lang.Create') }}</button>
                                    <button type="reset" class="btn btn-custom btn-flat btn-lg">{{ __('lang.Reset') }}</button>
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <div class="form-group{{ $errors->has('content_en') ? ' has-error' : '' }}">
                                    <label class="required">{{ __('lang.Content') }}({{ __('lang.En') }}):</label>
                                    <textarea class="form-control summernote" name="content_en" required>{{ old('content_en', isset($data) ? $data->content_en : '') }}</textarea>

                                    @if ($errors->has('content_en'))
                                        <span class="help-block">{{ $errors->first('content_en') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('content_bn') ? ' has-error' : '' }}">
                                    <label class="required">{{ __('lang.Content') }}({{ __('lang.Bn') }}):</label>
                                    <textarea class="form-control summernote" name="content_bn" required>{{ old('content_bn', isset($data) ? $data->content_bn : '') }}</textarea>

                                    @if ($errors->has('content_bn'))
                                        <span class="help-block">{{ $errors->first('content_bn') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @elseif (isset($list))
            <div class="tab-pane active">
                <form method="GET" action="{{ route('admin.classified.post.index') }}" class="form-inline">
                    <div class="box-header text-right">
                        <div class="row">
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="">{{ __('lang.AnyField', ['field' => __('lang.Status')]) }}</option>
                                    @foreach(['Draft', 'Published', 'Rejected'] as $sts)
                                        <option value="{{ $sts }}" {{ (Request::get('status') == $sts) ? 'selected' : '' }}>{{ $sts }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="{{ __('lang.SearchInputPlaceholder') }}">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-custom btn-flat"><i class="fa fa-search"></i></button>
                                <a class="btn btn-custom btn-flat" href="{{ route('admin.classified.post.index') }}"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover dataTable">
                        <thead>
                            <tr>
                                <th>{{ __('lang.Category') }}</th>
                                <th>{{ __('lang.Content') }}({{ __('lang.En') }})</th>
                                <th>{{ __('lang.Content') }}({{ __('lang.Bn') }})</th>
                                <th>{{ __('lang.Editor') }}</th>
                                <th>{{ __('lang.Publish Date') }}</th>
                                <th>{{ __('lang.Expire Date') }}</th>
                                <th>{{ __('lang.Premium') }}</th>
                                <th>{{ __('lang.Status') }}</th>
                                <th>{{ __('lang.ApprovedAt') }}</th>
                                <th class="col-action">{{ __('lang.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $val)
                            <tr>
                                <td>{{ $val->category != null ? $val->category->name_en .' / '. $val->category->name_bn : '-' }}</td>
                                <td>{{ excerpt($val->content_en) }}</td>
                                <td>{{ excerpt($val->content_bn) }}</td>
                                <td>{{ $val->editor != null ? $val->editor->name : 'N/A' }}</td>
                                <td>{{ dateFormat($val->published_date) }}</td>
                                <td>{{ dateFormat($val->expired_date) }}</td>
                                <td>{{ $val->is_premium }}</td>
                                <td>{{ $val->status }}</td>
                                <td>{{ $val->approved_at }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-default btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">{{ __('lang.Action') }} <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            @can('approve post') 
                                            <li><a onclick="activity('{{ route('admin.classified.post.approve', $val->id).qString() }}')"><i class="fa fa-check"></i> {{ __('lang.Approve') }}</a></li>
                                            @endcan

                                            @can('show post') 
                                            <li><a href="{{ route('admin.classified.post.show', $val->id).qString() }}"><i class="fa fa-eye"></i> {{ __('lang.Show') }}</a></li>
                                            @endcan

                                            @can('edit post') 
                                            <li><a href="{{ route('admin.classified.post.edit', $val->id).qString() }}"><i class="fa fa-pencil"></i> {{ __('lang.Edit') }}</a></li>
                                            @endcan

                                            @can('delete post') 
                                            <li><a onclick="deleted('{{ route('admin.classified.post.destroy', $val->id).qString() }}')"><i class="fa fa-trash"></i> {{ __('lang.Delete') }}</a></li>
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