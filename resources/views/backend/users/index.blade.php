@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Manajemen Pengguna</h6>
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">Tambah User</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-3">
            <button type="button" class="btn btn-danger" id="btnDeleteSelectedUser" disabled onclick="submitBulkDelete()">
                <i class="fa fa-trash me-2"></i>Hapus Terpilih
            </button>
        </div>

        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col" style="width: 40px;">
                            <input class="form-check-input" type="checkbox" id="selectAllUser">
                        </th>
                        <th scope="col" style="min-width: 200px;">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col" class="text-center" style="width: 120px;">Role</th>
                        <th scope="col" class="text-center" style="width: 120px;">Status</th>
                        <th scope="col" class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            @if($user->id !== 1 && $user->id !== auth()->id())
                                <input class="form-check-input select-item-user" type="checkbox" name="ids[]" value="{{ $user->id }}">
                            @endif
                        </td>
                        <td class="fw-bold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            @if($user->role === 'admin')
                                <span class="badge bg-primary">Admin</span>
                            @elseif($user->role === 'siswa')
                                <span class="badge bg-info text-dark">Siswa</span>
                            @else
                                <span class="badge bg-secondary">Panitia</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->is_active)
                                <span class="badge bg-success rounded-pill">Aktif</span>
                            @else
                                <span class="badge bg-danger rounded-pill">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->id !== 1 && $user->id !== auth()->id())
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning" title="Edit / Reset Password">
                                        <i class="fa fa-key me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @elseif($user->id === auth()->id())
                                <span class="text-muted"><small>Akun Anda</small></span>
                            @else
                                <span class="text-muted"><small>Super Admin</small></span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <h5 class="text-muted">Belum ada data user</h5>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Hidden Form for Bulk Delete -->
        <form action="{{ route('admin.users.destroy_multiple') }}" method="POST" id="bulkDeleteForm" style="display: none;">
            @csrf
        </form>

        <script>
            document.getElementById('selectAllUser').addEventListener('change', function() {
                var checkboxes = document.querySelectorAll('.select-item-user');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = this.checked;
                }.bind(this));
                toggleDeleteUserButton();
            });

            var checkboxesUser = document.querySelectorAll('.select-item-user');
            checkboxesUser.forEach(function(checkbox) {
                checkbox.addEventListener('change', toggleDeleteUserButton);
            });

            function toggleDeleteUserButton() {
                var selected = document.querySelectorAll('.select-item-user:checked').length;
                var btn = document.getElementById('btnDeleteSelectedUser');
                if(selected > 0) {
                    btn.disabled = false;
                } else {
                    btn.disabled = true;
                }
            }

            function submitBulkDelete() {
                if(!confirm('Yakin ingin menghapus user yang dipilih?')) return;
                
                var form = document.getElementById('bulkDeleteForm');
                var checkboxes = document.querySelectorAll('.select-item-user:checked');
                
                checkboxes.forEach(function(checkbox) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = checkbox.value;
                    form.appendChild(input);
                });
                
                form.submit();
            }
        </script>
        <div class="mt-3">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
