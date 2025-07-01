<!doctype html>
<html lang="es" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Facturación</title>
    <link rel="icon" type="image/x-icon" href="../librerias/img/Logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/js/all.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../librerias/assets/css/styles.css">
</head>

<body>
    <div id="particles-js"></div>
    
    <div class="login-container">
        <div class="decorative-circle"></div>
        <div class="decorative-circle"></div>
        
        <div class="login-box animate__animated animate__fadeInUp">
            <div id="camara-wrapper" class="d-none" style="display: none;">
                <video id="video" width="280" height="210" autoplay muted style="display: none;"></video>
                <canvas id="canvas" width="280" height="210" style="display: none;"></canvas>
            </div>
            
            <div class="logo-container">
                <img src="../librerias/img/Logo.png" class="logo-img" alt="Logo Facturación GO" />
            </div>
            
            <h4 class="login-title animate__animated animate__fadeIn">Portal Facturación</h4>
            <p class="login-subtitle animate__animated animate__fadeIn animate__delay-1s">Inicia sesión con tus credenciales</p>

            <form id="formulario">
                <div class="mb-3 animate__animated animate__fadeInLeft animate__delay-2s">
                    <label class="form-label">
                        <i class="fas fa-user"></i>
                        Correo o usuario
                    </label>
                    <input type="text" class="form-control" id="login_usuario" name="login_usuario" placeholder="Ingresa tu usuario" />
                </div>
                
                <div class="mb-4 animate__animated animate__fadeInRight animate__delay-3s">
                    <label class="form-label">
                        <i class="fas fa-lock"></i>
                        Contraseña
                    </label>
                    <input type="password" class="form-control" id="login_clave" name="login_clave" placeholder="Ingresa tu contraseña" />
                </div>
                
                <button type="button" class="btn btn-primary w-100 animate__animated animate__fadeInUp animate__delay-4s" onclick="login()">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Iniciar sesión
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        let modeloCargado = false;
        
        // Inicializa el efecto de las pinches partículas
        document.addEventListener('DOMContentLoaded', function() {
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 60,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#f07d42"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        }
                    },
                    "opacity": {
                        "value": 0.4,
                        "random": false,
                        "anim": {
                            "enable": false,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 40,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#f07d42",
                        "opacity": 0.3,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 1.5,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": false,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 140,
                            "line_linked": {
                                "opacity": 0.6
                            }
                        },
                        "bubble": {
                            "distance": 400,
                            "size": 40,
                            "duration": 2,
                            "opacity": 8,
                            "speed": 3
                        },
                        "repulse": {
                            "distance": 200,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        },
                        "remove": {
                            "particles_nb": 2
                        }
                    }
                },
                "retina_detect": true
            });
        });

        async function login() {
            const login_usuario = document.getElementById("login_usuario").value.trim();
            const login_clave = document.getElementById("login_clave").value.trim();
            
            if (!login_usuario || !login_clave) {
                Swal.fire({ 
                    title: "Campos requeridos", 
                    text: "Por favor ingresa tu usuario y contraseña", 
                    icon: "warning",
                    confirmButtonColor: "#f07d42"
                });
                return;
            }

            Swal.fire({
                title: 'Iniciando sesión...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            const formData = new URLSearchParams({
                usuario: login_usuario,
                password: login_clave
            });
            
            try {
                const response = await fetch("../Controllers/loginController.php?op=validar", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: formData
                });

                const text = await response.text(); // Obtener respuesta como texto para depuración
                console.log("Respuesta del servidor:", text); // Mostrar en consola para depurar

                try {
                    const data = JSON.parse(text); // Intentar parsear como JSON
                    if (data.status === 'success') {
                        // Guardar el token en localStorage y sesión
                        if (data.token) {
                            localStorage.setItem('jwt_token', data.token); // Guardar en localStorage
                            // Guardar en sesión del lado del servidor
                            await fetch("../Controllers/loginController.php?op=save_session", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded",
                                    "Authorization": `Bearer ${data.token}`
                                },
                                body: new URLSearchParams({ token: data.token })
                            });
                        }
                        Swal.fire({
                            title: "¡Bienvenido!",
                            text: data.message,
                            icon: "success",
                            confirmButtonColor: "#f07d42",
                            timer: 1500
                        }).then(() => {
                            window.location.href = "inicio.php"; // Redirigir a la página deseada
                        });
                    } else {
                        Swal.fire({ 
                            title: "Error", 
                            text: data.message, 
                            icon: "error",
                            confirmButtonColor: "#f07d42"
                        });
                    }
                } catch (jsonError) {
                    console.error("Error parseando JSON:", jsonError);
                    Swal.fire({ 
                        title: "Error", 
                        text: "Respuesta del servidor no válida: " + text, 
                        icon: "error",
                        confirmButtonColor: "#f07d42"
                    });
                }
            } catch (error) {
                console.error("Error de conexión:", error);
                Swal.fire({ 
                    title: "Error de conexión", 
                    text: "No se pudo conectar con el servidor: " + error.message, 
                    icon: "error",
                    confirmButtonColor: "#f07d42"
                });
            }
        }

        // Permitir login con Enter
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                login();
            }
        });
    </script>
</body>
</html>