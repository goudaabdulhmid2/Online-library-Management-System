
<x-layout>

    @if (session('error'))
        <div class="mb-2">
            <x-flashMsg msg="{{session('error')}}"  bg="bg-red-500"/>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-2">
            <x-flashMsg msg="{{session('success')}}" />
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        
        <div class="card">
            <h2 class="fond-bold text-xl">{{$book->title}}</h2>
            <div class="text-xs font-light mb-4">
                <span>Author</span>
                <p class="text-blue-500 font-medium">{{$book->author}}</p>
            </div>

            <div class="text-xs font-light mb-4">
                <span>Available</span>
                <p class="text-blue-500 font-medium">
                    {{ $book->quantity > 0 ? $book->quantity : 'Not available' }}
                </p>
            </div>
            

            <div class="text-xs font-light mb-4">
                <span>Genre</span>
                <p class="text-blue-500 font-medium">{{$book->genre->name}}</p>
            </div>

            <div class="text-sm font-light mb-4">
                <span>Description:</span>
                <p>  {{ $book->description }}</p>
            </div>

            @if(Auth::user() && Auth::user()->role =='student')
             <a href="/books/{{$book->book_id}}" class="sp btn-loan">Borrow</a>
            @endif

            @if(Auth::user() && Auth::user()->role !='student')

                <div class="text-xs font-light mb-4">
                    <span>Borrowed</span>
                    <p class="text-blue-500 font-medium">
                        {{$book->borrowed}}
                    </p>
                </div>

                <div class="text-xs font-light mb-4">
                    <span>Created at</span>
                    <p class="text-blue-500 font-medium">
                        {{$book->created_at}}
                    </p>
                </div>

                <a href="/books/{{$book->book_id}}/edit" class="sp btn-secondry">Update</a>
                <form method="post"  action="/books/{{ $book->book_id }}" style="display: inline;">
                    @method('DELETE')
                    @csrf
                    <input type="submit" value="Delete" name="Delete" class='sp btn-danger' style="display: inline;" >
            
                </form>
            
            @endif

        </div>

        @if(!Auth::check())

        <h2 class="fond-bold text-xl" style="color: red">Register to you can borrow</h2>

        @endif


    </div>


             
</x-layout>
