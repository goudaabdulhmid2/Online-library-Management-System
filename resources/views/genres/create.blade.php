<x-layout>

    <div class="card mb-4">
        <h2 class="font-bold mb-4">Add a new genre</h2>
    
        <form action="{{route('genres.store')}}" method="post">
            @csrf
    
            <div class="mb-4">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{old('name')}}"class='input  @error('name') ring-red-500 @enderror'>
    
                @error('name')
                 <p class="error">{{$message}}</p> 
                @enderror
    
            </div>
    
    
            <button class="btn">Create</button>

           
          
        </form>
    </div>
    

</x-layout>