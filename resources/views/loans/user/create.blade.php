<x-layout>

    <div class="card mb-4">
    <h2 class="font-bold mb-4"> Borrow book</h2>

    <form action="/loans/userBorrowed/{{$book->book_id}}" method="post">
        @csrf
        <div class="mb-4">
            <label for="title">Title</label>
            <p class="input">{{$book->title}}</p>

        </div>

        <div class="mb-4">
            <label for="author">Author</label>
            <p class="input">{{$book->author}}</p>
        </div>

        <div class="mb-4">
            <label for="author">Author</label>
            <p class="input">{{$book->genre->name}}</p>
        </div>

        <div class="mb-4">
            <label for="loan_date">Loan Date</label>
            <input type="date" name="loan_date" id="loan_date" value="{{ old('loan_date') }}" class="input @error('loan_date') ring-red-500 @enderror">
            @error('loan_date')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" class="input @error('due_date') ring-red-500 @enderror">
            @error('due_date')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>


        <button class="btn">Create</button>
       
      
    </form>
</div>

</x-layout>
