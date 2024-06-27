<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Register</title>
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

<body class="bg-secondary">
  <div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full p-8 bg-white rounded-lg shadow-lg">
      <div class="flex justify-center">
        <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="h-32">
      </div>
      <form id="registerForm" class="mt-8 space-y-6">
        <div>
          <label for="name" class="block text-sm font-medium text-primary">Name</label>
          <input id="name" name="name" type="text" class="mt-1 block w-full px-3 py-2 border border-primary rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-primary">Email</label>
          <input id="email" name="email" type="email" class="mt-1 block w-full px-3 py-2 border border-primary rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-primary">Password</label>
          <input id="password" name="password" type="password" class="mt-1 block w-full px-3 py-2 border border-primary rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-primary">Confirm Password</label>
          <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full px-3 py-2 border border-primary rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div>
          <button type="submit" class="w-full bg-primary text-white p-2 rounded-lg">Register</button>
        </div>
        <div class="text-center mt-4">
          <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">Already have an account? Login here</a>
        </div>
      </form>
      <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4 hidden">
        <strong class="font-bold">Whoops!</strong>
        <span class="block sm:inline">There were some problems with your input.</span>
        <ul class="mt-3 list-disc list-inside text-sm text-red-600" id="errorList"></ul>
      </div>
    </div>
  </div>
  <script>
    document.getElementById('registerForm').addEventListener('submit', async function(event) {
      event.preventDefault();
      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const password_confirmation = document.getElementById('password_confirmation').value;

      const response = await fetch('/api/register', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        credentials: 'same-origin',
        body: JSON.stringify({
          name,
          email,
          password,
          password_confirmation
        })
      });

      const data = await response.json();

      if (response.ok) {
        window.location.href = '/home';
      } else {
        const errorMessage = document.getElementById('errorMessage');
        const errorList = document.getElementById('errorList');
        errorList.innerHTML = '';
        if (data.errors) {
          Object.values(data.errors).forEach(error => {
            const li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
          });
        } else {
          const li = document.createElement('li');
          li.textContent = data.message;
          errorList.appendChild(li);
        }
        errorMessage.classList.remove('hidden');
      }
    });
  </script>
</body>

</html>