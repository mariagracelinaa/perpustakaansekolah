@extends('layouts.gentelella')

@section('content')
    <div>
        {{-- Pake canvas biar responsiv besar kecil chartnya, disarankan --}}
        <canvas id="visitChart"></canvas>
    </div>
@endsection

@section('javascript')
    <script>
        // Label di chartnya
        const labels = [
            'Minggu 1',
            'Minggu 2',
            'Minggu 3',
            'Minggu 4',
        ];

        // Dataset isian dari chartnya
        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Guru/Staf',
                    backgroundColor: 'rgb(0, 0, 255)',
                    borderColor: 'rgb(0, 0, 255)',
                    data: [0, 10, 18, 2, 10, 30, 45],
                }, 
                {
                    label: 'Murid',
                    backgroundColor: 'rgb(255, 0, 0)',
                    borderColor: 'rgb(255, 0, 0)',
                    data: [0, 0, 5, 10, 20, 16, 55]
                }
            ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                // scales: {
                //     y: {
                //         beginAtZero: true
                //     }
                // }
            }
        };

        // Menempatkan chartnya di canvas yang sudah dibuat di bagian body
        const visitChartChart = new Chart(
            document.getElementById('visitChart'),
            // config -> chartnya
            config
        );
    </script>
@endsection