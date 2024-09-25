
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

    <form action="{{ route('books.index') }}" method="GET">
        <div class="flex items-center">
        <label for="search_title" class="fond-bold text-xl mb-4">Search Book by title:</label>
        <input type="text" name="search" placeholder="Search by title..." value="{{ request('search') }}">
        <button type="submit" class="sp btn-primary">Search</button>
        </div>
    </form>

    <div class="grid grid-cols-2 gap-6">
        @foreach ($books as $book)
        <div class="card">
            <h2 class="fond-bold text-xl">{{$book->title}}</h2>
            <div class="text-xs font-light mb-4">
                <span>Author</span>
                <p class="text-blue-500 font-medium">{{$book->author}}</p>
            </div>

            <div class="text-xs font-light mb-4">
                <span>Genre</span>
                <p class="text-blue-500 font-medium">{{$book->genre->name}}</p>
            </div>

            <div class="text-sm font-light mb-4">
                <span>Description:</span>
                <p class="text-blue-500 font-medium">  {{ Str::words($book->description,10) }}</p>
            </div>

            @if(Auth::user() && Auth::user()->role =='student')
            <a href="/loans/userBorrowed/{{$book->book_id}}" class="sp btn-loan">Borrow</a>
            @endif

            <a href="/books/{{$book->book_id}}" class="sp btn-primary">View</a>
          

           @if(Auth::user() && Auth::user()->role !='student')

               <a href="/books/{{$book->book_id}}/edit" class="sp btn-secondry">Update</a>
               <form method="post"  action="/books/{{ $book->book_id }}" style="display: inline;">
                   @method('DELETE')
                   @csrf
                   <input type="submit" value="Delete" name="Delete" class='sp btn-danger' style="display: inline;" >
           
               </form>
           
           @endif
        </div>
        @endforeach
    </div>

    <div>
        {{ $books->links() }}

    </div>

   
   
            
      
   
</x-layout>
