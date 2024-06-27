@extends('template.main')

@section('content')
<div class="flex-1 p-8">
    <h1 class="text-4xl font-bold mb-8 text-primary">Profile</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <form id="profileForm">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-primary">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-primary rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-primary">Email</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-primary rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-primary">Alamat</label>
                <input type="text" id="alamat" name="alamat" class="mt-1 block w-full px-3 py-2 border border-primary rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-yellow-500">Isi untuk merubah password</label>
                <label for="password" class="block text-sm font-medium text-primary">New Password</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-primary rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-primary">New Password Confirmation</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full px-3 py-2 border border-primary rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <button type="button" class="bg-primary text-white px-6 py-2 rounded-lg" onclick="updateProfile()">Update Profile</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchProfile();
    });

    function fetchProfile() {
        fetch('/api/profile', {
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('name').value = data.name;
            document.getElementById('email').value = data.email;
            document.getElementById('alamat').value = data.alamat;
        })
        .catch(error => console.error('Error fetching profile:', error));
    }

    function updateProfile() {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const alamat = document.getElementById('alamat').value;
        const password = document.getElementById('password').value;
        const password_confirmation = document.getElementById('password_confirmation').value;

        fetch('/api/profile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                name: name,
                email: email,
                alamat: alamat,
                password: password,
                password_confirmation: password_confirmation
            })
        })
        .then(response => response.json())
        .then(data => {
            alert('Profile updated successfully');
            fetchProfile();
        })
        .catch(error => console.error('Error updating profile:', error));
    }
</script>
@endpush
