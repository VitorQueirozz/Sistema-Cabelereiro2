<?php 
    include_once('conn.php');
?>

<?php 

    $method = $_SERVER['REQUEST_METHOD'];

    if($method === "GET") {

        $dadosQuery = $conn->query('SELECT clientes.nome, clientes.sobrenome, clientes.telefone, datas.id, datas.dia, horarios.hora, agendamentos.cliente_id, agendamentos.data_id, agendamentos.horario_id, agendamentos.funcionario_id, funcionarios.nome_funcionario FROM clientes JOIN agendamentos ON clientes.id = agendamentos.cliente_id JOIN datas ON datas.id = agendamentos.data_id JOIN horarios ON horarios.id = agendamentos.horario_id JOIN funcionarios ON funcionarios.id = agendamentos.funcionario_id');

        $dados = $dadosQuery->fetchAll();

        $horarioQuery = $conn->query('SELECT * FROM horarios');

        $horarios = $horarioQuery->fetchAll();

        $barbeiroQuery = $conn->query("SELECT * FROM funcionarios");

        $barbeiros = $barbeiroQuery->fetchAll();

    } else if($method === "POST") {

        $type = $_POST['type'];

        if($type === 'delete') {

            $cliente_id = $_POST['cliente_id'];
            $data_id = $_POST['data_id'];
            $horario_id = $_POST['horario_id'];
            $funcionario_id = $_POST['funcionario_id'];

            $deleteQuery = $conn->prepare('DELETE FROM agendamentos WHERE cliente_id = :cliente_id AND data_id = :data_id AND horario_id = :horario_id AND funcionario_id = :funcionario_id');

            $deleteQuery->bindParam(':cliente_id', $cliente_id);
            $deleteQuery->bindParam(':data_id', $data_id);
            $deleteQuery->bindParam(':horario_id', $horario_id);
            $deleteQuery->bindParam(':funcionario_id', $funcionario_id);

            $deleteQuery->execute();

            $deleteQuery = $conn->prepare('DELETE FROM datas WHERE id = :data_id');

            $deleteQuery->bindParam(':data_id', $data_id);

            $deleteQuery->execute();

            $deleteQuery = $conn->prepare('DELETE FROM clientes WHERE id = :cliente_id');

            $deleteQuery->bindParam(':cliente_id', $cliente_id);

            $deleteQuery->execute();

            header("Location: ../dashboard.php");

        } else if ($type === 'update') {

            $data = $_POST;

            $nome = $data['nome'];
            $sobrenome = $data['sobrenome'];
            $dia = $data['dia'];
            $cliente_id = $data['cliente_id'];
            $data_id = $data['data_id'];
            $id_horario = $data['id_horario'];
            $horario_id = $_POST['horario_id'];
     
            $updateQuery = $conn->prepare('UPDATE clientes SET nome = :nome, sobrenome = :sobrenome WHERE id = :cliente_id');

            $updateQuery->bindParam(':nome', $nome);
            $updateQuery->bindParam(':sobrenome', $sobrenome);
            $updateQuery->bindParam(':cliente_id', $cliente_id);

            $updateQuery->execute();

            $updateQuery = $conn->prepare('UPDATE datas SET dia = :dia WHERE id = :data_id');

            $updateQuery->bindParam(':dia', $dia);
            $updateQuery->bindParam(':data_id', $data_id);

            $updateQuery->execute();

            header("Location: ../dashboard.php");

        }

    }

?>