
/*
 * GET boleto.
 */

exports.boleto = function(req, res){
	var nossonumero = 1234567;
	var parcela = 1;
	var exec = require('child_process').exec;
	var boleto = __dirname + '/../lib/boleto/boleto.php';
	exec("php "+boleto+" " + nossonumero.toString() + ' ' + parcela,
		{ encoding: 'binary'}, 
			function (error, stdout, stderr) {
			if (error !== null) {
				console.log('exec error: ' + error);
			}        
			res.send(stdout, { 'Content-Type': 'text/html' }, 200);
		});
};