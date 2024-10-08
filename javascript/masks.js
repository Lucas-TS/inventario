$(document).ready(function () {
    function applyMasks() {
        $('#input-mac').mask('AA:AA:AA:AA:AA:AA', {
            translation: {
                'A': { pattern: /[A-Fa-f0-9]/ }
            },
            onKeyPress: function (value, e, field, options) {
                field.val(value.toUpperCase());
            }
        });

        $('#serial-so').mask('AAAAA-AAAAA-AAAAA-AAAAA-AAAAA', {
            translation: {
                'A': { pattern: /[A-Za-z0-9]/ }
            },
            onKeyPress: function (value, e, field, options) {
                field.val(value.toUpperCase());
            }
        });

        $('#input-hn').on('input', function () {
            this.value = this.value.toUpperCase();
        });
    }

    function applyClockAndTurboMasks() {
        $('#clock-proc, #turbo-proc').mask('00.00', {
            reverse: true, // Aplica a máscara de trás para frente
            translation: {
                '0': { pattern: /[0-9]/ }
            },
            onKeyPress: function (value, e, field, options) {}
        });
    }

    // Aplicar máscaras inicialmente
    applyMasks();

    // Verificação periódica a cada 500ms
    setInterval(function () {
        if ($('#clock-proc').length || $('#turbo-proc').length) {
            applyClockAndTurboMasks();
        }
    }, 500);
});
