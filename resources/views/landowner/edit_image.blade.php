@extends('layouts.dashboard' , ['sectionName' => 'ویرایش عکس ملک'])

@section('title' , 'ویرایش عکس ملک')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
<script>
    $('#delete_image button').on('click' , {url:"{{route("landowner.delete_image")}}"} , changeImages)
    $('#form_add_image #add_image').on('change' , {url:"{{route("landowner.add_image")}}"} , changeImages)

    function changeImages(e){
        e.preventDefault();
        let formData = new FormData(this.form)
        $.ajax({
            method:"post",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:e.data.url,
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache:false,
            success:function (response){
                console.log(response)
                $('#form_add_image').trigger("reset");
                let addedImages = '';
                $('#show-images').children().remove();
                response.images.forEach(function (image){
                    let primary = (image.is_primary === 1) ? 'border border-3 border-primary' : ''
                    addedImages += addNewImageToPage(image.image , primary , image.id , image.landowner_id)
                });
                $('#show-images').append(addedImages);

                $('#delete_image button').on('click' , {url:"{{route("landowner.delete_image")}}"} , changeImages)
            },
            error:function (xhr, ajaxOptions, thrownError){
                console.log("error: " + xhr.status)
            },
        })
    }

    function addNewImageToPage(image_name , primary , image_id , landowner_id)
    {
        let html = '<div class="col-md-3 '+ primary +'">'+
            '<div class="card bg-dark mb-3">'+
            '<img width="100" height="170" class="card-img-top" src="{{url(env('LANDOWNER_IMAGES_UPLOAD_PATH'))}}' + '/' + image_name +'">'+
            '<div class="card-body text-center">'+
            '<form action="{{route("landowner.delete_image")}}" method="post" id="delete_image">'+
            '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
            '<input type="hidden" name="image_id" value="' + image_id + '">'+
            '<input type="hidden" name="landowner_id" value="' + landowner_id + '">'+
            '<button class="btn btn-danger btn-sm mb-2 w-100"  type="button" ">حذف</button>'+
            '</form>'+
            '</div>'+
            '</div>'+
            '</div>';
        return html;
    }
</script>
@endsection

@section('content')
    <div class="card row">
        <div class="card-body px-5 py-4">
            <div class="d-flex justify-content-between">
                <div><h3 class="card-title mb-3">ویرایش عکس ملک</h3></div>
                <div><a href="{{route('landowner.index')}}" class="btn btn-primary p-2">نمایش مالکان</a></div>
            </div>
            <hr>
            <div class="row m-4">
                <form action="{{route("landowner.add_image")}}" id="form_add_image" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="landowner_id" value="{{ $landowner->id }}">
                    <input type="file" name="add_image" id="add_image" class="d-none" />
                    <button type="button" onclick="$('#add_image').click();" class="btn btn-success w-100">
                        اضافه کردن عکس
                    </button>
                </form>
            </div>

            <div class="mx-5 row" id="show-images">
                @foreach ($landowner->images as $image)
                    <div @class(["col-md-3" , 'border border-3 border-primary' => $image->is_primary === 1])>
                        <div class="card bg-dark mb-3">
                            <img width="100" height="170" class="card-img-top" src="{{ url(env('LANDOWNER_IMAGES_UPLOAD_PATH') . $image->image) }}"
                                 alt="{{ $landowner->name }}">
                            <div class="card-body text-center">
                                <form action="{{route("landowner.delete_image")}}" method="post" id="delete_image">
                                    @csrf
                                    <input type="hidden" name="image_id" value="{{ $image->id }}">
                                    <input type="hidden" name="landowner_id" value="{{ $landowner->id }}">
                                    <button class="btn btn-danger btn-sm mb-2 w-100" type="button">حذف</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
