@extends('layouts.gentelella')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div>
                    <ul class="nav navbar-right panel_toolbox">
                        <button onclick="convertToPDF()" class="btn btn-primary"><i class="fa fa-print"></i> Simpan File PDF</button>  
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <h3 style="text-align: center; color: black; margin-top: 20px">
                                    Grafik Peminjaman Buku Perpustakaan SMA Santo Carolus Surabaya
                                </h3>
                                <canvas id="visitChart">
                                    {{-- grafik --}}
                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    $data = "";
    foreach ($monthly_borrow as $d) {
        $data .= "'$d'".",";
    }
    // echo $data;
@endphp
 
@section('javascript')
    {{-- Chart JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Chart value --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    
    <script>
        // Label di chartnya
        const labels = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        // Dataset isian dari chartnya
        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Peminjaman',
                    backgroundColor: '#D82777',
                    borderColor: '#D82777',
                    data: [<?= $data ?>],        
                }
            ]
        };

        const colorBackgroundImage = {
            id :'color',
            beforeDraw: (chart, options) => {
                const {ctx, width, height} = chart;
                ctx.fillStyle = 'white';
                ctx.fillRect(0,0, width, height)
                ctx.restore()
            }
        }

        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    datalabels:{
                        anchor:'end',
                        align:'top',
                    }
                }
            },
            plugins: [ChartDataLabels, colorBackgroundImage],
        };

        // Menempatkan chartnya di canvas yang sudah dibuat di bagian body
        const visitChartChart = new Chart(
            document.getElementById('visitChart'),
            // config -> chartnya
            config
        );
        
        // Save PDF
        function convertToPDF(){
            const cv = document.getElementById('visitChart');

            // chart to image
            const img = cv.toDataURL('images/png', 1.0);

            // taruh img ke pdf nya
            let pdf = new jsPDF('landscape');
            pdf.setFontSize(20);
            pdf.addImage(img, 'PNG', 15, 15, 250, 150);
            pdf.text(30,15 ,'Grafik Pengunjung Perpustakaan SMA Santo Carolus Surabaya Tahun {{$this_year}}');
            pdf.save('pengunjung_perpustakaan_sma_carolus_sby.pdf');
        }

    </script>
@endsection