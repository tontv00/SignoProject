<?php include('layouts/header.php');


$signoEncontrado = null;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataNascimento = $_POST['data_nascimento'] ?? '';

    $data = DateTime::createFromFormat('!Y-m-d', $dataNascimento);
    $errosData = DateTime::getLastErrors();

    if (
        !$data ||
        ($errosData !== false &&
        ($errosData['warning_count'] > 0 ||
         $errosData['error_count'] > 0)) ||
        $data->format('Y-m-d') !== $dataNascimento
    ) {
        $erro = 'Informe uma data de nascimento válida.';
    } else {
        $diaMes = (int) $data->format('md');

        $xml = simplexml_load_file(__DIR__ . '/signos.xml');

        if ($xml === false) {
            $erro = 'Não foi possível carregar os dados dos signos.';
        } else {
            foreach ($xml->signo as $signo) {
                $inicio = DateTime::createFromFormat(
                    '!d/m',
                    (string) $signo->dataInicio
                );

                $fim = DateTime::createFromFormat(
                    '!d/m',
                    (string) $signo->dataFim
                );

                $inicioMD = (int) $inicio->format('md');
                $fimMD = (int) $fim->format('md');

                if ($inicioMD <= $fimMD) {
                    $corresponde =
                        $diaMes >= $inicioMD &&
                        $diaMes <= $fimMD;
                } else {
                    // Signo que atravessa a virada do ano.
                    $corresponde =
                        $diaMes >= $inicioMD ||
                        $diaMes <= $fimMD;
                }

                if ($corresponde) {
                    $signoEncontrado = $signo;
                    break;
                }
            }
        }
    }
}
?>

<body>
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow border-0">
                    <div class="card-body p-4 p-md-5 text-center">

                        <?php if ($erro): ?>

                            <h1 class="mb-3">Ops!</h1>

                            <p class="text-danger">
                                <?= htmlspecialchars($erro) ?>
                            </p>

                        <?php elseif ($signoEncontrado): ?>

                            <p class="text-muted">Seu signo é</p>

                            <h1 class="mb-4">
                                <?= htmlspecialchars(
                                    (string) $signoEncontrado->signoNome
                                ) ?>
                            </h1>

                            <p>
                                <?= htmlspecialchars(
                                    (string) $signoEncontrado->descricao
                                ) ?>
                            </p>

                            <p class="text-muted">
                                Período:
                                <?= htmlspecialchars(
                                    (string) $signoEncontrado->dataInicio
                                ) ?>
                                a
                                <?= htmlspecialchars(
                                    (string) $signoEncontrado->dataFim
                                ) ?>
                            </p>

                        <?php else: ?>

                            <h1>Descubra seu signo</h1>

                            <p>Envie sua data de nascimento pelo formulário.</p>

                        <?php endif; ?>

                        <a href="index.php"
                           class="btn btn-primary mt-3">
                            Voltar ao início
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
