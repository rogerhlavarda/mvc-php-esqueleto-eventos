<?php require 'views/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Eventos Esportivos</h1>
        <p class="text-muted mb-0">CRUD introdutório em PHP puro usando MVC com tema de corrida de rua.</p>
    </div>
    <a href="index.php?acao=criar" class="btn btn-success">Novo evento</a>
</div>

<?php if (!empty($mensagem)) : ?>
    <div class="alert alert-<?php echo htmlspecialchars($tipoMensagem); ?>">
        <?php echo htmlspecialchars($mensagem); ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Evento</th>
                        <th>Cidade</th>
                        <th>Data</th>
                        <th>Distância</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($eventos)) : ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Nenhum evento cadastrado até agora.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($eventos as $evento) : ?>
                            <!-- TODO: completar as colunas da linha com os dados do evento -->
                            <tr>
                                <td><?php echo htmlspecialchars($evento['id']); ?></td>
                                <td><?php echo htmlspecialchars($evento['nome']); ?></td>
                                <td><?php echo htmlspecialchars($evento['cidade']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($evento['data_evento'])); ?></td>
                                <td><?php echo htmlspecialchars($evento['distancia']); ?></td>
                                <td><?php echo htmlspecialchars($evento['status_evento']); ?></td>
                                <td class="text-center">
                                    <a href="index.php?acao=editar&id=<?php echo $evento['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        Editar
                                    </a>
                                    <a href="index.php?acao=excluir&id=<?php echo $evento['id']; ?>" class="btn btn-sm btn-outline-danger">
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'views/layout/footer.php'; ?>
