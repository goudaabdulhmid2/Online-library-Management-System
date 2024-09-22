
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

    <!-- Search Form -->
    <form action="{{ route('users.index') }}" method="GET" class="mb-4">
        <div class="flex items-center">
            <label for="search_id" class="fond-bold text-xl mb-4">Search User by ID:</label>
            <input type="text" id="search_id" name="search_id" value="{{ request('search_id') }}" placeholder="Enter user ID" class="border border-gray-300 rounded p-2">
            <button type="submit" class="sp btn-primary">Search</button>
        </div>
    </form>


    <!-- Display Users -->
    <div class="grid grid-cols-2 gap-6">
        @foreach ($users as $user)
        <div class="card">
            <div class="fond-bold text-xl mb-4">
                <span>Username</span>
                <p class="text-blue-500 font-medium">{{$user->username}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Email</span>
                <p class="text-blue-500 font-medium">{{$user->email}}</p>
            </div>

            <a href="/users/{{$user->id}}" class="sp btn-primary">View</a>
            <a href="/users/{{$user->id}}/edit" class="sp btn-secondry">Update</a>
            <form method="post"  action="/users/{{ $user['id'] }}" style="display: inline;">
                @method('DELETE')
                @csrf
                <input type="submit" value="Delete" name="Delete" class='sp btn-danger' style="display: inline;" >
        
            </form>

        </div>
        @endforeach
    </div>

    <div>
        {{ $users->links() }}

    </div>

   
   
            
      
   
</x-layout>
