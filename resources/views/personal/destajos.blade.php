<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destajos - Sistema de Pagos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <h1 class="text-2xl font-semibold text-gray-900">Sistema de Destajos</h1>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Token Input Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <div class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1">
                        <label for="token" class="block text-sm font-medium text-gray-700 mb-1">Token de Acceso</label>
                        <input type="text" id="token" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ingresa el token">
                    </div>
                    <button onclick="fetchDestajos()" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Consultar
                    </button>
                </div>
            </div>

            <!-- Results Section -->
            <div id="results" class="space-y-6">
                <!-- Summary Card -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Resumen de Pagos</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Total de Órdenes</p>
                                <p id="total-ordenes" class="text-2xl font-semibold text-gray-900">-</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Monto Total</p>
                                <p id="monto-total" class="text-2xl font-semibold text-gray-900">-</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Monto Pendiente</p>
                                <p id="monto-pendiente" class="text-2xl font-semibold text-gray-900">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Órdenes de Trabajo</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Folio</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehículo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="orders-body" class="bg-white divide-y divide-gray-200">
                                    <!-- Orders will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        async function fetchDestajos() {
            const token = document.getElementById('token').value;
            if (!token) {
                alert('Por favor ingresa un token');
                return;
            }

            try {
                const response = await fetch(`/api/destajos?token=${token}`);
                const data = await response.json();

                if (response.ok) {
                    updateUI(data);
                } else {
                    alert(data.error || 'Error al obtener los destajos');
                }
            } catch (error) {
                alert('Error al conectar con el servidor');
            }
        }

        function updateUI(data) {
            // Update summary
            document.getElementById('total-ordenes').textContent = data.resumen.total_ordenes;
            document.getElementById('monto-total').textContent = formatCurrency(data.resumen.monto_total);
            document.getElementById('monto-pendiente').textContent = formatCurrency(data.resumen.monto_pendiente);

            // Update orders table
            const ordersBody = document.getElementById('orders-body');
            ordersBody.innerHTML = '';

            data.ordenes.forEach(orden => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${orden.folio_short}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${orden.vehiculo}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatCurrency(orden.monto)}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${orden.pagado ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                            ${orden.pagado ? 'Pagado' : 'Pendiente'}
                        </span>
                    </td>
                `;
                ordersBody.appendChild(row);
            });
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('es-MX', {
                style: 'currency',
                currency: 'MXN'
            }).format(amount);
        }
    </script>
</body>
</html> 