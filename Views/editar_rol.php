<!doctype html>
<?php 
session_start();

// Verificación estricta de sesión
if (!isset($_SESSION['jwt_token']) || empty($_SESSION['jwt_token'])) {
    header("Location: login.php");
    exit();
} 
require_once "../Controllers/oauth.php";
require_once "../Config/Conexion.php";
$title = isset($_GET['id']) && $_GET['id'] != 0 ? "Editar Rol" : "Crear Rol"; 
$id_rol = isset($_GET['id']) ? (int)$_GET['id'] : 0;
?>
<html lang="es" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../librerias/assets/" data-template="vertical-menu-template">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Librerías de estilos de crear_usuario.php -->
    <link rel="stylesheet" href="../librerias/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../librerias/assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../librerias/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../librerias/assets/vendor/libs/plyr/plyr.css" />
    <link rel="stylesheet" href="../librerias/assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="../librerias/assets/css/styles.css" />
    <!-- Librerías adicionales para DataTables y compatibilidad -->
    <link rel="stylesheet" href="../librerias/assets/vendor/css/rtl.css" />
    <link rel="stylesheet" href="../librerias/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-permiso:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .card-scrollable {
            scrollbar-width: thin;
            scrollbar-color: #6969dd #e0e0e0;
            transition: height 0.3s ease;
            min-height: 400px;
        }
        .card-scrollable::-webkit-scrollbar {
            width: 8px;
        }
        .card-scrollable::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .card-scrollable::-webkit-scrollbar-thumb {
            background-color: #6969dd;
            border-radius: 10px;
        }
        .btn-alargado {
            padding: 0.8rem 1.8rem;
            font-size: 1rem;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            white-space: nowrap;
        }
        .btn-group .btn-alargado {
            margin-right: 0;
            margin-bottom: 15px;
        }
        .btn-icon i {
            font-size: 1.3rem !important;
        }
        .btn-icon {
            padding: 0.6rem 1.2rem !important;
            line-height: 1;
        }
        .dt-responsive .btn-icon {
            width: 45px;
            height: 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .permiso-item {
            transition: all 0.3s ease;
            visibility: visible;
        }
        .permiso-item.hidden {
            visibility: hidden;
            height: 0;
            overflow: hidden;
        }
        .solo-vista-switch {
            margin-left: 10px;
        }
        .card-permiso .permiso-check:disabled + .form-check-label {
            opacity: 0.6;
        }
        @media (max-width: 768px) {
            .btn-group .btn-alargado {
                width: 100%;
                margin-bottom: 10px;
            }
            .card-header .btn-alargado {
                width: 100%;
                margin-bottom: 10px;
            }
        }
        .card-header .btn-alargado {
            margin-right: 15px !important;
        }
        .btn-group {
            flex-wrap: wrap !important;
        }
        .layout-menu, .layout-menu-resizer {
            pointer-events: auto !important;
            z-index: 1001 !important;
        }
        .layout-menu-collapsed .layout-menu {
            transform: translateX(0) !important;
        }
    </style>
    <?php 
    $header_path = file_exists('header.php') ? 'header.php' : (file_exists('includes/header.php') ? 'includes/header.php' : false);
    if ($header_path) {
        require_once $header_path;
    } else {
        die('Error: No se encontró header.php en C:\xampp\htdocs\facturación ni en includes/. Verifica la ruta.');
    }
    ?>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php 
            $menu_path = file_exists('menu.php') ? 'menu.php' : (file_exists('includes/menu.php') ? 'includes/menu.php' : false);
            if ($menu_path) {
                require_once $menu_path;
            } else {
                die('Error: No se encontró menu.php en C:\xampp\htdocs\facturación ni en includes/. Verifica la ruta.');
            }
            ?>
            <div class="layout-page">
                <?php 
                $nav_path = file_exists('barra_navegacion.php') ? 'barra_navegacion.php' : (file_exists('includes/barra_navegacion.php') ? 'includes/barra_navegacion.php' : false);
                if ($nav_path) {
                    require_once $nav_path;
                } else {
                    die('Error: No se encontró barra_navegacion.php en C:\xampp\htdocs\facturación ni en includes/. Verifica la ruta.');
                }
                ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1">
                                <div class="card sticky-top mb-3" style="top: 80px; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0"><?php echo $title; ?></h5>
                                        <div class="d-flex flex-wrap gap-3">
                                            <button class="btn btn-secondary btn-alargado" onclick="window.history.back()">
                                                <i class="ti ti-arrow-left"></i> Volver
                                            </button>
                                            <button type="button" class="btn btn-primary btn-alargado" onclick="guardarCambios()">
                                                <i class="ti ti-check"></i> Guardar Cambios
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" style="height: calc(100vh - 220px);">
                                    <div class="card-body card-scrollable" style="overflow-y: auto; height: 100%;">
                                        <form name="formulario" id="formulario" method="POST">
                                            <div class="row">
                                                <div class="col-md-12 mb-4">
                                                    <label for="name" class="form-label">Nombre del Rol</label>
                                                    <input type="text" id="name" name="name" class="form-control" placeholder="Ingresa el nombre del rol" required/>
                                                    <input type="hidden" id="id_registro" name="id_registro" value="<?php echo $id_rol; ?>"/>
                                                </div>
                                                <?php if($id_rol != 0): ?>
                                                <div class="col-12">
                                                    <h5 class="mb-3">Permisos</h5>
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <div class="input-group input-group-merge">
                                                                <span class="input-group-text"><i class="ti ti-search"></i></span>
                                                                <input type="text" id="buscadorPermisos" class="form-control" placeholder="Buscar vista...">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 text-end">
                                                            <div class="btn-group d-flex flex-wrap gap-3">
                                                                <button type="button" class="btn btn-sm btn-outline-primary btn-alargado" onclick="seleccionarTodos('create')">
                                                                    <i class="ti ti-check"></i> Todos Crear
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-primary btn-alargado" onclick="seleccionarTodos('update')">
                                                                    <i class="ti ti-check"></i> Todos Editar
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-primary btn-alargado" onclick="seleccionarTodos('delete')">
                                                                    <i class="ti ti-check"></i> Todos Eliminar
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-primary btn-alargado" onclick="seleccionarTodos('approve')">
                                                                    <i class="ti ti-check"></i> Todos Aprobar
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-primary btn-alargado" onclick="seleccionarTodos('validate')">
                                                                    <i class="ti ti-check"></i> Todos Validar
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-secondary btn-alargado" onclick="deseleccionarTodos()">
                                                                    <i class="ti ti-x"></i> Limpiar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="contenedorPermisos">
                                                        <?php 
                                                        $sql_vistas = "SELECT * FROM system_views WHERE deleted_at IS NULL AND modulo IN ('EMPLEADOS', 'ADMINISTRACION', 'CATALOGOS', 'NOMINAS', 'ASISTENCIAS')";
                                                        $vistas = ejecutarConsulta($sql_vistas);
                                                        while($vista = mysqli_fetch_array($vistas)) {
                                                            echo '<div class="col permiso-item" data-vista="'.strtolower($vista['name']).'">';
                                                            echo '<div class="card h-100 card-permiso">';
                                                            echo '<div class="card-header py-2 d-flex justify-content-between align-items-center">';
                                                            echo '<h6 class="mb-0">'.$vista['name'].'</h6>';
                                                            $sql_permisos = "SELECT * FROM system_views_roles 
                                                                        WHERE role_id = $id_rol AND view_id = ".$vista['id'];
                                                            $permisos = ejecutarConsultaSimpleFila($sql_permisos);
                                                            $esSoloVista = $permisos && 
                                                                $permisos["permison_create"] == 0 &&
                                                                $permisos["permison_update"] == 0 &&
                                                                $permisos["permison_delete"] == 0 &&
                                                                $permisos["permison_approve"] == 0 &&
                                                                $permisos["permison_validate"] == 0;
                                                            echo '<div class="form-check form-switch">
                                                            <input class="form-check-input solo-vista" type="checkbox" 
                                                                id="solo_vista_'.$vista['id'].'" 
                                                                name="solo_vista['.$vista['id'].']" 
                                                                '.($esSoloVista ? 'checked' : '').'>
                                                            <label class="form-check-label" for="solo_vista_'.$vista['id'].'">
                                                            Solo Vista
                                                            </label>
                                                            </div>';
                                                            echo '</div>';
                                                            echo '<div class="card-body py-2">';
                                                            $checks = ['create' => 'Crear', 'update' => 'Editar', 'delete' => 'Eliminar', 
                                                                    'approve' => 'Aprobar', 'validate' => 'Validar'];
                                                            foreach($checks as $check => $label) {
                                                                $checked = ($permisos && $permisos["permison_$check"] == 1) ? 'checked' : '';
                                                                echo '<div class="form-check form-switch mb-1">
                                                                        <input class="form-check-input permiso-check" type="checkbox" 
                                                                            id="perm_'.$vista['id'].'_'.$check.'" 
                                                                            name="permisos['.$vista['id'].']['.$check.']" '.$checked.'>
                                                                        <label class="form-check-label" for="perm_'.$vista['id'].'_'.$check.'">
                                                                            '.$label.'
                                                                        </label>
                                                                    </div>';
                                                            }
                                                            echo '</div></div></div>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php else: ?>
                                                <div class="col-12">
                                                    <div class="alert alert-info">
                                                        <i class="ti ti-info-circle"></i> Establecerás los permisos después de crear el rol.
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    $footer_path = file_exists('footer.php') ? 'footer.php' : (file_exists('includes/footer.php') ? 'includes/footer.php' : false);
                    if ($footer_path) {
                        require_once $footer_path;
                    } else {
                        die('Error: No se encontró footer.php en C:\xampp\htdocs\facturación ni en includes/. Verifica la ruta.');
                    }
                    ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
    <!-- Scripts de crear_usuario.php -->
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
    <!-- Scripts adicionales para DataTables y SweetAlert2 -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    var token = localStorage.getItem("jwt_token");
    var searchTimeout;

    $(document).ready(function() {
        if (!token) {
            window.location.href = 'login.php';
            return;
        }
        console.log('Inicializando editar_rol.php');
        // Forzar inicialización del menú
        $('.layout-menu').removeClass('layout-menu-collapsed');
        $('.layout-menu-toggle').removeClass('layout-menu-collapsed');
        // Calcular padding al inicio
        const stickyHeader = document.querySelector('.sticky-top');
        const scrollableContent = document.querySelector('.card-body');
        if (stickyHeader && scrollableContent) {
            scrollableContent.style.paddingTop = `${stickyHeader.offsetHeight + 20}px`;
        }
        cargarDatosRol();

        $('#buscadorPermisos').on('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchText = $(this).val().toLowerCase();
                $('.permiso-item').each(function() {
                    const vistaName = $(this).data('vista');
                    if (vistaName.includes(searchText)) {
                        $(this).removeClass('hidden');
                    } else {
                        $(this).addClass('hidden');
                    }
                });
            }, 300);
        });

        $(document).on('change', '.solo-vista', function() {
            const card = $(this).closest('.card-permiso');
            const isSoloVista = $(this).is(':checked');
            if (isSoloVista) {
                card.find('.permiso-check').prop('checked', false).trigger('change');
            }
            card.find('.permiso-check').prop('disabled', isSoloVista);
        });

        $(document).on('change', '.permiso-check', function() {
            const card = $(this).closest('.card-permiso');
            const anyChecked = card.find('.permiso-check:checked').length > 0;
            if (anyChecked) {
                card.find('.solo-vista').prop('checked', false);
            }
        });

        // Depuración: verificar eventos del resizer y menú
        $('.layout-menu-resizer').on('mousedown', function() {
            console.log('Resizer del menú clicado');
        });
        $('.layout-menu').on('click', function() {
            console.log('Menú clicado');
        });
    });

    function cargarDatosRol() {
        const id_rol = $('#id_registro').val();
        if (id_rol == 0) return;
        const scrollPos = $(window).scrollTop();
        console.log('Cargando datos del rol, scroll en:', scrollPos);
        $.ajax({
            url: "../Controllers/rolesUsuarioController.php?op=show",
            type: "POST",
            headers: {
                "Authorization": `Bearer ${token}`
            },
            data: { id_registro: id_rol },
            success: function(data) {
                try {
                    data = JSON.parse(data);
                    if (data.name) {
                        $("#name").val(data.name).blur();
                        $(window).scrollTop(scrollPos);
                        console.log('Datos cargados, scroll restaurado a:', scrollPos);
                        // Re-forzar menú abierto después de cargar datos
                        $('.layout-menu').removeClass('layout-menu-collapsed');
                    } else {
                        throw new Error("Respuesta inválida del servidor");
                    }
                } catch (e) {
                    console.error("Error al parsear respuesta:", e);
                    Swal.fire({
                        title: "Error",
                        text: "No se pudo cargar la información del rol",
                        icon: "error"
                    });
                }
            },
            error: function(error) {
                console.error("Error:", error);
                Swal.fire({
                    title: "Error",
                    text: "No se pudo cargar la información del rol",
                    icon: "error"
                });
            }
        });
    }

    function guardarCambios() {
        Swal.fire({
            title: 'Procesando',
            html: 'Actualizando permisos...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
                $('.layout-menu, .layout-menu-resizer').css('pointer-events', 'auto');
            }
        });
        $('.permiso-check').prop('disabled', false);
        const formData = new FormData(document.getElementById("formulario"));
        if (!formData.get('name')) {
            Swal.fire("Error", "El nombre del rol es requerido", "error");
            return;
        }
        $.ajax({
            url: "../Controllers/rolesUsuarioController.php?op=update_with_permissions",
            type: "POST",
            headers: {
                "Authorization": `Bearer ${token}`
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                try {
                    response = JSON.parse(response);
                    let mensaje = response.message || "Rol actualizado correctamente";
                    if ($('#id_registro').val() == '0') {
                        mensaje = response.message || "Rol creado correctamente";
                    }
                    Swal.fire({
                        title: "Éxito",
                        text: mensaje,
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if ($('#id_registro').val() == '0' && response.id) {
                                window.location.href = `editar_rol.php?id=${response.id}`;
                            } else {
                                window.location.href = "roles_usuarios.php";
                            }
                        }
                    });
                } catch (e) {
                    console.error("Error al parsear respuesta:", e);
                    Swal.fire({
                        title: "Error",
                        text: "Respuesta inválida del servidor",
                        icon: "error"
                    });
                }
            },
            error: function(error) {
                console.error("Error:", error);
                Swal.fire({
                    title: "Error",
                    text: "No se pudieron guardar los cambios",
                    icon: "error"
                });
            }
        });
    }

    function seleccionarTodos(tipo) {
        $('.permiso-item').each(function() {
            const checkbox = $(this).find(`input[name*="[${tipo}]"]`);
            checkbox.prop('checked', true);
            checkbox.trigger('change');
        });
        Swal.fire({
            title: 'Acción completada',
            text: `Todos los permisos de ${tipo} han sido seleccionados`,
            icon: 'success',
            timer: 1000,
            showConfirmButton: false
        });
    }

    function deseleccionarTodos() {
        $('.permiso-item').each(function() {
            $(this).find('input[type="checkbox"]').prop('checked', false);
            $(this).find('input[type="checkbox"]').trigger('change');
        });
        Swal.fire({
            title: 'Acción completada',
            text: 'Todos los permisos han sido deseleccionados',
            icon: 'success',
            timer: 1000,
            showConfirmButton: false
        });
    }
    </script>
</body>
</html>