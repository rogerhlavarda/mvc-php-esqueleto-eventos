<?php require 'views/layout/header.php'; ?>

<?php $usuarioAutenticado = usuarioEstaAutenticado(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Eventos Esportivos</h1>
        <p class="text-muted mb-0">CRUD introdutório em PHP puro usando MVC com tema de corrida de rua.</p>
    </div>
    <?php if ($usuarioAutenticado) : ?>
        <a href="index.php?acao=criar" class="btn btn-success">Novo evento</a>
    <?php else : ?>
        <a href="index.php?acao=login" class="btn btn-outline-success">Fazer login</a>
    <?php endif; ?>
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
                            <!-- Cada iteracao percorre um registro retornado pelo model e preenche uma linha da tabela. -->
                            <tr>
                                <td><?php echo htmlspecialchars($evento['id']); ?></td>
                                <td><?php echo htmlspecialchars($evento['nome']); ?></td>
                                <td><?php echo htmlspecialchars($evento['cidade']); ?></td>
                                <!-- O banco armazena a data em Y-m-d, mas a interface mostra no padrao brasileiro d/m/Y. -->
                                <td><?php echo date('d/m/Y', strtotime($evento['data_evento'])); ?></td>
                                <td><?php echo htmlspecialchars($evento['distancia']); ?></td>
                                <td><?php echo htmlspecialchars($evento['status_evento']); ?></td>
                                <td class="text-center">
                                    <?php if ($usuarioAutenticado) : ?>
                                        <a href="index.php?acao=editar&id=<?php echo $evento['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            Editar
                                        </a>
                                        <form action="index.php?acao=excluir" method="POST" class="d-inline">
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($evento['id']); ?>">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(gerarTokenCsrf()); ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Deseja realmente excluir este evento?');">
                                                Excluir
                                            </button>
                                        </form>
                                    <?php else : ?>
                                        <span class="badge text-bg-secondary">Login necessário</span>
                                    <?php endif; ?>
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
