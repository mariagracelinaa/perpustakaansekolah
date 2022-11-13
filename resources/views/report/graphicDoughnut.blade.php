@extends('layouts.gentelella')

@section('content')
<div>
    <div>
        <p>Filter berdasarkan tanggal peminjaman</p>
        <label>Tanggal Mulai <input type="date" name="date_start" id="date_start" class="form-control"></label>
        <label style="margin-left: 10px">Tanggal Akhir <input type="date" name="date_end" id="date_end"  class="form-control"></label>
        <input type="button" value="Tampilkan Data" id="btn_show" class="btn btn-primary" onclick="getData()">
    </div>
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
                                <div>
                                    {{-- <select name="date_pick" id="date_pick" style="width: 200px; height:30px">
                                        {{ $cur_year = date('Y') }}
                                        @for ($year = $cur_year-10; $year <= $cur_year+10; $year++)
                                            @if ($cur_year == $year)
                                                <option value="{{ $year }}" selected>{{ $year }}</option>
                                            @else
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endif
                                        @endfor
                                    </select> --}}
                                </div>
                                <h3 style="text-align: center; color: black; margin-top: 20px">
                                    Grafik Perbandingan peminjaman kembali tepat waktu dan terlambat
                                </h3>
                                
                                <canvas id="doughnutChart" style="height: 800px;">
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
    // $data_student = "";
    // $data_teacher = "";
    // foreach ($monthly_student as $ds) {
    //     $data_student .= "'$ds'".",";
    // }
    // foreach ($monthly_teacher as $dt) {
    //     $data_teacher .= "'$dt'".",";
    // }
    // echo $data;
@endphp
 
@section('javascript')
    {{-- Chart JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Chart value --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <script>
        function getData(){
            var start = $('#date_start').val();
            var end = $('#date_end').val();
            $.ajax({
                type:'POST',
                url:'{{url("/grafik-perbandingan-peminjaman-filter")}}',
                data:{
                        '_token': '<?php echo csrf_token() ?>',
                        'start':start,
                        'end':end,
                    },
                success:function(data) {
                    doughnutChartChart.data.datasets[0].data[0] = data.on_time;
                    doughnutChartChart.data.datasets[0].data[1] = data.not_on_time;
                    doughnutChartChart.data.datasets[0].data[2] = data.active;
                    // doughnutChartChart.data.datasets[1].data = data.not_on_time;
                    doughnutChartChart.update();

                    // $('#year').html("Tahun "+data.year);
                    // $('#year').attr('value', data.year);
                }
            });
        }
    </script>
    
    <script>
        // Label di chartnya
        const labels = [
            'Tepat Waktu',
            'Terlambat',
            'Belum Kembali'
        ];

        // Dataset isian dari chartnya
        const data = {
            labels: labels,
            datasets: [
                {
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 241, 46)',
                    ],
                    data : [{{$on_time}},{{$not_on_time}},{{$active}}],       
                },
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
            type: 'doughnut',
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
        const doughnutChartChart = new Chart(
            document.getElementById('doughnutChart'),
            // config -> chartnya
            config
        );
        
        // Save PDF
        function convertToPDF(){
            // var print_year = $('#year').attr('value');
            const cv = document.getElementById('doughnutChart');

            // chart to image
            const img = cv.toDataURL('images/png', 1.0);

            // taruh img ke pdf nya
            let pdf = new jsPDF('landscape');
            pdf.setFontSize(20);
            pdf.addImage(img, 'PNG', 15, 15, 150, 150);
            pdf.text(30,15 ,'Grafik Perbandingan peminjaman kembali tepat waktu dan terlambat');
            pdf.save('Peminjaman_Kembali_Tepat_Waktu_dan_terlambat.pdf');
        }
    </script>
@endsection