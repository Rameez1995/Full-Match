@extends('admin.layouts.app')

@section('content')
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card animate fadeUp">
                            <div class="card-content">
                                <h4 class="header mt-0">
                                    Club
                                    @can('add-club')
                                    <a href="{{ URL::route('club-form.create') }}" class="waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow right">Add</a>
                                        @endcan
                                </h4>
                                <div class="row">
                                    <div class="col s12">
                                        @if ($clubaddsuccess = Session::get('clubaddsuccess'))
                                            <div class="card-alert card gradient-45deg-green-teal">
                                                <div class="card-content white-text">
                                                    <p>
                                                        <i class="material-icons"></i>{{ $clubaddsuccess }}</p>
                                                </div>
                                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        @endif
                                        @if ($clubeditsuccess = Session::get('clubeditsuccess'))
                                            <div class="card-alert card gradient-45deg-green-teal">
                                                <div class="card-content white-text">
                                                    <p>
                                                        <i class="material-icons"></i>{{ $clubeditsuccess }}</p>
                                                </div>
                                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        @endif
                                        @if ($clubdelsuccess = Session::get('clubdelsuccess'))
                                            <div class="card-alert card gradient-45deg-green-teal">
                                                <div class="card-content white-text">
                                                    <p>
                                                        <i class="material-icons"></i>{{ $clubdelsuccess }}</p>
                                                </div>
                                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        @endif
                                        <table id="page-length-option" class="display">
                                            <thead>
                                            <tr>
                                                <th width="10%">Name</th>
                                                <th width="10%">Logo </th>
                                                <th width="10%">Banner</th>
                                                <th width="10%">Description</th>
                                                <th width="10%">Sorting</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($club as $club)
                                                <tr>
                                                    <td>{{ $club->name_en }}</td>
                                                    <td><img src="{{ asset('app-assets/images/club/'.$club->club_logo)}}" style="width:50px;height:50px;" /></td>
                                                    <td><img src="{{ asset('app-assets/images/club/'.$club->club_banner)}}" style="width:50px;height:50px;" /></td>
                                                    <td>{{ substr_replace(strip_tags($club->description_en,'descriptionn'), "...", 20) }}</td>
                                                    <td>{{ $club->club_sorting }}</td>
                                                    <td><form action="{{ route('club-form.destroy', $club->id)}}" method="post">
                                                            @can('edit-club')
                                                            <a href="{{ route('club-form.edit',$club->id)}}" class="dt-button buttons-excel buttons-html5 waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow">Edit</a>
                                                            @endcan
                                                                {{ csrf_field() }}
                                                                @can('delete-club')
                                                                @method('DELETE')
                                                            <button onclick="return window.confirm('Are you sure you want to delete this record?');" class="dt-button buttons-excel buttons-html5 waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow" type="submit">Delete</button>
                                                            @endcan
                                                        </form></td>
                                            @endforeach
                                            </tbody>


                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
@endsection
@section('scripts')
    <script src={{ asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}></script>
    <script src={{ asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}></script>
    <script src={{ asset('app-assets/vendors/data-tables/js/dataTables.select.min.js') }}></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <style type="text/css">
        div.dt-buttons {
            margin-bottom:20px;
        }

    </style>
    <script type="text/javascript">
        $(document).ready(function(){

            $('#page-length-option').DataTable({
                "responsive": true,
                "lengthMenu": [
                    [10, 25, 50, 75, 100, -1],
                    [10, 25, 50, 75, 100, "All"]
                ],
                "order":[[4,"asc"]],
                buttons: [
                    {
                        extend: 'excel',
                        text: '{{ __("customer.excel") }}',
                        className: 'waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow',
                        filename : '{{ __("customer.excel") }}' ,
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5 ]
                        },
                    },
                    {
                        extend: 'csv',
                        text: '{{ __("customer.csv") }}',
                        className: 'waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow',
                        filename : '{{ __("customer.csv") }}' ,
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5 ]
                        },
                    }
                ],
                dom: 'Blfrtip',
            });
        });
    </script>
@endsection
