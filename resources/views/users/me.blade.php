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
            

            <div class="fond-bold text-xl mb-4">
                <span>Username</span>
                <p class="text-blue-500 font-medium">{{$userToShow['username']}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Email</span>
                <p class="text-blue-500 font-medium">{{$userToShow->email}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Role</span>
                <p class="text-blue-500 font-medium">{{$userToShow->role}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Created at:</span>
                <p class="text-blue-500 font-medium">{{$userToShow->created_at}}</p>
            </div>

        </div>
    </div>

</x-layout>