
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
                <p class="text-blue-500 font-medium">  {{ $book->description }}</p>
            </div>

            @if(Auth::user() && Auth::user()->role =='student')
             <a href="/loans/userBorrowed/{{$book->book_id}}" class="sp btn-loan">Borrow</a>
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
    <br>
     {{-- users who have borrowed this book --}}
     @if(Auth::user() && Auth::user()->role !='student')

        @if ($loans->count() > 0)
            
            
            <h2 class="font-bold mb-4"> users who still borrowed this book</h2>


            <div class="grid grid-cols-2 gap-6">
                @foreach ($loans as $loan)
                    {{-- Post card component --}}
                    <x-usersCard :user="$loan->user">

                        <div class="flex items-center justify-end gap-4 mt-6">
                            {{-- Update view --}}
                            <a href="/users/{{$loan->user->id}}"
                                class="bg-blue-500 text-white px-2 py-1 text-xs rounded-md">View</a>
                        </div>
                    </x-usersCard>
                @endforeach
            </div>

            {{-- Pagination links --}}
            <div>
                {{ $loans->links() }}
            </div>
        @else
            <h2 class="font-bold mb-4">No user borrowed this book yet</h2>
            
        @endif
 
    @endif

 


             
</x-layout>
