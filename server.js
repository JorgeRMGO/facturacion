const express = require('express');
const jwt = require('jsonwebtoken');
const cors = require('cors'); // Importación de cors
const app = express();
const PORT = process.env.PORT || 3000;

app.use(cors()); // Uso del middleware cors para permitir peticiones de diferentes orígenes

// SIMULACIÓN DE BASE DE DATOS DE USUARIOS
const users = [
    {
        id: 'user_fact_001',
        username: 'uziel',
        password: 'admin123',
        role: 'admin'
    },
    {
        id: 'user_fact_002',
        username: 'maria',
        password: 'password456',
        role: 'user'
    },
    {
        id: 'user_fact_003',
        username: 'invitado',
        password: 'guest123',
        role: 'viewer'
    }
];

app.use(express.json()); // Middleware para procesar JSON en las solicitudes
app.use(express.urlencoded({ extended: true })); // Middleware para procesar datos de formularios URL-encoded

const JWT_SECRET = 'TuClaveSecretaSUPERCOMPLEJAyUNICAaquiParaFacturacion!';

app.post('/api/login', (req, res) => {
    const { username, password } = req.body;

    const user = users.find(u => u.username === username && u.password === password);

    if (user) {
        const payload = {
            userId: user.id,
            username: user.username,
            role: user.role
        };

        const token = jwt.sign(payload, JWT_SECRET, { expiresIn: '5h' });

        return res.json({
            message: `Inicio de sesión exitoso como ${user.username} (${user.role})`,
            token: token
        });
    } else {
        return res.status(401).json({ message: 'Usuario o contraseña incorrectos' });
    }
});

function authenticateToken(req, res, next) {
    const authHeader = req.headers['authorization'];
    const token = authHeader && authHeader.split(' ')[1];

    if (token == null) {
        return res.status(401).json({ message: 'Acceso denegado. No se proporcionó token.' });
    }

    jwt.verify(token, JWT_SECRET, (err, user) => {
        if (err) {
            return res.status(403).json({ message: 'Token inválido o expirado.' });
        }
        req.user = user;
        next();
    });
}

app.get('/api/data_protegida', authenticateToken, (req, res) => {
    const userRole = req.user.role;
    let responseData = {};

    switch (userRole) {
        case 'admin':
            responseData = {
                message: 'Acceso Total de Administrador',
                data: {
                    reporteGlobal: 'Reporte de todas las facturas del sistema (Administrador)',
                    usuariosActivos: 150,
                    gananciasTotales: '€1,250,000',
                    accessedBy: req.user.username,
                    role: userRole
                }
            };
            break;
        case 'user':
            responseData = {
                message: 'Acceso de Usuario Estándar',
                data: {
                    misFacturas: 'Factura #12345 (Cliente: Ejemplo S.A. - Tuya)',
                    saldoPendiente: '€500',
                    accessedBy: req.user.username,
                    role: userRole
                }
            };
            break;
        case 'viewer':
            responseData = {
                message: 'Acceso de Visualizador',
                data: {
                    informacionPublica: 'Solo puedes ver información pública del sistema.',
                    estadisticasBasicas: 'Número de facturas emitidas hoy: 25',
                    accessedBy: req.user.username,
                    role: userRole
                }
            };
            break;
        default:
            responseData = {
                message: 'Acceso limitado para rol no definido',
                data: {
                    generalInfo: 'No tienes un rol específico asignado.',
                    accessedBy: req.user.username,
                    role: userRole
                }
            };
            break;
    }

    res.json(responseData);
});

app.get('/api/admin_panel', authenticateToken, (req, res) => {
    if (req.user.role === 'admin') {
        res.json({
            message: 'Bienvenido al panel de administración!',
            adminData: {
                gestionUsuarios: 'Control total de usuarios',
                configuracionSistema: 'Acceso a configuración crítica'
            },
            accessedBy: req.user.username
        });
    } else {
        res.status(403).json({ message: 'No tienes permisos de administrador para acceder a esta ruta.' });
    }
});

app.get('/', (req, res) => {
    res.send('Servidor de Facturación funcionando. Prueba las rutas /api/login y /api/data_protegida');
});

app.listen(PORT, () => {
    console.log(`Servidor de facturación corriendo en http://localhost:${PORT}`);
    console.log(`Para iniciar sesión: POST http://localhost:${PORT}/api/login`);
    console.log(`Para acceder a datos protegidos: GET http://localhost:${PORT}/api/data_protegida (requiere JWT)`);
    console.log(`Para acceder al panel de admin: GET http://localhost:${PORT}/api/admin_panel (solo admin)`);
});
