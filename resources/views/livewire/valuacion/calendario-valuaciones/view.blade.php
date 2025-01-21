
@section('title', __("Catalogo de Valuaciones"))
<div class="pt-3" x-data="{ eventos: @entangle('eventos') }">

    @livewire('valuacion.mdl-crear-valuacion')
    @livewire('cliente.common.mdl-select-cliente')

    @push('js')
        <script src="{{asset('vendor/fullcalendar-6.1.15/dist/index.global.js')}}"></script>
        <script>

            let calendar;
            function initCalendar() {
                const calendarEl = document.getElementById('calendar');
                calendar = new FullCalendar.Calendar(calendarEl, {
                    headerToolbar: {
                        left: 'prev,today,next',
                        center: 'title',
                        right: null,
                    },
                    events: @this.eventos,
                    initialDate: new Date(),
                    eventTimeFormat: {
                        hour: 'numeric', // 12-hour clock
                        minute: '2-digit',
                        hour12: true,
                        omitZeroMinute: true,
                    },
                    editable: true,
                    dayMaxEvents: true, // allow "more" link when too many events
                    eventClick: function(info) {
                        // window.Livewire.dispatch('initMdlVerCita', [ info.event.id ]);
                        window.location.href = `/valuaciones/${info.event.id}`;
                    },
                    dateClick: function(info) {
                        const date = info.dateStr + ' 12:00:00';
                        window.livewire.emit('initMdlCrearValuacion', date);
                    },
                    locale: 'es',
                });

                calendar.render();
            }

            function addEvent(cita){
                calendar.addEvent({
                    id: cita.id,
                    title: cita.vehiculo,
                    start: cita.fecha_cita,
                    color: cita.valuacion_efectuada ? 'green' : 'red'
                });
            }

            function addTestEvent(){
                calendar.addEvent({
                    id: 1,
                    title: 'Test',
                    start: '2025-01-31 12:00:00',
                    color: 'black'
                });
            }

            Livewire.on('addCalendarEvent',function(event){
                addEvent(event);
            });

            Livewire.on('updateCalendarEvent', function(event) {
                console.log(event[0].id);

                const id = event[0].id;
                const vehiculo = event[0].vehiculo;
                const eventCalendar = calendar.getEventById(id);
                const valuacionEfectuada = event[0].valuacion_efectuada;
                const fecha = event[0].fecha_valuacion;

                // const formattedDate = fecha.replace('T', ' ');

                if (eventCalendar) {
                    eventCalendar.setProp('title', vehiculo);
                    eventCalendar.setProp('color', valuacionEfectuada ? 'green' : 'red');
                    eventCalendar.setStart(fecha);
                    eventCalendar.setEnd(fecha);
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                initCalendar();
            });

        </script>
    @endpush

    @push('css')
        <style>

            .calendar {
                color: black !important;
                padding: 40px 10px;
                font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
                font-size: 14px;
            }

            #calendar {
                max-width: 1100px;
                margin: 0 auto;
            }

            a {
                color: #343a40;
                text-decoration: none;
            }

        </style>
    @endpush


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Calendario de Valuaciones</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0 bg-white">

            <div class="calendar">
                <div id='calendar-container'>
                    <div id='calendar'></div>
                </div>
            </div>

        </div>
    </div>

</div>
