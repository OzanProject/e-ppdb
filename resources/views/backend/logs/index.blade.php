@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">System Activity Logs (Audit Trail)</h6>
                    <div class="d-flex align-items-center">
                        <form action="{{ route('admin.logs.index') }}" method="GET" class="d-flex me-2">
                            <input type="text" name="search" class="form-control form-control-sm bg-dark border-0 text-white me-2" placeholder="Search User/Action..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary btn-sm">Search</button>
                        </form>
                        
                        @role('admin')
                        <button type="button" class="btn btn-warning btn-sm me-2" id="btnBulkDelete" disabled onclick="submitBulkDelete()">
                            <i class="fa fa-trash me-1"></i> Hapus Terpilih
                        </button>
                        <form action="{{ route('admin.logs.destroy') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA log aktivitas? Tindakan ini tidak dapat dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-bomb me-1"></i> Bersihkan Semua</button>
                        </form>
                        @endrole
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-white">
                                <th scope="col" width="40"><input class="form-check-input" type="checkbox" id="selectAll"></th>
                                <th scope="col">Time</th>
                                <th scope="col">User (Causer)</th>
                                <th scope="col">Action</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Changes (Attributes)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td><input class="form-check-input user-checkbox" type="checkbox" value="{{ $log->id }}"></td>
                                    <td style="white-space: nowrap;">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                                    <td>{{ $log->causer->name ?? 'System' }}</td>
                                    <td>
                                        <span class="badge {{ $log->event == 'created' ? 'bg-success' : ($log->event == 'updated' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                            {{ ucfirst($log->event) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                                    </td>
                                    <td>
                                        @if($log->properties && isset($log->properties['attributes']))
                                            <small class="d-block text-muted">New:</small>
                                            @foreach($log->properties['attributes'] as $key => $value)
                                                @if(!in_array($key, ['updated_at', 'created_at']))
                                                    <span class="text-success">{{ $key }}: {{ is_array($value) ? json_encode($value) : $value }}</span><br>
                                                @endif
                                            @endforeach
                                            
                                            @if(isset($log->properties['old']))
                                                <hr class="my-1 border-secondary">
                                                <small class="d-block text-muted">Old:</small>
                                                @foreach($log->properties['old'] as $key => $value)
                                                    @if(!in_array($key, ['updated_at', 'created_at']))
                                                        <span class="text-danger">{{ $key }}: {{ is_array($value) ? json_encode($value) : $value }}</span><br>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @else
                                            <span class="text-muted">- No Attributes Logged -</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No logs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Bulk Delete Form -->
<form id="bulkDeleteForm" action="{{ route('admin.logs.destroy_multiple') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="ids" id="bulkDeleteIds">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.user-checkbox');
        const btnBulkDelete = document.getElementById('btnBulkDelete');

        function toggleBulkButton() {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            if (btnBulkDelete) {
                btnBulkDelete.disabled = !anyChecked;
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => {
                    cb.checked = selectAll.checked;
                });
                toggleBulkButton();
            });
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', toggleBulkButton);
        });
    });

    function submitBulkDelete() {
        const selectedIds = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
        if (selectedIds.length === 0) return;

        if (confirm('Apakah Anda yakin ingin menghapus ' + selectedIds.length + ' log yang dipilih?')) {
            document.getElementById('bulkDeleteIds').value = JSON.stringify(selectedIds);
            document.getElementById('bulkDeleteForm').submit();
        }
    }
</script>
@endsection
