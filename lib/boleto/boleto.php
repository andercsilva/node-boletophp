<?php
//Dados vindos pelo NODE
$nossonumero = $argv[1];
$parcela = $argv[2];
//Configuração
$boleto['vencimento'] = date('d/m/Y');
$boleto['valor'] = '1.00';
$boleto['nosso_numero'] = str_pad($nossonumero, 9, "0", STR_PAD_LEFT);


//$dias_de_prazo_para_pagamento = 100;
$taxa_boleto = 0.0;
$data_venc = $boleto['vencimento'];//date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $boleto['valor'];//"64,07"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

// Composição Nosso Numero - CEF SIGCB
$dadosboleto["nosso_numero1"] = "000"; // tamanho 3
$dadosboleto["nosso_numero_const1"] = "2"; //constanto 1 , 1=registrada , 2=sem registro
$dadosboleto["nosso_numero2"] = "000"; // tamanho 3
$dadosboleto["nosso_numero_const2"] = "4"; //constanto 2 , 4=emitido pelo proprio cliente
$dadosboleto["nosso_numero3"] = $boleto['nosso_numero'];//"000000003";  // tamanho 9


$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero3"];//"000000001";	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
if (array_key_exists('google',$user)) {	
	$dadosboleto["sacado"] = utf8_decode($user['google']['name']);
} else if (array_key_exists('fb',$user)) {
	$dadosboleto["sacado"] = utf8_decode($user['fb']['name']['full']);
} else if (array_key_exists('twit',$user)) {
	$dadosboleto["sacado"] = utf8_decode($user['twit']['name']);
} else {
	$dadosboleto["sacado"] = utf8_decode($user['name']['first'] . ' ' . $user['name']['last']);
}
$dadosboleto["endereco1"] = utf8_decode($user['address']['address'] . ', ' . $user['address']['number']);
$dadosboleto["endereco2"] = utf8_decode($user['address']['district'] . ' - ' .  $user['address']['city'] . ' - ' . $user['address']['uf'] . ' - ' .  $user['cep']);

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Compra do Anderson Loyola";
$dadosboleto["demonstrativo2"] = "Referente ao pedido N: " . strtoupper($buyId);//<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = "Anderson Loyola - http://www.andersonloyola.com.br";

// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema do MeuFluir - www.andersonloyola.com.br";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "N";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DS";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //

// DADOS DA SUA CONTA - CEF
$dadosboleto["agencia"] = "0991"; // Num da agencia, sem digito
$dadosboleto["conta"] = "1785"; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "2"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - CEF
$dadosboleto["conta_cedente"] = "000000"; // Código Cedente do Cliente, com 6 digitos (Somente Números)
$dadosboleto["carteira"] = "SR";  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

// SEUS DADOS
$dadosboleto["identificacao"] = "ANDERSON LOYOLA";
$dadosboleto["cpf_cnpj"] = "09.000.000/0000-03";
$dadosboleto["endereco"] = "Rua Teste, 123";
$dadosboleto["cidade_uf"] = "Curitiba / Paraná";
$dadosboleto["cedente"] = "Anderson Loyola Ltda";


// NÃO ALTERAR!
include("include/funcoes_cef_sigcb.php"); 
include("include/layout_cef.php");

//echo json_encode($dadosboleto);
?>
