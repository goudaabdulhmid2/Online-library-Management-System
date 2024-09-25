
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

    <form action="{{ route('loans.index') }}" method="GET">
        <div class="flex items-center">
        <label for="search_id" class="fond-bold text-xl mb-4">Search loan by id:</label>
        <input type="text" name="search" placeholder="Search by id..." value="{{ request('search') }}">
        <button type="submit" class="sp btn-primary">Search</button>
        </div>
    </form>

 
    <div class="grid grid-cols-2 gap-6">
        @foreach ($loans as $loan)
        <div class="card">
            <div class="fond-bold text-xl mb-4">
                <span>Id</span>
                <p class="text-blue-500 font-medium">{{$loan->loan_id}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Status</span>
                <p class="text-blue-500 font-medium">{{$loan->loan_status}}</p>
            </div>

            @if($loan->loan_status == 'active')
                <div class="fond-bold text-xl mb-4">
                    <span>remaining days to returned</span>
                    <p class="text-blue-500 font-medium">{{ $loan->remainingDays>0 ? "$loan->remainingDays days" :'Time come to returned book.'}}</p>
                </div>
            @endif
 

            <a href="/loans/{{$loan->loan_id}}" class="sp btn-primary">View</a>
            <a href="/loans/{{$loan->loan_id}}/edit" class="sp btn-secondry">Update</a>
            <form method="post"  action="/loans/{{$loan->loan_id }}" style="display: inline;">
                @method('DELETE')
                @csrf
                <input type="submit" value="Delete" name="Delete" class='sp btn-danger' style="display: inline;" >
        
            </form>

        </div>
        @endforeach
    </div>

    <div>
        {{ $loans->links() }}

    </div>

   
   
            
      
   
</x-layout>
