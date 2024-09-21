
<x-layout>

    @if (Auth::user()->role == 'admin')

        

        @if (session('success'))
            <div class="mb-2">
                <x-flashMsg msg="{{session('success')}}" />
            </div>
        @endif
       
         <div class="grid grid-cols-2 gap-6">
        <div class="card">
            <h2 class="fond-bold text-xl">books</h2>
            <div class="text-xs font-light mb-4">
                <span>Number of books</span>
                <p class="text-blue-500 font-medium">{{$bookCount}}</p>
            </div>

            <div class="text-xs font-light mb-4">
                <span>Number of genres</span>
                <p class="text-blue-500 font-medium">{{$genreCount}}</p>
            </div>

            <div class="text-xs font-light mb-4">
                <span>Number of active loans</span>
                <p class="text-blue-500 font-medium">{{$activeLoansCount}}</p>
            </div>

            <a href="/books/create" class="sp btn-primary">Add new book</a>
    </div>
   
    @endif

    
   
   
</x-layout>
