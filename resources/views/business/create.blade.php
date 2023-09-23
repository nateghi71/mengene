<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ایجاد محصول جدید') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="text-align: right">
                <div class="p-6 bg-white border-b border-gray-200" style="text-align: right">


                    <form action="{{route('business.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="name">نام:</label>
                            <input type="text" name="name"
                                   value="{{old('name')}}">
                            @error('name')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="en_name">نام انگلیسی: </label>
                            <input type="text" name="en_name" value="{{old('en_name')}}">
                            @error('en_name')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="city">شهر:</label>
                            <input type="text" name="city" value="{{old('city')}}">
                            @error('city')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="area">منطقه:</label>
                            <input type="text" name="area" value="{{old('area')}}">
                            @error('area')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="address">آدرس:</label>
                            <textarea name="address" style="width: 500px; height: 150px">
                                {{old('address')}}
                            </textarea>
                            @error('address')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <label for="image">عکس:</label>
                            <input type="file" name="image" id="imageInput">
                            @error('image')
                            <div>{{$message}}</div> @enderror
                        </div>
                        <div>
                            <img id="imagePreview" src="#" alt="Preview" style="max-width: 200px;">
                        </div>
                        <br>

                        <div>
                            <button type=" submit">ذخیره</button>
                        </div>
                    </form>

                </div>
                <a href="{{route('business.index')}}">بازگشت</a>

            </div>
        </div>
    </div>
    <script>
        // Get the file input element
        const imageInput = document.getElementById('imageInput');

        // Get the image preview element
        const imagePreview = document.getElementById('imagePreview');

        // Add an event listener to the file input field
        imageInput.addEventListener('change', function () {
            // Check if a file is selected
            if (this.files && this.files[0]) {
                const reader = new FileReader();

                // Set the image source to the selected file
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                };

                // Read the selected file as a data URL
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>

</x-app-layout>
