@extends('layout.admin')
@section('content')
<main class="bg-gray-100 p-10 w-full">
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Manage Users</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('akun.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah User</a>

        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Role</th>
                    <th class="py-2 px-4 border-b">Password</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                        <td class="py-2 px-4 border-b">
                            <form action="{{ route('akun.roleupdate', $user) }}" method="POST" class="inline-block">
                                @csrf
                                <select name="role" class="shadow appearance-none border rounded py-1 px-2 text-gray-700">
                                    <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Admin</option>
                                    <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Writer</option>
                                </select>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Role</button>
                            </form>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <form action="{{ route('akun.resetpass', $user) }}" method="POST" class="inline-block">
                                @csrf
                                <input type="password" name="password" placeholder="New password" class="shadow appearance-none border rounded w-48 py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <input type="password" name="password_confirmation" placeholder="Confirm password" class="shadow appearance-none border rounded w-48 py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Reset Password</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection
