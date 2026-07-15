<div id="session-timeout-modal" class="fixed inset-0 hidden items-center justify-center p-4 transition-all duration-300"
    style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); z-index: 9999;">
    <!-- Modal Card -->
    <div id="session-timeout-panel"
        class="bg-white rounded-md shadow-2xl w-full max-w-md mx-4 transform scale-95 opacity-0 transition-all duration-300 ease-out border border-slate-200">
        <div class="p-6">
            <!-- Header & Icon -->
            <div class="flex items-start gap-4">
                <div
                    class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-amber-50 text-amber-500 border border-amber-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-slate-800" id="session-timeout-title">
                        Session Expiring
                    </h2>
                    <p class="text-sm text-slate-500 mt-1 leading-relaxed">
                        For your security, your session will expire due to inactivity.
                    </p>
                </div>
            </div>

            <!-- Countdown Timer -->
            <div class="my-6 py-4 bg-slate-50 rounded-md border border-slate-100 text-center">
                <span id="session-timeout-countdown"
                    class="text-4xl font-mono font-bold tracking-widest text-slate-700">
                    01:00
                </span>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row-reverse gap-3">
                <button type="button" id="session-timeout-continue"
                    class="w-full inline-flex justify-center items-center bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-4 py-2.5 rounded-md shadow-sm transition-all duration-150 active:scale-95">
                    Continue Session
                </button>
                <button type="button" id="session-timeout-logout"
                    class="w-full inline-flex justify-center items-center border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium px-4 py-2.5 rounded-md transition-all duration-150">
                    Logout Now
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        // Config values (in milliseconds)
        const INACTIVITY_LIMIT = 20 * 60 * 1000; // 20 minutes
        const WARNING_THRESHOLD = 19 * 60 * 1000; // 19 minutes

        // Selectors
        const modal = document.getElementById('session-timeout-modal');
        const panel = document.getElementById('session-timeout-panel');
        const countdownEl = document.getElementById('session-timeout-countdown');
        const continueBtn = document.getElementById('session-timeout-continue');
        const logoutBtn = document.getElementById('session-timeout-logout');

        let timerInterval = null;
        let modalVisible = false;
        let lastUpdate = 0;

        // Initialize session_last_activity in localStorage if not set or invalid
        const initialTime = Date.now();
        if (!localStorage.getItem('session_last_activity')) {
            localStorage.setItem('session_last_activity', initialTime.toString());
        }

        // Helper to format remaining time
        function formatTime(ms) {
            const totalSec = Math.max(0, Math.ceil(ms / 1000));
            const min = Math.floor(totalSec / 60);
            const sec = totalSec % 60;
            return `${min.toString().padStart(2, '0')}:${sec.toString().padStart(2, '0')}`;
        }

        // Reset inactivity timer locally and sync via localStorage
        function resetInactivityTimer() {
            const now = Date.now();
            // Throttle localStorage writes to once per second for performance
            if (now - lastUpdate > 1000) {
                localStorage.setItem('session_last_activity', now.toString());
                lastUpdate = now;
            }
        }

        // Trigger logout redirection
        function triggerLogout() {
            // Clear timer and activity key
            clearInterval(timerInterval);
            localStorage.removeItem('session_last_activity');
            // Redirect to logout route
            window.location.href = "{{ url('Welcome/Logout') }}";
        }

        // Call keep alive endpoint to extend Laravel session
        function continueSession() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Disable continue button to prevent duplicate clicks
            continueBtn.disabled = true;
            const originalContent = continueBtn.innerHTML;
            continueBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Continuing...
        `;

            fetch("{{ route('keep-alive') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Reset local activity
                    localStorage.setItem('session_last_activity', Date.now().toString());
                    hideModal();
                })
                .catch(error => {
                    console.error('Error renewing session:', error);
                    // Fallback: If keep-alive fails, force logout
                    triggerLogout();
                })
                .finally(() => {
                    continueBtn.disabled = false;
                    continueBtn.innerHTML = originalContent;
                });
        }

        // Modal show/hide with animations
        function showModal() {
            if (modalVisible) return;
            modalVisible = true;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Force reflow to enable transition
            void modal.offsetWidth;

            // Apply transitions
            panel.classList.remove('scale-95', 'opacity-0');
            panel.classList.add('scale-100', 'opacity-100');
        }

        function hideModal() {
            if (!modalVisible) return;
            modalVisible = false;

            panel.classList.remove('scale-100', 'opacity-100');
            panel.classList.add('scale-95', 'opacity-0');

            // Wait for CSS transition to finish (300ms matches duration-300)
            setTimeout(() => {
                if (!modalVisible) {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            }, 300);
        }

        // Add activity listeners
        const activityEvents = ['mousemove', 'mousedown', 'click', 'keydown', 'scroll', 'touchstart', 'touchmove'];
        activityEvents.forEach(eventName => {
            document.addEventListener(eventName, resetInactivityTimer, { passive: true });
        });

        // Intercept native fetch
        if (window.fetch) {
            const originalFetch = window.fetch;
            window.fetch = function (...args) {
                const url = args[0];
                const isKeepAliveOrLogout = typeof url === 'string' && (url.includes('keep-alive') || url.includes('Logout'));

                return originalFetch.apply(this, args).then(response => {
                    if (response.ok && !isKeepAliveOrLogout) {
                        resetInactivityTimer();
                    }
                    return response;
                });
            };
        }

        // Intercept native XMLHttpRequest
        const originalSend = XMLHttpRequest.prototype.send;
        XMLHttpRequest.prototype.send = function (...args) {
            this.addEventListener('load', function () {
                const isKeepAliveOrLogout = this.responseURL && (this.responseURL.includes('keep-alive') || this.responseURL.includes('Logout'));
                if (this.status >= 200 && this.status < 300 && !isKeepAliveOrLogout) {
                    resetInactivityTimer();
                }
            });
            return originalSend.apply(this, args);
        };

        // Button event listeners
        continueBtn.addEventListener('click', continueSession);
        logoutBtn.addEventListener('click', triggerLogout);

        // Core interval tick function
        function tick() {
            const now = Date.now();
            const lastActivityStr = localStorage.getItem('session_last_activity');
            const lastActivity = lastActivityStr ? parseInt(lastActivityStr, 10) : now;
            const idleTime = now - lastActivity;

            if (idleTime >= INACTIVITY_LIMIT) {
                triggerLogout();
            } else if (idleTime >= WARNING_THRESHOLD) {
                showModal();
                const remainingMs = INACTIVITY_LIMIT - idleTime;
                countdownEl.textContent = formatTime(remainingMs);
            } else {
                hideModal();
            }
        }

        // Start timer interval
        timerInterval = setInterval(tick, 1000);

        // Initial check run immediately
        tick();
    })();
</script>