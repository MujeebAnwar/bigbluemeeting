@extends('public.layouts.app')
@section('pagename', $pageName)
@section('css')
    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/front.css?v=time()')}}">
@stop
@section('content')
    <div id="data">
        @include('includes.meetingAccessCodeForm')
    </div>


@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src={{asset('js/jquery.dataTables.min.js')}}></script>
    <!-- Data Bootstarp -->
    <script type="text/javascript" src={{asset('js/dataTables.bootstrap4.min.js')}}></script>
    <script>
        $(document).ready(function () {
            $('#data').on('submit','#accessFrm',function (e) {
                e.preventDefault();
                frmData =$(this).serialize();
                $.post('{{route("accessCodeResult")}}',frmData,
                    function (data,xhrStatus,xhr) {
                    if (data.error){
                        $('#error').html(data.error[0]);
                    }else {
                        $('#data').empty().append(data);
                        $( '#data').find('#table').DataTable({
                            pagingType: 'full_numbers',
                            lengthMenu :[[5,10,25,50,-1],[5,10,25,50,'All']],
                            "initComplete": function () {
                                var api = this.api();
                                api.$('td').click( function () {
                                    api.search( this.innerHTML ).draw();
                                });
                            }
                        });
                    }

                    });
            });

            $('#data').on('submit','#frm',function (e) {

                e.preventDefault();
                frmData =$(this).serialize();
                time = setTimeout(function () {
                    jsonResult()
                },1000);
            });

            function jsonResult() {
                $.post('{{route("meetingAttendeesJoin")}}',frmData,
                    function (data,xhrStatus,xhr) {
                        if (data.error)
                        {
                            $('#error').html(data.error[0]);
                            clearInterval(time);
                        }
                        if (data.notStart)
                        {
                            $('.input-group').html(`
                                                <div>
                                                <h4>This meeting hasn't started yet.</h4>
                                                <p>You will automatically  join when the meeting starts.</p>
                                                </div>
                                            <span class="input-group-append ml-5 mb-1">
                                            <div id="overlay">
                                                <div class="cv-spinner">
                                                    <span class="newspinner"></span>
                                                </div>
                                            </div>
                                            </span>`)
                            $('#errorDiv').empty();
                            setTimeout(jsonResult,15000)

                        }
                        if (data.url)
                        {
                            window.location =data.url;
                        }


                    });
            }
        })
    </script>
@stop

