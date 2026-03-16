<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente API v1 - FitPadel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 980px;
            margin: 24px auto;
            padding: 0 16px;
            background: #f5f7fb;
            color: #1f2937;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 16px;
        }

        h1 {
            margin-top: 0;
        }

        h2 {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input, textarea, button, select {
            width: 100%;
            margin-top: 6px;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
        }

        button {
            background: #0f766e;
            color: #fff;
            border: none;
            cursor: pointer;
            margin-top: 12px;
        }

        button:hover {
            background: #115e59;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .actions button {
            width: auto;
            min-width: 140px;
        }

        pre {
            background: #111827;
            color: #e5e7eb;
            padding: 12px;
            border-radius: 8px;
            overflow-x: auto;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <h1>Cliente basico API v1 (Token)</h1>

    <div class="card">
        <h2>1) Configuracion</h2>
        <label for="baseUrl">Base URL API</label>
        <input id="baseUrl" type="text" value="">

        <label for="token">Token Bearer (se rellena tras login)</label>
        <textarea id="token" rows="3" placeholder="Pega aqui tu token si ya lo tienes"></textarea>
    </div>

    <div class="card">
        <h2>2) Login</h2>
        <div class="grid">
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" placeholder="usuario@correo.com">
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" placeholder="********">
            </div>
        </div>
        <button id="loginBtn">Login y obtener token</button>
    </div>

    <div class="card">
        <h2>3) CRUD de Registros</h2>

        <div class="actions">
            <button id="listBtn">GET /registros</button>
            <button id="createBtn">POST /registros</button>
            <button id="logoutBtn">POST /logout</button>
        </div>

        <label for="registroId">ID para show/update/delete</label>
        <input id="registroId" type="number" placeholder="Ej: 1">

        <div class="actions">
            <button id="showBtn">GET /registros/{id}</button>
            <button id="updateBtn">PATCH /registros/{id}</button>
            <button id="deleteBtn">DELETE /registros/{id}</button>
        </div>

        <label for="payload">Payload JSON (create/update)</label>
        <textarea id="payload" rows="10">{
  "nombre": "Abian",
  "fecha": "2026-03-05",
  "pasos": 8000,
  "calorias": 350,
  "estado": "Bien"
}</textarea>
    </div>

    <div class="card">
        <h2>4) Respuesta</h2>
        <pre id="result">Aun no hay peticiones.</pre>
    </div>

    <script>
        // Ponemos una URL por defecto para que el alumno no tenga que escribirla siempre.
        const baseUrlInput = document.getElementById('baseUrl');
        baseUrlInput.value = window.location.origin + '/api/v1';

        const tokenInput = document.getElementById('token');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const registroIdInput = document.getElementById('registroId');
        const payloadInput = document.getElementById('payload');
        const resultEl = document.getElementById('result');

        function writeResult(status, body) {
            resultEl.textContent = 'HTTP ' + status + '\n\n' + JSON.stringify(body, null, 2);
        }

        function getHeaders(withAuth = true) {
            const headers = {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            };

            // Todas las rutas privadas necesitan Authorization: Bearer <token>
            if (withAuth && tokenInput.value.trim()) {
                headers['Authorization'] = 'Bearer ' + tokenInput.value.trim();
            }

            return headers;
        }

        async function request(path, method, body = null, withAuth = true) {
            // Centralizamos las peticiones para reutilizar cabeceras y salida por pantalla.
            const options = {
                method,
                headers: getHeaders(withAuth),
            };

            if (body !== null) {
                options.body = JSON.stringify(body);
            }

            const response = await fetch(baseUrlInput.value + path, options);
            let data;

            try {
                // Intentamos leer JSON porque la API REST responde en ese formato.
                data = await response.json();
            } catch (e) {
                // En 204 (No Content) no hay cuerpo JSON y caeremos aquí.
                data = { message: 'Respuesta no JSON o sin contenido.' };
            }

            writeResult(response.status, data);
            return { response, data };
        }

        document.getElementById('loginBtn').addEventListener('click', async () => {
            const payload = {
                email: emailInput.value,
                password: passwordInput.value,
            };

            const { data } = await request('/login', 'POST', payload, false);

            // Guardamos token automáticamente para no copiar/pegar manualmente.
            if (data.access_token) {
                tokenInput.value = data.access_token;
            }
        });

        document.getElementById('listBtn').addEventListener('click', async () => {
            // Lista todos los registros del recurso principal.
            await request('/registros', 'GET');
        });

        document.getElementById('createBtn').addEventListener('click', async () => {
            // create y update comparten el JSON del textarea para facilitar pruebas rápidas.
            const payload = JSON.parse(payloadInput.value);
            await request('/registros', 'POST', payload);
        });

        document.getElementById('showBtn').addEventListener('click', async () => {
            await request('/registros/' + registroIdInput.value, 'GET');
        });

        document.getElementById('updateBtn').addEventListener('click', async () => {
            const payload = JSON.parse(payloadInput.value);
            await request('/registros/' + registroIdInput.value, 'PATCH', payload);
        });

        document.getElementById('deleteBtn').addEventListener('click', async () => {
            // DELETE debe responder 204 cuando el recurso se elimina correctamente.
            await request('/registros/' + registroIdInput.value, 'DELETE');
        });

        document.getElementById('logoutBtn').addEventListener('click', async () => {
            await request('/logout', 'POST');
        });
    </script>
</body>
</html>
