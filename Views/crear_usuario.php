<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../librerias/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="UTF-8">
    <title>Crear usuario</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Librerías de estilos principales -->
    <link rel="stylesheet" href="../librerias/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../librerias/assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../librerias/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../librerias/assets/vendor/libs/plyr/plyr.css" />
    <link rel="stylesheet" href="../librerias/assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="../librerias/assets/css/styles.css">

    <?php require_once('header.php'); ?>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php require_once('menu.php'); ?>

            <div class="layout-page">
                <?php require_once('barra_navegacion.php'); ?>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <!-- Tabla de permisos -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Crear usuario</h5>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-warning me-2" onclick="filtrar()">
                                                <i class="ti ti-filter"></i> Filtros
                                            </button>
                                            <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#createUserModal">
                                                <i class="ti ti-cloud-upload"></i> Crear
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-datatable">
                                        <table class="dt-responsive table table-striped" id="tbllistado">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Rol</th>
                                                    <th>Vista</th>
                                                    <th>Modulo</th>
                                                    <th>Editar</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal para crear usuario -->
                    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createUserModalLabel">Crear Nuevo Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="createUserForm">
                                        <input type="hidden" id="id" name="id">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Usuario</label>
                                            <input type="text" class="form-control" id="username" name="username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="employee_code" class="form-label">Clave Empleado</label>
                                            <input type="number" class="form-control" id="employee_code" name="employee_code" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Correo electrónico</label>
                                            <input type="email" class="form-control" id="email" name="email">
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Contraseña</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirmación de contraseña</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" onclick="submitUserForm()">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php require_once('footer.php'); ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>

    <!-- Scripts esenciales -->
    <script src="../librerias/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../librerias/assets/vendor/libs/bootstrap/bootstrap.js"></script>
    <script src="../librerias/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../librerias/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../librerias/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../librerias/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../librerias/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../librerias/assets/vendor/libs/select2/select2.js"></script>
    <script src="../librerias/assets/vendor/libs/plyr/plyr.js"></script>
    <script src="../librerias/assets/vendor/js/menu.js"></script>
    <script src="../librerias/assets/js/main.js"></script>

    <!-- Script propio de esta página
    <script src="scripts/permisos.js"></script>
     -->
    <!-- Script para manejar el formulario -->

    <!-- DataTables JS  -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
    function submitUserForm() {
    const form = document.getElementById('createUserForm');
    const password = document.getElementById('password')?.value || '';
    const confirmPassword = document.getElementById('confirm_password')?.value || '';

    if (password !== confirmPassword) {
        alert('Las contraseñas no coinciden');
        return;
    }

    if (form.checkValidity()) {
        const formData = new FormData(form);

        fetch('../Controllers/UsuariosController.php?op=crear', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())  // <-- Mostrar texto crudo
        .then(text => {
            console.log('Respuesta del servidor:', text);
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    alert('Usuario creado exitosamente');
                    $('#createUserModal').modal('hide');
                    form.reset();
                    $('#tbllistado').DataTable().ajax.reload();
                } else {
                    alert('Error al crear usuario: ' + data.message);
                }
            } catch (e) {
                console.error('Respuesta no es JSON válido:', e);
                alert('Error en la respuesta del servidor: ' + text);
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert('Ocurrió un error al procesar la solicitud');
        });
    } else {
        form.reportValidity();
    }
}


</script>
        <script>
            $(document).ready(function() {
                const table = $('#tbllistado').DataTable({
                    ajax: {
                        url: '../Controllers/UsuariosController.php?op=listar',
                        type: 'GET',
                        dataType: 'json'
                    },
                    columns: [{
                            data: 'id'},
                        {
                            data: 'rol'},
                        {
                            data: 'username'},
                        {
                            data: 'email'},
                        {
                            data: null,
                            render: function() {
                                return `<button class="btn btn-sm btn-warning btn-edit">Editar</button>`;
                            }
                        },
                        {
                            data: null,
                            render: function() {
                                return `<button class="btn btn-sm btn-danger btn-delete">Eliminar</button>`;
                            }
                        }
                    ]
                });

                // Editar
                $('#tbllistado tbody').on('click', '.btn-edit', function() {
                    const data = table.row($(this).parents('tr')).data();
                    fetch(`../Controllers/UsuariosController.php?op=obtener&id=${data.id}`)
                        .then(r => r.json())
                        .then(user => {
                            $('#id').val(user.id);
                            $('#name').val(user.full_name);
                            $('#username').val(user.username);
                            $('#employee_code').val(user.employee_code);
                            $('#email').val(user.email);
                            $('#password, #confirm_password').val('');
                            $('#createUserModal').modal('show');
                        });
                });

                // Eliminar
                $('#tbllistado tbody').on('click', '.btn-delete', function() {
                    const data = table.row($(this).parents('tr')).data();
                    if (confirm(`¿Deseas eliminar al usuario ${data.username}?`)) {
                        fetch('../Controllers/UsuariosController.php?op=eliminar', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: `id=${data.id}`
                            })
                            .then(r => r.json())
                            .then(res => {
                                if (res.success) {
                                    alert('Usuario eliminado');
                                    table.ajax.reload();
                                } else {
                                    alert('No se pudo eliminar');
                                }
                            });
                    }
                });
            });
    </script>


</body>

</html>