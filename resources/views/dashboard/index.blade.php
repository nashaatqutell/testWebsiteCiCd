@extends('dashboard.master')
@section('title', __('keys.home'))

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-2">
                    <div class="col">
                        <h2 class="h5 page-title">{{ __('keys.welcome') }}!</h2>
                    </div>
                    <div class="col-auto">
                        <form class="form-inline">
                            <div class="form-group d-none d-lg-inline">
                                <span class="small"> {{ now()->format('F j, Y') }} <div class="clock" id="clock"></div>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- info small box -->
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <span class="h2 mb-0">{{ $servicesCount }}</span>
                                        <p class="small text-muted mb-0">{{ __('keys.service') }}</p>
                                    </div>
                                    <div class="col-auto">
                                        <span class="fe fe-32 fe-briefcase text-muted mb-0"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <span class="h2 mb-0">{{ $contactsCount }}</span>
                                        <p class="small text-muted mb-0">{{ __('keys.message') }}</p>
                                    </div>
                                    <div class="col-auto">
                                        <span class="fe fe-32 fe-phone text-muted mb-0"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <span class="h2 mb-0">{{ $employeesCount }}</span>
                                        <p class="small text-muted mb-0">{{ __('keys.employees') }}</p>
                                    </div>
                                    <div class="col-auto">
                                        <span class="fe fe-32 fe-users text-muted mb-0"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end section -->


                <div class="row">
                    <!-- Recent Activity -->
                    <div class="col-md-12 col-lg-12 mb-4">
                        <div class="card timeline shadow">
                            <div class="card-header">
                                <strong class="card-title">{{__('activity.activity_log')}}</strong>
                                <a class="float-right small text-muted"
                                   href="{{route('admin.fetch_activity')}}">{{__('activity.view_all')}}</a>
                            </div>
                            <div class="card-body" data-simplebar
                                 style="height:355px; overflow-y: auto; overflow-x: hidden;">
                                <h6 class="text-uppercase text-muted mb-4">{{__('activity.last_activity')}}</h6>
                                <div class="pb-3 timeline-item ">
                                    @foreach($activities as $activity)
                                        <div class="pl-5">
                                            <div class="mb-1">
                                                {{ $loop->iteration }}
                                            </div>
                                            <div class="mb-1">
                                                <strong>
                                                    <a href="{{ route('admin.profile.show', $activity->causer->id ?? '#') }}">
                                                        {{ $activity->causer->name ?? 'Admin' }}
                                                    </a>
                                                </strong>
                                                <span
                                                    class="text-muted small mx-2">   @if(App::isLocale('ar'))
                                                        {{ $activity->description_ar }}
                                                    @else
                                                        {{ $activity->description_en }}
                                                    @endif
                                                </span>
                                            </div>
                                            <p class="small text-muted">
                                                {{ $activity->created_at->diffForHumans() }}
                                                <span
                                                    class="badge badge-light">{{ $activity->created_at->format('g:i A') }}</span>
                                            </p>
                                        </div>
                                    @endforeach

                                </div>
                            </div> <!-- / .card-body -->
                        </div> <!-- / .card -->
                    </div> <!-- / .col-md-6 -->
                    <!-- Striped rows -->
{{--                    <div class="col-md-12 col-lg-8">--}}
{{--                        <div class="card shadow">--}}
{{--                            <div class="card-header">--}}
{{--                                <strong class="card-title">Recent Data</strong>--}}
{{--                                <a class="float-right small text-muted" href="#!">View all</a>--}}
{{--                            </div>--}}
{{--                            <div class="card-body my-n2">--}}
{{--                                <table class="table table-striped table-hover table-borderless">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th>ID</th>--}}
{{--                                        <th>Name</th>--}}
{{--                                        <th>Address</th>--}}
{{--                                        <th>Date</th>--}}
{{--                                        <th>Action</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    <tr>--}}
{{--                                        <td>2474</td>--}}
{{--                                        <th scope="col">Brown, Asher D.</th>--}}
{{--                                        <td>Ap #331-7123 Lobortis Avenue</td>--}}
{{--                                        <td>13/09/2020</td>--}}
{{--                                        <td>--}}
{{--                                            <div class="dropdown">--}}
{{--                                                <button class="btn btn-sm dropdown-toggle more-vertical"--}}
{{--                                                        type="button" id="dr1" data-toggle="dropdown"--}}
{{--                                                        aria-haspopup="true" aria-expanded="false">--}}
{{--                                                    <span class="text-muted sr-only">Action</span>--}}
{{--                                                </button>--}}
{{--                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dr1">--}}
{{--                                                    <a class="dropdown-item" href="#">Edit</a>--}}
{{--                                                    <a class="dropdown-item" href="#">Remove</a>--}}
{{--                                                    <a class="dropdown-item" href="#">Assign</a>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>2786</td>--}}
{{--                                        <th scope="col">Leblanc, Yoshio V.</th>--}}
{{--                                        <td>287-8300 Nisl. St.</td>--}}
{{--                                        <td>04/05/2019</td>--}}
{{--                                        <td>--}}
{{--                                            <div class="dropdown">--}}
{{--                                                <button class="btn btn-sm dropdown-toggle more-vertical"--}}
{{--                                                        type="button" id="dr2" data-toggle="dropdown"--}}
{{--                                                        aria-haspopup="true" aria-expanded="false">--}}
{{--                                                    <span class="text-muted sr-only">Action</span>--}}
{{--                                                </button>--}}
{{--                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dr2">--}}
{{--                                                    <a class="dropdown-item" href="#">Edit</a>--}}
{{--                                                    <a class="dropdown-item" href="#">Remove</a>--}}
{{--                                                    <a class="dropdown-item" href="#">Assign</a>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>2747</td>--}}
{{--                                        <th scope="col">Hester, Nissim L.</th>--}}
{{--                                        <td>4577 Cras St.</td>--}}
{{--                                        <td>04/06/2019</td>--}}
{{--                                        <td>--}}
{{--                                            <div class="dropdown">--}}
{{--                                                <button class="btn btn-sm dropdown-toggle more-vertical"--}}
{{--                                                        type="button" data-toggle="dropdown" aria-haspopup="true"--}}
{{--                                                        aria-expanded="false">--}}
{{--                                                    <span class="text-muted sr-only">Action</span>--}}
{{--                                                </button>--}}
{{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
{{--                                                    <a class="dropdown-item" href="#">Edit</a>--}}
{{--                                                    <a class="dropdown-item" href="#">Remove</a>--}}
{{--                                                    <a class="dropdown-item" href="#">Assign</a>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>2639</td>--}}
{{--                                        <th scope="col">Gardner, Leigh S.</th>--}}
{{--                                        <td>P.O. Box 228, 7512 Lectus Ave</td>--}}
{{--                                        <td>04/08/2019</td>--}}
{{--                                        <td>--}}
{{--                                            <div class="dropdown">--}}
{{--                                                <button class="btn btn-sm dropdown-toggle more-vertical"--}}
{{--                                                        type="button" id="dr4" data-toggle="dropdown"--}}
{{--                                                        aria-haspopup="true" aria-expanded="false">--}}
{{--                                                    <span class="text-muted sr-only">Action</span>--}}
{{--                                                </button>--}}
{{--                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dr4">--}}
{{--                                                    <a class="dropdown-item" href="#">Edit</a>--}}
{{--                                                    <a class="dropdown-item" href="#">Remove</a>--}}
{{--                                                    <a class="dropdown-item" href="#">Assign</a>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>2238</td>--}}
{{--                                        <th scope="col">Higgins, Uriah L.</th>--}}
{{--                                        <td>Ap #377-5357 Sed Road</td>--}}
{{--                                        <td>04/01/2019</td>--}}
{{--                                        <td>--}}
{{--                                            <div class="dropdown">--}}
{{--                                                <button class="btn btn-sm dropdown-toggle more-vertical"--}}
{{--                                                        type="button" id="dr5" data-toggle="dropdown"--}}
{{--                                                        aria-haspopup="true" aria-expanded="false">--}}
{{--                                                    <span class="text-muted sr-only">Action</span>--}}
{{--                                                </button>--}}
{{--                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dr5">--}}
{{--                                                    <a class="dropdown-item" href="#">Edit</a>--}}
{{--                                                    <a class="dropdown-item" href="#">Remove</a>--}}
{{--                                                    <a class="dropdown-item" href="#">Assign</a>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div> <!-- Striped rows -->--}}
                </div> <!-- .row-->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
    <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">Notifications</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="list-group list-group-flush my-n3">
                        <div class="list-group-item bg-transparent">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="fe fe-box fe-24"></span>
                                </div>
                                <div class="col">
                                    <small><strong>Package has uploaded successfull</strong></small>
                                    <div class="my-0 text-muted small">Package is zipped and uploaded</div>
                                    <small class="badge badge-pill badge-light text-muted">1m ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="fe fe-download fe-24"></span>
                                </div>
                                <div class="col">
                                    <small><strong>Widgets are updated successfull</strong></small>
                                    <div class="my-0 text-muted small">Just create new layout Index, form,
                                        table
                                    </div>
                                    <small class="badge badge-pill badge-light text-muted">2m ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="fe fe-inbox fe-24"></span>
                                </div>
                                <div class="col">
                                    <small><strong>Notifications have been sent</strong></small>
                                    <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus commodo
                                    </div>
                                    <small class="badge badge-pill badge-light text-muted">30m ago</small>
                                </div>
                            </div> <!-- / .row -->
                        </div>
                        <div class="list-group-item bg-transparent">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="fe fe-link fe-24"></span>
                                </div>
                                <div class="col">
                                    <small><strong>Link was attached to menu</strong></small>
                                    <div class="my-0 text-muted small">New layout has been attached to the menu
                                    </div>
                                    <small class="badge badge-pill badge-light text-muted">1h ago</small>
                                </div>
                            </div>
                        </div> <!-- / .row -->
                    </div> <!-- / .list-group -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear
                        All
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">Shortcuts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="row align-items-center">
                        <div class="col-6 text-center">
                            <div class="squircle bg-success justify-content-center">
                                <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Control area</p>
                        </div>
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-activity fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Activity</p>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-droplet fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Droplet</p>
                        </div>
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-upload-cloud fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Upload</p>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-users fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Users</p>
                        </div>
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-settings fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Settings</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_script')
    <script>
        function updateClock() {
            const currentTime = new Date();
            const hours = currentTime.getHours().toString().padStart(2, '0');
            const minutes = currentTime.getMinutes().toString().padStart(2, '0');
            const seconds = currentTime.getSeconds().toString().padStart(2, '0');

            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Update the clock every second
        setInterval(updateClock, 1000);
    </script>
@endsection
