// server.js

// 1. Importar librerías necesarias
const express = require('express');
const jwt = require('jsonwebtoken');
const app = express();
const PORT = process.env.PORT || 3000; // Puerto donde correrá tu servidor

// 2. Middleware para procesar JSON en las solicitudes (importante para logins)
app.use(express.json());

// 3. Definir la clave secreta del JWT (¡¡MUY IMPORTANTE Y SECRETA!!)
//    En un entorno real, esto iría en una variable de entorno (.env file)
const JWT_SECRET = 'TuClaveSecretaSUPERCOMPLEJAyUNICAaquiParaFacturacion!'; // <--- ¡CÁMBIALA POR ALGO MÁS SEGURO!

// 4. Ruta para el inicio de sesión (genera el JWT)
app.post('/api/login', (req, res) => {
    // Aquí, en un escenario real, VALIDARÍAS las credenciales del usuario contra una base de datos.
    // Por ahora, SIMULAMOS un usuario y contraseña válidos.
    const { username, password } = req.body;

    if (username === 'uziel' && password === 'admin123') { // SIMULACIÓN DE VALIDACIÓN
        // Credenciales válidas: Generar el JWT
        const payload = {
            userId: 'user_fact_001',
            username: username,
            role: 'admin' // O 'user', 'auditor', etc.
        };

        const token = jwt.sign(payload, JWT_SECRET, { expiresIn: '5h' }); // Token válido por 1 hora

        return res.json({
            message: 'Inicio de sesión exitoso',
            token: token // Enviamos el JWT al cliente
        });
    } else {
        // Credenciales inválidas
        return res.status(401).json({ message: 'Usuario o contraseña incorrectos' });
    } // <--- ¡AQUÍ ESTABA EL CAMBIO! QUITAR EL PARÉNTESIS EXTRA
}); // <--- Este cierra la función app.post correctamente.

// 5. Middleware de autenticación (para proteger rutas)
//    Esta función se ejecutará ANTES de las rutas protegidas para verificar el JWT.
function authenticateToken(req, res, next) {
    const authHeader = req.headers['authorization'];
    // El token viene en el formato "Bearer <TOKEN>"
    const token = authHeader && authHeader.split(' ')[1]; // Extrae el token después de "Bearer "

    if (token == null) {
        return res.status(401).json({ message: 'Acceso denegado. No se proporcionó token.' });
    }

    jwt.verify(token, JWT_SECRET, (err, user) => {
        if (err) {
            // Error de verificación: token inválido (expirado, modificado, firma incorrecta)
            return res.status(403).json({ message: 'Token inválido o expirado.' });
        }
        req.user = user; // Guarda la información del usuario (el payload del token) en la solicitud
        next(); // Continúa a la siguiente función (la ruta protegida)
    });
}

// 6. Ruta Protegida (solo accesible con un JWT válido)
app.get('/api/data_protegida', authenticateToken, (req, res) => {
    // Si llegamos aquí, el token fue válido y req.user contiene el payload del token.
    res.json({
        message: 'Datos confidenciales de facturación',
        data: {
            item1: 'Factura #12345',
            item2: 'Cliente: Ejemplo S.A.',
            accessedBy: req.user.username, // Usamos la info del token para mostrar quién accedió
            role: req.user.role
        }
    });
});

// 7. Ruta de prueba simple (sin protección)
app.get('/', (req, res) => {
    res.send('Servidor de Facturación funcionando. Prueba las rutas /api/login y /api/data_protegida');
});

// 8. Iniciar el servidor
app.listen(PORT, () => {
    console.log(`Servidor de facturación corriendo en http://localhost:${PORT}`);
    console.log(`Para iniciar sesión: POST http://localhost:${PORT}/api/login`);
    console.log(`Para acceder a datos protegidos: GET http://localhost:${PORT}/api/data_protegida (requiere JWT)`);
});