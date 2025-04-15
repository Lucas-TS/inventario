$(document).ready(function () {
    function applyMask(selector, maskPattern) {
        $(document).on('input', selector, function () {
            $(selector).mask(maskPattern, {
                reverse: true,
                translation: {
                    'A': { pattern: /[A-Fa-f0-9]/ },
                    '0': { pattern: /[0-9]/ }
                },
                onKeyPress: function (value, e, field, options) {
                    field.val(value.toUpperCase());
                }
            });
        });
    }

    function applyInputMasks() {
        applyMask('#input-mac, #input-mac-wifi', 'AA:AA:AA:AA:AA:AA');
        applyMask('#serial-so, #serial-office', 'AAAAA-AAAAA-AAAAA-AAAAA-AAAAA');
        applyMask('#clock-proc, #turbo-proc, #clock-edit-proc, #turbo-edit-proc', '00.00');
        applyMask('#tam-add-mon, #tam-edit-mon, #tela', '00.0');
    }

    $('#input-hn').on('input', function () {
        this.value = this.value.toUpperCase();
    });

    applyInputMasks();
});

