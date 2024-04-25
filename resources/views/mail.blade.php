@extends('master');

@section('pageTitle')
    Mail
@endsection

@section('main-content')
    <div class="col-md-12">
        <!-- /.card-header -->
        <div class="card-body">
            <div class="mailbox-read-info">
                <h5>{{ $mailData[0]->mailSubject }}</h5><br>
                <h6>{{ ($mailData[0]->mailType != "1") ? "Email: " . $mailData[0]->mailFromEmail : "Email: " . $mailData[0]->mailToEmail }}<br>
                {{ ($mailData[0]->mailType != "1") ? "Name: " . $mailData[0]->mailFromName : "Name: " . $mailData[0]->mailToName }}
                    <span class="mailbox-read-time float-right">{{ date("d M, Y h:i A", strtotime($mailData[0]->mailTime)) }}</span>
                </h6>
            </div>
            <!-- /.mailbox-read-info -->
            <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Delete">
                        <i class="far fa-trash-alt"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Reply">
                        <i class="fas fa-reply"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Forward">
                        <i class="fas fa-share"></i>
                    </button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm" title="Print">
                    <i class="fas fa-print"></i>
                </button>
            </div>
            <!-- /.mailbox-controls -->
            <div class="mailbox-read-message">
                <iframe src="/mail/body/{{ $mailData[0]->mailId }}" frameborder="0" width="100%" style="height: 62vh"></iframe>
            </div>
            <!-- /.mailbox-read-message -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <div class="float-right">
                <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
                <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>
            </div>
            <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
            <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->
    <br><br><br>
@endsection
