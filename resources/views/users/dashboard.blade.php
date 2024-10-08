
<x-layout>

    @if (session('success'))
            <div class="mb-2">
                <x-flashMsg msg="{{session('success')}}" />
            </div>
        @endif

    @if (session('error'))
        <div class="mb-2">
            <x-flashMsg msg="{{session('error')}}"  bg='bg-red-500'/>
        </div>
    @endif


    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'manager')


        {{--Users --}}
        <div class="grid grid-cols-2 gap-6">

            <div class="card">
                <h2 class="fond-bold text-xl">Users</h2>
                <div class="text-xs font-light mb-4">
                    <span>Number of users</span>
                    <p class="text-blue-500 font-medium">{{$usersCount}}</p>
                </div>

                <div class="text-xs font-light mb-4">
                    <span>Number of admins</span>
                    <p class="text-blue-500 font-medium">{{$adminsCount}}</p>
                </div>

                <div class="text-xs font-light mb-4">
                    <span>Number of students</span>
                    <p class="text-blue-500 font-medium">{{$studentsCount}}</p>
                </div>

                <a href="/users/create" class="sp btn-primary">Add new User</a>
                <a href="/users" class="sp btn-secondry">View</a>
            </div>


        {{--Books --}}
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
                        <span>Number of active borrowed books</span>
                        <p class="text-blue-500 font-medium">{{$borrowedBooksActiveCount}}</p>
                    </div>

                    <a href="/books/create" class="sp btn-primary">Add new book</a>
                    <a href="/books" class="sp btn-secondry">View</a>
                </div>


                {{--Genres --}}
                <div class="card">
                    <h2 class="fond-bold text-xl">Genres</h2>

                    <div class="text-xs font-light mb-4">
                        <span>Number of genres</span>
                        <p class="text-blue-500 font-medium">{{$genreCount}}</p>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>

                    <a href="/genres/create" class="sp btn-primary">Add new genre</a>
                    <a href="/genres" class="sp btn-secondry">View</a>

                </div>

                    {{-- loans --}}
                    <div class="card">
                        <h2 class="fond-bold text-xl">Borrowed books</h2>
                        <div class="text-xs font-light mb-4">
                            <span>Number of borrowed books</span>
                            <p class="text-blue-500 font-medium">{{$borrowedBooksActiveCount}}</p>
                        </div>
        
                        <div class="text-xs font-light mb-4">
                            <span>Number of books avliable to borrowed </span>
                            <p class="text-blue-500 font-medium">{{$booksAvliableToBorrowed}}</p>
                        </div>
        
                        <br>
                        <br>
                        <a href="/loans/create" class="sp btn-primary">Add new loan</a>
                        <a href="/loans" class="sp btn-secondry">View</a>
                    </div>
        

            
        

        </div>
   
    @endif

    @if(Auth::user()->role === 'student')

        <form action="{{ route('dashboard') }}" method="GET">
            <div class="flex items-center">
            <label for="search_id" class="fond-bold text-xl mb-4">Search borrowed book by title:</label>
            <input type="text" name="search" placeholder="Search by title..." value="{{ request('search') }}">
            <button type="submit" class="sp btn-primary">Search</button>
            </div>
        </form>

    
        <div class="grid grid-cols-2 gap-6">
            @foreach ($userBorrows as $borrow)
                <div class="card">
                    <div class="fond-bold text-xl mb-4">
                        <span>Book</span>
                        <p class="text-blue-500 font-medium">{{$borrow->book->title}}</p>
                    </div>

                    <div class="fond-bold text-xl mb-4">
                        <span>Status</span>
                        <p class="text-blue-500 font-medium">{{$borrow->loan_status}}</p>
                    </div>

                    
                

                    @if($borrow->loan_status !== 'returned')            
                        <div class="fond-bold text-xl mb-4">
                            <span>remaining days to returned</span>
                            <p class="text-blue-500 font-medium">{{ $borrow->remainingDays>0 ? "$borrow->remainingDays days" :'Time come to returned book.'}}</p>
                        </div>
                    @else
                        <div class="fond-bold text-xl mb-4">
                            <span>returned date</span>
                            <p class="text-blue-500 font-medium">{{$borrow->return_date}} </p>
                        </div>
                    @endif
                    


                    <a href="/loans/user/{{$borrow->loan_id}}" class="sp btn-primary">View</a>

                    @if($borrow->loan_status == 'active') 

                        <form action="/loans/user/{{$borrow->loan_id}}" method="post" style="display: inline;">
                            @method('PATCH')
                            @csrf
                            
                            <button class="sp btn-secondry">Returned</button>
        
                        </form>

                    @endif

                </div>
            @endforeach
        </div>

        <div>
            {{ $userBorrows->links() }}

        </div>




    @endif
    
   
   
</x-layout>
