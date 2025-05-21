@extends("dashboard.master")
@section('title', isset($financial_menu) ? __('keys.edit_financial_menu') : __('keys.add_financial_menu'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">{{ isset($financial_menu) ? __('keys.edit_financial_menu') : __('keys.add_financial_menu') }}</strong>
                    </div>
                    <div class="card-body">
                         <form action="{{ $financial_menu->exists ? route('admin.financial_menus.update', $financial_menu->id) :
                                route('admin.financial_menus.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($financial_menu->exists)
                                @method('PUT')
                            @endif
                            @include('dashboard.financialMenu.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
