document.addEventListener('DOMContentLoaded', () => {
    const cpInput        = document.getElementById('cp');
    if (!cpInput) return; // solo corre en la página de solicitud

    const cargando       = document.getElementById('cp-cargando');
    const errorMsg       = document.getElementById('cp-error');
    const coloniaInput   = document.getElementById('colonia-input');
    const coloniaSelect  = document.getElementById('colonia-select');
    const municipioInput = document.getElementById('municipio');
    const estadoInput    = document.getElementById('estado');

    function mostrarInput() {
        coloniaInput.style.display  = '';
        coloniaInput.name           = 'colonia';
        coloniaSelect.style.display = 'none';
        coloniaSelect.name          = '';
    }

    function mostrarSelect(colonias) {
        coloniaInput.style.display  = 'none';
        coloniaInput.name           = '';
        coloniaSelect.style.display = '';
        coloniaSelect.name          = 'colonia';

        coloniaSelect.innerHTML = colonias
            .map(c => `<option value="${c}">${c}</option>`)
            .join('');
    }

    function limpiarDireccion() {
        mostrarInput();
        coloniaInput.value   = '';
        municipioInput.value = '';
        estadoInput.value    = '';
    }

    cpInput.addEventListener('input', function () {
        const cp = this.value.trim();
        errorMsg.style.display = 'none';

        if (cp.length < 5) {
            limpiarDireccion();
            return;
        }

        cargando.style.display = 'inline';

        fetch(`https://api.zippopotam.us/MX/${cp}`)
            .then(res => {
                if (!res.ok) throw new Error('CP no encontrado');
                return res.json();
            })
            .then(data => {
                cargando.style.display = 'none';

                const lugares   = data.places;
                const estado    = lugares[0]['state'] || '';
                const municipio = lugares[0]['place name'] || '';

                estadoInput.value    = estado;
                municipioInput.value = municipio;

                const colonias = [...new Set(lugares.map(p => p['place name']))];

                if (colonias.length === 1) {
                    mostrarInput();
                    coloniaInput.value = colonias[0];
                } else {
                    fetch(`https://sepomex.icalialabs.com/api/v1/zip_codes?zip_code=${cp}`)
                        .then(r => r.ok ? r.json() : null)
                        .then(sepData => {
                            if (sepData && sepData.zip_codes && sepData.zip_codes.length > 0) {
                                const cols = [...new Set(
                                    sepData.zip_codes.map(z => z.d_asenta).filter(Boolean)
                                )];
                                municipioInput.value = sepData.zip_codes[0].D_mnpio || municipio;
                                estadoInput.value    = sepData.zip_codes[0].d_estado || estado;
                                cols.length > 1
                                    ? mostrarSelect(cols)
                                    : (mostrarInput(), coloniaInput.value = cols[0] || '');
                            } else {
                                colonias.length > 1
                                    ? mostrarSelect(colonias)
                                    : (mostrarInput(), coloniaInput.value = colonias[0] || '');
                            }
                        })
                        .catch(() => {
                            colonias.length > 1
                                ? mostrarSelect(colonias)
                                : (mostrarInput(), coloniaInput.value = colonias[0] || '');
                        });
                }
            })
            .catch(() => {
                cargando.style.display = 'none';
                errorMsg.textContent   = 'CP no encontrado. Llena los campos manualmente.';
                errorMsg.style.display = 'inline';
                limpiarDireccion();
            });
    });
});