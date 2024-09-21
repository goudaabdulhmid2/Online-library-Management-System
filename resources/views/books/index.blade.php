
<x-layout>

    <div class="grid grid-cols-2 gap-6">
        @foreach ($books as $book)
        <div class="card">
            <h2 class="fond-bold text-xl">{{$book->title}}</h2>
            <div class="text-xs font-light mb-4">
                <span>Author</span>
                <p class="text-blue-500 font-medium">{{$book->author}}</p>
            </div>

            <div class="text-xs font-light mb-4">
                <span>Quantity</span>
                <p class="text-blue-500 font-medium">{{$book->quantity}}</p>
            </div>

            <div class="text-xs font-light mb-4">
                <span>Genre</span>
                <p class="text-blue-500 font-medium">{{$book->genre->name}}</p>
            </div>

            <div class="text-sm font-light mb-4">
                <span>Description:</span>
                <p>  {{ Str::words($book->description,10) }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div>
        {{ $books->links() }}

    </div>

   
   
            
      
   
</x-layout>
