<div class="modal fade" id="editModal{{$data->activity->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add_activity" enctype="multipart/form-data" method="post" action="{{url('/admin/edit-meal', $data->activity->id)}}">
            {{ csrf_field() }}
                <div class="modal-body">
                    <h4>Edit Activity</h4>
                    <div class="mt-2">
                        <label>Title</label>
                        <input type="text" name="activityTitle" id="activityTitle" class="form-control" value="{{ $data->activity->title }}">
                    </div>
                    <div class="mt-2">
                        <label>Description</label>
                        <textarea name="activityDesc" id="activityDesc" class="form-control">{{ $data->activity->description }}</textarea>
                    </div>
              
                    <div class="mt-2 d-flex justify-content-center">
                        <img  src="{{ asset('/Images/activity/' .$data->activity->image) }}" class="img-fluid " alt="Image Preview" style="max-width: 300px; max-height: 300px; ">
                    </div>
                    <div class="mt-2">
                        <label>Image</label>
                        <input type="file" name="activityImage" id="activityImage" class="form-control" value="{{ $data->activity->image }}" ">
                    </div>
                    <div class="mt-2">
                        <label>Date</label>
                        <input type="date" name="activityDate" id="activityDate" class="form-control" value="{{ $data->activity->date }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Update Activity">
                </div>
            </form>
        </div>
    </div>
</div>