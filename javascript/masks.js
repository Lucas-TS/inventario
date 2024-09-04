$("#input-mac").mask("AA:AA:AA:AA:AA:AA",
    {
       translation:
       {
          'A': { pattern: /[A-Fa-f0-9]/ }
       }
    });