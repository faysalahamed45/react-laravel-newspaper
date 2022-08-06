@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li {{ (isset($list)) ? 'class=active' : '' }}>
                <a href="{{ route('admin.post.index').qString() }}">
                    <i class="fa fa-list" aria-hidden="true"></i> {{ __('lang.Post') }}
                </a>
            </li>

            @can('add post') 
            <li {{ (isset($create)) ? 'class=active' : '' }}>
                <a href="{{ route('admin.post.create').qString() }}">
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
                        <div class="row margin-bottom">
                            <div class="text-center">
                                <div>
                                {!! viewImg('posts/' . $data->id, $data->image, ['popup' => 1, 'fakeimg' => 'no-img']) !!}
                                </div>
                                @foreach ($data->medias as $img)
                                    {!! viewImg('posts/' . $data->id, $img->file_name, ['popup' => 1, 'fakeimg' => 'no-img', 'class' =>'img-medium']) !!}
                                @endforeach
                            </div>
                        </div>

                        <div class="user-block">
                            <a href="javascript:void(0);">{{ $data->category != null ? $data->category->name_en . ' / ' . $data->category->name_bn : '-' }}</a>
                            
                            @if($data->postCategories->count() > 0)
                            |
                                @foreach ($data->postCategories as $pck => $pcat)
                                {{ $pck != 0 ? ', ' : ''}}
                                <a href="javascript:void(0);">{{ $pcat->category != null ? $pcat->category->name_en . ' / ' . $pcat->category->name_bn : '-' }}</a>
                                @endforeach
                            @endif
                            <div>Publish Time - {{ dateFormat($data->published_at) }} | Editor - {{ $data->editor != null ? $data->editor->name : 'N/A' }} | Status - {{ $data->status }}</div>
                        </div>
                        
                        <h3><a target="_blank" href="{{ url('posts/' .$data->slug_en) }}">{{ $data->title_en }}</a></h3>
                        {!! $data->content_en !!}

                        <hr >
                        
                        <h3><a target="_blank" href="{{ url('posts/' .$data->slug_bn) }}">{{ $data->title_bn }}</a></h3>
                        {!! $data->content_bn !!}
                    </div>
                </div>
            </div>

            @elseif(isset($edit) || isset($create))
            <div class="tab-pane active">
                <div class="box-body">
                    <form method="POST" action="{{ isset($edit) ? route('admin.post.update', $edit) : route('admin.post.store') }}{{ qString() }}" id="are_you_sure" enctype="multipart/form-data">
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
                                            @foreach($cat->childs as $chld)
                                            <option value="{{ $chld->id }}" {{ ($category_id == $chld->id) ? 'selected' : '' }}>-- {{ $chld->name_en }} / {{ $chld->name_bn }}</option>
                                        @endforeach
                                        @endforeach
                                    </select>

                                    @if ($errors->has('category_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('category_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="form-group{{ $errors->has('other_categories') ? ' has-error' : '' }}">
                                    <label>{{ __('lang.Other Category') }}:</label>
                                    <select name="other_categories[]" class="form-control select2" multiple>
                                        @php ($other_categories = old('other_categories', $other_categories))
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ in_array($cat->id, $other_categories) ? 'selected' : '' }}>{{ $cat->name_en }} / {{ $cat->name_bn }}</option>
                                            @foreach($cat->childs as $chld)
                                            <option value="{{ $chld->id }}" {{ in_array($chld->id, $other_categories) ? 'selected' : '' }}>-- {{ $chld->name_en }} / {{ $chld->name_bn }}</option>
                                        @endforeach
                                        @endforeach
                                    </select>

                                    @if ($errors->has('other_categories'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('other_categories') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('video_url') ? ' has-error' : '' }}">
                                    <label>{{ __('lang.Video Url') }}:</label>
                                    <input type="url" class="form-control" name="video_url" value="{{ old('video_url', isset($data) ? $data->video_url : '') }}">

                                    @if ($errors->has('video_url'))
                                        <span class="help-block">{{ $errors->first('video_url') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                    <label>Image:</label>
                                    <input type="file" class="form-control" name="image">
                                    @if(isset($data))
                                    <small>{!! viewFile('posts/' . $data->id, $data->image) !!}</small>
                                    @endif
    
                                    @if ($errors->has('image'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Other Images:</label>
                                    <div id="imgBox">
                                        @foreach ($medias as $ik => $iv)
                                        <div class="imgBox" id="file_row_{{ $ik }}">
                                            <div class="input-group">
                                                <input type="hidden" name="image_ids[{{ $ik }}]" value="{{ $iv->id }}">
                                                <input type="file" class="form-control" name="medias[{{ $ik }}]">
                                                @if ($ik == 0)
                                                <span class="input-group-addon" onclick="addFilesRow({{ $ik }})"><i class="fa fa-plus"></i></span>
                                                @else
                                                <span class="input-group-addon" onclick="removeFilesRowAjax({{ $iv->id }}, {{ $ik }})"><i class="fa fa-minus"></i></span>
                                                @endif
                                            </div>
                                            @if(isset($data))
                                            <small>{!! viewFile('posts/' . $data->id, $iv->file_name) !!}</small>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('published_at') ? ' has-error' : '' }}">
                                    <label class="required">{{ __('lang.Publish Time') }}:</label>
                                    <input type="text" class="form-control datetimepicker" name="published_at" value="{{ old('published_at', isset($data) ? $data->published_at : '') }}" required>

                                    @if ($errors->has('published_at'))
                                        <span class="help-block">{{ $errors->first('published_at') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('editor_id') ? ' has-error' : '' }}">
                                    <label class="required">{{ __('lang.Editor') }}:</label>
                                    <select name="editor_id" class="form-control" required>
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

                                <div class="form-group">
                                    @foreach (['feature_post' => 'Feature Post', 'feature_post_2' => 'Second Feature Post', 'exclusive' => 'Exclusive'] as $k1 => $v1)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="{{ $k1 }}" value="1">
                                            {{ $v1 }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>                                

                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-success btn-flat btn-lg">{{ isset($edit) ? __('lang.Update') : __('lang.Create') }}</button>
                                    <button type="reset" class="btn btn-custom btn-flat btn-lg">{{ __('lang.Reset') }}</button>
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <div class="form-group{{ $errors->has('title_en') ? ' has-error' : '' }}">
                                    <label class="required">{{ __('lang.Title') }}({{ __('lang.En') }}):</label>
                                    <input type="text" class="form-control" name="title_en" value="{{ old('title_en', isset($data) ? $data->title_en : '') }}" required>

                                    @if ($errors->has('title_en'))
                                        <span class="help-block">{{ $errors->first('title_en') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('content_en') ? ' has-error' : '' }}">
                                    <label class="required">{{ __('lang.Content') }}({{ __('lang.En') }}):</label>
                                    <textarea class="form-control summernote" name="content_en" required>{{ old('content_en', isset($data) ? $data->content_en : '') }}</textarea>

                                    @if ($errors->has('content_en'))
                                        <span class="help-block">{{ $errors->first('content_en') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('title_bn') ? ' has-error' : '' }}">
                                    <label class="required">{{ __('lang.Title') }}({{ __('lang.Bn') }}):</label>
                                    <input type="text" class="form-control" name="title_bn" value="{{ old('title_bn', isset($data) ? $data->title_bn : '') }}" required>

                                    @if ($errors->has('title_bn'))
                                        <span class="help-block">{{ $errors->first('title_bn') }}</span>
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
                <form method="GET" action="{{ route('admin.post.index') }}" class="form-inline">
                    <div class="box-header text-right">
                        <div class="row">
                            <div class="form-group">
                                <select name="feature" class="form-control">
                                    <option value="">{{ __('lang.AnyField', ['field' => __('lang.Feature')]) }}</option>
                                    @foreach (['feature_post' => 'Feature Post', 'feature_post_2' => 'Second Feature Post', 'exclusive' => 'Exclusive'] as $k1 => $v1)
                                        <option value="{{ $k1 }}" {{ (Request::get('feature') == $k1) ? 'selected' : '' }}>{{ $v1 }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="">{{ __('lang.AnyField', ['field' => __('lang.Status')]) }}</option>
                                    @foreach(['Draft', 'Published', 'Rejected'] as $sts)
                                        <option value="{{ $sts }}" {{ (Request::get('status') == $sts) ? 'selected' : '' }}>{{ $sts }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="category" class="form-control">
                                    <option value="">{{ __('lang.AnyField', ['field' => __('lang.Category')]) }}</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ (Request::get('category') == $cat->id) ? 'selected' : '' }}>{{ $cat->name_en }} / {{ $cat->name_bn }}</option>
                                        @foreach($cat->childs as $chld)
                                            <option value="{{ $chld->id }}" {{ (Request::get('category') == $chld->id) ? 'selected' : '' }}>-- {{ $chld->name_en }} / {{ $chld->name_bn }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="{{ __('lang.SearchInputPlaceholder') }}">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-custom btn-flat"><i class="fa fa-search"></i></button>
                                <a class="btn btn-custom btn-flat" href="{{ route('admin.post.index') }}"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover dataTable">
                        <thead>
                            <tr>
                                <th>{{ __('lang.Category') }}</th>
                                <th>{{ __('lang.Title') }}({{ __('lang.En') }})</th>
                                <th>{{ __('lang.Title') }}({{ __('lang.Bn') }})</th>
                                <th>{{ __('lang.Content') }}({{ __('lang.En') }})</th>
                                <th>{{ __('lang.Content') }}({{ __('lang.Bn') }})</th>
                                <th>{{ __('lang.Editor') }}</th>
                                <th>{{ __('lang.Publish Time') }}</th>
                                <th>{{ __('lang.Status') }}</th>
                                <th>{{ __('lang.ApprovedAt') }}</th>
                                <th class="col-action">{{ __('lang.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $val)
                            <tr>
                                <td>{{ $val->category != null ? $val->category->name_en .' / '. $val->category->name_bn : '-' }}</td>
                                <td>{{ $val->title_en }}</td>
                                <td>{{ $val->title_bn }}</td>
                                <td>{{ excerpt($val->content_en) }}</td>
                                <td>{{ excerpt($val->content_bn) }}</td>
                                <td>{{ $val->editor != null ? $val->editor->name : 'N/A' }}</td>
                                <td>{{ dateFormat($val->published_at, 1) }}</td>
                                <td>{{ $val->status }}</td>
                                <td>{{ $val->approved_at }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-default btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">{{ __('lang.Action') }} <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            @can('approve post') 
                                            <li><a onclick="activity('{{ route('admin.post.approve', $val->id).qString() }}')"><i class="fa fa-check"></i> {{ __('lang.Approve') }}</a></li>
                                            @endcan

                                            @can('show post') 
                                            <li><a href="{{ route('admin.post.show', $val->id).qString() }}"><i class="fa fa-eye"></i> {{ __('lang.Show') }}</a></li>
                                            @endcan

                                            @can('edit post') 
                                            <li><a href="{{ route('admin.post.edit', $val->id).qString() }}"><i class="fa fa-pencil"></i> {{ __('lang.Edit') }}</a></li>
                                            @endcan

                                            @can('delete post') 
                                            <li><a onclick="deleted('{{ route('admin.post.destroy', $val->id).qString() }}')"><i class="fa fa-trash"></i> {{ __('lang.Delete') }}</a></li>
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

@if(isset($edit) || isset($create))

@section('styles')
<style>
    .imgBox {
        margin-bottom: 10px;
    }
</style>
@endsection

@section('scripts')
<script>
    function addFilesRow() {
        var k = $('#imgBox .imgBox').length;

        var html = `<div class="imgBox" id="file_row_${k}">
            <div class="input-group">
                <input type="hidden" name="image_ids[${k}]" value="0">
                <input type="file" class="form-control" name="medias[${k}]">
                <span class="input-group-addon" onclick="removeFilesRow(${k})"><i class="fa fa-minus"></i></span>
            </div>
        </div>`;
        $('#imgBox').append(html);
    }

    function removeFilesRow(k) {
        $('#file_row_' + k).remove();
    }

    function removeFilesRowAjax(id, k) {
        $.ajax({
            type: 'POST',
            dataType: "JSON",
            data: {id: id},
            url: "{{ route('admin.post.image-destory') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                if (res.success) {
                    $('#file_row_' + k).remove();
                }
                alert(res.message);
            },
            error: function (err) {
                alert(err.responseJSON.message);
            }
        });
    }
</script>
@endsection
@endif