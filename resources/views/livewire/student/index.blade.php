<div class="bg-gradient-to-br from-indigo-100 via-white to-blue-100 min-h-screen py-10 max-w-screen-xl mx-auto px-4 py-6">

    <!-- Notifikasi flash -->
    @if (session()->has('success'))
        <div class="mb-4 p-2 bg-green-100 border border-green-300 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-2 bg-red-100 border border-red-300 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header: Pencarian -->
    <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold text-indigo-700 mb-2">12 - Network, Information, System, Application</h1>
        <form>
            <label for="default-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m19 19-4-4m0 0a7 7 0 1 1 1-1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="default-search"
                       class="block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                       wire:model.live="search" placeholder="Search" />
            </div>
        </form>
    </div>

    <!-- Student Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-xs text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-center">No</th>
                    <th class="px-4 py-3 text-center">Name</th>
                    <th class="px-4 py-3 text-center">NIS</th>
                    <th class="px-4 py-3 text-center">Gender</th>
                    <th class="px-4 py-3 text-center">Class Group</th>
                    <th class="px-4 py-3 text-center">Address</th>
                    <th class="px-4 py-3 text-center">Contact</th>
                    <th class="px-4 py-3 text-center">Email</th>
                    <th class="px-4 py-3 text-center">PKL Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr class="odd:bg-white even:bg-gray-50 border-b">
                        <td class="px-4 py-3 text-center">
                            {{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-3 text-center">{{ $student->name }}</td>
                        <td class="px-4 py-3 text-center">{{ $student->nis }}</td>
                        <td class="px-4 py-3 text-center">{{ $genders[$student->gender] ?? 'Unknown' }}</td>
                        <td class="px-4 py-3 text-center">{{ $class_groups[$student->class_group] ?? 'Unknown' }}</td>
                        <td class="px-4 py-3 text-center">{{ $student->address }}</td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $cleanNumber = preg_replace('/[^0-9]/', '', $student->contact);
                            @endphp
                            @if ($cleanNumber)
                                <a href="https://wa.me/{{ $cleanNumber }}" target="_blank" class="text-green-600 hover:underline">
                                    WhatsApp ({{ $student->contact }})
                                </a>
                            @else
                                <span class="text-gray-400 italic">Tidak tersedia</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">{{ $student->email }}</td>
                        <td class="px-4 py-3 text-center">
                            @if ($student->pkl_report_status)
                                <span class="text-green-600 font-semibold">Active</span>
                            @else
                                <span class="text-red-600 font-semibold">Nonactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button wire:click="delete({{ $student->id }})"
                                    onclick="return confirm('Yakin ingin menghapus siswa ini?')"
                                    class="text-red-600 hover:underline">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-4 text-center text-gray-500">
                            No student registered.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>
</div>
