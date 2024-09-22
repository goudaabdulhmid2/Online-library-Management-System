
<x-layout>
    <h1 class="title">Update {{$user->username}} account</h1>
    
    <div class="mx-auto max-w-screen-sm card">
        <form action="{{ route('users.updateDetails', $user->id) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="mb-4">
                <label for="username">Username</label>
                <input type="text" name="username"  value="{{$user->username}}" class="input  @error('username') ring-red-500 @enderror">

                @error('username')
                   <p class="error">{{$message}}</p> 
                @enderror
            </div>

            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{$user->email}}" class='input  @error('email') ring-red-500 @enderror'>
                @error('email')
                <p class="error">{{$message}}</p> 
             @enderror
            </div>

            @if(Auth::user()->role === 'manager')
            <div class="mb-4">
                <label for="role">Select Role</label>
                <select name="role" class="input @error('role') ring-red-500 @enderror">
                    <option value="">Choose a role</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                </select>
                @error('role') <p class="error">{{ $message }}</p> @enderror
            </div>
            @endif
            
            <button class="btn primary-btn">Update</button>
        </form>
    </div>


<br>
   
    <div class="mx-auto max-w-screen-sm card">
        <form action="{{route('users.updatePassword',$user->id)}}" method="post">
            @method('PATCH')
            @csrf
            <div class="mb-4">
        <label for="password">Password</label>
        <input type="password" name="password"class='input  @error('password') ring-red-500 @enderror'>
        @error('password')
        <p class="error">{{$message}}</p> 
     @enderror
    </div>

    <div class="mb-8">
        <label for="password_confirmation">Confirm password</label>
        <input type="password" name="password_confirmation"class='input  @error('password') ring-red-500 @enderror '>

    </div>
            
            <button class="btn primary-btn">Update</button>
        </form>
    </div>
    

</x-layout>
