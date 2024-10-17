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
        applyMask('#input-mac', 'AA:AA:AA:AA:AA:AA');
        applyMask('#serial-so', 'AAAAA-AAAAA-AAAAA-AAAAA-AAAAA');
        applyMask('#serial-office', 'AAAAA-AAAAA-AAAAA-AAAAA-AAAAA');
        applyMask('#clock-proc, #turbo-proc', '00.00');
        applyMask('#tam-add-mon', '00.0');
    }

    $('#input-hn').on('input', function () {
        this.value = this.value.toUpperCase();
    });

    applyInputMasks();
});

