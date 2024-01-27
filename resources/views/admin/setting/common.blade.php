@extends('layouts.back')

@section('content-back')
    <?php
    $umum = $settings['umum'];
    ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form id="formSetting">
                        @csrf
                        <div class="mb-3">
                            <label for="namaAplikasi" class="form-label">Nama Aplikasi</label>
                            <input type="text" class="form-control" name="umum[name_app]" placeholder="Masukan Nama Aplikasi" value="{{ $umum['name_app'] }}">
                            <div class="invalid-feedback d-block" id="msg_umum.name_app"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Created By</label>
                            <input type="text" class="form-control" name="umum[creator_app]" placeholder="Masukan Created By" value="{{ $umum['creator_app'] }}">
                            <div class="invalid-feedback d-block" id="msg_umum.creator_app"></div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" data-style="expand-left">
                                <i class="fa fa-check"></i> Simpan Semua
                            </button>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {

            let $form = $('#formSetting');
            let $formSettingBtn = $form.find(`[type="submit"]`).ladda();

            $form.on('submit', function(e) {
                e.preventDefault();
                clearInvalid();

                let formData = $(this).serialize();

                $formSettingBtn.ladda('start');
                ajaxSetup();

                $.ajax({
                        url: "{{ route('admin.setting.common.store') }}",
                        data: formData,
                        method: 'post',
                        dataType: 'json'
                    })
                    .done(response => {
                        let {
                            message
                        } = response;
                        successNotificationSnack(message)
                        $formSettingBtn.ladda('stop');
                        reloadWindow()
                    })
                    .fail(error => {
                        const {
                            status,
                            responseJSON
                        } = error;
                        const {
                            message,
                            errors
                        } = responseJSON;

                        if (status == 422) {
                            invalidResponse($form, errors)
                        }

                        $formSettingBtn.ladda('stop');
                        ajaxErrorHandlingSnack(error, $form);
                    })


            })
        })
    </script>
@endsection
