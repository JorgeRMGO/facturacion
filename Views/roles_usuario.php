<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
$title = "Roles";
require_once '../config/Conexion.php'; // Ajusta la ruta si es necesario
?>
<!DOCTYPE html>
<html lang="es" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../librerias/assets/" data-template="vertical-menu-template">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <!-- CSS -->
    <link rel="stylesheet" href="../librerias/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../librerias/assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../librerias/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../librerias/assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="../librerias/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .modal-content {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: scale(0.7);
        }
        .modal.show .modal-dialog {
            transform: scale(1);
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
    </style>
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
                            <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Roles</h5>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modal">
                                                <i class="ti ti-cloud-upload"></i> Crear
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-datatable table-responsive">
                                        <table class="dt-responsive table table-striped" id="tbllistado">
                                            <thead>
                                                <tr>
                                                    <th style="width: 300px;">Acciones</th>
                                                    <th>#</th>
                                                    <th>Nombre</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal para crear/editar rol -->
                    <div class="modal animate__animated animate__flipInX" id="modal" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Crear Rol</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="form-message" class="alert d-none"></div>
                                    <form name="formulario" id="formulario" method="POST">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="name" class="form-label">Nombre *</label>
                                                <input type="text" id="name" name="name" class="form-control" placeholder="Ingresa..." required>
                                                <input type="hidden" id="id_registro" name="id_registro" class="form-control" />
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label>Permisos por Módulo</label>
                                                <?php
                                                $stmt = $conn->query("SELECT modulo_name FROM modulos");
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    $modulo = $row['modulo_name'];
                                                    echo "<div class='mb-2'>";
                                                    echo "<strong>Módulo: $modulo</strong>";
                                                    echo "<div class='form-check'>";
                                                    echo "<input type='checkbox' class='form-check-input' name='permisos[$modulo][vista]' value='1'>";
                                                    echo "<label class='form-check-label'>Ver</label>";
                                                    echo "</div>";
                                                    echo "<div class='form-check'>";
                                                    echo "<input type='checkbox' class='form-check-input' name='permisos[$modulo][crear]' value='1'>";
                                                    echo "<label class='form-check-label'>Crear</label>";
                                                    echo "</div>";
                                                    echo "<div class='form-check'>";
                                                    echo "<input type='checkbox' class='form-check-input' name='permisos[$modulo][editar]' value='1'>";
                                                    echo "<label class='form-check-label'>Editar</label>";
                                                    echo "</div>";
                                                    echo "<div class='form-check'>";
                                                    echo "<input type='checkbox' class='form-check-input' name='permisos[$modulo][eliminar]' value='1'>";
                                                    echo "<label class='form-check-label'>Eliminar</label>";
                                                    echo "</div>";
                                                    echo "<div class='form-check'>";
                                                    echo "<input type='checkbox' class='form-check-input' name='permisos[$modulo][aprobar]' value='1'>";
                                                    echo "<label class='form-check-label'>Aprobar</label>";
                                                    echo "</div>";
                                                    echo "<div class='form-check'>";
                                                    echo "<input type='checkbox' class='form-check-input' name='permisos[$modulo][validar]' value='1'>";
                                                    echo "<label class='form-check-label'>Validar</label>";
                                                    echo "</div>";
                                                    echo "</div>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary" onclick="store()">Guardar</button>
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
    <!-- Scripts -->
    <script src="../librerias/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../librerias/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../librerias/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../librerias/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../librerias/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../librerias/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../librerias/assets/vendor/libs/select2/select2.js"></script>
    <script src="../librerias/assets/js/main.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var tabla;
        $(document).ready(function() {
            listar();
        });

        var token = localStorage.getItem("jwt_token");

        const listar = () => {
            if ($.fn.DataTable.isDataTable('#tbllistado')) {
                $('#tbllistado').DataTable().ajax.reload();
                return;
            }

            tabla = $('#tbllistado').dataTable({
                "aProcessing": true,
                "aServerSide": true,
                "ajax": {
                    url: '../Controllers/rolesUsuarioController.php?op=index',
                    type: "get",
                    headers: {
                        "Authorization": `Bearer ${token}`
                    },
                    dataType: "json",
                    error: (e) => {
                        console.log(e.responseText);
                        Swal.fire({
                            title: "Error",
                            text: "No se pudo cargar la tabla. Verifica el token o la conexión.",
                            icon: "error"
                        });
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 10,
                "lengthMenu": [5, 10, 25, 50, 100],
                "order": [[1, "desc"]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "columns": [
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-primary" onclick="show(${row.role_id})">Editar</button>
                                <button class="btn btn-sm btn-danger" onclick="borrar(${row.role_id})">Eliminar</button>
                            `;
                        }
                    },
                    { data: 'role_id' },
                    { data: 'role_name' }
                ]
            }).DataTable();
        };

        const store = () => {
            const form = document.getElementById('formulario');
            const messageDiv = document.getElementById('form-message');
            if (form.checkValidity()) {
                const formData = new FormData(form);
                Swal.fire({
                    title: "Guardando rol...",
                    text: "Por favor, espera mientras se procesan los datos.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    url: "../Controllers/rolesUsuarioController.php?op=store",
                    type: "POST",
                    headers: {
                        "Authorization": `Bearer ${token}`
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        response = JSON.parse(response);
                        Swal.close();
                        if (response.success) {
                            messageDiv.classList.remove('d-none', 'alert-danger');
                            messageDiv.classList.add('alert-success');
                            messageDiv.textContent = response.message;
                            form.reset();
                            setTimeout(() => $('#modal').modal('hide'), 1000);
                            tabla.ajax.reload();
                        } else {
                            messageDiv.classList.remove('d-none', 'alert-success');
                            messageDiv.classList.add('alert-danger');
                            messageDiv.textContent = response.message;
                        }
                    },
                    error: function(error) {
                        Swal.close();
                        messageDiv.classList.remove('d-none', 'alert-success');
                        messageDiv.classList.add('alert-danger');
                        messageDiv.textContent = 'Error al guardar el rol';
                        console.error("Error:", error);
                    }
                });
            } else {
                form.reportValidity();
            }
        };

        const show = (id_registro) => {
            window.location.href = `editar_rol.php?id=${id_registro}`;
        };

        const borrar = (id) => {
            Swal.fire({
                title: "¿Estás seguro de realizar esta acción?",
                text: "Se borrará el rol de usuario permanentemente",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, borrar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Eliminando rol...",
                        text: "Por favor, espera mientras se procesan los datos.",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    $.ajax({
                        url: '../Controllers/rolesUsuarioController.php?op=delete',
                        type: 'POST',
                        headers: {
                            "Authorization": `Bearer ${token}`
                        },
                        data: { id_registro: id },
                        success: function(response) {
                            response = JSON.parse(response);
                            Swal.close();
                            if (response.success) {
                                Swal.fire({
                                    title: "Éxito",
                                    text: response.message,
                                    icon: "success"
                                });
                                tabla.ajax.reload();
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.close();
                            Swal.fire({
                                title: "Error",
                                text: "Ocurrió un error al eliminar el rol.",
                                icon: "error"
                            });
                            console.error('Error:', error);
                        }
                    });
                }
            });
        };
    </script>
</body>
</html>