<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Date</th>
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
                            
                                </tr>
                            @endforeach
                        @endif

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>