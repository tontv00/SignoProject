
<?php include('layouts/header.php'); ?>

<body>
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card shadow border-0">
                    <div class="card-body p-4 p-md-5 text-center">

                        <h1 class="mb-3">Descubra seu signo</h1>

                        <p class="text-muted mb-4">
                            Informe sua data de nascimento e descubra
                            as principais características do seu signo.
                        </p>

                        <form action="show_zodiac_sign.php" method="POST">
                            <div class="mb-3 text-start">
                                <label for="data_nascimento"
                                       class="form-label">
                                    Data de nascimento
                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="data_nascimento"
                                    name="data_nascimento"
                                    required
                                >
                            </div>

                            <button type="submit"
                                    class="btn btn-primary w-100">
                                Descobrir meu signo
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
