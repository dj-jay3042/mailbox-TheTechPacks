@extends('master')

@section('main-content')
    <!-- /.col -->
    <div class="col-md-12">
        <form action="/mail/send" method="post">
          @csrf
          @method("POST")
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Compose New Message</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <input class="form-control" name="toEmail" placeholder="To:">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="toName" placeholder="Name:">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="mailSubject" placeholder="Subject:">
                    </div>
                    <div class="form-group">
                        <textarea id="compose-textarea" name="mailBody" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="btn btn-default btn-file">
                            <i class="fas fa-paperclip"></i> Attachment
                            <input type="file" name="mailAttachment">
                        </div>
                        <p class="help-block">Max. 32MB</p>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Draft</button>
                        <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                    </div>
                    <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </form>
    </div>
    <!-- /.col -->
@endsection

@section('script')
    <!-- Summernote -->
    <script src="/plugins/summernote/summernote-bs4.min.js"></script>
    <script>
        $(function() {
            //Add text editor
            $('#compose-textarea').summernote()
        })
    </script>
@endsection
