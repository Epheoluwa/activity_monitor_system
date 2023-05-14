@extends('welcome')

@section('content')
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Email</th>
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
                                <a class="btn btn-info mb-3 text-white" style="cursor:pointer" href="{{ url('users-activity/1') }}">
                                    View User Activities
                                </a>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->


@endsection