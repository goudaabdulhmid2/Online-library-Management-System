
<x-layout>

    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')

        

        @if (session('success'))
            <div class="mb-2">
                <x-flashMsg msg="{{session('success')}}" />
            </div>
        @endif

        @if (session('error'))
            <div class="mb-2">
                <x-flashMsg msg="{{session('error')}}" />
            </div>
        @endif

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
                    <span>Number of active loans</span>
                    <p class="text-blue-500 font-medium">{{$activeLoansCount}}</p>
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

         
        


    </div>
   
    @endif

    
   
   
</x-layout>
