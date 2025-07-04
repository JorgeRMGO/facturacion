<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../librerias/assets/" data-template="vertical-menu-template">
<?php require_once('header.php'); ?>
<link rel="stylesheet" href="../librerias/assets/css/styles.css">

<!--header -->

<body>
    <div id="particles-js"></div>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php require_once('menu.php'); ?>
            <div class="layout-page">
                <?php require_once('barra_navegacion.php'); ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="py-3 mb-2 welcome-message">
                            <h4>
                                <div class="welcome-container py-2 mb-4">
                                    <span class="welcome-text">Bienvenido</span>
                                    <span class="welcome-emoji">&#x1F44B;</span>
                                    <span class="welcome-username"><?php echo htmlspecialchars($_SESSION['empleado']); ?></span>
                                </div>
                            </h4>
                            <div class="app-billing">
                                <div class="card p-0 mb-4">
                                    <div class="card-body d-flex flex-column flex-md-row justify-content-between p-0 pt-4">
                                        <div class="app-billing-md-25 card-body py-0">
                                            <img src="../librerias/assets/img/illustrations/bulb-light.png"
                                                class="img-fluid app-billing-img-height scaleX-n1-rtl" alt="Invoice icon"
                                                data-app-light-img="illustrations/bulb-light.png"
                                                data-app-dark-img="illustrations/bulb-dark.png" height="90" />
                                        </div>
                                        <div class="app-billing-md-50 card-body d-flex align-items-md-center flex-column text-md-center">
                                            <h3 class="card-title mb-4 lh-sm px-md-5 lh-lg">
                                                Simplifica tu Gestión con
                                                <span class="text-primary fw-medium text-nowrap">Facturación GO</span>
                                            </h3>
                                            
                                            <div class="d-flex align-items-center justify-content-between app-billing-md-80">
                                                <input type="search" placeholder="Buscar factura por número o cliente" class="form-control me-2" />
                                                <button type="submit" class="btn btn-primary btn-icon"><i class="ti ti-search"></i></button>
                                            </div>
                                            <a href="create-invoice.php" class="btn btn-primary mt-3">Crear mi Primera Factura</a>
                                        </div>
                                        <div class="app-billing-md-25 d-flex align-items-end justify-content-end">
                                            <img src="../librerias/assets/img/illustrations/pencil-rocket.png"
                                                alt="money rocket" height="188" class="scaleX-n1-rtl" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gy-4 mb-4">
                                    <div class="col-lg-6">
                                        <div class="card card-border-shadow-success text-center">
                                            <div class="card-body">
                                                <h5 class="card-title mb-1">Usuarios en línea</h5>
                                                <h4 id="usuariosEnLinea" class="mb-0 text-success">...</h4>
                                                <small class="text-muted">En este momento</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card card-border-shadow-info text-center">
                                            <div class="card-body">
                                                <h5 class="card-title mb-1">Hora actual</h5>
                                                <h4 id="horaActual" class="mb-0 text-info"></h4>
                                                <small id="fechaActual" class="text-muted"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row gy-4 mb-4">
                                    <div class="col-lg-6">
                                        <div class="card bg-label-primary h-100">
                                            <div class="card-body d-flex justify-content-between flex-wrap-reverse">
                                                <div class="mb-0 w-100 app-billing-sm-60 d-flex flex-column justify-content-between text-center text-sm-start">
                                                    <div class="card-title">
                                                        <h4 class="text-primary mb-2">Crear y Gestionar Facturas</h4>
                                                        <p class="text-body w-sm-80 app-billing-xl-100">
                                                            Genera facturas profesionales en minutos y mantén un seguimiento de tus pagos.
                                                        </p>
                                                    </div>
                                                    <div class="mb-0">
                                                        <a href="create-invoice.php" class="btn btn-primary">Crear Factura</a>
                                                    </div>
                                                </div>
                                                <div class="w-100 app-billing-sm-40 d-flex justify-content-center justify-content-sm-end h-px-150 mb-3 mb-sm-0">
                                                    <img class="img-fluid scaleX-n1-rtl"
                                                        src="../librerias/assets/img/illustrations/boy-app-academy.png"
                                                        alt="create invoice illustration" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card bg-label-success h-100">
                                            <div class="card-body d-flex justify-content-between flex-wrap-reverse">
                                                <div class="mb-0 w-100 app-billing-sm-60 d-flex flex-column justify-content-between text-center text-sm-start">
                                                    <div class="card-title">
                                                        <h4 class="text-success mb-2">Resumen Financiero</h4>
                                                        <p class="text-body app-billing-sm-60 app-billing-xl-100">
                                                            Visualiza tus ingresos, facturas pendientes y pagos en un solo lugar.
                                                        </p>
                                                    </div>
                                                    <div class="mb-0">
                                                        <a href="billing-summary.php" class="btn btn-success">Ver Resumen</a>
                                                    </div>
                                                </div>
                                                <div class="w-100 app-billing-sm-40 d-flex justify-content-center justify-content-sm-end h-px-150 mb-3 mb-sm-0">
                                                    <img class="img-fluid scaleX-n1-rtl"
                                                        src="../librerias/assets/img/illustrations/girl-app-academy.png"
                                                        alt="billing summary illustration" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body row gy-4">
                                        <div class="col-sm-6 col-lg-4 text-center">
                                            <span class="badge bg-label-primary p-2 mb-3"><i class="ti ti-file-invoice ti-lg"></i></span>
                                            <h3 class="card-title mb-2">Facturas Pendientes</h3>
                                            <a href="invoices.php?filter=pending" class="btn btn-primary">Ver Facturas</a>
                                        </div>
                                        <div class="col-sm-6 col-lg-4 text-center">
                                            <span class="badge bg-label-success p-2 mb-3"><i class="ti ti-currency-dollar ti-lg"></i></span>
                                            <h3 class="card-title mb-2">Total Facturado</h3>
                                            <a href="billing-summary.php" class="btn btn-success">Ver Detalles</a>
                                        </div>
                                        <div class="col-sm-6 col-lg-4 text-center">
                                            <span class="badge bg-label-info p-2 mb-3"><i class="ti ti-checks ti-lg"></i></span>
                                            <h3 class="card-title mb-2">Pagos Recibidos</h3>
                                            <a href="invoices.php?filter=paid" class="btn btn-info">Ver Pagos</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body text-center">
                                        <h3 class="card-title mb-3">¿Listo para Optimizar tu Facturación?</h3>
                                        <p class="card-text mb-4">
                                            Comienza ahora y descubre cómo nuestra plataforma puede ayudarte a gestionar tus finanzas de manera eficiente.
                                        </p>
                                        <a href="create-invoice.php" class="btn btn-primary btn-lg">Comenzar Ahora</a>
                                    </div>
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
    <script src="../librerias/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../librerias/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../librerias/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../librerias/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../librerias/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../librerias/assets/vendor/js/menu.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>


    <script src="../librerias/assets/vendor/libs/select2/select2.js"></script>
    <script src="../librerias/assets/vendor/libs/plyr/plyr.js"></script>

    <script src="../librerias/assets/js/main.js"></script>

    <script src="../librerias/assets/js/app-academy-course.js"></script>

    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle"
                },
                "opacity": {
                    "value": 0.9,
                    "random": false
                },
                "size": {
                    "value": 3,
                    "random": true
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 4,
                    "direction": "none",
                    "out_mode": "out"
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    }
                },
                "modes": {
                    "repulse": {
                        "distance": 100
                    },
                    "push": {
                        "particles_nb": 4
                    }
                }
            },
            "retina_detect": true
        });
    </script>
    <script>
        function actualizarHora() {
            const ahora = new Date();
            const opcionesFecha = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            document.getElementById("horaActual").textContent = ahora.toLocaleTimeString('es-MX');
            document.getElementById("fechaActual").textContent = ahora.toLocaleDateString('es-MX', opcionesFecha);
        }
        setInterval(actualizarHora, 1000);
        actualizarHora();


        function actualizarActividad() {
            fetch('../online_users/actualizar_actividad.php', {
                    method: 'POST'
                })
                .then(() => fetch('../online_users/usuarios_online.php'))
                .then(response => response.text())
                .then(cantidad => {
                    document.getElementById('usuariosEnLinea').textContent = cantidad;
                })
                .catch(console.error);
        }


        // Actualizar actividad y usuarios en línea cada 30 segundos
        actualizarActividad();
        setInterval(actualizarActividad, 30000);
    </script>


</body>


</html>