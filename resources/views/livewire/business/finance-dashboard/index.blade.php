@extends('adminlte::page')

{{-- css --}}
@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/chart.js/Chart.min.css') }}">
@endsection

@section('content')
    @include('partials.system.loader')
    @livewire('business.finance-dashboard')
@endsection

@section('js')
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script>

        let chart = null;
        function loadGraph(labels, data1, data2){
            var areaChartData = {
                labels  : labels,
                datasets: [
                    {
                        type                : 'line',
                        label               : 'Utilidad Neta',
                        backgroundColor:'tansparent',
                        borderColor:'#ced4da',
                        pointBorderColor:'#ced4da',
                        pointBackgroundColor:'#ced4da',
                        fill:false
                        data                : data1
                    },
                    {
                        type                : 'line',
                        label               : 'Utilidad Bruta',
                        backgroundColor:'transparent',
                        borderColor:'#007bff',
                        pointBorderColor:'#007bff',
                        pointBackgroundColor:'#007bff',
                        fill:false
                        data                : data2
                    },
                ]
            }

            var barChartData = $.extend(true, {}, areaChartData)
            var stackedBarChartCanvas = $('#chartdiv').get(0).getContext('2d');

            var stackedBarChartData = $.extend(true, {}, barChartData)

            var stackedBarChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }

            if(chart != null){
                chart.destroy();
            }

            chart = new Chart(stackedBarChartCanvas, {
                type: 'line',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            })

            // chart.data = stackedBarChartData;
        }

        $(document).ready(function() {
            // loadGraph();
        });

        Livewire.on('loadGraphLive', function(labels, data1, data2) {
            loadGraph(labels, data1, data2);
        });


    </script>
@endsection
