
<x-layout>

    <div class="card mb-4">
    <h2 class="font-bold mb-4">Update loan</h2>

    <form action="/loans/{{$loan->loan_id}}" method="post">
        @method('PATCH')
        @csrf

        <div class="mb-4">
            <label for="user_id">User</label>
            <p class="input">{{$loan->user->username}}</p>
        </div>

        

        <div class="mb-4">
            <label for="book_id">Book</label>
            <p class="input">{{$loan->book->title}}</p>
        </div>

        <div class="mb-4">
            <label for="loan_status">Status</label>
            <select name="loan_status" id="loan_status" class="input @error('loan_status') ring-red-500 @enderror">
                <option value="active" {{ (old('loan_status') ?? $loan->loan_status) == 'active' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="returned" {{ (old('loan_status') ?? $loan->loan_status) == 'returned' ? 'selected' : '' }}>
                    Returned
                </option>
            </select>
        
            @error('loan_status')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        

        <div class="mb-4">
            <label for="loan_date">Loan Date</label>
            <input type="date" name="loan_date" id="loan_date" value="{{$loan->loan_date }}" class="input @error('loan_date') ring-red-500 @enderror">
            @error('loan_date')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" id="due_date" value="{{ $loan->due_date }}" class="input @error('due_date') ring-red-500 @enderror">
            @error('due_date')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        </div>

        <button class="btn">Update</button>
       
      
    </form>
</div>

</x-layout>
