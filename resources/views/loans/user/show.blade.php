<x-layout>
    <div class="grid grid-cols-1 gap-6">
        
            <div class="card">
                <div class="fond-bold text-xl mb-4">
                    <span>Book</span>
                    <p class="text-blue-500 font-medium">{{$borrow->book->title}}</p>
                </div>

                <div class="fond-bold text-xl mb-4">
                    <span>Status</span>
                    <p class="text-blue-500 font-medium">{{$borrow->loan_status}}</p>
                </div>

                @if ($borrow->loan_status == 'active')
                <div class="fond-bold text-xl mb-4">
                    <span>remaining days to returned</span>
                    <p class="text-blue-500 font-medium">{{ $borrow->remainingDays>0 ? $borrow->remainingDays :'Time come to returned book.'}} days</p>
                </div>
                @elseif ($borrow->return_date)
                    <div class="fond-bold text-xl mb-4">
                        <span>Returned date</span>
                        <p class="text-blue-500 font-medium">{{$borrow->return_date}}</p>
                    </div>
                @endif
                
                
                
                @if ($borrow->loan_status == 'active')
                    <a href="/loans/{{$borrow->loan_id}}/edit" class="sp btn-secondry">Update<a>
                @endif
                
                <form method="post"  action="/loans/{{$borrow->loan_id }}" style="display: inline;">
                    @method('DELETE')
                    @csrf
                    <input type="submit" value="Delete" name="Delete" class='sp btn-danger' style="display: inline;" >
            
                </form>

            </div>
    
    </div>

</x-layout>
