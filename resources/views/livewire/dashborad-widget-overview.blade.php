<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-stats-card title="Total Keluarga" tooltip="Menampilkan jumlah keluarga yang aktif" value="{{ $totalKeluargas }}"
            percentage="" />
        <x-stats-card title="Total Jemaat" tooltip="Menampilkan jumlah jemaat yang aktif"
            value="{{ $totalKeluargaAnggotas }}" percentage="" />

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @if (auth()->user()->role != 'warga')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            {{-- Donut 1: Jenis Kelamin --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-bold text-black mb-4">Distribusi Jenis Kelamin</h3>
                <canvas id="genderChart"></canvas>
            </div>

            {{-- Donut 2: Generasi --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-bold text-black mb-4">Distribusi Generasi Jemaat</h3>
                <canvas id="generationChart"></canvas>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Donut Chart: Jenis Kelamin
            var genderCtx = document.getElementById('genderChart').getContext('2d');
            var genderData = @json($totalJnsKelamin);
            new Chart(genderCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(genderData),
                    datasets: [{
                        data: Object.values(genderData),
                        backgroundColor: ['#36A2EB', '#FF6384'], // L, P
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Donut Chart: Generasi
            var genCtx = document.getElementById('generationChart').getContext('2d');
            var genData = @json($generasiJemaat);
            new Chart(genCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(genData),
                    datasets: [{
                        data: Object.values(genData),
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                            '#9966FF', '#FF9F40'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });



        });
    </script>

</div>
