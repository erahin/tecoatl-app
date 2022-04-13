@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Gráfica del porcentaje de proyectos por región
                    </h1>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div id="container"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    Highcharts.theme = {
    colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572',
    '#FF9655', '#FFF263', '#6AF9C4'],
    chart: {
    backgroundColor: {
    linearGradient: [0, 0, 500, 500],
    stops: [
    [0, 'rgb(255, 255, 255)'],
    [1, 'rgb(240, 240, 255)']
    ]
    },
    },
    title: {
    style: {
    color: '#000',
    font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
    }
    },
    subtitle: {
    style: {
    color: '#666666',
    font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
    }
    },
    legend: {
    itemStyle: {
    font: '9pt Trebuchet MS, Verdana, sans-serif',
    color: 'black'
    },
    itemHoverStyle:{
    color: 'gray'
    }
    }
    };
    Highcharts.setOptions(Highcharts.theme);
    Highcharts.setOptions({
        lang: {
            contextButtonTitle: "Menú contextual del diagrama"
            , loading: 'Cargando...'
            , months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre'
                , 'Noviembre'
                , 'Diciembre'
            ]
            , weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
            , shortMonths: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
            , exportButtonTitle: "Exportar"
            , printButtonTitle: "Importar"
            , rangeSelectorFrom: "Desde"
            , rangeSelectorTo: "Hasta"
            , rangeSelectorZoom: "Período"
            , downloadPNG: 'Descargar imagen PNG'
            , downloadJPEG: 'Descargar imagen JPEG'
            , downloadPDF: 'Descargar imagen PDF'
            , downloadSVG: 'Descargar imagen SVG'
            , downloadCSV: 'Descargar CSV'
            , downloadXLS: 'Descargar XLS'
            , viewFullScreen: 'Ver pantalla completa'
            , printChart: 'Imprimir'
            , resetZoom: 'Reiniciar zoom'
            , resetZoomTitle: 'Reiniciar zoom'
            , thousandsSep: ","
            , decimalPoint: '.'
            , viewFullscreen: "Ver en pantalla completa"
            , viewdataTable: "Ver en pantalla completa"
        }
    });
    Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null
            , plotBorderWidth: null
            , plotShadow: false
            , type: 'pie'
        }
        , title: {
            text: ''
        }
        , tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            , enabled: false
        }
        , accessibility: {
            point: {
                valueSuffix: '%'
            }
        }
        , plotOptions: {
            pie: {
                allowPointSelect: true
                , cursor: 'pointer'
                , dataLabels: {
                    enabled: true
                    , format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        }
        , series: [{
            name: 'Brands'
            , colorByPoint: true
            , data: <?= $data ?>
        }]
    });
</script>
@endsection
