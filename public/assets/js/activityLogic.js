
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: false,
        selectable: true,
        displayEventTime: false,
        selectHelper: true,
        eventLimit: 3,
        events: {
            url: 'getactivity', // URL to the API that returns events
            method: 'GET',
            failure: function () {
                alert('There was an error fetching activities!');
            },
        },
        select: function (info) {
            // Get the selected date and format it
            var events = calendar.getEvents();
            var maxEventsPerDay = 4; // set the maximum number of events per day here
            var date = info.start.toISOString().substring(0, 10);

            // check if the maximum number of events per day has been reached
            if (events.filter(event => event.start.toISOString().substring(0, 10) === date).length >= maxEventsPerDay) {
                alert('Maximum number of activity per day reached!');
                return;
            }

            var date = info.startStr;

            // Show the modal
            $('#addActivity').modal('show');
            $('#imagePreview2').css('display', 'none');
            $('#activityTitle').val('');
            $('#activityDesc').val('');
            $('#activityImage').val('');

            $('#add_activity').unbind().on('submit', function (e) {
                e.preventDefault();

                // Create a new form data object
                var formData = new FormData(this);

                // Append the date to the form data
                formData.append('date', date);

                // Append the CSRF token to the form data
                formData.append('_token', csrfToken);

                // Send the Ajax request
                $.ajax({
                    url: "/saveactivity",
                    data: formData,
                    type: "POST",
                    processData: false,
                    contentType: false,

                    beforeSend: function () {
                        $('#add_activity button[type="submit"]').attr('disabled', true);
                    },
                    //handle status code
                    statusCode: {
                        200: function (data) {
                            $('#add_activity button[type="submit"]').attr('disabled', false);
                            //render the new activity
                            calendar.addEvent({
                                id: data.data.id,
                                title: data.data.title,
                                desc: data.data.description,
                                image: data.data.image,
                                start: data.data.date,
                                allDay: true
                            });
                            $('#addActivity').modal('hide');
                            displayMessage("Activity Created Successfully");
                        },
                        400: function (jqXHR) {
                            $('#add_activity button[type="submit"]').attr('disabled', false);
                            displayMessage(jqXHR.responseJSON); // Display the error message from the response
                        },
                        500: function () {
                            $('#add_activity button[type="submit"]').attr('disabled', false);
                            displayMessage("Internal Server Error");
                        }
                    },
                });
            });
        },

        eventClick: function (info) {
            $('#EditActivity').modal('show');
            // populate the form fields with the event's data
            $('#editActivityTitle').val(info.event.title);
            $('#editActivityDesc').val(info.event.extendedProps.desc);

            // handle the Edit activity
            $('#edit_activity').unbind().on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('_method', 'PUT');
                formData.append('_token', csrfToken);


                // send the update request to the backend API
                $.ajax({
                    url: "editactivity/" + info.event.id,
                    data: formData,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#edit_activity button[type="submit"]').attr('disabled', true);
                    },
                    //handle status code
                    statusCode: {
                        200: function (data) {
                            $('#edit_activity button[type="submit"]').attr('disabled', false);

                            // update the event's data and render it on the calendar
                            info.event.setProp('title', data.data.title);
                            info.event.setExtendedProp('desc', data.data.description);
                            info.event.setExtendedProp('image', data.data.image);
                            info.event.setStart(data.data.date);
                            calendar.refetchEvents();
                            $('#EditActivity').modal('hide');
                            displayMessage("Activity Updated Successfully");
                        },
                        500: function () {
                            $('#add_activity button[type="submit"]').attr('disabled', false);
                            displayMessage("Internal Server Error");
                        }
                    },
                });
            });

            // handle the delete activity
            $('#delete_activity').unbind().on('click', function () {

                // send the update request to the backend API
                $.ajax({
                    url: "deleteactivity/" + info.event.id,
                    type: "get",
                    processData: false,
                    contentType: false,
                    //handle status code
                    statusCode: {
                        200: function (data) {
                            calendar.refetchEvents();
                            $('#EditActivity').modal('hide');
                            displayMessage("Activity Deleted Successfully");
                        },
                        500: function () {
                            displayMessage("Internal Server Error");
                        }
                    },
                });
            });
        }

    });
    calendar.render();
});

function displayMessage(message) {
    alert(message);
}


//function to preview image
function previewImage(event, id) {
    var input = event.target;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var imagePreview = document.getElementById(id);
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

