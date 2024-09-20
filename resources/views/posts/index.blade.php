
<x-layout>
    @auth
        <h1>Logged in</h1>
    @endauth

    @guest
        <h1>Guset user</h1>
    @endguest
</x-layout>
