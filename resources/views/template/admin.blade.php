<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin Dashboard</title>
    <style>
        .bg-primary {
            background-color: #000000;
        }

        .text-primary {
            color: #ffffff;
        }

        .hover-primary {
            background-color: #4a3f35;
        }

        .bg-secondary {
            background-color: #ffffff;
        }
    </style>
</head>

<body class="bg-secondary min-h-screen flex">
    <nav class="bg-primary text-white p-4 flex flex-col items-start">
        <ul class="space-y-4">
            <li><a href="{{ route('admin.products.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Products</a></li>
            <li><a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Orders</a></li>
            <li><a href="{{ route('logout') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Logout</a></li>
        </ul>
    </nav>

    <div class="flex-1 p-8 bg-white">
        @yield('content')
    </div>
</body>

</html>