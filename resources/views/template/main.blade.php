<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Home</title>
    <style>
        .bg-primary {
            background-color: #4a3f35;
        }

        .text-primary {
            color: #4a3f35;
        }

        .border-primary {
            border-color: #4a3f35;
        }

        .bg-secondary {
            background-color: #f5e6cc;
        }
    </style>
</head>

<body class="bg-secondary min-h-screen flex">
    <nav class="bg-primary text-white p-4 flex flex-col items-start">
        <ul class="space-y-4">
            <li><a href="{{ route('home')}}" class="block px-4 py-2 rounded hover:bg-gray-700">Home</a></li>
            <li><a href="{{ route('profile') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Profile</a></li>
            <li><a href="{{ route('cart') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Cart</a></li>
            @if (Auth::user())
            <li><a href="{{ route('logout') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Logout</a></li>
            @else
            <li><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Login</a></li>
            <li><a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Register</a></li>
            @endif
        </ul>
    </nav>

    @yield('content')
    
    @stack('scripts')
</body>

</html>