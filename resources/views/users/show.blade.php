
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

    <div class="grid grid-cols-2 gap-6">
     
        <div class="card">
            <div class="fond-bold text-xl mb-4">
                <span>Username</span>
                <p class="text-blue-500 font-medium">{{$user['username']}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Email</span>
                <p class="text-blue-500 font-medium">{{$user->email}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Role</span>
                <p class="text-blue-500 font-medium">{{$user->role}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Created at:</span>
                <p class="text-blue-500 font-medium">{{$user->created_at->diffForHumans()}}</p>
            </div>
            <div class="fond-bold text-xl mb-4">
                <span>Updated at:</span>
                <p class="text-blue-500 font-medium">{{$user->updated_at->diffForHumans()}}</p>
            </div>

            <a href="/users/{{$user->id}}/edit" class="sp btn-secondry">Update</a>
            <form method="post"  action="/users/{{ $user['id'] }}" style="display: inline;">
                @method('DELETE')
                @csrf
                <input type="submit" value="Delete" name="Delete" class='sp btn-danger' style="display: inline;" >
        
            </form>

        </div>
    </div>

    <br>
   @if ($borroweds->count() > 0)
       
    {{-- Student borroweds --}}
    <h2 class="font-bold mb-4">{{$user->username}} Latest borroweds</h2>


    <div class="grid grid-cols-2 gap-6">
        @foreach ($borroweds as $borrowed)
            {{-- Post card component --}}
            <x-borrowedCard :borrowed="$borrowed">

                <div class="flex items-center justify-end gap-4 mt-6">
                    {{-- Update post --}}
                    <a href=""
                        class="bg-green-500 text-white px-2 py-1 text-xs rounded-md">Update</a>

                    {{-- Delete post --}}
                    <form action="" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-2 py-1 text-xs rounded-md">Delete</button>
                    </form>
                </div>
            </x-borrowedCard>
        @endforeach
    </div>

    {{-- Pagination links --}}
    <div>
        {{ $borroweds->links() }}
    </div>
    @else
        <h2 class="font-bold mb-4">No borrowed books yet</h2>
            
    @endif

    
   

    
      
   
</x-layout>
