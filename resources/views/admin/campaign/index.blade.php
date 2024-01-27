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
                <th> Pesan </th>
                <th> Deskripsi </th>
                <th> Total Target </th>
                <th> Total Sent </th>
                <th> Total Received </th>
                <th> Total Read </th>
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
            <form id="formCreate">
                @csrf
                <div class="form-group">
                    <label for="campaign_name" class="form-label">Nama Campaign {!! $wajibIsi !!}</label>
                    <input type="text" class="form-control" name="campaign_name" id="campaign_name" placeholder="Contoh: PT Adiva Sumber Solusi">
                    <span class="invalid-feedback"></span>
                </div>

                <div class="form-group mb-3">
                    <label for="role" class="form-label">Pesan {!! $wajibIsi !!}</label>
                    <textarea class="form-control" name="message" id="message" cols="30" rows="3"></textarea>
                    <span class="invalid-feedback"></span>
                </div>

                <div class="form-group mb-3">
                    <label for="role" class="form-label">Deskripsi (opsional)</label>
                    <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                    <span class="invalid-feedback"></span>
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

  <div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="modalUpdateLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalUpdateLabel">Update</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <?php
                $wajibIsi = '<span class="text-danger">*</span>';
            ?>
            <form id="formUpdate">
                @csrf
                <div class="form-group">
                    <label for="campaign_name" class="form-label">Nama Campaign {!! $wajibIsi !!}</label>
                    <input type="text" class="form-control" name="campaign_name" id="campaign_name" placeholder="Contoh: PT Adiva Sumber Solusi">
                    <span class="invalid-feedback"></span>
                </div>

                <div class="form-group mb-3">
                    <label for="role" class="form-label">Pesan {!! $wajibIsi !!}</label>
                    <textarea class="form-control" name="message" id="message" cols="30" rows="3"></textarea>
                    <span class="invalid-feedback"></span>
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Deskripsi (opsional)</label>
                    <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                    <span class="invalid-feedback"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Update</button>
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
            const $modalUpdate = $('#modalUpdate');
            const $formCreate = $('#formCreate');
            const $formUpdate = $('#formUpdate');
            const $formCreateSubmitBtn = $formCreate.find(`[type="submit"]`).ladda();
            const $formUpdateSubmitBtn = $formUpdate.find(`[type="submit"]`).ladda();

            $modalCreate.on('shown.bs.modal', function() {
                $modalCreate.find(`[name="name"]`).focus();
                $modalCreate.find(`[name="role"]`).select2({
                    dropdownParent: $modalCreate,
                    placeholder: 'Pilih Role',
                });
            })

            $modalUpdate.on('shown.bs.modal', function() {
                $modalUpdate.find(`[name="name"]`).focus();
                $modalUpdate.find(`[name="role"]`).select2({
                    dropdownParent: $modalUpdate,
                    placeholder: 'Pilih Role',
                });
            })


            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('admin.campaign') }}"
                },
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all",
                }],
                columns: [{
                        data: "campaign_name",
                        name: "campaign_name",
                    },
                    {
                        data: "message",
                        name: "message",
                    },
                    {
                        data: "description",
                        name: "description",
                    },
                    {
                        data: "total_target",
                        name: "total_target",
                    },
                    {
                        data: "total_sent",
                        name: "total_sent",
                    },
                    {
                        data: "total_received",
                        name: "total_received",
                    },
                    {
                        data: "total_read",
                        name: "total_read",
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

                    $.each($('.edit'), (i, editBtn) => {
                        $(editBtn).off('click')
                        $(editBtn).on('click', function() {
                            let {
                                editHref,
                                getHref
                            } = $(this).data();
                            $.get({
                                    url: getHref,
                                    dataType: 'json'
                                })
                                .done(response => {
                                    let {
                                        campaign
                                    } = response;
                                    clearInvalid();
                                    $modalUpdate.modal('show')
                                    $formUpdate.attr('action', editHref)
                                    $formUpdate.find(`[name="campaign_name"]`).val(campaign
                                        .campaign_name);
                                    $formUpdate.find(`[name="message"]`).val(campaign.message);
                                    $formUpdate.find(`[name="description"]`).val(campaign.description);


                                    formSubmit(
                                        $modalUpdate,
                                        $formUpdate,
                                        $formUpdateSubmitBtn,
                                        editHref,
                                        'put'
                                    );
                                })
                                .fail(error => {
                                    ajaxErrorHandlingSnack(error);
                                })
                            })
                    })

            }

            const clearFormCreate = () => {
                $formCreate[0].reset();
            }

            const formSubmit = ($modal, $form, $submit, $href, $method, $addedAction = null) => {
                    $form.off('submit')
                    $form.on('submit', function(e) {
                        e.preventDefault();
                        clearInvalid();

                        let formData = $(this).serialize();
                        $submit.ladda('start');

                        ajaxSetup();
                        $.ajax({
                            url: $href,
                            method: $method,
                            data: formData,
                            dataType: 'json',
                        }).done(response => {
                            let {
                                message
                            } = response;
                            successNotificationSnack(message);
                            reloadDT();
                            clearFormCreate();
                            $submit.ladda('stop');
                            $modal.modal('hide');

                            if(addedAction) {
                                addedAction();
                            }
                        }).fail(error => {
                            $submit.ladda('stop');
				        	ajaxErrorHandlingSnack(error, $form);
                        })
                    })
                }

                formSubmit(
                    $modalCreate,
                    $formCreate,
                    $formCreateSubmitBtn,
                    `{{ route('admin.campaign.store') }}`,
                    'post'
                );
        })
    </script>
@endsection
