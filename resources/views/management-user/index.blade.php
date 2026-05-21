<x-dashboard-layout title="Management User">
    <div class="bg-white rounded-2xl shadow-sm border p-5">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <form method="GET" action="{{ route('management-user.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Filter pencarian..."
                    class="border rounded-lg px-3 py-2 w-full md:w-72 text-sm">
                <button class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm">Cari</button>
            </form>

            <a href="{{ route('management-user.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">
                + Tambah User
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-200">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-4 py-3 border text-left text-sm font-semibold">No.</th>
                        <th class="px-4 py-3 border text-left text-sm font-semibold">Nama</th>
                        <th class="px-4 py-3 border text-left text-sm font-semibold">Email</th>
                        <th class="px-4 py-3 border text-left text-sm font-semibold">No HP</th>
                        <th class="px-4 py-3 border text-left text-sm font-semibold">Jenis</th>
                        <th class="px-4 py-3 border text-left text-sm font-semibold">Asal/Kelas/Jabatan</th>
                        <th class="px-4 py-3 border text-left text-sm font-semibold">Jurusan</th>
                        <th class="px-4 py-3 border text-left text-sm font-semibold">Role</th>
                        <th class="px-4 py-3 border text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td class="px-4 py-3 border text-sm">{{ $users->firstItem() + $index }}</td>
                            <td class="px-4 py-3 border text-sm">{{ $user->name }}</td>
                            <td class="px-4 py-3 border text-sm">{{ $user->email }}</td>
                            <td class="px-4 py-3 border text-sm">{{ $user->no_hp }}</td>
                            <td class="px-4 py-3 border text-sm">{{ $user->jenis_pengguna ? ucfirst($user->jenis_pengguna) : '-' }}</td>
                            <td class="px-4 py-3 border text-sm">{{ $user->asal_kelas_jabatan ?? '-' }}</td>
                            <td class="px-4 py-3 border text-sm">{{ $user->jurusan?->nama ?? '-' }}</td>
                            <td class="px-4 py-3 border text-sm">{{ $user->role }}</td>
                            <td class="px-4 py-3 border">
                                <div class="flex gap-2">
                                    <a href="{{ route('management-user.edit', $user) }}"
                                        class="px-3 py-1 bg-yellow-500 text-white rounded text-xs font-medium">Edit</a>
                                    <form action="{{ route('management-user.destroy', $user) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 text-white rounded text-xs font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-4 border text-center text-slate-500 text-sm">Data user belum ada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-dashboard-layout>