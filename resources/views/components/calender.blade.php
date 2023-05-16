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

<!-- Add new modal  -->
<div class="modal fade" id="addActivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add_activity" enctype="multipart/form-data"  method="post">
          
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
                    <div class="mt-2 d-flex justify-content-center">
                        <img id="imagePreview2" src="#" alt="Image Preview" style="max-width: 300px; max-height: 300px; display: none;">
                    </div>
                    <div class="mt-2">
                        <label>Image</label>
                        <input type="file" name="activityImage" id="activityImage" class="form-control" onchange="previewImage(event, 'imagePreview2')">
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

<!-- //Edit modal  -->
<div class="modal fade" id="EditActivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="edit_activity" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <h4>Update/Delete Activity Record</h4>
                    <div class="">
                        <label>Title</label>
                        <input type="text" name="editActivityTitle" id="editActivityTitle" class="form-control">
                    </div>
                    <div class="mt-2">
                        <label>Description</label>
                        <textarea name="editActivityDesc" id="editActivityDesc" class="form-control"></textarea>
                    </div>
                
                    <div class="mt-2">
                        <label>Image</label>
                        <input type="file" name="editActivityImage" id="editActivityImage" class="form-control" >

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger ml-auto" id="delete_activity">Delete this Activity</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Update Activity">
                </div>
            </form>
        </div>
    </div>
</div>