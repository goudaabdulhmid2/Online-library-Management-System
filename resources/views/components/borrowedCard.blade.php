@props(['borrowed', 'full' => false])

<div class="card">
    <div class="flex gap-6">

        <div class="w-4/5">
            {{-- Title --}}
            <h2 class="font-bold text-xl">{{ $borrowed->book->title }}</h2>

            {{-- Author and Date --}}
            <div class="text-xs font-light mb-4">
                <span>Author {{ $borrowed->book->author }}  </span>
            </div>

            <div class="fond-bold text-xl">
                <span>Borrowed date</span>
                <p  class="text-blue-500 font-medium">{{ $borrowed->loan_date }} </p>
            </div>
            <div class="fond-bold text-xl">
                <span>Due date</span>
                <p  class="text-blue-500 font-medium">{{ $borrowed->due_date }} </p>
            </div>

            <div class="fond-bold text-xl">
                <span>status</span>
                <p  class="text-blue-500 font-medium">{{ $borrowed->loan_status }} </p>
            </div>

        </div>

    </div>


    {{-- Placeholder for extra elements used in user dashboard --}}
    <div>
        {{ $slot }}
    </div>
</div>