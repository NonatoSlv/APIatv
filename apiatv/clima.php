<?php
if (!isset($_GET['cidade'])) {
    echo json_encode(["erro" => "Cidade não informada."]);
    exit;
}

$cidade = urlencode($_GET['cidade']);
$apiKey = "fd80c8f3906b34ebaeb01e4b60471bff"; // Substitua pela sua chave da OpenWeatherMap
$url = "https://api.openweathermap.org/data/2.5/weather?q={$cidade}&appid={$apiKey}&units=metric&lang=pt_br";

// Inicializa o cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Executa e obtém o resultado
$resposta = curl_exec($ch);
curl_close($ch);

// Decodifica o JSON
$data = json_decode($resposta, true);

// Trata erro
if (isset($data['cod']) && $data['cod'] != 200) {
    echo json_encode(["erro" => "Cidade não encontrada."]);
    exit;
}

// Monta a resposta simplificada
$resultado = [
    "nome" => $data['name'],
    "temperatura" => $data['main']['temp'],
    "descricao" => $data['weather'][0]['description']
];

echo json_encode($resultado);
