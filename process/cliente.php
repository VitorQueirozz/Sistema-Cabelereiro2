<?php 
    include_once('conn.php');
?>

<?php 

    $method = $_SERVER['REQUEST_METHOD'];

    if($method === "GET") {

        $dadosQuery = $conn->query('SELECT clientes.nome, clientes.sobrenome, clientes.telefone, datas.id, datas.dia, horarios.hora, agendamentos.cliente_id, agendamentos.data_id, agendamentos.horario_id, agendamentos.funcionario_id FROM clientes JOIN agendamentos ON clientes.id = agendamentos.cliente_id JOIN datas ON datas.id = agendamentos.data_id JOIN horarios ON horarios.id = agendamentos.horario_id JOIN funcionarios ON funcionarios.id = agendamentos.funcionario_id');

        $dados = $dadosQuery->fetchAll();

        $horarioQuery = $conn->query('SELECT * FROM horarios');

        $horarios = $horarioQuery->fetchAll();

        $barbeiroQuery = $conn->query("SELECT * FROM funcionarios");

        $barbeiros = $barbeiroQuery->fetchAll();

    } else if ($method === "POST") {

        $data = $_POST;

        $nome = $data['nome'];
        $sobrenome = $data['sobrenome'];
        $telefone = $data['telefone'];
        $dia = $data['dia'];
        $funcionario = $data['id_barbeiro'];
        
        $id_horario = $_POST['id_horario'];

        $stmt = $conn->prepare('INSERT INTO clientes (nome, sobrenome, telefone) VALUES (:nome, :sobrenome, :telefone)');

        $stmt->bindParam('nome', $nome);
        $stmt->bindParam('sobrenome', $sobrenome);
        $stmt->bindParam('telefone', $telefone);

        $stmt->execute();

        $cliente_id = $conn->lastInsertId();

        $stmt = $conn->prepare('INSERT INTO datas (dia) VALUES (:dia)');

        $stmt->bindParam('dia', $dia);

        $stmt->execute();

        $data_id = $conn->lastInsertId();

        $stmt = $conn->prepare('INSERT INTO agendamentos (cliente_id, data_id, horario_id, funcionario_id) VALUES (:cliente_id, :data_id, :horario_id, :funcionario_id)');

        $stmt->bindParam('cliente_id', $cliente_id);
        $stmt->bindParam('data_id', $data_id);
        $stmt->bindParam('horario_id', $id_horario);
        $stmt->bindParam('funcionario_id', $funcionario);

        $stmt->execute();

        header("Location: ../index.php");
        
    }

?>