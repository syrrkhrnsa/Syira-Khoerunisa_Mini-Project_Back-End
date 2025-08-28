<!DOCTYPE html>
<html>

<head>
    <title>Aplikasi To-Do List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center">Daftar Tugas</h2>

        <div class="card mt-4">
            <div class="card-header">
                Tambah Tugas Baru
            </div>
            <div class="card-body">
                <form id="addTaskForm">
                    <div class="form-group">
                        <input type="text" class="form-control" id="judul" placeholder="Masukkan judul tugas" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Tambah</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Daftar Tugas
            </div>
            <div class="card-body">
                <table id="tasksTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm">
                        <input type="hidden" id="edit-id">
                        <div class="form-group">
                            <label for="edit-judul">Judul Tugas</label>
                            <input type="text" class="form-control" id="edit-judul">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="edit-status">
                            <label class="form-check-label" for="edit-status">Selesai</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        var table = $('#tasksTable').DataTable({
            "ajax": {
                "url": "<?php echo base_url('task/list'); ?>",
                "dataSrc": "tasks" // <--- Ini adalah perbaikan utamanya
            },
            "columns": [{
                    "data": "judul"
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        var isChecked = data == 1 ? 'checked' : '';
                        return `<input type="checkbox" class="status-checkbox" data-id="${row.id}" ${isChecked}>`;
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return `<button class="btn btn-warning btn-sm edit-btn" data-id="${row.id}" data-judul="${row.judul}" data-status="${row.status}">Edit</button> <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}">Hapus</button>`;
                    }
                }
            ]
        });

        // Add Task via Ajax
        $('#addTaskForm').on('submit', function(e) {
            e.preventDefault();
            var judul = $('#judul').val();
            if (judul === '') {
                alert('Judul tugas tidak boleh kosong.');
                return;
            }
            $.ajax({
                url: "<?php echo base_url('task/create'); ?>",
                type: "POST",
                data: {
                    judul: judul
                },
                success: function(response) {
                    table.ajax.reload();
                    $('#judul').val('');
                }
            });
        });

        // Update Status via Ajax
        $('#tasksTable').on('change', '.status-checkbox', function() {
            var id = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: "<?php echo base_url('task/update'); ?>",
                type: "POST",
                data: {
                    id: id,
                    status: status
                },
                success: function(response) {
                    table.ajax.reload(null, false); // false agar tidak reset pagination
                }
            });
        });

        // Show Edit Modal
        $('#tasksTable').on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            var judul = $(this).data('judul');
            var status = $(this).data('status');
            $('#edit-id').val(id);
            $('#edit-judul').val(judul);
            $('#edit-status').prop('checked', status == 1);
            $('#editModal').modal('show');
        });

        // Edit Task via Ajax
        $('#editTaskForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit-id').val();
            var judul = $('#edit-judul').val();
            var status = $('#edit-status').is(':checked') ? 1 : 0;
            $.ajax({
                url: "<?php echo base_url('task/update'); ?>",
                type: "POST",
                data: {
                    id: id,
                    judul: judul,
                    status: status
                },
                success: function(response) {
                    $('#editModal').modal('hide');
                    table.ajax.reload();
                }
            });
        });

        // Delete Task via Ajax
        $('#tasksTable').on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            if (confirm("Apakah Anda yakin ingin menghapus tugas ini?")) {
                $.ajax({
                    url: "<?php echo base_url('task/delete'); ?>/" + id,
                    type: "GET",
                    success: function(response) {
                        table.ajax.reload();
                    }
                });
            }
        });
    });
    </script>

</body>

</html>