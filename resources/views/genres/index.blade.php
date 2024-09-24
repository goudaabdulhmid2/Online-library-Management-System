
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
        @foreach ($genres as $genre)
        <div class="card">
            <div class="fond-bold text-xl mb-4">
                <span>Id</span>
                <p class="text-blue-500 font-medium">{{$genre->id}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Name</span>
                <p class="text-blue-500 font-medium">{{$genre->name}}</p>
            </div>
            
            <div class="fond-bold text-xl mb-4">
                <span>Created at</span>
                <p class="text-blue-500 font-medium">{{$genre->created_at}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Updated at</span>
                <p class="text-blue-500 font-medium">{{$genre->updated_at}}</p>
            </div>

            <a href="/genres/{{$genre->id}}/edit" class="sp btn-secondry">Update</a>
            <form method="post"  action="/genres/{{ $genre['id'] }}" style="display: inline;">
                @method('DELETE')
                @csrf
                <input type="submit" value="Delete" name="Delete" class='sp btn-danger' style="display: inline;" >
        
            </form>

        </div>
        @endforeach
    </div>

    <div>
        {{ $genres->links() }}

    </div>

   
   
            
      
   
</x-layout>
