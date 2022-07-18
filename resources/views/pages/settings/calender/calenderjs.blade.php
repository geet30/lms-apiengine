<script>

var green =  KTUtil.getCssVariableValue("--bs-active-success");
var red =  KTUtil.getCssVariableValue("--bs-active-danger");

var calendarEl = document.getElementById("kt_docs_fullcalendar_background_events");


var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
    },
    // initialDate:moment(),
    navLinks: true, // can click day/week names to navigate views
    businessHours: true, // display business hours
    editable: false,
    selectable: true,
    events:{
        
            url : 'get-calendar-events',
            type: "GET",
            extraParams: function() { // a function that returns an object
                return {
                    state_requested: $('#state_requested').val()
                };
            },
            success: function (result) { 
                if(result.success == 'false'){
                    alertify.error(result.message);
                }     
                else {              
                    var data_event=result;
                    var event_array=[              
                        {
                            daysOfWeek: [0,6], //Sundays and saturdays
                            display: "background",
                            color: "darkgray",
                            overLap: false,
                            allDay: true
                        },
                    ];
     

                    $.each(data_event.json, function(index, value) {                       
                        //Pusing event to event array
                        event_array.push({
                                "id":value.id,
                                "title":value.title,
                                "description":value.description,
                                "start":value.start,
                                "end":value.end
                            }
                        );                        
                    });
                    if(data_event.minimum_date !=undefined  && data_event.minimum_date!=''){
                        minimum_date=data_event.minimum_date;
                        var start = moment().format('YYYY-MM-DD');
                        var end = minimum_date;
                        while(start < end){
                            // $("[data-date="+start+"]").css("background-color", "darkgray").css("border-color", "white");
                            start = moment(start).add(1,'d').format('YYYY-MM-DD');
                        }
                    }
                    //retuning to full calender
                    return event_array;
                }
            },
            error: function (error) {
                 toastr.error('Error while fetching records.');
            },
           
            // color: 'green', // a non-ajax option
            overLap: false,
    },
});

calendar.render();
$(document).on('change','#state_requested', function(){
    calendar.refetchEvents();
});

</script>