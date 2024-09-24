<x-layout>

    <div class="card mb-4">
    <h2 class="font-bold mb-4">Add a new loan</h2>

    <form action="{{route('loans.store')}}" method="post">
        @csrf

        <div class="mb-4">
            <label for="user_id">User</label>
            <select name="user_id" id="user_id" class="input @error('user_id') ring-red-500 @enderror">
                <option value="">Select a user</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->username }} 
                    </option>
                @endforeach
            </select>
        
            @error('user_id')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        

        <div class="mb-4">
            <label for="user_id">Book</label>
            <select name="book_id" id="book_id" class="input @error('book_id') ring-red-500 @enderror">
                <option value="">Select a book</option>
                @foreach($books as $book)
                    <option value="{{ $book->book_id }}" {{ old('book_id') == $book->book_id ? 'selected' : '' }}>
                        {{ $book->title }} 
                    </option>
                @endforeach
            </select>
        
            @error('book_id')
                <p class="error">{{ $message }}</p>
            @enderror
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

        </div>

        <button class="btn">Create</button>
       
      
    </form>
</div>

</x-layout>
