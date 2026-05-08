document.addEventListener('DOMContentLoaded', () => {
    // ── Teléfono: solo dígitos, exactamente 10 ──────────────────────────────
    const tel    = document.getElementById('telefono');
    const telErr = document.getElementById('telefono-error');

    if (tel && telErr) {
        tel.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '');
            const ok = this.value.length === 10;
            telErr.style.display = (!ok && this.value.length > 0) ? 'block' : 'none';
            this.setCustomValidity(ok || this.value.length === 0 ? '' : 'Ingresa exactamente 10 dígitos.');
        });
    }

    // ── Correo: formato válido ───────────────────────────────────────────────
    const correo    = document.getElementById('correo');
    const correoErr = document.getElementById('correo-error');
    const reEmail   = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    if (correo && correoErr) {
        correo.addEventListener('blur', function () {
            const ok = reEmail.test(this.value.trim());
            correoErr.style.display = (!ok && this.value.length > 0) ? 'block' : 'none';
            this.setCustomValidity(ok || this.value.length === 0 ? '' : 'Formato de correo inválido.');
        });

        correo.addEventListener('input', function () {
            if (reEmail.test(this.value.trim())) {
                correoErr.style.display = 'none';
                this.setCustomValidity('');
            }
        });
    }
});