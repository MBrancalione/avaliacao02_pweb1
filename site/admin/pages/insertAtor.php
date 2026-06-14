<?php
include '../../header.php';
include '../login/autenticacao.php';
include_once "../db.class.php";

if($_SESSION['user_tipo'] !== 'admin') { 
    header('Location: ../login.php?erro=sem_permissao');
    exit; 
}

$db = new db('atores');
$success = '';
$actionError = '';
$errors = [];
$data = '';


if(!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {

    $data = (object) $_POST; //converte o array associativo do post para um objeto para facilitar o acesso aos campos
    // var_dump($_POST);
    //exit;
    try {

        if (empty($_POST['nome_artista'])) {
            $errors[] = "<li>O nome do artista é obrigatório</li>";
        }

        if (empty($_POST['data_nascimento'])) {
            $errors[] = "<li>O email é obrigatório</li>";
        }

        if (empty($_POST['nacionalidade'])) {
            $errors[] = "<li>A nacionalidade é obrigatório</li>";
        }

        if (empty($errors)) {
            if(empty($_POST['id'])) {
                //o código está enviando um id vazio para o banco, se não existir um id, ele deve ser retirado, para que então seja possível ao banco inserir automaticamente
                unset($_POST['id']);

                $db->store($_POST);
                $success = "Registro Salvo com sucesso!";
            }
            else {
        // Atualização
        $db->update($_POST); // Passa o $_POST (array), já que a sua função espera só um parâmetro!
        $success = "Registro Atualizado com sucesso!";
    }

            redirect('atorList.php');
        }
    } catch (PDOException $e) {
        $actionError = $e->getMessage();
    } catch (Exception $e) {
        $actionError = $e->getMessage();
    }
}


?>

<div class="row">
    <?php actionMessage($success, $actionError) ?>
    <?php showValidationError($errors) ?>

    <form action="./insertAtor.php" method="post">
        <h3>Formulário INSERT ATOR</h3>

        <input type="hidden" name="id" value="<?php echo isset($data->id) ? $data->id : ''; ?>"> 

        <div class="col-6">
            <label for="nome_artista">Nome do Artista</label>
            <input type="text" name="nome_artista" class="form-control" value="<?php echo getFormValue($data, 'nome_artista'); ?>">
        </div>
        <div class="col-6">
            <label for="data_nascimento">Data de Nascimento</label>
            <input type="date" name="data_nascimento" class="form-control" value="<?php echo getFormValue($data, 'data_nascimento'); ?>">
        </div>
        <div class="col-6">
            <label for="nacionalidade">País de Origem</label>
            <select class="form-select" name="nacionalidade">
                <option value="">Selecione o País</option>
                <?php
                $paises = [
                    "Afeganistão", "Ilhas Aland", "Albânia", "Argélia", "Samoa Americana", "Andorra", "Angola", 
                    "Anguila", "Antártida", "Antígua e Barbuda", "Argentina", "Armênia", "Aruba", "Austrália", 
                    "Áustria", "Azerbaijão", "Bahamas", "Barein", "Bangladesh", "Barbados", "Bielorrússia", 
                    "Bélgica", "Belize", "Benin", "Bermudas", "Butão", "Bolívia", "Bósnia e Herzegovina", 
                    "Botsuana", "Ilha Bouvet", "Brasil", "Território Britânico do Oceano Índico", "Brunei", 
                    "Bulgária", "Burquina Faso", "Burundi", "Cabo Verde", "Camboja", "Camarões", "Canadá", 
                    "Países Baixos Caribenhos", "Ilhas Cayman", "República Centro-Africana", "Chade", "Chile", 
                    "China", "Ilha Christmas", "Ilhas Cocos (Keeling)", "Colômbia", "Comores", "República do Congo", 
                    "Congo - Kinshasa", "Ilhas Cook", "Costa Rica", "Croácia", "Cuba", "Curaçao", "Chipre", 
                    "Tchéquia", "Costa do Marfim", "Dinamarca", "Djibuti", "Dominica", "República Dominicana", 
                    "Equador", "Egito", "El Salvador", "Guiné Equatorial", "Eritreia", "Estônia", "Essuatíni", 
                    "Etiópia", "Ilhas Malvinas", "Ilhas Faroé", "Fiji", "Finlândia", "França", "Guiana Francesa", 
                    "Polinésia Francesa", "Territórios Franceses do Sul", "Gabão", "Gâmbia", "Geórgia", "Alemanha", 
                    "Gana", "Gibraltar", "Grécia", "Groenlândia", "Granada", "Guadalupe", "Guam", "Guatemala", 
                    "Guernsey", "Guiné", "Guiné-Bissau", "Guiana", "Haiti", "Ilhas Heard e McDonald", "Honduras", 
                    "Hong Kong, RAE da China", "Hungria", "Islândia", "Índia", "Indonésia", "Irã", "Iraque", 
                    "Irlanda", "Ilha de Man", "Israel", "Itália", "Jamaica", "Japão", "Jersey", "Jordânia", 
                    "Cazaquistão", "Quênia", "Quiribati", "Coreia do Norte", "Coreia do Sul", "Kosovo", "Kuwait", 
                    "Quirguistão", "Laos", "Letônia", "Líbano", "Lesoto", "Libéria", "Líbia", "Liechtenstein", 
                    "Lituânia", "Luxemburgo", "Macau, RAE da China", "Macedônia do Norte", "Madagascar", "Malaui", 
                    "Malásia", "Maldivas", "Mali", "Malta", "Ilhas Marshall", "Martinica", "Mauritânia", "Maurício", 
                    "Mayotte", "México", "Micronésia", "Moldávia", "Mônaco", "Mongólia", "Montenegro", "Montserrat", 
                    "Marrocos", "Moçambique", "Mianmar (Birmânia)", "Namíbia", "Nauru", "Nepal", "Países Baixos", 
                    "Curaçao", "Nova Caledônia", "Nova Zelândia", "Nicarágua", "Níger", "Nigéria", "Niue", 
                    "Ilha Norfolk", "Ilhas Marianas do Norte", "Noruega", "Omã", "Paquistão", "Palau", 
                    "Territórios palestinos", "Panamá", "Papua-Nova Guiné", "Paraguai", "Peru", "Filipinas", 
                    "Ilhas Pitcairn", "Polônia", "Portugal", "Porto Rico", "Catar", "Reunião", "Romênia", "Rússia", 
                    "Ruanda", "São Bartolomeu", "Santa Helena", "São Cristóvão e Névis", "Santa Lúcia", "São Martinho", 
                    "São Pedro e Miquelão", "São Vicente e Granadinas", "Samoa", "San Marino", "São Tomé e Príncipe", 
                    "Arábia Saudita", "Senegal", "Sérvia", "Seicheles", "Serra Leoa", "Singapura", "Sint Maarten", 
                    "Eslováquia", "Eslovênia", "Ilhas Salomão", "Somália", "África do Sul", 
                    "Ilhas Geórgia do Sul e Sandwich do Sul", "Sudão do Sul", "Espanha", "Sri Lanka", "Sudão", 
                    "Suriname", "Svalbard e Jan Mayen", "Suécia", "Suíça", "Síria", "Taiwan", "Tadjiquistão", 
                    "Tanzânia", "Tailândia", "Timor-Leste", "Togo", "Tokelau", "Tonga", "Trinidad e Tobago", 
                    "Tunísia", "Turquia", "Turcomenistão", "Ilhas Turcas e Caicos", "Tuvalu", 
                    "Ilhas Menores Distantes dos EUA", "Uganda", "Ucrânia", "Emirados Árabes Unidos", "Reino Unido", 
                    "Estados Unidos", "Uruguai", "Uzbequistão", "Vanuatu", "Cidade do Vaticano", "Venezuela", 
                    "Vietnã", "Ilhas Virgens Britânicas", "Ilhas Virgens Americanas", "Wallis e Futuna", 
                    "Saara Ocidental", "Iêmen", "Zâmbia", "Zimbábue"
                ];

                $paisSelecionado = getFormValue($data, 'nacionalidade');

                foreach ($paises as $pais) { //aqui ele compara os dois em um laço de repetição. Ele pega o pais selecionado e compara com os paises, aquele que ficar igual, ele manterá como selecionado quando for editar. Pedi ajuda pro gemini com isso, a lista eu vi exemplo na internet.
                    $selecionado = ($pais === $paisSelecionado) ? 'selected' : '';
                    echo "<option value=\"{$pais}\" {$selecionado}>{$pais}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="atorList.php" class="btn btn-primary"> Voltar</a>
        </div>
</div>


    </form>

</div>


<?php
include '../../footer.php';
?>