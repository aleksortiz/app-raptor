/**
 * Sistema de Navegación del Wizard de Inventario
 * Optimizado para ahorrar recursos del servidor
 * Maneja toda la lógica de navegación en el frontend
 */

class InventarioWizard {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = 6;
        this.stepValidations = new Map();
        this.canvasInitialized = false;
        this.rangeSliderInitialized = false;
        
        this.initializeWizard();
        this.setupValidations();
        this.bindEvents();
    }

    initializeWizard() {
        // Inicializar componentes del primer paso
        this.initRangeSlider();
        this.updateProgressBar();
        this.updateNavigationButtons();
        
        // Precargar eventos de formulario
        this.loadFormEvents();
        
        console.log('Inventario Wizard initialized');
    }

    setupValidations() {
        // Validaciones por paso
        this.stepValidations.set(1, () => this.validateStep1());
        this.stepValidations.set(2, () => this.validateStep2());
        this.stepValidations.set(3, () => this.validateStep3());
        this.stepValidations.set(4, () => this.validateStep4());
        this.stepValidations.set(5, () => this.validateStep5());
        this.stepValidations.set(6, () => this.validateStep6());
    }

    bindEvents() {
        // Eventos de validación en tiempo real
        document.addEventListener('input', (e) => {
            if (e.target.matches('[wire\\:model\\.defer]')) {
                this.validateCurrentStep();
            }
        });

        document.addEventListener('change', (e) => {
            if (e.target.matches('[wire\\:model\\.defer]')) {
                this.validateCurrentStep();
                this.updateSummary();
            }
        });

        // Eventos de teclado para navegación rápida
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey) {
                switch(e.key) {
                    case 'ArrowLeft':
                        e.preventDefault();
                        this.previousStep();
                        break;
                    case 'ArrowRight':
                        e.preventDefault();
                        this.nextStep();
                        break;
                }
            }
        });
    }

    nextStep() {
        if (this.currentStep >= this.totalSteps) return;
        
        // Validar paso actual antes de continuar
        if (!this.validateCurrentStep()) {
            this.showValidationErrors();
            return;
        }

        this.hideStep(this.currentStep);
        this.currentStep++;
        this.showStep(this.currentStep);
        
        // Inicializar componentes específicos del paso
        this.initializeStepComponents();
        
        this.updateProgressBar();
        this.updateNavigationButtons();
        this.updateStepLabels();
        
        // Scroll suave al inicio
        this.scrollToTop();
    }

    previousStep() {
        if (this.currentStep <= 1) return;
        
        this.hideStep(this.currentStep);
        this.currentStep--;
        this.showStep(this.currentStep);
        
        this.updateProgressBar();
        this.updateNavigationButtons();
        this.updateStepLabels();
        
        // Scroll suave al inicio
        this.scrollToTop();
    }

    showStep(stepNumber) {
        const step = document.getElementById(`step-${stepNumber}`);
        if (step) {
            step.classList.remove('d-none');
            step.style.opacity = '0';
            step.style.transform = 'translateX(50px)';
            
            // Animación de entrada
            setTimeout(() => {
                step.style.transition = 'all 0.3s ease';
                step.style.opacity = '1';
                step.style.transform = 'translateX(0)';
            }, 10);
        }
    }

    hideStep(stepNumber) {
        const step = document.getElementById(`step-${stepNumber}`);
        if (step) {
            step.style.transition = 'all 0.2s ease';
            step.style.opacity = '0';
            step.style.transform = 'translateX(-50px)';
            
            setTimeout(() => {
                step.classList.add('d-none');
            }, 200);
        }
    }

    initializeStepComponents() {
        switch(this.currentStep) {
            case 1:
                if (!this.rangeSliderInitialized) {
                    this.initRangeSlider();
                }
                break;
            case 2:
                if (!this.canvasInitialized) {
                    this.initCanvas();
                    this.canvasInitialized = true;
                }
                break;
            case 3:
                this.loadFormEvents();
                break;
            case 5:
                this.loadFormEvents();
                break;
            case 6:
                this.updateSummary();
                break;
        }
    }

    updateProgressBar() {
        const progressBar = document.getElementById('progress-bar');
        const percentage = (this.currentStep / this.totalSteps) * 100;
        
        if (progressBar) {
            progressBar.style.width = `${percentage}%`;
        }
    }

    updateNavigationButtons() {
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const finishBtn = document.getElementById('finish-btn');
        
        // Botón anterior
        if (prevBtn) {
            prevBtn.disabled = this.currentStep === 1;
        }
        
        // Botón siguiente/finalizar
        if (this.currentStep === this.totalSteps) {
            nextBtn?.classList.add('d-none');
            finishBtn?.classList.remove('d-none');
        } else {
            nextBtn?.classList.remove('d-none');
            finishBtn?.classList.add('d-none');
        }
    }

    updateStepLabels() {
        document.querySelectorAll('.step-label').forEach((label, index) => {
            const stepNumber = index + 1;
            if (stepNumber <= this.currentStep) {
                label.classList.add('active');
            } else {
                label.classList.remove('active');
            }
        });
    }

    scrollToTop() {
        document.getElementById('inventario-wizard').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    // Validaciones por paso
    validateStep1() {
        const requiredFields = ['color'];
        const numericFields = ['year', 'kilometros'];
        let isValid = true;
        
        // Validar campos requeridos
        requiredFields.forEach(field => {
            const input = document.querySelector(`[wire\\:model\\.defer="${field}"]`);
            if (input && !input.value.trim()) {
                this.showFieldError(input, 'Este campo es requerido');
                isValid = false;
            } else {
                this.clearFieldError(input);
            }
        });
        
        // Validar campos numéricos
        numericFields.forEach(field => {
            const input = document.querySelector(`[wire\\:model\\.defer="${field}"]`);
            if (input && input.value && !/^\d+$/.test(input.value)) {
                this.showFieldError(input, 'Solo se permiten números');
                isValid = false;
            }
        });
        
        // Validar año específicamente
        const yearInput = document.querySelector('[wire\\:model\\.defer="year"]');
        if (yearInput && yearInput.value) {
            const year = parseInt(yearInput.value);
            const currentYear = new Date().getFullYear();
            if (year < 1900 || year > currentYear + 1) {
                this.showFieldError(yearInput, `Año debe estar entre 1900 y ${currentYear + 1}`);
                isValid = false;
            }
        }
        
        return isValid;
    }

    validateStep2() {
        // El diagrama es opcional, siempre válido
        return true;
    }

    validateStep3() {
        const requiredSelects = [
            'estereo', 'tapetes', 'parabrisas', 'gato', 
            'extra', 'herramientas', 'cables', 'ac'
        ];
        
        let isValid = true;
        
        requiredSelects.forEach(field => {
            const select = document.querySelector(`[wire\\:model\\.defer="${field}"]`);
            if (select && !select.value) {
                this.showFieldError(select, 'Seleccione una opción');
                isValid = false;
            } else {
                this.clearFieldError(select);
            }
        });
        
        return isValid;
    }

    validateStep4() {
        // Los testigos son opcionales
        return true;
    }

    validateStep5() {
        // Validar campos condicionales
        let isValid = true;
        
        // Validar campos de texto condicionales
        const conditionalFields = [
            { checkbox: 'carroceria_otro', text: 'carroceria_otro_text' },
            { checkbox: 'falla_mecanica', text: 'falla_mecanica_text' },
            { checkbox: 'suspension', text: 'suspension_text' },
            { checkbox: 'mecanica_otro', text: 'mecanica_otro_text' }
        ];
        
        conditionalFields.forEach(({ checkbox, text }) => {
            const checkboxEl = document.querySelector(`[wire\\:model\\.defer="${checkbox}"]`);
            const textEl = document.querySelector(`[wire\\:model\\.defer="${text}"]`);
            
            if (checkboxEl && checkboxEl.checked && textEl && !textEl.value.trim()) {
                this.showFieldError(textEl, 'Este campo es requerido cuando está marcado');
                isValid = false;
            } else if (textEl) {
                this.clearFieldError(textEl);
            }
        });
        
        return isValid;
    }

    validateStep6() {
        // Paso final, siempre válido
        return true;
    }

    validateCurrentStep() {
        const validator = this.stepValidations.get(this.currentStep);
        return validator ? validator() : true;
    }

    showFieldError(element, message) {
        if (!element) return;
        
        // Remover error anterior
        this.clearFieldError(element);
        
        // Agregar clase de error
        element.classList.add('is-invalid');
        
        // Crear mensaje de error
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback wizard-error';
        errorDiv.textContent = message;
        
        // Insertar después del elemento
        element.parentNode.insertBefore(errorDiv, element.nextSibling);
    }

    clearFieldError(element) {
        if (!element) return;
        
        element.classList.remove('is-invalid');
        const errorMsg = element.parentNode.querySelector('.wizard-error');
        if (errorMsg) {
            errorMsg.remove();
        }
    }

    showValidationErrors() {
        // Mostrar toast de error
        this.showToast('Por favor, complete todos los campos requeridos', 'error');
        
        // Hacer scroll al primer campo con error
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    }

    updateSummary() {
        if (this.currentStep !== 6) return;
        
        // Actualizar resumen en el último paso
        const summaryFields = {
            'summary-year': 'year',
            'summary-color': 'color',
            'summary-placas': 'placas',
            'summary-km': 'kilometros',
            'summary-gas': 'gasolina'
        };
        
        Object.entries(summaryFields).forEach(([summaryId, fieldName]) => {
            const summaryEl = document.getElementById(summaryId);
            const fieldEl = document.querySelector(`[wire\\:model\\.defer="${fieldName}"]`);
            
            if (summaryEl && fieldEl) {
                let value = fieldEl.value || 'No especificado';
                if (fieldName === 'gasolina') {
                    value = value + '%';
                }
                summaryEl.textContent = value;
            }
        });
    }

    // Inicialización de componentes
    initRangeSlider() {
        if (this.rangeSliderInitialized) return;
        
        const slider = $("#range_gas");
        if (slider.length && typeof slider.ionRangeSlider === 'function') {
            slider.ionRangeSlider({
                skin: "round",
                postfix: ' %',
                prettify_enabled: true,
                min: 0,
                max: 100,
                from: 0,
                onFinish: (data) => {
                    // Actualizar valor en Livewire
                    window.livewire.emit('setGas', data.from);
                    
                    // Actualizar display
                    const gasValue = document.getElementById('gas-value');
                    if (gasValue) {
                        gasValue.textContent = data.from + '%';
                    }
                }
            });
            
            this.rangeSliderInitialized = true;
        }
    }

    initCanvas() {
        const canvas = document.getElementById('drawingCanvas');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        
        canvas.height = 500;
        canvas.width = 1050;
        
        // Variables para el dibujo
        let drawing = false;
        
        // Prevenir scroll en dispositivos táctiles
        canvas.addEventListener('touchstart', function(e) {
            if (e.target === canvas) {
                e.preventDefault();
            }
        }, { passive: false });
        
        canvas.addEventListener('touchmove', function(e) {
            if (e.target === canvas) {
                e.preventDefault();
            }
        }, { passive: false });
        
        function startDrawing(e) {
            e.preventDefault();
            drawing = true;
            draw(e);
        }
        
        function stopDrawing(e) {
            e.preventDefault();
            drawing = false;
            ctx.beginPath();
        }
        
        function getEventPosition(e) {
            const rect = canvas.getBoundingClientRect();
            return {
                x: e.clientX !== undefined ? e.clientX - rect.left : e.touches[0].clientX - rect.left,
                y: e.clientY !== undefined ? e.clientY - rect.top : e.touches[0].clientY - rect.top
            };
        }
        
        function draw(e) {
            if (!drawing) return;
            
            e.preventDefault();
            ctx.lineWidth = 3;
            ctx.lineCap = 'round';
            ctx.strokeStyle = 'red';
            
            const pos = getEventPosition(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
        }
        
        // Event Listeners
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseleave', stopDrawing);
        
        canvas.addEventListener('touchstart', startDrawing);
        canvas.addEventListener('touchend', stopDrawing);
        canvas.addEventListener('touchmove', draw);
        
        // Cargar imágenes de fondo
        const image = new Image();
        const image2 = new Image();
        image.src = "/images/inventario/foto1.png";
        image2.src = "/images/inventario/foto2.png";
        
        image.onload = () => {
            image2.onload = () => {
                ctx.drawImage(image, 20, 20, 500, 400);
                ctx.drawImage(image2, 500, 20, 550, 400);
            };
        };
        
        // Función global para limpiar canvas
        window.cleanCanvas = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            // Redibujar imágenes de fondo
            if (image.complete && image2.complete) {
                ctx.drawImage(image, 20, 20, 500, 400);
                ctx.drawImage(image2, 500, 20, 550, 400);
            }
        };
    }

    loadFormEvents() {
        // Eventos para checkboxes con targets (versión original)
        document.querySelectorAll('.checkB').forEach(checkbox => {
            const target = checkbox.dataset.target;
            if (target) {
                checkbox.addEventListener('change', function() {
                    const targetEl = document.querySelector(target);
                    if (targetEl) {
                        if (this.checked) {
                            targetEl.classList.remove('d-none');
                        } else {
                            targetEl.classList.add('d-none');
                        }
                    }
                });
            }
        });

        // Eventos para checkboxes mejorados con targets (damage-checkbox)
        document.querySelectorAll('.damage-checkbox').forEach(checkbox => {
            const target = checkbox.dataset.target;
            if (target) {
                checkbox.addEventListener('change', function() {
                    const targetEl = document.querySelector(target);
                    if (targetEl) {
                        if (this.checked) {
                            targetEl.classList.remove('d-none');
                            // Animación de entrada
                            setTimeout(() => {
                                targetEl.style.opacity = '0';
                                targetEl.style.transform = 'translateY(-10px)';
                                targetEl.style.transition = 'all 0.3s ease';
                                setTimeout(() => {
                                    targetEl.style.opacity = '1';
                                    targetEl.style.transform = 'translateY(0)';
                                }, 10);
                            }, 10);
                        } else {
                            targetEl.style.transition = 'all 0.2s ease';
                            targetEl.style.opacity = '0';
                            targetEl.style.transform = 'translateY(-10px)';
                            setTimeout(() => {
                                targetEl.classList.add('d-none');
                            }, 200);
                        }
                    }
                });
            }
        });
        
        // Eventos para selects con labels
        document.querySelectorAll('select[data-label]').forEach(select => {
            const labelId = select.dataset.label;
            const label = document.getElementById(labelId);
            
            if (label) {
                select.addEventListener('change', function() {
                    if (this.value) {
                        label.classList.add('text-success');
                    } else {
                        label.classList.remove('text-success');
                    }
                });
            }
        });

        // Eventos para testigos mejorados
        document.querySelectorAll('.testigo-input').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const card = this.closest('.testigo-card');
                if (card) {
                    if (this.checked) {
                        card.classList.add('testigo-active');
                    } else {
                        card.classList.remove('testigo-active');
                    }
                }
            });
        });

        // Eventos para elementos de daño simples
        document.querySelectorAll('.damage-simple-content').forEach(content => {
            content.addEventListener('click', function() {
                const checkbox = this.closest('.form-check').querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
        });
    }

    showToast(message, type = 'info') {
        // Crear toast notification
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 5000);
    }

    finishInventario() {
        if (!this.validateCurrentStep()) {
            this.showValidationErrors();
            return;
        }
        
        // Obtener datos del canvas
        const canvas = document.getElementById('drawingCanvas');
        let canvasData = null;
        
        if (canvas) {
            canvasData = canvas.toDataURL('image/png');
        }
        
        // Mostrar loading
        this.showLoading();
        
        // Emitir evento a Livewire
        window.livewire.emit('createInventario', canvasData);
    }

    showLoading() {
        const finishBtn = document.getElementById('finish-btn');
        if (finishBtn) {
            finishBtn.disabled = true;
            finishBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';
        }
    }
}

// Funciones globales para compatibilidad
let wizardInstance;

function nextStep() {
    wizardInstance?.nextStep();
}

function previousStep() {
    wizardInstance?.previousStep();
}

function finishInventario() {
    wizardInstance?.finishInventario();
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    wizardInstance = new InventarioWizard();
});

// Eventos de Livewire
document.addEventListener('livewire:load', function() {
    // Reinicializar si Livewire recarga el componente
    if (!wizardInstance) {
        wizardInstance = new InventarioWizard();
    }
});
