@extends('welcome')

@section('content')
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <a class="btn btn-secondary mb-3 text-white" style="cursor:pointer" href="{{ url('users') }}">
                    <span class="fa fa-arrow-left" aria-hidden="true"></span>
                    All Users
                </a>
                <a class="btn btn-primary mb-3 text-white" style="cursor:pointer" data-toggle="modal" data-target="#createModal">
                    <span class="fa fa-plus"></span>
                    Add New User Activity
                </a>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sn = 0; ?>
                        <!-- Display the user specific activities -->
                        @if ($activitiesData['userActivities']->isNotEmpty())
                        @foreach ($activitiesData['userActivities'] as $data)
                        <tr>
                            <td><?= ++$sn ?></td>
                            <td>{{ $data->title }}</td>
                            <td>{{ $data->description }}</td>
                            <td>
                                <img src="{{ asset('/Images/activity/' .$data->image) }}" height="150px" width="150px" />
                            </td>
                            <td>{{ $data->date }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action &nbsp;
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item btn-sm" style="cursor:pointer" data-toggle="modal" data-target="#editModal{{$data->id}}"> <i class="fas fa-edit"></i> Edit Activity</a>
                                        <form action="{{ url('delete-user-activity', $data->id) }}" method="post"  onsubmit="return confirm('Are you sure you want to delete this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item btn-sm" style="cursor:pointer; background: red; color: white;"> <i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- Edit modal -->
                                @include('utils.userActivity')
                            </td>
                        </tr>
                        @endforeach
                        @endif

                        <!-- Display the global activities -->
                        @if ($activitiesData['globalActivities']->isNotEmpty())
                        @foreach ($activitiesData['globalActivities'] as $data)
                        <tr>
                            <td><?= ++$sn ?></td>
                            <td>{{ $data->activity->title }}</td>
                            <td>{{ $data->activity->description }}</td>
                            <td>
                                <img src="{{ asset('/Images/activity/' .$data->activity->image) }}" height="150px" width="150px" />
                            </td>
                            <td>{{ $data->activity->date }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action &nbsp;
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item btn-sm" style="cursor:pointer" data-toggle="modal" data-target="#editModal{{$data->activity->id}}"> <i class="fas fa-edit"></i> Edit Activity</a>

                                        <form action="{{ url('delete-user-activity-global', $data->activity->id) }}" method="post"  onsubmit="return confirm('Are you sure you want to delete this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="user_id" value="{{$user_id['user_id']}}">
                                            <button type="submit" class="dropdown-item btn-sm" style="cursor:pointer; background: red; color: white;"> <i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        </form>
<!-- 
                                        <a class="dropdown-item btn-sm" style="cursor:pointer; background: red; color: white;" href="{{ url('delete-user-activity-global', $data->id, $user_id['user_id']) }}"> <i class="fa fa-trash" aria-hidden="true"></i> Delete</a> -->

                                    </div>
                                </div>
                                <!-- Edit modal -->
                                @include('utils.MainActivity')
                            </td>
                        </tr>
                        @endforeach
                        @endif

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
            <form id="add_activity" enctype="multipart/form-data" method="post" action="{{url('users-activity-post')}}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <h4>Add New User Activity</h4>
                    <div class="mt-2">
                        <label>Title</label>
                        <input type="text" name="activityTitle" id="activityTitle" class="form-control" required>
                        <input type="hidden" name="user_id" id="user_id" value="{{$user_id['user_id']}}" class="form-control" required>
                    </div>
                    <div class="mt-2">
                        <label>Description</label>
                        <textarea name="activityDesc" id="activityDesc" class="form-control" required></textarea>
                    </div>
                    <div class="mt-2 d-flex justify-content-center">
                        <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 300px; max-height: 300px; display: none;">
                    </div>
                    <div class="mt-2">
                        <label>Image</label>
                        <input type="file" name="activityImage" id="activityImage" class="form-control" onchange="previewImage(event, 'imagePreview')" required>
                    </div>
                    <div class="mt-2">
                        <label>Date</label>
                        <input type="date" name="date" id="date" min="{{date('Y-m-d')}}" class="form-control" required>
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
    function previewImage(event) {
        var input = event.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection