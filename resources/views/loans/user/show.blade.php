<x-layout>
    <div class="grid grid-cols-1 gap-6">
        
            <div class="card">
                <div class="fond-bold text-xl mb-4">
                    <span>Book</span>
                    <p class="text-blue-500 font-medium">{{$borrow->book->title}}</p>
                </div>

                <div class="fond-bold text-xl mb-4">
                    <span>Author</span>
                    <p class="text-blue-500 font-medium">{{$borrow->book->author}}</p>
                </div>

                <div class="fond-bold text-xl mb-4">
                    <span>Status</span>
                    <p class="text-blue-500 font-medium">{{$borrow->loan_status}}</p>
                </div>

                <div class="fond-bold text-xl mb-4">
                    <span>Loan date</span>
                    <p class="text-blue-500 font-medium">{{$borrow->loan_date}}</p>
                </div>

                <div class="fond-bold text-xl mb-4">
                    <span>Due date</span>
                    <p class="text-blue-500 font-medium">{{$borrow->due_date}}</p>
                </div>

                @if ($borrow->loan_status == 'active')
                <div class="fond-bold text-xl mb-4">
                    <span>remaining days to returned</span>
                    <p class="text-blue-500 font-medium">{{ $borrow->remainingDays>0 ? "$borrow->remainingDays days" :'Time come to returned book.'}} </p>
                </div>
                @elseif ($borrow->return_date)
                    <div class="fond-bold text-xl mb-4">
                        <span>Returned date</span>
                        <p class="text-blue-500 font-medium">{{$borrow->return_date}}</p>
                    </div>
                @endif
                
                
                
                @if ($borrow->loan_status == 'active')

                    <form action="/loans/user/{{$borrow->loan_id}}" method="post" style="display: inline;">
                        @method('PATCH')
                        @csrf
                        
                        <button class="sp btn-secondry">Returned</button>

                    </form>
                @endif
                
            </div>
    
    </div>

</x-layout>
