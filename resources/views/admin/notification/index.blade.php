@extends('admin.layouts.app')

@section('content')
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col s12 m12 l12">
                        @if ($notifiyaddsuccess = Session::get('notifiyaddsuccess'))
                            <div class="card-alert card gradient-45deg-green-teal">
                                <div class="card-content white-text">
                                    <p>
                                        <i class="material-icons">check</i>{{ $notifiyaddsuccess }}</p>
                                </div>
                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @elseif($notifiyeditsuccess = Session::get('notifiyeditsuccess'))
                            <div class="card-alert card gradient-45deg-green-teal">
                                <div class="card-content white-text">
                                    <p>
                                        <i class="material-icons">check</i>{{ $notifiyeditsuccess }}</p>
                                </div>
                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @elseif($notifiysendsuccess = Session::get('notifiysendsuccess'))
                            <div class="card-alert card gradient-45deg-green-teal">
                                <div class="card-content white-text">
                                    <p>
                                        <i class="material-icons">check</i>{{ $notifiysendsuccess }}</p>
                                </div>
                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif
                        <div class="card animate fadeUp">
                            <div class="card-content">
                                <h4 class="header mt-0">
                                    {{ __('customer.notification.notification_section') }}
                                    @can('add-notify')
                                    <a href="{{ route('notification.create') }}" class="waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow right"> {{ __('customer.add') }}</a>
                                    @endcan
                                </h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="page-length-option" class="display">
                                            <thead>
                                            <tr>
                                                <th>{{ __('customer.id') }}</th>
                                                <th>{{ __('customer.title') }}</th>
                                                <th>{{ __('customer.decs') }}</th>
                                                <th>{{ __('customer.notification.notification_type') }}</th>
                                                <th>{{ __('customer.notification.notifi_date_time') }}</th>
                                                <th>{{ __('customer.action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($notifications as $notification)
                                                <tr>
                                                    <td>{{ $notification->id }}</td>
                                                    <td>{{ $notification->notify_title }}</td>
                                                    <td>{{ $notification->notify_text }}</td>
                                                    @if($notification->notify_type == 1)
                                                        <td>{{ __('customer.notification.all_user') }}</td>
                                                    @elseif($notification->notify_type == 2)
                                                        <td>{{ __('customer.notification.guest_user') }}</td>
                                                    @elseif($notification->notify_type == 3)
                                                        <td>{{ __('customer.notification.registered_user') }}</td>
                                                    @endif
                                                    <td>{{ $notification->created_at }}</td>
                                                    <td>
                                                        @can('edit-notify')
                                                            <a class="mb-5 btn waves-effect waves-light gradient-45deg-purple-deep-orange" href="{{ route('notification.edit',[ 'notification' => $notification->id ]) }}">{{ __('customer.customer.edit') }}</a>
                                                        @endcan
                                                        <a class="mb-5 btn waves-effect waves-light gradient-45deg-purple-deep-orange" href="{{ route('notification.show',[ 'notification' => $notification->id ]) }}">{{ __('customer.view') }}</a>
                                                        @can('edit-notify')
                                                            <a class="mb-5 btn waves-effect waves-light gradient-45deg-purple-deep-orange" href="{{ route('notification.send',$notification->id) }}">{{ __('customer.notification.send_notifi') }}</a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>{{ __('customer.id') }}</th>
                                                <th>{{ __('customer.title') }}</th>
                                                <th>{{ __('customer.decs') }}</th>
                                                <th>{{ __('customer.notification.notification_type') }}</th>
                                                <th>{{ __('customer.notification.notifi_date_time') }}</th>
                                                <th>{{ __('customer.action') }}</th>
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
                            columns: [ 0,1,2,3]
                        },
                    },
                    {
                        extend: 'csv',
                        text: '{{ __("customer.csv") }}',
                        className: 'waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow',
                        filename : '{{ __("customer.csv") }}' ,
                        exportOptions: {
                            columns: [ 0,1,2,3 ]
                        },
                    }
                ],
                dom: 'Blfrtip',
            });
        });
    </script>
@endsection
