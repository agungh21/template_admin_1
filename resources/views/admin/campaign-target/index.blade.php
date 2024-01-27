@extends('layouts.back')

@section('styles')
<style>

</style>
@endsection

@section('content-back')
<div class="d-flex justify-content-between mb-3">
    <div class="">
        <h2 class="main-title text-uppercase">{{ $title }}</h2>
    </div>
    <div class="">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
            <i class="fa-solid fa-circle-plus"></i> Tambah
        </button>
    </div>
</div>
<div class="card p-3">
    <div class="card-body">
        <table class="table table-hover" style="width: 100%;" id="dataTable">
          <thead class="bg-primary text-white">
            <tr>
                <th style="border-top-left-radius: 5px;"> Nama Campaign </th>
                <th> Nama </th>
                <th> Nomor Telepon </th>
                <th> Status </th>
                <th style="border-top-right-radius: 5px; width: 50px"> Aksi </th>
            </tr>
          </thead>
        </table>
    </div>
</div>

@endsection

@section('modal')
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalCreateLabel">Tambah</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <?php
                $wajibIsi = '<span class="text-danger">*</span>';
            ?>
            <form id="formCreate" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="id_campaign" class="form-label">Campaign {!! $wajibIsi !!}</label>
                    <select class="form-control" name="id_campaign" id="">
                        <option selected disabled>Pilih Campaign</option>
                        @foreach ($campaigns as $campaign)
                            <option value="{{ $campaign->id }}">{{ $campaign->campaign_name }}</option>
                        @endforeach
                    </select>
                    <span class="invalid-feedback"></span>
                </div>

                <div class="form-group alert alert-info mt-3">
                    <p class="mb-2 fw-bold"> Catatan : </p>
                    <ol>
                        <li>Import wajib menggunakan template yg kita sediakan.</li>
                        <li>Download template dengan <a href="{{ route('admin.campaign_target.import_templates', 'import_campaign_target.xlsx') }}" class="link-danger" download>Klik Disini.</a>
                        <li>Kolom dengan background merah wajib diisi.</li>
                      </ol>
                </div>

                <div class="form-group">
                    <label class="form-label"> File {!! $wajibIsi !!} </label>
                    <input type="file" name="file_excel" class="form-control">
                    <span class="invalid-feedback"></span>
                    <small><span class="text-danger">*</span> File harus berformat .xlsx, .xls</small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
    <script>
         $(document).ready(function() {

            const $modalCreate = $('#modalCreate');
            const $formCreate = $('#formCreate');
            const $formCreateSubmitBtn = $formCreate.find(`[type="submit"]`).ladda();

            $modalCreate.on('shown.bs.modal', function() {
                $modalCreate.find(`[name="id_campaign"]`).select2({
                    dropdownParent: $modalCreate,
                    placeholder: 'Pilih Campaign',
                });

            })

            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('admin.campaign_target') }}"
                },
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all",
                }],
                columns: [
                    {
                        data: "campaign.campaign_name",
                        name: "campaigns.campaign_name",
                    },
                    {
                        data: "name",
                        name: "name",
                    },
                    {
                        data: "phone_number",
                        name: "phone_number",
                    },
                    {
                        data: "status",
                        name: "status",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
                drawCallback: settings => {
                    renderedEvent();
                }


            })
            const reloadDT = () => {
                $('#dataTable').DataTable().ajax.reload();
            }

            const renderedEvent = () => {
                $.each($('.delete'), (i, deleteBtn) => {
                        $(deleteBtn).off('click')
                        $(deleteBtn).on('click', function() {
                            let {
                                deleteMessage,
                                deleteHref
                            } = $(this).data();
                            confirmation(deleteMessage, function() {
                                ajaxSetup()
                                        $.ajax({
                                            url: deleteHref,
                                            method: 'delete',
                                            dataType: 'json'
                                        })
                                        .done(response => {
                                            let {
                                                message
                                            } = response
                                            successNotificationSnack('Berhasil', message)
                                            reloadDT();
                                        })
                                        .fail(error => {
                                            ajaxErrorHandlingSnack(error);
                                        })
                            })
                        })
                    })

            }

            const clearFormCreate = () => {
                $formCreate[0].reset();
            }

                $formCreate.on('submit', function(e) {
                    e.preventDefault();
                    clearInvalid();

                    let formData = new FormData(this);
                    $formCreateSubmitBtn.ladda('start');

                    ajaxSetup();
                    $.ajax({
                            url: "{{ route('admin.campaign_target.store') }}",
                            method: 'post',
                            data: formData,
                            dataType: 'json',
                            processData: false,
                            contentType: false,
                        })
                        .done(response => {
                            let {
                                message
                            } = response;
                            $formCreateSubmitBtn.ladda('stop')
                            successNotificationSnack(message);
                            $formCreate[0].reset();
                            reloadDT()
                            $modalCreate.modal('hide');
                        })
                        .fail(error => {
                            $formCreateSubmitBtn.ladda('stop')
                            ajaxErrorHandlingSnack(error, $formCreate)
                        })
                })
        })
    </script>
@endsection
