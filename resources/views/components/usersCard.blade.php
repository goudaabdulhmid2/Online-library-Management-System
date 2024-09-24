@props(['user', 'full' => false])

<div class="card">
    <div class="flex gap-6">

        <div class="w-4/5">
            <div class="fond-bold text-xl">
                <span>Student</span>
                <p  class="text-blue-500 font-medium">{{ $user->username }} </p>
            </div>

            {{-- id--}}
            <div class="text-xs font-light mb-4">
                <span>Id {{ $user->id }}  </span>
            </div>

            <div class="fond-bold text-xl">
                <span>Email</span>
                <p  class="text-blue-500 font-medium">{{ $user->email }} </p>
            </div>
            
        </div>

    </div>


    {{-- Placeholder for extra elements used in user dashboard --}}
    <div>
        {{ $slot }}
    </div>
</div>