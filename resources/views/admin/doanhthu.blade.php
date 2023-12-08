@extends('admin_layout')
@section('admin_content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">Chi tiết tổng doanh thu</h2>
        </div>
    </div>
    <canvas id="doanhThuChart" width="300" height="100"></canvas>


    <script>
        var ctx = document.getElementById('doanhThuChart').getContext('2d');

        var labels = {!! json_encode($labels) !!};
        var data = {!! json_encode($data) !!};

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh Thu',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <section>
        <div class="container">
            <!-- Revenue Widget -->
            <div class="widget revenue-widget">
                <div style="display: flex">
                </div>
                <p class="revenue-amount">Tổng doanh thu: {{ number_format($tong, 0, '.', ',') }} vnđ</p>
                <p>Doanh thu trong năm: <span>{{ number_format($nam, 0, '.', ',') }}</span></p>
                <p>Doanh thu tháng: <span>{{ number_format($thang, 0, '.', ',') }}</span></p>
                <p>Doanh thu ngày: <span>{{ number_format($day, 0, '.', ',') }}</span> </p>
            </div>
        </div>
    </section>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        nav {
            background-color: #f0f0f0;
            padding: 10px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .widget {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 10px;
            flex: 1 0 300px; /* Flexbox properties for responsiveness */
        }

        .revenue-widget {
            color: #333;
        }

        .revenue-widget h2 {
            color: #e44d26; /* Orange color for emphasis */
        }

        .revenue-amount {
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
@endsection
