@extends('master')

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('add-css')
    <style>
        body,
        html {
            height: 100%;
            overflow: hidden;
        }

        .wrapper {
            height: 100%;
            overflow-y: auto;
        }

        /* Add your additional CSS styles here */
    </style>
@endsection

@section('pageTitle')
    Inbox
@endsection

@section('inbox')
    active
@endsection

@section('main-content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Inbox</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Search Mail">
                                <div class="input-group-append">
                                    <div class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i
                                    class="far fa-square"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-reply"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-share"></i>
                                </button>
                            </div>
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm" onclick="location.reload();">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <div class="float-right">
                                <div class="row">
                                    <div class="count">
                                    </div>&nbsp;&nbsp;&nbsp;
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm prev-btn">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm next-btn">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.btn-group -->
                            </div>
                            <!-- /.float-right -->
                        </div>

                        <div class="table-responsive mailbox-messages card-body p-0" style="height: 60vh;">
                            <table class="table table-hover table-striped table-head-fixed text-nowrap" id="tblMails">
                                <tbody>
                                    @foreach ($mailData as $mail)
                                        <tr onclick="window.location.href='/mail/{{ $mail->mailId }}'">
                                            <td>
                                                <div class="icheck-primary">
                                                    <input type="checkbox" value="" id="check1">
                                                    <label for="check1"></label>
                                                </div>
                                            </td>
                                            <td class="mailbox-star"><i class="fas fa-envelope{{ ($mail->mailIsRead == "0") ? "-open" : "" }}"></i></td>
                                            <td class="mailbox-name">{{ $mail->mailFromName }}</td>
                                            <td class="mailbox-subject">
                                                @if ($mail->mailIsRead != "0")
                                                    {{ $mail->mailSubject }}
                                                @else
                                                    <b> {{ $mail->mailSubject }} </b>                                                    
                                                @endif
                                            </td>
                                            <td class="mailbox-attachment"></td>
                                            <td class="mailbox-date">{{ date('d M, Y h:i a', strtotime($mail->mailTime)) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer p-0">
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                                <i class="far fa-square"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-reply"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-share"></i>
                                </button>
                            </div>
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm" onclick="location.reload();">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <div class="float-right">
                                <div class="row">
                                    <div class="count">
                                    </div>&nbsp;&nbsp;&nbsp;
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm prev-btn">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm next-btn">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.btn-group -->
                            </div>
                            <!-- /.float-right -->
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <!-- Google Apis JQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Pagination Script -->
    <script>
        $(document).ready(function() {
            // Define number of rows per page and get total number of rows
            var rowsPerPage = 8; // Change this to the desired number of rows per page
            var totalRows = $('#tblMails tbody tr').length;

            // Calculate total number of pages
            var totalPages = Math.ceil(totalRows / rowsPerPage);

            // Show the first page by default
            var currentPage = 1;
            showPage(currentPage);

            // Handle "Previous" button click
            $('.prev-btn').click(function() {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                }
            });

            // Handle "Next" button click
            $('.next-btn').click(function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    showPage(currentPage);
                }
            });

            // Function to display the specified page
            function showPage(pageNum) {
                // Hide all rows
                $('#tblMails tbody tr').hide();

                // Calculate start and end row index for the current page
                var startIndex = (pageNum - 1) * rowsPerPage;
                var endIndex = startIndex + rowsPerPage;

                // Show rows for the current page
                $('#tblMails tbody tr').slice(startIndex, endIndex).show();

                // Update page count
                var pageStart = (startIndex + 1);
                var pageEnd = Math.min(startIndex + rowsPerPage, totalRows);
                $('.count').text(pageStart + '-' + pageEnd + ' / ' + totalRows);

                // Disable "Previous" button if on the first page, otherwise enable it
                if (pageNum === 1) {
                    $('.prev-btn').prop('disabled', true);
                } else {
                    $('.prev-btn').prop('disabled', false);
                }

                // Disable "Next" button if on the last page, otherwise enable it
                if (pageNum === totalPages) {
                    $('.next-btn').prop('disabled', true);
                } else {
                    $('.next-btn').prop('disabled', false);
                }
            }

        });
    </script>
@endsection
