<x-dashboard-layout title="Management User">
    <div class="bg-white rounded-2xl shadow-sm border p-5">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <form method="GET" action="{{ route('management-user.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Filter pencarian..." class="border rounded-lg px-3 py-2 w-full md:w-72">
                <button class="px-4 py-2 bg-slate-800 text-white rounded-lg">Cari</button>
            </form>

            <a href="{{ route('management-user.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                + Tambah User
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-slate-200">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-4 py-3 border text-left">No.</th>
                        <th class="px-4 py-3 border text-left">Nama</th>
                        <th class="px-4 py-3 border text-left">Email</th>
                        <th class="px-4 py-3 border text-left">No HP</th>
                        <th class="px-4 py-3 border text-left">Jenis</th>
                        <th class="px-4 py-3 border text-left">Asal/Kelas/Jabatan</th>
                        <th class="px-4 py-3 border text-left">Jurusan</th>
                        <th class="px-4 py-3 border text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td class="px-4 py-3 border">{{ $users->firstItem() + $index }}</td>
                            <td class="px-4 py-3 border">{{ $user->name }}</td>
                            <td class="px-4 py-3 border">{{ $user->email }}</td>
                            <td class="px-4 py-3 border">{{ $user->no_hp }}</td>
                            <td class="px-4 py-3 border">{{ ucfirst($user->jenis_pengguna) }}</td>
                            <td class="px-4 py-3 border">{{ $user->asal_kelas_jabatan }}</td>
                            <td class="px-4 py-3 border">{{ $user->jurusan?->nama ?? '-' }}</td>
                            <td class="px-4 py-3 border">
                                <div class="flex gap-2">
                                    <a href="{{ route('management-user.edit', $user) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>
                                    <form action="{{ route('management-user.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 border text-center text-slate-500">Data user belum ada.</td>
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