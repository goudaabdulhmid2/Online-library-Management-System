<x-layout>

    <div class="card mb-4">
    <h2 class="font-bold mb-4">Update {{$book->title}} book</h2>

    <form action="/books/{{$book->book_id}}" method="post">
        @method('PATCH')
        @csrf

        <div class="mb-4">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{$book->title}}"class='input  @error('title') ring-red-500 @enderror'>

            @error('title')
             <p class="error">{{$message}}</p> 
            @enderror

        </div>

        <div class="mb-4">
            <label for="author">Author</label>
            <input type="text" name="author" id="author" value="{{$book->author}}"class='input  @error('author') ring-red-500 @enderror'>

            @error('author')
             <p class="error">{{$message}}</p> 
            @enderror

        </div>

        <div class="mb-4">
            <label for="description">Description</label>

            <textarea name="description" rows="5" class='input  @error('description') ring-red-500 @enderror'>{{$book->description}}</textarea>


            @error('description')
             <p class="error">{{$message}}</p> 
            @enderror

        </div>


        <div class="mb-4">
            <label for="genre_id">Select Genre</label>
            <select class="form-control" id="genre_id" name="genre_id" class='input  @error('genre_id') ring-red-500 @enderror'>
                <option value="">Choose a Genre</option>
                @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" {{ $book->genre_id == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                @endforeach
            </select>
            
            @error('genre_id')
             <p class="error">{{$message}}</p> 
            @enderror

        </div>

        <div class="mb-4">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" value="{{$book->quantity}}"class='input  @error('quantity') ring-red-500 @enderror'>

            @error('quantity')
             <p class="error">{{$message}}</p> 
            @enderror

        </div>

        <button class="btn">Update</button>
       
      
    </form>
</div>

</x-layout>
