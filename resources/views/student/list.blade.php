@extends('layouts.app')
@section('content')
<div class="row btn-info">
    <div class="col-lg-11">
        <h2>Tabla de Cliente</h2>
    </div>
    <div class="col-lg-1">
        <a class="btn btn-warning" href="#" data-toggle="modal" data-target="#addModal">Agregar</a>
    </div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif <!--Tabla de datos -->
<table class="table table-striped table-hover" id="studentTable">
    <thead>
        <tr>
            <th>Id</th>
            <th>Primer Nombre</th>
            <th>Segundo Nombre</th>
            <th>Dirección</th>
            <th width="280px">Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
        <tr id="{{ $student->id }}">
            <td>{{ $student->id }}</td>
            <td>{{ $student->first_name }}</td>
            <td>{{ $student->last_name }}</td>
            <td>{{ $student->address }}</td>
            <td>            <!--  botones de editar y borar registros de la tabla -->
                <a data-id="{{ $student->id }}" class="btn btn-info btnEdit">Editar</a>
                <a data-id="{{ $student->id }}" class="btn btn-success btnDelete">Eliminar</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Add Student Modal -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Student Modal content-->
        <div class="modal-content btn-warning">
            <div class="modal-header btn-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Agregar Nuevo Cliente</h4>
            </div>
            <div class="modal-body">
                <form id="addStudent" name="addStudent" action="{{ route('student.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="txtFirstName">Primer Nombre:</label>
                        <input type="text" class="form-control" id="txtFirstName" placeholder="Ingrese el Nombre" name="txtFirstName">
                    </div>
                    <div class="form-group">
                        <label for="txtLastName">Segundo Nombre:</label>
                        <input type="text" class="form-control" id="txtLastName" placeholder="Introduzca el apellido" name="txtLastName">
                    </div>
                    <div class="form-group">
                        <label for="txtAddress">Dirección:</label>
                        <textarea class="form-control" id="txtAddress" name="txtAddress" rows="10" placeholder="Ingrese la dirección"></textarea>
                    </div>
                    <button type="submit" class="btn btn-info">Guardar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Update Student Modal -->
<div id="updateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Student Modal content-->
        <div class="modal-content">
            <div class="modal-header btn-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Actulizar cliente</h4>
            </div>
            <div class="modal-body">
                <form id="updateStudent" name="updateStudent" action="{{ route('student.update') }}" method="post">
                    <input type="hidden" name="hdnStudentId" id="hdnStudentId" />
                    @csrf
                    <div class="form-group">
                        <label for="txtFirstName">Primer Nombre:</label>
                        <input type="text" class="form-control" id="txtFirstName" placeholder="Igrese el nombre" name="txtFirstName">
                    </div>
                    <div class="form-group">
                        <label for="txtLastName">Apellido:</label>
                        <input type="text" class="form-control" id="txtLastName" placeholder="Introduzca el apellido" name="txtLastName">
                    </div>
                    <div class="form-group">
                        <label for="txtAddress">Dirección:</label>
                        <textarea class="form-control" id="txtAddress" name="txtAddress" rows="10" placeholder="Ingrese la dirección"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        //Add the Student  
        $("#addStudent").validate({
            rules: {
                txtFirstName: "required"
                , txtLastName: "required"
                , txtAddress: "required"
            }
            , messages: {},

            submitHandler: function(form) {
                var form_action = $("#addStudent").attr("action");
                $.ajax({
                    data: $('#addStudent').serialize()
                    , url: form_action
                    , type: "POST"
                    , dataType: 'json'
                    , success: function(data) {
                        var student = '<tr id="' + data.id + '">';
                        student += '<td>' + data.id + '</td>';
                        student += '<td>' + data.first_name + '</td>';
                        student += '<td>' + data.last_name + '</td>';
                        student += '<td>' + data.address + '</td>';
                        student += '<td><a data-id="' + data.id + '" class="btn btn-info btnEdit">Editar</a>&nbsp;&nbsp;<a data-id="' + data.id + '" class="btn btn-success btnDelete">Eliminar</a></td>';
                        
                        student += '</tr>';
                        $('#studentTable tbody').prepend(student);
                        $('#addStudent')[0].reset();
                        $('#addModal').modal('hide');
                    }
                    , error: function(data) {}
                });
            }
        });


        //When click edit student
        $('body').on('click', '.btnEdit', function() {
            var student_id = $(this).attr('data-id');
            $.get('student/' + student_id + '/edit', function(data) {
                $('#updateModal').modal('show');
                $('#updateStudent #hdnStudentId').val(data.id);
                $('#updateStudent #txtFirstName').val(data.first_name);
                $('#updateStudent #txtLastName').val(data.last_name);
                $('#updateStudent #txtAddress').val(data.address);
            })
        });
        // Update the student
        $("#updateStudent").validate({
            rules: {
                txtFirstName: "required"
                , txtLastName: "required"
                , txtAddress: "required"

            }
            , messages: {},

            submitHandler: function(form) {
                var form_action = $("#updateStudent").attr("action");
                $.ajax({
                    data: $('#updateStudent').serialize()
                    , url: form_action
                    , type: "POST"
                    , dataType: 'json'
                    , success: function(data) {
                        var student = '<td>' + data.id + '</td>';
                        student += '<td>' + data.first_name + '</td>';
                        student += '<td>' + data.last_name + '</td>';
                        student += '<td>' + data.address + '</td>';
                        student += '<td><a data-id="' + data.id + '" class="btn btn-info btnEdit">Editar</a>&nbsp;&nbsp;<a data-id="' + data.id + '" class="btn btn-success btnDelete">Eliminar</a></td>';
                        $('#studentTable tbody #' + data.id).html(student);
                        $('#updateStudent')[0].reset();
                        $('#updateModal').modal('hide');
                    }
                    , error: function(data) {}
                });
            }
        });

        //delete student
        $('body').on('click', '.btnDelete', function() {
            var student_id = $(this).attr('data-id');
            $.get('student/' + student_id + '/delete', function(data) {
                $('#studentTable tbody #' + student_id).remove();
            })
        });

    });

</script>
@endsection
