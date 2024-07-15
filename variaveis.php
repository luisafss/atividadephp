<?php

// Função para limpar o buffer de entrada (stdin)
function limparBuffer() {
    while (ob_get_status()) {
        ob_end_clean();
    }
}

// Função para exibir o menu principal
function exibirMenu() {
    echo "=== Sistema de Gestão de Notas ===\n";
    echo "1. Cadastrar Alunos\n";
    echo "2. Atribuir Notas\n";
    echo "3. Mostrar Resultados\n";
    echo "4. Editar Resultados Individuais\n";
    echo "5. Sair\n";
    echo "Escolha uma opção: ";
}

// Função para calcular o resultado geral de acordo com a média
function calcularResultado($media) {
    if ($media < 4) {
        return "Reprovado";
    } elseif ($media >= 4 && $media <= 6) {
        return "Recuperação";
    } elseif ($media > 6) {
        return "Aprovado";
    }
}

// Array para armazenar os dados dos alunos
$alunos = [];

// Loop principal do programa
do {
    exibirMenu();

    // Captura da escolha do usuário
    $opcao = trim(fgets(STDIN));

    switch ($opcao) {
        case 1:
            // Cadastro de alunos
            echo "\n== Cadastro de Alunos ==\n";
            for ($i = 0; $i < 5; $i++) {
                echo "Digite o nome do aluno " . ($i + 1) . ": ";
                $nome = trim(fgets(STDIN));
                $alunos[$i]['nome'] = $nome;
                $alunos[$i]['notas'] = [];
            }
            echo "\nAlunos cadastrados com sucesso!\n";
            break;

        case 2:
            // Atribuição de notas
            if (empty($alunos)) {
                echo "Cadastre os alunos primeiro!\n";
                break;
            }

            echo "\n== Atribuição de Notas ==\n";
            foreach ($alunos as $indice => $aluno) {
                echo "Notas do aluno {$aluno['nome']}:\n";
                $total = 0;
                for ($j = 1; $j <= 4; $j++) {
                    echo "Digite a nota {$j} (entre 0 e 10): ";
                    $nota = floatval(trim(fgets(STDIN)));
                    while ($nota < 0 || $nota > 10) {
                        echo "Nota inválida! Digite novamente (entre 0 e 10): ";
                        $nota = floatval(trim(fgets(STDIN)));
                    }
                    $alunos[$indice]['notas'][] = $nota;
                    $total += $nota;
                }
                $media = $total / 4;
                $alunos[$indice]['media'] = $media;
            }
            echo "\nNotas atribuídas com sucesso!\n";
            break;

        case 3:
            // Mostrar resultados
            echo "\n== Resultados dos Alunos ==\n";
            foreach ($alunos as $aluno) {
                echo "Aluno: {$aluno['nome']}\n";
                echo "Notas: " . implode(", ", $aluno['notas']) . "\n";
                echo "Média: {$aluno['media']}\n";
                echo "Resultado: " . calcularResultado($aluno['media']) . "\n\n";
            }
            break;

        case 4:
            // Editar resultado individualmente
            echo "\n== Edição de Resultados Individuais ==\n";
            echo "Digite o nome do aluno que deseja editar: ";
            $nome = trim(fgets(STDIN));
            $encontrado = false;
            foreach ($alunos as $indice => $aluno) {
                if ($aluno['nome'] == $nome) {
                    echo "Novas notas do aluno {$aluno['nome']}:\n";
                    $total = 0;
                    for ($j = 1; $j <= 4; $j++) {
                        echo "Digite a nota {$j} (entre 0 e 10): ";
                        $nota = floatval(trim(fgets(STDIN)));
                        while ($nota < 0 || $nota > 10) {
                            echo "Nota inválida! Digite novamente (entre 0 e 10): ";
                            $nota = floatval(trim(fgets(STDIN)));
                        }
                        $alunos[$indice]['notas'][$j - 1] = $nota;
                        $total += $nota;
                    }
                    $media = $total / 4;
                    $alunos[$indice]['media'] = $media;
                    $encontrado = true;
                    echo "\nResultado editado com sucesso!\n";
                    break;
                }
            }
            if (!$encontrado) {
                echo "Aluno não encontrado!\n";
            }
            break;

        case 5:
            // Sair do programa
            echo "Saindo do programa...\n";
            break;

        default:
            // Opção inválida
            echo "Opção inválida! Escolha novamente.\n";
            break;
    }

    // Limpa o buffer de entrada
    limparBuffer();

} while ($opcao != 5);

?>
