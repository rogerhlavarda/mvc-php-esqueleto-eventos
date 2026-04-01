<?php require 'views/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-1"><?php echo $tituloPagina; ?></h1>
                        <p class="text-muted mb-0">Preencha os dados do evento esportivo.</p>
                    </div>
                    <a href="index.php" class="btn btn-outline-secondary">Voltar</a>
                </div>

                <form action="index.php?acao=<?php echo $acaoFormulario; ?>" method="POST">
                    <?php if ($acaoFormulario === 'atualizar') : ?>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($evento['id']); ?>">
                    <?php endif; ?>

                    <!-- TODO: criar o campo nome -->
                    <!-- TODO: criar o campo cidade -->

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <!-- TODO: criar o campo data_evento -->
                        </div>

                        <div class="col-md-4 mb-3">
                            <!-- TODO: criar o select distancia -->
                            <!-- Sugestões: 5 km, 10 km, 15 km, 21 km, 42 km -->
                        </div>

                        <div class="col-md-4 mb-3">
                            <!-- TODO: criar o select status_evento -->
                            <!-- Sugestões: Planejado, Inscrito, Concluído -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <!-- TODO: criar o textarea observacoes -->
                    </div>

                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require 'views/layout/footer.php'; ?>
