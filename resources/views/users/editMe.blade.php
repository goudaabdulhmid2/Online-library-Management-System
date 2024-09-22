
<x-layout>
    <h1 class="title">Update my account</h1>
    
    <div class="mx-auto max-w-screen-sm card">
        <form action="{{ route('users.updateMeDetalis') }}" method="post">
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

            
            <button class="btn primary-btn">Update</button>
        </form>
    </div>


<br>
   
    <div class="mx-auto max-w-screen-sm card">
        <form action="{{route('users.updateMePassword')}}" method="post">
            @method('PATCH')
            @csrf

            <div class="mb-4">
                <label for="password_current">Current password</label>
                <input type="password" name="password_current"class='input  @error('password_current') ring-red-500 @enderror'>
                @error('password_current')
                <p class="error">{{$message}}</p> 
             @enderror
            </div>

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
