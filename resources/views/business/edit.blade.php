<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="text-align: right">
            {{ __('ویرایش بیزینس') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="text-align: right">
                <div class="p-6 bg-white border-b border-gray-200"
                     style="text-align: right;">
                    {{--                    {{dd($business)}}--}}
                    <form action="{{route('business.update',$business->id)}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="name">نام:</label>
                            <input type="text" name="name"
                                   value="{{$business->name}}">
                            @error('name')
                            <div>{{$message}}</div> @enderror
                        </div>

                        <label for="en_name">نام انگلیسی: </label>
                        <input type="text" name="en_name" value="{{$business->en_name}}">
                        @error('en_name')
                        <div>{{$message}}</div> @enderror
                        <div>
                            <label for="city">شهر:</label>
                            <input type="text" name="city" value="{{$business->city}}">
                            @error('city')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="area">منطقه:</label>
                            <input type="text" name="area" value="{{$business->area}}">
                            @error('area')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="address">آدرس:</label>
                            <textarea name="address" style="width: 500px; height: 150px">
                               {{$business->address}}
                            </textarea>
                            @error('address')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="image">عکس مجوز:</label>
                            @if($business->image)
                                <img src="{{ $business->image }}" id="oldImagePreview"
                                     style="max-width: 80%; height: 400px">
                            @else
                                <img src="#" id="oldImagePreview" style="display: none; max-width: 80%; height: 400px">
                            @endif
                            <input type="file" name="image" id="imageInput">
                            @error('image')
                            <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <img id="newImagePreview" src="#" alt="Preview"
                                 style="max-width: 80%; height: 400px; display: none;">
                        </div>
                        <div>
                            <div>
                                <button type="submit">ذخیره</button>
                            </div>
                        </div>
                    </form>
                </div>
                <br>
                <a href="{{route('business.index')}}">بازگشت</a>

            </div>
        </div>
    </div>
    <script>
        // Get the file input element
        const imageInput = document.getElementById('imageInput');

        // Get the image preview elements
        const oldImagePreview = document.getElementById('oldImagePreview');
        const newImagePreview = document.getElementById('newImagePreview');

        // Set the existing image source as the initial preview
        oldImagePreview.style.display = 'block';

        // Add an event listener to the file input field
        imageInput.addEventListener('change', function () {
            // Check if a file is selected
            if (this.files && this.files[0]) {
                const reader = new FileReader();

                // Set the new image source to the selected file
                reader.onload = function (e) {
                    newImagePreview.src = e.target.result;
                    newImagePreview.style.display = 'block';
                    oldImagePreview.style.display = 'none';
                };

                // Read the selected file as a data URL
                reader.readAsDataURL(this.files[0]);
            } else {
                // No file selected, reset the new image preview
                newImagePreview.src = '';
                newImagePreview.style.display = 'none';
                oldImagePreview.style.display = 'block';
            }
        });
    </script>
</x-app-layout>
