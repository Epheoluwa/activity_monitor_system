@extends('welcome')

@section('content')
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body">
            <a class="btn btn-primary mb-3 text-white" style="cursor:pointer" data-toggle="modal" data-target="#createModal">
                <span class="fa fa-plus"></span>
                Add New User Activity
            </a>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sn = 0; ?>

                        <tr class="warning">
                            <td><?= ++$sn ?></td>
                            <td>

                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                                remember to add the id to the modal pop up and modal id as done before
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action &nbsp;
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item btn-sm" style="cursor:pointer" data-toggle="modal" data-target="#editModal"> <i class="fas fa-edit"></i> Edit Activity</a>
                                        <form id="credit-form" action="{{url('/admin/delete-recipe')}}" method="post">
                                            {{ csrf_field() }}

                                            <button class="dropdown-item btn-sm" style="cursor:pointer; background: red;
    color: white;" id="pay" type="submit"> <i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </form>

                                    </div>
                                </div>

                                <!-- Edit user Modal-->
                                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form id="add_activity" enctype="multipart/form-data" method="post">
                                                <div class="modal-body">
                                                    <h4>Add New User Activity</h4>
                                                    <div class="mt-2">
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
                                                    <div class="mt-2">
                                                        <label>Date</label>
                                                        <input type="date" name="activityDate" id="activityDate" class="form-control">
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
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add new modal  -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add_activity" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <h4>Add New User Activity</h4>
                    <div class="mt-2">
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
                    <div class="mt-2">
                        <label>Date</label>
                        <input type="date" name="activityDate" id="activityDate" class="form-control">
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


@endsection