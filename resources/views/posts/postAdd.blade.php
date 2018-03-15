@extends('Ripple::layouts.beta-app')
@section('page-title') New Blog Post @stop
@section('buttons') 
<div class="buttons">
    <a href="{!! route('Ripple::adminPostIndex') !!}" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> List Posts</a>
</div>
@stop
@section('page-content')
<div class="container-fluid p-3 mt-3">
    
    <form action="" method="post" enctype="Multipart/form-data">
        {!! csrf_field() !!}
        <input type="hidden" value="zzz" name="post-create">
        <input type="hidden" value="post" name="post-type">
        <input type="hidden" value="1" name="post-author">
        <div class="row">
            <div class="col-md-8">
                <div class="card rounded-0">
                    <div class="card-header"><i class="far fa-file-alt"></i> Post Content</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Post Title: </label>
                            <input type="text" name="post-title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Post Content</label>
                            <textarea type="text" name="post-content" class="form-control ripple_text_editor" rows="11"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Post Excerpt</label>
                            <textarea name="post-excerpt" class="form-control" id="" rows="4" placeholder="Excerpt"></textarea>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card rounded-0 mb-3">
                    <div class="card-header"><i class="fas fa-cog"></i> Post Settings</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Post Comments</label>
                                    <select name="post-comments" id="" class="custom-select">
                                        <option value="open">Open</option>
                                        <option value="closed">Closed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Post Visibility</label>
                                    <select name="post-visibility" id="" class="custom-select">
                                        <option value="public">Public</option>
                                        <option value="private">Private</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Post Tags</label>
                                    <select name="post-tag[]" multiple class="custom-select multipleSelect tags">
                                    @foreach(Ripple::allTags() as $tag)
                                        <option value="{!! $tag->name !!}">{!! $tag->name !!}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Post Categories</label>
                                    <select name="post-category[]" multiple class="custom-select categories multipleSelect">
                                        @foreach(Ripple::allCategories() as $category)
                                            <option value="{!! $category->name !!}">{!! $category->name !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        
                        

                        
                        <div class="form-group">
                            <label for="">Post Status</label>
                            <select name="post-status" id="" class="custom-select">
                                <option value="publish">Publish</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        
                        
                        
                        <input type="submit" name="post-status" value="draft" class="text-capitalize col btn btn-default btn-sm">
                        <input type="submit" name="post-status" value="publish" class="text-capitalize col btn btn-primary btn-sm">
                    </div>
                </div>
                <div class="card rounded-0">
                    <div class="card-header"><i class="fa fa-image" style="font-size: 18px"></i> Featured Image</div>
                    <div class="card-body">
                        <div class="clearfix" id="featured-image">
                            <img class="w-100" src="{!! ripple_asset('/img/default/default.png') !!}" alt="" width="200" height="200">
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="custom-file">
                            <input class="image-preview custom-file-input" name="post-image" id="post-image" data-preview="featured-image" data-width="100%" data-height="200" type="file">
                            <label class="custom-file-label" for="post-image">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@stop
@push('page-script') 
<link rel="stylesheet" href="{!! ripple_asset('/lib/css/select2/select2.min.css') !!}"/>
<script src="{!! ripple_asset('/lib/js/select2/select2.min.js') !!}" type="text/javascript" charset="utf-8"></script>
<script src="{!! ripple_asset('/lib/js/slimscroll/slimscroll.min.js') !!}" type="text/javascript" charset="utf-8"></script>
<script src="{!! ripple_asset('/lib/js/ace/ace.js') !!}" type="text/javascript" charset="utf-8"></script>
<script>
    

    $(".select2_demo_3").select2({
        placeholder: "Select a state",
        allowClear: false
    });
    $(".tags.multipleSelect").select2({
        placeholder: "Tags",
        allowClear: true
    });
    $('.categories.multipleSelect').select2({
        placeholder: "Categories",
        allowClear: true
    });
</script>
@endpush