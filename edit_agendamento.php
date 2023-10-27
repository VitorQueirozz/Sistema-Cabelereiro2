<?php 
    include_once('process/orders.php');
    include_once('process/conn.php');
    require_once('templates/header.php');

    $cliente_id = $_GET['cliente_id'];
    $data_id = $_GET['data_id'];

    $query = $conn->prepare('SELECT clientes.nome, clientes.sobrenome, datas.dia FROM clientes JOIN agendamentos ON clientes.id = agendamentos.cliente_id JOIN datas ON datas.id = agendamentos.data_id WHERE clientes.id = :cliente_id AND datas.id = :data_id');
    $query->bindParam(':cliente_id', $cliente_id);
    $query->bindParam(':data_id', $data_id);
    $query->execute();
    $queryData = $query->fetch();

    $nome = $queryData['nome'];
    $sobrenome = $queryData['sobrenome'];
    $data = $queryData['dia'];

?>
    <main>
        <form action="process/orders.php" method="POST" class="form-cabelo">
            <div>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" value="<?= $nome; ?>">
                <label for="sobrenome">Sobrenome:</label>
                <input type="text" name="sobrenome" id="sobrenome" value="<?= $sobrenome; ?>">
                <label for="dia">Dia:</label>
                <input type="text" name="dia" id="dia" value="<?= $data; ?>">
            </div>
            <input type="hidden" name="type" value="update">
            <input type="hidden" name="cliente_id" value="<?= $cliente_id; ?>">
            <input type="hidden" name="data_id" value="<?= $data_id; ?>">
            <button type="submit" class="btn-marcar">Atualizar</button>
        </form>
    </main>
<?php 
    require_once('templates/footer.php');
?>