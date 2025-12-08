function verificarTecla(event, n) {
  const teclasValidas =
    /^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?`~áéíóúÁÉÍÓÚãõÃÕâêîôûÂÊÎÔÛçÇ°ºª§¹²³£¢¬]$/;
  const teclasIgnoradas = [
    "End",
    "Home",
    "ArrowLeft",
    "ArrowRight",
    "ArrowUp",
    "ArrowDown",
    "Shift",
    "Control",
    "Alt",
    "Meta",
    "CapsLock",
    "Tab",
    "Escape",
  ];

  if (
    teclasValidas.test(event.key) ||
    event.key === "Backspace" ||
    event.key === "Delete"
  ) {
    if (n && n !== "") {
      limparFichaMon(n);
    } else {
      limparFichaProc();
    }
  } else if (!teclasIgnoradas.includes(event.key)) {
    event.preventDefault();
  }
}

function limparFormulario() {
  limparFichaProc();

  let pv = document.getElementById("formulario-pv-1");
  pv.innerHTML = "";

  let office = document.getElementById("formulario-office-1");
  office.innerHTML = "";

  let so = document.getElementById("formulario-so-1");
  so.innerHTML = "";

  contadorMonitor = 0;
  contadorbMonitor = 0;
  let mon = document.getElementById("monitores-container");
  mon.innerHTML = "";
  document.getElementById("adicionarMonitor").style.display = "flex";

  contadorDsk = 0;
  contadorbDsk = 0;
  let dsk = document.getElementById("armazenamentos-container");
  dsk.innerHTML = "";
  document.getElementById("adicionarDsk").style.display = "flex";
}

async function preencherProc(id) {
  let formData = {
    id: id,
    funcao: "proc",
  };

  try {
    let response = await fetch("./includes/buscar_pc.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json;charset=UTF-8",
      },
      body: JSON.stringify(formData),
    });
    if (!response.ok) {
      throw new Error("Erro ao buscar os dados.");
    }
    let data = await response.json(); // Converte a resposta para JSON
    //Preenche os campos do formulário com os dados retornados
    let marca = data.marca ?? "";
    let modelo = data.modelo ?? "";
    let memorias = data.memoria;
    let processador = marca + " " + modelo;
    const tipo = document.getElementById("hidden-tipo").value;

    const tipos = {
      0: "desktop",
      1: "notebook",
      2: "servidor",
    };

    const categoria = tipos[tipo];
    if (categoria) {
      document.getElementById(`processador-${categoria}`).value = processador;
      document.getElementById(`hidden-processador-${categoria}`).value =
        data.id_processador;
      document.getElementById(
        `hidden-id-assoc-processador-${categoria}`
      ).value = data.id_assoc;
    }

    fichaProcessador(processador);
    suggestionsMem(memorias, 1);
  } catch (error) {
    console.error(error.message);
  }
}

let contadorAddDsk = 1;

async function preencherSsd(id) {
  let formData = {
    id: id,
    funcao: "ssd",
  };

  try {
    let response = await fetch("./includes/buscar_pc.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json;charset=UTF-8",
      },
      body: JSON.stringify(formData),
    });
    if (!response.ok) {
      throw new Error("Erro ao buscar os dados.");
    }
    let data = await response.json(); // Converte a resposta para JSON
    data.forEach((item) => {
      adicionarArmazenamento();
      document.getElementById("ssd-" + contadorAddDsk).checked = true;
      mostrarFormulario(contadorAddDsk, "SSD");
      // Preenche os campos do formulário com os dados retornados
      let tamanho = item.tamanho;
      document.getElementById("tam-ssd-" + contadorAddDsk).value = tamanho;
      document.getElementById("hidden-tam-ssd-" + contadorAddDsk).value =
        item.id_ssd;
      document.getElementById("hidden-id-assoc-ssd-" + contadorAddDsk).value =
        item.id_assoc;
      let saude = item.saude;
      document.getElementById("saude-ssd-" + contadorAddDsk).value = saude;
      let tipo = item.tipo;
      if (tipo == "NVME") {
        document.getElementById("NVME-" + contadorAddDsk).checked = true;
      } else if (tipo == "M2SATA") {
        document.getElementById("M2SATA-" + contadorAddDsk).checked = true;
      } else {
        document.getElementById("SATA-" + contadorAddDsk).checked = true;
      }

      contadorAddDsk++;
      // Adicione aqui o preenchimento dos campos específicos do seu formulário
    });
  } catch (error) {
    console.error("Erro:", error);
  }
}

async function preencherHd(id) {
  let formData = {
    id: id,
    funcao: "hd",
  };

  try {
    let response = await fetch("./includes/buscar_pc.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json;charset=UTF-8",
      },
      body: JSON.stringify(formData),
    });
    if (!response.ok) {
      throw new Error("Erro ao buscar os dados.");
    }
    let data = await response.json(); // Converte a resposta para JSON
    data.forEach((item) => {
      adicionarArmazenamento();
      document.getElementById("hd-" + contadorAddDsk).checked = true;
      mostrarFormulario(contadorAddDsk, "HD");
      // Preenche os campos do formulário com os dados retornados
      let tamanho = item.tamanho;
      document.getElementById("tam-hd-" + contadorAddDsk).value = tamanho;
      document.getElementById("hidden-tam-hd-" + contadorAddDsk).value =
        item.id_hd;
      document.getElementById("hidden-id-assoc-hd-" + contadorAddDsk).value =
        item.id_assoc;
      let saude = item.saude;
      document.getElementById("saude-hd-" + contadorAddDsk).value = saude;
      let tipo = item.tipo;
      if (tipo == "IDE") {
        document.getElementById("IDE-" + contadorAddDsk).checked = true;
      } else {
        document.getElementById("SATA-" + contadorAddDsk).checked = true;
      }

      contadorAddDsk++;
      // Adicione aqui o preenchimento dos campos específicos do seu formulário
    });
  } catch (error) {
    console.error("Erro:", error);
  }
}

async function preencherPv(id) {
  let formData = {
    id: id,
    funcao: "pv",
  };

  try {
    let response = await fetch("./includes/buscar_pc.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json;charset=UTF-8",
      },
      body: JSON.stringify(formData),
    });
    if (!response.ok) {
      throw new Error("Erro ao buscar os dados.");
    }
    let data = await response.json(); // Converte a resposta para JSON
    //Preenche os campos do formulário com os dados retornados
    if (data) {
      document.getElementById("pv-off").checked = true;
      let tipo = document.getElementById("hidden-tipo").value;
      formularioGPU("off", tipo === "1" ? "Notebook" : undefined);

      if (tipo === "0") {
        document.getElementById("hidden-mem-pv").value = data.id_placa_video;
        document.getElementById("hidden-id-assoc-pv").value = data.id_assoc;
        document.getElementById("gpu-pv").value = data.gpu;
        document.getElementById("marca-pv").removeAttribute("disabled");
        document.getElementById("marca-pv").value = data.marca;
        document.getElementById("modelo-pv").removeAttribute("disabled");
        document.getElementById("modelo-pv").value = data.modelo;
        document.getElementById("mem-pv").removeAttribute("disabled");
        document.getElementById("mem-pv").value = data.memoria;
      } else if (tipo === "1") {
        document.getElementById("hidden-mem-pv-nb").value = data.id_placa_video;
        document.getElementById("hidden-id-assoc-pv").value = data.id_assoc;
        document.getElementById("gpu-pv-nb").value = data.gpu;
        document.getElementById("mem-pv-nb").removeAttribute("disabled");
        document.getElementById("mem-pv-nb").value = data.memoria;
      }

    }
  } catch (error) {
    console.error(error.message);
  }
}

let contadorAddMon = 1;

async function preencherMonitor(id) {
  let formData = {
    id: id,
    funcao: "monitor",
  };

  try {
    let response = await fetch("./includes/buscar_pc.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json;charset=UTF-8",
      },
      body: JSON.stringify(formData),
    });
    if (!response.ok) {
      throw new Error("Erro ao buscar os dados.");
    }
    let data = await response.json(); // Converte a resposta para JSON
    data.forEach((item) => {
      adicionarMonitor();
      // Preenche os campos do formulário com os dados retornados
      let marca = item.marca;
      document.getElementById("marca-monitor-" + contadorAddMon).value = marca;
      let modelo = item.modelo;
      document.getElementById("modelo-monitor-" + contadorAddMon).value =
        modelo;
      document.getElementById("hidden-modelo-monitor-" + contadorAddMon).value =
        item.id_monitor;
      document.getElementById(
        "hidden-id-assoc-monitor-" + contadorAddMon
      ).value = item.id_assoc;
      let conexao = item.conexao;
      if (conexao == "HDMI") {
        document.getElementById("HDMI-" + contadorAddMon).checked = true;
      } else if (conexao == "DP") {
        document.getElementById("DP-" + contadorAddMon).checked = true;
      } else if (conexao == "DVI") {
        document.getElementById("DVI-" + contadorAddMon).checked = true;
      } else {
        document.getElementById("VGA-" + contadorAddMon).checked = true;
      }
      document
        .getElementById("modelo-monitor-" + contadorAddMon)
        .removeAttribute("disabled");
      let monitor = marca + " " + modelo;
      fichaMonitor(monitor, contadorAddMon);

      contadorAddMon++;
      // Adicione aqui o preenchimento dos campos específicos do seu formulário
    });
  } catch (error) {
    console.error("Erro:", error);
  }
}

async function preencherSo(id) {
  let formData = {
    id: id,
    funcao: "so",
  };

  try {
    let response = await fetch("./includes/buscar_pc.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json;charset=UTF-8",
      },
      body: JSON.stringify(formData),
    });
    if (!response.ok) {
      throw new Error("Erro ao buscar os dados.");
    }
    let data = await response.json(); // Converte a resposta para JSON
    //Preenche os campos do formulário com os dados retornados
    let nome = data.nome;
    if (nome == "Windows") {
      document.getElementById("win").checked = true;
      formularioSO(nome);
      document.getElementById("ver-win").value = data.versao;
      document.getElementById("b-line-so-3").classList.remove("display-none");
      document.getElementById("ed-win").value = data.edicao;
      document.getElementById("b-line-so-5").classList.remove("display-none");
      let arq = data.arquitetura;
      if (arq == "x86") {
        document.getElementById("x86-win").checked = true;
        document.getElementById("x64-win").classList.add("display-none");
        document.querySelector('label[for="x64-win"]').classList.add("display-none");
      } else {
        document.getElementById("x64-win").checked = true;
        document.getElementById("x86-win").classList.add("display-none");
        document.querySelector('label[for="x86-win"]').classList.add("display-none");
      }
    } else if (nome == "Linux") {
      document.getElementById("linux").checked = true;
      formularioSO(nome);
      document.getElementById("distro-linux").value = data.distribuicao;
      document.getElementById("b-line-so-3").classList.remove("display-none");
      document.getElementById("ver-linux").value = data.versao;
      document.getElementById("b-line-so-4").classList.remove("display-none");
      document.getElementById("if-linux").value = data.edicao;
      document.getElementById("b-line-so-5").classList.remove("display-none");
      let arq = data.arquitetura;
      if (arq == "x86") {
        document.getElementById("x86-linux").checked = true;
        document.getElementById("x64-linux").classList.add("display-none");
        document
          .querySelector('label[for="x64-linux"]')
          .classList.add("display-none");
      } else {
        document.getElementById("x64-linux").checked = true;
        document.getElementById("x86-linux").classList.add("display-none");
        document
          .querySelector('label[for="x86-linux"]')
          .classList.add("display-none");
      }
    }
    document.getElementById("hidden-so").value = data.id_so;
    document.getElementById("hidden-id-assoc-so").value = data.id_assoc;
  } catch (error) {
    console.error(error.message);
  }
}

async function preencherOffice(id) {
  let formData = {
    id: id,
    funcao: "office",
  };

  try {
    let response = await fetch("./includes/buscar_pc.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json;charset=UTF-8",
      },
      body: JSON.stringify(formData),
    });
    if (!response.ok) {
      throw new Error("Erro ao buscar os dados.");
    }
    let data = await response.json(); // Converte a resposta para JSON
    //Preenche os campos do formulário com os dados retornados
    let dev = data.dev;
    if (dev == "Microsoft") {
      document.getElementById("ms").checked = true;
      formularioOffice("Office");
      document.getElementById("ver-ms").value = data.versao;
      document.getElementById("ed-ms").removeAttribute("disabled");
      document.getElementById("ed-ms").value = data.edicao;
    } else {
      document.getElementById("free").checked = true;
      formularioOffice("Free");
      document.getElementById("nome-free").value = data.nome;
      document.getElementById("ver-free").removeAttribute("disabled");
      document.getElementById("ver-free").value = data.versao;
    }
    document.getElementById("hidden-office").value = data.id_office;
    document.getElementById("hidden-id-assoc-office").value = data.id_assoc;
  } catch (error) {
    console.error(error.message);
  }
}

function preencherSituacao(situacao) {
  let texto = "";
  switch (situacao) {
    case 0:
      texto = "Em uso";
      break;
    case 1:
      texto = "Devolver";
      break;
    case 2:
      texto = "Distribuir";
      break;
    case 3:
      texto = "Manutenção";
      break;
    case 4:
      texto = "Aguardando peças";
      break;
    case 5:
      texto = "Defeito";
      break;
    case 6:
      texto = "Descarregar";
      break;
    case 7:
      texto = "Bloqueado";
      break;
    default:
      texto = "";
  }
  return texto;
}

async function preencherPC(id) {
  let formData = {
    id: id,
    funcao: "buscar_pc",
  };

  try {
    let response = await fetch("./includes/buscar_pc.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json;charset=UTF-8",
      },
      body: JSON.stringify(formData),
    });
    if (!response.ok) {
      throw new Error("Erro ao buscar os dados.");
    }
    let data = await response.json(); // Converte a resposta para JSON
    //Preenche os campos do formulário com os dados retornados
    document.getElementById("id-edit-pc").value = data.id;
    if (data.ativo === 1) {
      document.getElementById("ativo-edit-pc").checked = true;
    }
    let dataInclusao = data.data_inclusao;
    let militarInclusao = data.fullname_add;
    let textoInclusao = dataInclusao + " por " + militarInclusao;
    document.getElementById("data-add-edit-pc").innerHTML = textoInclusao;
    let dataAtualizacao = data.data_atualizacao;
    if (dataAtualizacao) {
      let militarAtualizacao = data.fullname_updt;
      let textoAtualizacao = dataAtualizacao + " por " + militarAtualizacao;
      document.getElementById("data-updt-edit-pc").innerHTML = textoAtualizacao;
    } else {
      document.getElementById("data-updt-edit-pc").innerHTML = "---";
    }
    document.getElementById("op").value = data.op;
    document.getElementById("hidden-op").value = data.id_operador;
    document.getElementById("lacre").value = data.lacre;
    document.getElementById("marca").value = data.marca;
    document.getElementById("modelo").value = data.modelo;
    document.getElementById("garantia").value = data.garantia;

    await preencherProc(id);

    document.getElementById("qtde-mem").value = data.tam_mem;
    toggleButtons(document.getElementById("qtde-mem"), "mem");
    document.getElementById("tipo-mem").value = data.tipo_mem;

    await preencherSsd(id);
    await preencherHd(id);
    await preencherPv(id);
    await preencherMonitor(id);
    await preencherSo(id);

    let windows = document.querySelector(
      'input[type="radio"][id="win"]:checked'
    );
    let linux = document.querySelector(
      'input[type="radio"][id="linux"]:checked'
    );
    if (windows) {
      document.getElementById("user-win").value = data.usuario;
      document.getElementById("pw-win").value = data.senha;
      let serialSo = data.licenca_so;
      if (serialSo && serialSo == 1) {
        document.getElementById("digital-rd-win").checked = true;
      } else if (
        (serialSo && serialSo == 0) ||
        serialSo == null ||
        serialSo == ""
      ) {
        document.getElementById("pirata-rd-win").checked = true;
      } else {
        document.getElementById("serial-rd-win").checked = true;
        document.getElementById("serial-so").removeAttribute("disabled");
        document.getElementById("serial-so").value = serialSo;
      }
    } else if (linux) {
      document.getElementById("user-linux").value = data.usuario;
      document.getElementById("pw-linux").value = data.senha;
    }

    await preencherOffice(id);

    let office = document.querySelector('input[type="radio"][id="ms"]:checked');
    if (office) {
      let serialOffice = data.licenca_office;
      if (serialOffice && serialOffice == 1) {
        document.getElementById("digital-rd-office").checked = true;
      } else if (
        (serialOffice && serialOffice == 0) ||
        serialOffice == null ||
        serialOffice == ""
      ) {
        document.getElementById("pirata-rd-office").checked = true;
      } else {
        document.getElementById("serial-rd-office").checked = true;
        document.getElementById("serial-office").value = serialOffice;
        document.getElementById("serial-office").removeAttribute("disabled");
      }
    }

    if (data.antivirus === 1) {
      document.getElementById("av-sim").checked = true;
    } else {
      document.getElementById("av-nao").checked = true;
    }

    document.getElementById("input-hn").value = data.hostname;

    if (data.rede === 1) {
      document.getElementById("rede-off").checked = true;
    } else {
      document.getElementById("rede-on").checked = true;
    }

    document.getElementById("input-mac").value = data.mac;
    $("#input-mac").trigger("input");

    if (data.wifi === 1) {
      document.getElementById("wifi-sim").checked = true;
      document.getElementById("input-mac-wifi").removeAttribute("disabled");
    } else {
      document.getElementById("wifi-nao").checked = true;
      document
        .getElementById("input-mac-wifi")
        .setAttribute("disabled", "true");
    }

    document.getElementById("input-mac-wifi").value = data.mac_wifi;
    $("#input-mac-wifi").trigger("input");

    document.getElementById("ip").value = data.ip;

    let idSituacao = data.situacao;
    let situacao = preencherSituacao(idSituacao);
    document.getElementById("situacao").value = situacao;
    document.getElementById("hidden-situacao").value = idSituacao;

    document.getElementById("input-obs").value = data.observacao;
  } catch (error) {
    console.error(error.message);
  }
}

function expandirItem(ref) {
  // Se for string, busca o elemento pelo id
  let hLine;
  if (typeof ref === 'string') {
    hLine = document.getElementById(ref);
  } else if (ref instanceof HTMLElement) {
    hLine = ref.closest('.h-line.expansivel');
  }
  if (!hLine || !hLine.classList.contains('expansivel')) return;

  // Encontra a .linha que contém o h-line
  const linhaAtual = hLine.closest('.linha');
  if (!linhaAtual) return;

  // Busca os elementos filhos da linha, entre o h-line clicado e o próximo h-line expansivel/fixo
  let found = false;
  const blocos = [];
  linhaAtual.childNodes.forEach(el => {
    if (el === hLine) {
      found = true;
      return;
    }
    // Se for h-line-sec, exibe junto
    if (found && el.nodeType === 1 && el.classList.contains('h-line-sec')) {
      blocos.push(el);
    }
    // Se for bloco comum, exibe normalmente
    if (found && el.nodeType === 1 && !el.classList.contains('h-line')) {
      blocos.push(el);
    }
    // Para se encontrar outro h-line expansivel/fixo dentro da mesma linha
    if (found && el.nodeType === 1 && el.classList.contains('h-line') && (el.classList.contains('expansivel') || el.classList.contains('fixo'))) {
      found = false;
    }
  });

  if (!blocos.length) return;

  // Recolhe todos os outros blocos expandidos e reseta rotação dos outros SVGs
  document.querySelectorAll('.h-line.expansivel').forEach(outroHLine => {
    if (outroHLine !== hLine) {
      const outraLinha = outroHLine.closest('.linha');
      if (!outraLinha) return;
      let foundOutro = false;
      const outrosBlocos = [];
      outraLinha.childNodes.forEach(el => {
        if (el === outroHLine) {
          foundOutro = true;
          return;
        }
        // Inclui h-line-sec nos blocos a serem recolhidos
        if (foundOutro && el.nodeType === 1 && el.classList.contains('h-line-sec')) {
          outrosBlocos.push(el);
        }
        if (foundOutro && el.nodeType === 1 && !el.classList.contains('h-line')) {
          outrosBlocos.push(el);
        }
        if (foundOutro && el.nodeType === 1 && el.classList.contains('h-line') && (el.classList.contains('expansivel') || el.classList.contains('fixo'))) {
          foundOutro = false;
        }
      });
      if (outrosBlocos.length && !outrosBlocos[0].classList.contains('oculto')) {
        outrosBlocos.forEach(b => b.classList.add('oculto'));
      }
      // Rotaciona o SVG para recolhido
      const svgOutro = outroHLine.querySelector('svg');
      if (svgOutro) svgOutro.classList.remove('rotacionado');
    }
  });

  // Verifica se o primeiro bloco está oculto
  const oculto = blocos[0].classList.contains('oculto');

  // Alterna a classe 'oculto' em todos os blocos (incluindo h-line-sec)
  blocos.forEach(b => {
    if (oculto) {
      b.classList.remove('oculto');
    } else {
      b.classList.add('oculto');
    }
  });

  // Rotaciona o SVG dentro do h-line clicado
  const svg = hLine.querySelector('svg');
  if (svg) {
    if (oculto) {
      svg.classList.add('rotacionado');
    } else {
      svg.classList.remove('rotacionado');
    }
  }
}