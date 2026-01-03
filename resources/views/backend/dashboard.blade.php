@extends('backend.layouts.app')

@section('content')
<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-users fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Pendaftar</p>
                    <h6 class="mb-0">{{ $totalRegistrations }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chair fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Kuota Tersedia</p>
                    <h6 class="mb-0">{{ $availableQuota }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-check-circle fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Terverifikasi</p>
                    <h6 class="mb-0">{{ $totalVerified }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-graduation-cap fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Lulus Seleksi</p>
                    <h6 class="mb-0">{{ $totalAccepted }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sale & Revenue End -->

<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Tren Pendaftaran (7 Hari Terakhir)</h6>
                </div>
                <canvas id="registration-chart"></canvas>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Statistik Jalur Pendaftaran</h6>
                </div>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-white">
                                <th scope="col">Jalur</th>
                                <th scope="col" class="text-center">Kuota</th>
                                <th scope="col" class="text-center">Pendaftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrationsByTrack as $track)
                            <tr>
                                <td>{{ $track->name }}</td>
                                <td class="text-center">{{ $track->quota }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $track->registrations_count >= $track->quota ? 'bg-danger' : 'bg-success' }}">
                                        {{ $track->registrations_count }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sales Chart End -->

<!-- Recent Sales Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Pendaftar Terbaru</h6>
            <a href="{{ route('admin.registrations.index') }}">Tampilkan Semua</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th scope="col">Tgl Daftar</th>
                        <th scope="col">No. Daftar</th>
                        <th scope="col">Nama Siswa</th>
                        <th scope="col">Jalur</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRegistrations as $reg)
                    <tr>
                        <td>{{ $reg->created_at->format('d M Y') }}</td>
                        <td>{{ $reg->registration_code }}</td>
                        <td>{{ $reg->user->name }}</td>
                        <td>{{ $reg->track->name ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $reg->status == 'verified' ? 'bg-success' : ($reg->status == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                {{ ucfirst($reg->status) }}
                            </span>
                        </td>
                        <td><a class="btn btn-sm btn-primary" href="{{ route('admin.registrations.show', $reg->id) }}">Detail</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada pendaftar terbaru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Recent Sales End -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx1 = document.getElementById("registration-chart").getContext("2d");
        var myChart1 = new Chart(ctx1, {
            type: "bar",
            data: {
                labels: {!! json_encode($chartLabels) !!}, // e.g., ["01 Jan", "02 Jan"]
                datasets: [{
                    label: "Pendaftar",
                    data: {!! json_encode($chartData) !!}, // e.g., [10, 20]
                    backgroundColor: "rgba(235, 22, 22, .7)",
                    fill: true
                }]
            },
            options: {
                responsive: true
            }
        });
    });
</script>
@endsection
