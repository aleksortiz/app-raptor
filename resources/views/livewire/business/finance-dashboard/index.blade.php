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
                        label               : 'Utilidad Neta',
                        backgroundColor     : '#28a745',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : data1
                    },
                    {
                        label               : 'Utilidad Bruta',
                        backgroundColor     : '#007bff',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
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
