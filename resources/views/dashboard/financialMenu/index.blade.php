@extends('dashboard.master')
{{-- @section('title', $title) --}}

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{-- <h2 class="h5 page-title">{{ $title }}</h2> --}}
                        @can('create_financials')
                            <a href="{{ route('admin.financial_menus.create') }}" class="btn btn-primary">
                                {{ __('keys.add_new') }}
                            </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>

                                        <th></th>
                                        <th>#</th>
                                        <th>{{ __('keys.title') }}</th>
                                        <th>{{ __('keys.year') }}</th>
                                        <th>{{ __('keys.status') }}</th>
                                        <th>{{ __('keys.download_file') }}</th>
                                        <th>{{ __('keys.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($financial_menus) > 0)
                                        @foreach ($financial_menus as $financial_menu)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $financial_menu->name }}</td>
                                                <td>{{ $financial_menu->year }}</td>
                                                <td>
                                                    @can('active_financials')
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input toggle-status"
                                                                id="customSwitch{{ $financial_menu->id }}"
                                                                data-id="{{ $financial_menu->id }}"
                                                                {{ $financial_menu->is_active ? 'checked' : '' }}>
                                                            <label class="custom-control-label"
                                                                for="customSwitch{{ $financial_menu->id }}"></label>
                                                        </div>
                                                    @endcan

                                                </td>

                                                <td>
                                                    @if ($financial_menu->getMedia('financial_file')->count() > 0)
                                                        <a href="{{ $financial_menu->getFirstMediaUrl('financial_file') }}"
                                                            class="btn btn-sm btn-info d-inline-flex align-items-center gap-1"
                                                            download target="_blank"
                                                            title="{{ __('keys.download_file') }}">
                                                            <i class="fe fe-download m-1"></i>
                                                            {{ __('keys.download') }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted">{{ __('keys.no_file') }}</span>
                                                    @endif
                                                </td>

                                                <td style="width:10%">
                                                    @can('update_financials')
                                                        <a href="{{ route('admin.financial_menus.edit', $financial_menu->id) }}"
                                                            class="btn btn-sm btn-success">
                                                            <i class='fe fe-edit fa-2x'></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete_financials')
                                                        <button class="btn btn-sm btn-danger delete-financial_menu"
                                                            data-id="{{ $financial_menu->id }}">
                                                            <i class="fe fe-trash-2 fa-2x"></i>
                                                        </button>
                                                    @endcan

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="100%">
                                                <div class="no-data">
                                                    <img src="{{ asset('no-data.png') }}" alt="No Data Found">
                                                    <p>{{ __('keys.no_data') }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection
@section('after_script')
    <script>
        $(document).ready(function() {
            $('.toggle-status').on('change', function() {
                var financial_menuId = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.financial_menus.changeStatus', ':id') }}".replace(':id',
                        financial_menuId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(
                                "{{ __('keys.status_updated_successfully') }}"
                            );
                        } else {
                            toastr.error("{{ __('keys.something_wrong') }}");
                        }
                    },
                    error: function() {
                        toastr.error("{{ __('keys.error_occurred') }}");
                    }
                });
            });


            $(document).on('click', '.delete-financial_menu', function(e) {

                e.preventDefault();
                let financial_menuId = $(this).data('id');
                let deleteUrl = "{{ route('admin.financial_menus.destroy', ':id') }}".replace(':id',
                    financial_menuId);
                let row = $(this).closest('tr'); // Select the row to remove

                // SweetAlert confirmation
                Swal.fire({
                    title: "{{ __('keys.confirm_delete') }}",
                    text: "{{ __('keys.are_you_sure') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "{{ __('keys.yes_delete') }}",
                    cancelButtonText: "{{ __('keys.no_cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: "DELETE"
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire("{{ __('keys.deleted') }}",
                                        response.message,
                                        "success");
                                    row.fadeOut(500, function() {
                                        $(this).remove();
                                    });
                                } else {
                                    Swal.fire("{{ __('keys.error') }}",
                                        "{{ __('keys.something_wrong') }}",
                                        "error");
                                }
                            },
                            error: function() {
                                Swal.fire("{{ __('keys.error') }}",
                                    "{{ __('keys.error_occurred') }}", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
