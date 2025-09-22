@extends('layouts.public')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/ion-range-slider/css/ion.rangeSlider.min.css') }}">
    <style>
        /* Canvas Styling */
        .layer {
            align-items: center;
            justify-content: center;
        }

        canvas {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            cursor: crosshair;
            max-width: 100%;
            height: auto;
        }

        /* Wizard Styling */
        .wizard-step {
            min-height: 400px;
            transition: all 0.3s ease;
        }

        .step-label {
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .step-label.active {
            color: #198754 !important;
            font-weight: 600;
            transform: scale(1.05);
        }

        .progress-bar {
            transition: width 0.4s ease;
        }

        /* Form Styling */
        .form-check-lg .form-check-input {
            width: 1.5rem;
            height: 1.5rem;
            margin-top: 0.125rem;
        }

        .form-check-lg .form-check-label {
            font-size: 1.1rem;
            padding-left: 0.5rem;
        }

        .checkB {
            width: 40px;
            height: 40px;
            transform: scale(1.2);
        }

        .checkB-2 {
            width: 30px;
            height: 30px;
            transform: scale(1.1);
        }

        /* Card animations */
        .card {
            transition: all 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        /* Error styling */
        .is-invalid {
            border-color: #dc3545 !important;
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Loading states */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .step-label {
                font-size: 0.75rem;
            }
            
            canvas {
                width: 100% !important;
                height: 300px !important;
            }
            
            .checkB {
                width: 35px;
                height: 35px;
            }
        }

        /* Toast notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        /* Summary section styling */
        .summary-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-left: 4px solid #198754;
        }

        /* Navigation button styling */
        .wizard-navigation {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-top: 1px solid #dee2e6;
            position: sticky;
            bottom: 0;
            z-index: 100;
        }

        /* Testigos active state */
        .testigo-active .testigo-content {
            border-color: #198754 !important;
            background: linear-gradient(135deg, #f8fff9 0%, #e8f5e8 100%) !important;
            box-shadow: 0 4px 15px rgba(25, 135, 84, 0.2) !important;
        }

        .testigo-active .testigo-icon {
            transform: scale(1.1) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;
        }

        .testigo-active .status-indicator {
            background: #198754 !important;
            animation: pulse-green 2s infinite !important;
        }

        /* Hover effects for cards */
        .card:hover .card-header {
            transform: translateY(-1px);
        }

        /* Smooth transitions for all interactive elements */
        .form-check-input, .form-control, .btn {
            transition: all 0.2s ease;
        }

        /* Focus states */
        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }

        /* Loading spinner for finish button */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
    </style>
@endsection

@section('content')
    @include('shared.system.loader')
    @livewire('entrada.capturar-entrada-inventario-wizard')
@endsection

@section('js')
    <script src="{{ asset('vendor/ion-range-slider/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('js/wizard/navigation.js') }}"></script>
    
    <script>
        // Configuración global para el wizard
        window.WIZARD_CONFIG = {
            canvasImages: {
                image1: "{{ asset('/images/inventario/foto1.png') }}",
                image2: "{{ asset('/images/inventario/foto2.png') }}"
            },
            validation: {
                showToasts: true,
                autoScroll: true
            },
            performance: {
                lazyLoadCanvas: true,
                deferNonCritical: true
            }
        };

        // Eventos de Livewire optimizados
        document.addEventListener('livewire:load', function () {
            // Escuchar eventos específicos del componente
            window.livewire.on('ok', message => {
                showNotification(message, 'success');
            });

            window.livewire.on('error', message => {
                showNotification(message, 'error');
            });

            window.livewire.on('info', message => {
                showNotification(message, 'info');
            });

            // Optimizar actualizaciones de Livewire
            window.livewire.hook('message.processed', (message, component) => {
                // Reinicializar componentes si es necesario
                if (message.updateQueue && message.updateQueue.length > 0) {
                    // Solo reinicializar si hubo cambios significativos
                    const hasFormUpdates = message.updateQueue.some(update => 
                        update.type === 'syncInput' || update.type === 'callMethod'
                    );
                    
                    if (hasFormUpdates && window.wizardInstance) {
                        window.wizardInstance.loadFormEvents();
                    }
                }
            });
        });

        // Sistema de notificaciones optimizado
        function showNotification(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${getAlertClass(type)} alert-dismissible fade show`;
            toast.style.cssText = 'margin-bottom: 10px; min-width: 300px;';
            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas ${getIcon(type)} me-2"></i>
                    <span>${message}</span>
                    <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;

            let container = document.querySelector('.toast-container');
            if (!container) {
                container = document.createElement('div');
                container.className = 'toast-container';
                document.body.appendChild(container);
            }

            container.appendChild(toast);

            // Auto remove
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.classList.add('fade');
                    setTimeout(() => toast.remove(), 150);
                }
            }, type === 'error' ? 8000 : 5000);
        }

        function getAlertClass(type) {
            const classes = {
                'success': 'success',
                'error': 'danger',
                'info': 'info',
                'warning': 'warning'
            };
            return classes[type] || 'info';
        }

        function getIcon(type) {
            const icons = {
                'success': 'fa-check-circle',
                'error': 'fa-exclamation-circle',
                'info': 'fa-info-circle',
                'warning': 'fa-exclamation-triangle'
            };
            return icons[type] || 'fa-info-circle';
        }

        // Manejo de errores global
        window.addEventListener('error', function(e) {
            console.error('Wizard Error:', e.error);
            showNotification('Ha ocurrido un error inesperado. Por favor, recargue la página.', 'error');
        });

        // Optimización de rendimiento
        document.addEventListener('DOMContentLoaded', function() {
            // Precargar imágenes críticas
            if (window.WIZARD_CONFIG?.canvasImages) {
                const img1 = new Image();
                const img2 = new Image();
                img1.src = window.WIZARD_CONFIG.canvasImages.image1;
                img2.src = window.WIZARD_CONFIG.canvasImages.image2;
            }

            // Configurar lazy loading para elementos no críticos
            if ('IntersectionObserver' in window) {
                const lazyElements = document.querySelectorAll('[data-lazy]');
                const lazyObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const element = entry.target;
                            element.classList.remove('d-none');
                            lazyObserver.unobserve(element);
                        }
                    });
                });

                lazyElements.forEach(el => lazyObserver.observe(el));
            }
        });

        // Funciones de utilidad para debugging (solo en desarrollo)
        @if(config('app.debug'))
        window.WIZARD_DEBUG = {
            getCurrentStep: () => window.wizardInstance?.currentStep,
            validateStep: (step) => window.wizardInstance?.validateStep(step),
            getFormData: () => {
                const formData = new FormData();
                document.querySelectorAll('[wire\\:model\\.defer]').forEach(input => {
                    if (input.type === 'checkbox') {
                        formData.append(input.name || input.id, input.checked);
                    } else {
                        formData.append(input.name || input.id, input.value);
                    }
                });
                return Object.fromEntries(formData.entries());
            }
        };
        @endif
    </script>
@endsection
