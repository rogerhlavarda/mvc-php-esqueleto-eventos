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
                     <div class="mb-3">
                        <label for="nome" class="form-label">Nome do evento</label>
                        <input
                            type="text"
                            class="form-control"
                            id="nome"
                            name="nome"
                            value="<?php echo htmlspecialchars($evento['nome']); ?>"
                            required
                        >
                    </div>
                    <!-- TODO: criar o campo cidade -->
                     <div class="mb-3">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input
                            type="text"
                            class="form-control"
                            id="cidade"
                            name="cidade"
                            value="<?php echo htmlspecialchars($evento['cidade']); ?>"
                            required
                        >
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <!-- TODO: criar o campo data_evento -->
                             <label for="data_evento" class="form-label">Data</label>
                            <input
                                type="date"
                                class="form-control"
                                id="data_evento"
                                name="data_evento"
                                value="<?php echo htmlspecialchars($evento['data_evento']); ?>"
                                required
                            >
                        </div>

                        <div class="col-md-4 mb-3">
                            <!-- TODO: criar o select distancia -->
                            <!-- Sugestões: 5 km, 10 km, 15 km, 21 km, 42 km -->
                            <label for="distancia" class="form-label">Distância</label>
                            <select class="form-select" id="distancia" name="distancia" required>
                                <option value="">Selecione</option>
                                <option value="5 km" <?php echo $evento['distancia'] === '5 km' ? 'selected' : ''; ?>>5 km</option>
                                <option value="10 km" <?php echo $evento['distancia'] === '10 km' ? 'selected' : ''; ?>>10 km</option>
                                <option value="15 km" <?php echo $evento['distancia'] === '15 km' ? 'selected' : ''; ?>>15 km</option>
                                <option value="21 km" <?php echo $evento['distancia'] === '21 km' ? 'selected' : ''; ?>>21 km</option>
                                <option value="42 km" <?php echo $evento['distancia'] === '42 km' ? 'selected' : ''; ?>>42 km</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <!-- TODO: criar o select status_evento -->
                            <!-- Sugestões: Planejado, Inscrito, Concluído -->
                             <label for="status_evento" class="form-label">Status</label>
                            <select class="form-select" id="status_evento" name="status_evento" required>
                                <option value="">Selecione</option>
                                <option value="Planejado" <?php echo $evento['status_evento'] === 'Planejado' ? 'selected' : ''; ?>>Planejado</option>
                                <option value="Inscrito" <?php echo $evento['status_evento'] === 'Inscrito' ? 'selected' : ''; ?>>Inscrito</option>
                                <option value="Concluído" <?php echo $evento['status_evento'] === 'Concluído' ? 'selected' : ''; ?>>Concluído</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <!-- TODO: criar o textarea observacoes -->
                         <label for="observacoes" class="form-label">Observações</label>
                        <textarea
                            class="form-control"
                            id="observacoes"
                            name="observacoes"
                            rows="4"
                        ><?php echo htmlspecialchars($evento['observacoes']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require 'views/layout/footer.php'; ?>
