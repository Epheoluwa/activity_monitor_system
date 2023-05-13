@extends('welcome')

@section('content')


<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4 p-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Calender</h6>
            </div>
             <div id='calendar'></div>

        </div>
    </div>

</div>

<div class="modal fade" id="addActivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add_activity" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <h4>Add New Activity</h4>
                    <div class="">
                        <label>Title</label>
                        <input type="text" name="activityTitle" id="activityTitle" class="form-control">
                    </div>
                    <div class="mt-2">
                        <label>Description</label>
                        <textarea name="activityDesc" id="activityDesc" class="form-control"></textarea>
                    </div>
                    <div class="mt-2">
                        <label>Image</label>
                        <input type="file" name="activityImage" id="activityImage" class="form-control">

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Save Activity">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true,
            selectable: true,
            displayEventTime: false,
            selectHelper: true,
            select: function(info) {
                // Get the selected date and format it
                var date = info.startStr;

                // Show the modal
                $('#addActivity').modal('show');
                $('#activityTitle').val('');
                $('#activityDesc').val('');
                $('#activityImage').val('');

                $('#add_activity').unbind().on('submit', function(e) {
                    e.preventDefault();

                    // Create a new form data object
                    var formData = new FormData(this);

                    // Append the date to the form data
                    formData.append('date', date);

                    // Append the CSRF token to the form data
                    formData.append('_token', "{{ csrf_token() }}");

                    // Send the Ajax request
                    $.ajax({
                        url: "/saveactivity",
                        data: formData,
                        type: "POST",
                        processData: false,
                        contentType: false,

                        beforeSend: function() {
                            $('#add_activity button[type="submit"]').attr('disabled', true);
                        },
                        //handle status code
                        statusCode: {
                            200: function(data) {
                                $('#add_activity button[type="submit"]').attr('disabled', false);

                                calendar.addEvent({
                                    id: data.id,
                                    title: data.title,
                                    desc: data.desc,
                                    image: data.image,
                                    start: data.start,
                                    allDay: true
                                });
                                $('#addActivity').modal('hide');
                                displayMessage("Activity Created Successfully");
                            },
                            400: function(jqXHR, textStatus, errorThrown) {
                                $('#add_activity button[type="submit"]').attr('disabled', false);
                                displayMessage(jqXHR.responseJSON.errors.date || jqXHR.responseJSON.errors.activityDesc || jqXHR.responseJSON.errors.activityImage || jqXHR.responseJSON.errors.activityTitle);
                            },
                            500: function() {
                                $('#add_activity button[type="submit"]').attr('disabled', false);
                                displayMessage("Internal Server Error");
                            }
                        },
                        // success: function(data) {
                        //     console.log(data);
                        //     if (data.success == true) {
                        //         // displayMessage("Activity Created Successfully");
                        //     } else {
                        //         displayMessage(data.errors.date || data.errors.description || data.errors.image || data.errors.title);
                        //     }



                        //     // $('#addActivity').modal('hide');
                        // }
                    });
                });
            }
        });
        calendar.render();
    });

    function displayMessage(message) {
        alert(message);
    }
</script>
@endsection