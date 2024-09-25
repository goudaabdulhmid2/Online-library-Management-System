<x-layout>

    <div class="grid grid-cols-2 gap-6">
        @foreach ($usersBorrows as $borrow)
            <div class="card">
                <div class="fond-bold text-xl mb-4">
                    <span>Book</span>
                    <p class="text-blue-500 font-medium">{{$borrow->book->title}}</p>
                </div>

                <div class="fond-bold text-xl mb-4">
                    <span>Status</span>
                    <p class="text-blue-500 font-medium">{{$borrow->loan_status}}</p>
                </div>

                      
                <div class="fond-bold text-xl mb-4">
                    <span>Will be available at</span>
                    <p class="text-blue-500 font-medium">{{$borrow->due_date}}</p>
                </div>



                
            </div>
        @endforeach
    </div>

</x-layout>