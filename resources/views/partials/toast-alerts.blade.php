<!-- Modern Toast Alert Component -->
<div id="toast-container"
    class="fixed top-16 right-4 md:right-6 md:top-20 flex flex-col gap-3 pointer-events-none z-[9999] px-4 md:px-0">
    <!-- Alerts will be dynamically inserted here -->
</div>

<style>
    /* Modern Toast Animations */
    @keyframes slideInRight {
        from {
            transform: translateX(120%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }

        to {
            transform: translateX(120%);
            opacity: 0;
        }
    }

    @keyframes progressShrink {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }

    .toast-enter {
        animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .toast-exit {
        animation: slideOutRight 0.3s cubic-bezier(0.4, 0, 1, 1) forwards;
    }

    .toast-progress {
        animation: progressShrink linear forwards;
    }

    .toast-glass {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    .toast-container {
        width: 320px;
        max-width: 450px;
        pointer-events: auto;
    }

    @media (max-width: 768px) {
        #toast-container {
            left: 1rem;
            right: 1rem;
            top: 1rem;
        }

        .toast-container {
            width: 100%;
            max-width: 100%;
        }
    }
</style>

<script>
    class ModernToastManager {
        constructor() {
            this.container = document.getElementById('toast-container');
            this.toasts = [];
            this.maxToasts = 5;
            this.shownMessages = new Set();
        }

        show(message, type = 'success', duration = 5000) {
            // Prevent showing the exact same message multiple times simultaneously
            if (this.shownMessages.has(message)) return;

            if (this.toasts.length >= this.maxToasts) {
                this.remove(this.toasts[0]);
            }

            const toast = this.createToast(message, type, duration);
            this.container.appendChild(toast);
            this.toasts.push(toast);
            this.shownMessages.add(message);

            requestAnimationFrame(() => toast.classList.add('toast-enter'));

            const timer = setTimeout(() => this.remove(toast, message), duration);
            toast.dataset.timer = timer;
        }

        createToast(message, type, duration) {
            const config = this.getConfig(type);
            const toast = document.createElement('div');

            toast.className =
                `toast-container overflow-hidden toast-glass rounded-xl shadow-2xl relative border border-gray-100 transform transition-all duration-300 hover:scale-[1.01]`;

            toast.innerHTML = `
                <!-- Accent bar with matching corner radius -->
                <div class="absolute left-0 top-0 bottom-0 w-1.5 ${config.accentColor} rounded-l-xl"></div>
                
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-50/50">
                    <div class="h-full ${config.progressColor} toast-progress" style="animation-duration: ${duration}ms;"></div>
                </div>
                
                <div class="p-4 pl-6 flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg ${config.iconBg} flex items-center justify-center ${config.iconColor} shadow-sm">
                        <i class="${config.icon} text-lg"></i>
                    </div>
                    
                    <div class="flex-1 min-w-0 pr-6">
                        <h3 class="text-xs font-black uppercase tracking-wider ${config.titleColor} mb-0.5">${config.title}</h3>
                        <p class="text-sm text-gray-700 leading-snug font-medium line-clamp-2">${message}</p>
                    </div>
                    
                    <button onclick="toastManager.remove(this.closest('.toast-container'), '${message.replace(/'/g, "\\'")}')" 
                            class="absolute top-2 right-2 p-1 text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>
            `;

            return toast;
        }

        getConfig(type) {
            const configs = {
                success: {
                    title: 'Success',
                    icon: 'fa-solid fa-check',
                    iconBg: 'bg-green-500',
                    iconColor: 'text-white',
                    titleColor: 'text-green-600',
                    accentColor: 'bg-green-500',
                    progressColor: 'bg-green-500'
                },
                error: {
                    title: 'Error',
                    icon: 'fa-solid fa-xmark',
                    iconBg: 'bg-red-500',
                    iconColor: 'text-white',
                    titleColor: 'text-red-600',
                    accentColor: 'bg-red-500',
                    progressColor: 'bg-red-500'
                },
                warning: {
                    title: 'Warning',
                    icon: 'fa-solid fa-exclamation',
                    iconBg: 'bg-amber-500',
                    iconColor: 'text-white',
                    titleColor: 'text-amber-600',
                    accentColor: 'bg-amber-500',
                    progressColor: 'bg-amber-500'
                },
                info: {
                    title: 'Information',
                    icon: 'fa-solid fa-info',
                    iconBg: 'bg-blue-500',
                    iconColor: 'text-white',
                    titleColor: 'text-blue-600',
                    accentColor: 'bg-blue-500',
                    progressColor: 'bg-blue-500'
                }
            };
            return configs[type] || configs.info;
        }

        remove(toast, message) {
            if (!toast || !toast.parentNode || toast.classList.contains('toast-exit')) return;

            if (toast.dataset.timer) clearTimeout(toast.dataset.timer);

            toast.classList.remove('toast-enter');
            toast.classList.add('toast-exit');

            // Sync with 0.3s animation duration
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                    this.toasts = this.toasts.filter(t => t !== toast);
                    if (message) this.shownMessages.delete(message);
                }
            }, 300);
        }
    }

    const toastManager = new ModernToastManager();

    document.addEventListener('DOMContentLoaded', () => {
        const alerts = [{
                msg: "{{ session('success') }}",
                type: 'success'
            },
            {
                msg: "{{ session('error') }}",
                type: 'error'
            },
            {
                msg: "{{ session('warning') }}",
                type: 'warning'
            },
            {
                msg: "{{ session('info') }}",
                type: 'info'
            },
            {
                msg: "{{ session('status') }}",
                type: 'success'
            },
            {
                msg: "{{ session('message') }}",
                type: 'info'
            }
        ];

        alerts.forEach(alert => {
            if (alert.msg && alert.msg.trim() !== '') {
                toastManager.show(alert.msg, alert.type);
            }
        });

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastManager.show("{{ $error }}", 'error', 7000);
            @endforeach
        @endif
    });

    function showToast(message, type = 'success', duration = 5000) {
        toastManager.show(message, type, duration);
    }
</script>
