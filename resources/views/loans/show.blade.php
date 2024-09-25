
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
                <span>Id</span>
                <p class="text-blue-500 font-medium">{{$loan->loan_id}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Student</span>
                <p class="text-blue-500 font-medium">{{$loan->user->username}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Book</span>
                <p class="text-blue-500 font-medium">{{$loan->book->title}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Status</span>
                <p class="text-blue-500 font-medium">{{$loan->loan_status}}</p>
            </div>

            <div class="fond-bold text-xl mb-4">
                <span>Loan date</span>
                <p class="text-blue-500 font-medium">{{$loan->loan_date}}</p>
            </div>
            
            <div class="fond-bold text-xl mb-4">
                <span>Due date</span>
                <p class="text-blue-500 font-medium">{{$loan->due_date}}</p>
            </div>

            @if($loan->return_date)
                <div class="fond-bold text-xl mb-4">
                    <span>returned date</span>
                    <p class="text-blue-500 font-medium">{{$loan->return_date}}</p>
                </div>

            @endif

            @if ($loan->loan_status == 'active')
                <div class="fond-bold text-xl mb-4">
                    <span>remaining days to returned</span>
                    <p class="text-blue-500 font-medium">{{ $loan->remainingDays>0 ? "$loan->remainingDays days" :'Time come to returned book.'}}</p>
                </div>
            @endif


            <a href="/loans/{{$loan->loan_id}}/edit" class="sp btn-secondry">Update</a>
            <form method="post"  action="/loans/{{$loan->loan_id }}" style="display: inline;">
                @method('DELETE')
                @csrf
                <input type="submit" value="Delete" name="Delete" class='sp btn-danger' style="display: inline;" >
        
            </form>

        </div>
    </div>

    
    
      
   
</x-layout>

