<x-layout>

    <div class="card mb-4">
    <h2 class="font-bold mb-4">Update {{$genre->name}} book</h2>

    <form action="/genres/{{$genre->id}}" method="post">
        @method('PATCH')
        @csrf

        <div class="mb-4">
            <label for="name">name</label>
            <input type="text" name="name" id="name" value="{{$genre->name}}"class='input  @error('name') ring-red-500 @enderror'>

            @error('name')
             <p class="error">{{$message}}</p> 
            @enderror

        </div>

        <button class="btn">Update</button>
       
      
    </form>
</div>

</x-layout>
