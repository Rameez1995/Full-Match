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
                                    Advertisement Banner
                                    @can('add-advbanner')
                                    <a href="{{ URL::route('banner-form.create') }}" class="waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow right">Add</a>
                                    @endcan
                                </h4>
                                <div class="row">
                                    <div class="col s12">
                                        @if ($advbanneraddsuccess = Session::get('advbanneraddsuccess'))
                                            <div class="card-alert card gradient-45deg-green-teal">
                                                <div class="card-content white-text">
                                                    <p>
                                                        <i class="material-icons"></i>{{ $advbanneraddsuccess }}</p>
                                                </div>
                                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        @endif
                                        @if ($advbannereditsuccess = Session::get('advbannereditsuccess'))
                                            <div class="card-alert card gradient-45deg-green-teal">
                                                <div class="card-content white-text">
                                                    <p>
                                                        <i class="material-icons"></i>{{ $advbannereditsuccess }}</p>
                                                </div>
                                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        @endif
                                        @if ($advbannerdelsuccess = Session::get('advbannerdelsuccess'))
                                            <div class="card-alert card gradient-45deg-green-teal">
                                                <div class="card-content white-text">
                                                    <p>
                                                        <i class="material-icons"></i>{{ $advbannerdelsuccess }}</p>
                                                </div>
                                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        @endif
                                        <table id="page-length-option" class="display">
                                            <thead>
                                            <tr>
                                                <th width="15%">Video Title</th>
                                                <th width="15%">Video Banner</th>
                                                <th width="25%">Video Link</th>
                                                <th width="50%">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Adv_banner as $adv_banner)
                                                <tr>
                                                    <td>{{$adv_banner->video_title}}</td>
                                                    <td><img src="{{ asset('app-assets/images/advbanner/'.$adv_banner->video_banner)}}" style="width:50px;height:50px;" /></td>
                                                    <td>{{$adv_banner->video_link}}</td>
                                                    <td><form action="{{ route('banner-form.destroy', $adv_banner->id)}}" method="post">
                                                            <a href="{{ url('adv_banner/'.$adv_banner->id)}}" class="dt-button buttons-excel buttons-html5 waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow">Details</a>
                                                            @can('edit-advbanner')
                                                            <a href="{{ route('banner-form.edit',$adv_banner->id)}}" class="dt-button buttons-excel buttons-html5 waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow">Edit</a>
                                                            @endcan
                                                                {{ csrf_field() }}
                                                            @can('edit-advbanner')
                                                            @method('DELETE')
                                                            <button onclick="return window.confirm('Are you sure you want to delete this record?');" class="dt-button buttons-excel buttons-html5 waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow" type="submit">Delete</button>
                                                            @endcan
                                                        </form>
                                                    </td>
                                                </tr>
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
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                buttons: [
                    {
                        extend: 'excel',
                        text: '{{ __("customer.excel") }}',
                        className: 'waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow',
                        filename : '{{ __("customer.excel") }}' ,
                        exportOptions: {
                            columns: [ 0,1,2 ]
                        },
                    },
                    {
                        extend: 'csv',
                        text: '{{ __("customer.csv") }}',
                        className: 'waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow',
                        filename : '{{ __("customer.csv") }}' ,
                        exportOptions: {
                            columns: [ 0,1,2 ]
                        },
                    }
                ],
                dom: 'Blfrtip',
            });
        });
    </script>
@endsection
