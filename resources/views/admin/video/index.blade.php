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
                                        Player
                                        <a href="{{ URL::route('player-form.create') }}" class="waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow right">Add Player</a>
                                    </h4>
                                    <div class="row">
                                        <div class="col s12">
                                            <h2></h2>
                                            <table id="page-length-option" class="display">
                                                <thead>
                                                <tr>
                                                 <th width="10%">Video Title</th>
                                                  <th width="10%">Video Banner</th>
                                                  <th width="10%">Video Image</th>
                                                  <th width="10%">Video Description</th>
                                                  <th width="10%">Video Link</th>
                                                  <th width="10%">Video Duration</th>
                                                   <th width="10%">Action</th>
                                                   <th width="10%">Action</th>
                                                   <th width="10%">Action</th>
                                                 </tr>
                                                </thead>
                                                 <tbody>
                                                 @foreach($video as $video)
                                                 <tr>
                                               <td>{{ $video->video_title }}</td>
                                               <td><img src="/images/{{ $video->video_banner_img }}"  class="img-thumbnail" width="75" /></td>
                                               <td><img src="/images/{{ $video->video_img}}"  class="img-thumbnail" width="75" /></td>
                                               <td>{{ $video->video_description }}</td>
                                               <td>{{ $video->video_link }}</td>
                                               <td>{{ $video->video_duration }}</td>
                                               <td><a href="{{ url('videoclub/'.$video->id)}}" class="btn btn-small" >Club details </a></td>
                                               <td><a href="{{ url('videoplayer/'.$video->id)}}" class="btn btn-small" >Player details </a></td>  
                                               <td><form action="{{ route('video-form.destroy', $video->id)}}" method="post">
                                                {{ csrf_field() }}
                                                @method('DELETE')
                                                <button class="btn btn-small" type="submit">Delete</button>
                                                </form></td>
                                                </td>
                                                </tr>
                                                 @endforeach
                                                 </tbody>                                     
                                                 </tbody>
                                                <tfoot>
                                                <tr>
{{--                                                    <th>{{ __('order.email') }}</th>--}}
                                                    <th>a</th>
                                                    <th>a</th>
                                                    <th>a</th>
                                                    <th>a</th>
                                                    <th>a</th>
                                                    <th>a</th>
                                                    <th>a</th>
                                                </tr>
                                                </tfoot>
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
      <script src="app-assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <script src="app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js"></script>
    <script src="app-assets/vendors/data-tables/js/dataTables.select.min.js"></script>
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
                buttons: [
                    {
                        extend: 'excel',
                        text: '{{ __("customer.excel") }}',
                        className: 'waves-effect waves-light btn-small',
                        filename : '{{ __("customer.excel") }}' ,
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5,6,7 ]
                        },
                    },
                    {
                        extend: 'csv',
                        text: '{{ __("customer.csv") }}',
                        className: 'waves-effect waves-light btn-small',
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
