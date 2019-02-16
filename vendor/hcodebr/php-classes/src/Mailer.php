<?php

namespace Hcode;

use Rain\Tpl;

class Mailer {

	const USERNAME = "montserrat.tecnologia@gmail.com";
	const PASSWORD = "<?montserrattech20190214?>";
	const NAME_FROM = "Montserrat Tecnologia";

	private $mail;

	public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
	{
		$config = array(
			"tpl_dir" 		=> $_SERVER["DOCUMENT_ROOT"]."/views/email/",
			"cache_dir"		=> $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"			=> false
		);

		Tpl::configure( $config );

		$tpl = new Tpl;
		//$this->tpl = new Tpl;

		foreach ($data as $key => $value) 
		{
			$tpl->assign($key, $value);
			//$this->tpl->assign($key, $value);
		}

		$html = $tpl->draw($tplName, true);
		//$html = $this->tpl->draw($tplName, true);

		$this->mail = new \PHPMailer;

		$this->mail->isSMTP();

		$this->mail->SMTPDebug = 0;
		//$this->mail->SMTPDebug = 2;

		$this->mail->Debugoutput = 'html';

		$this->mail->Host = 'smtp.gmail.com';

		$this->mail->Port = 587;
		//$this->mail->Port = 465;

		//===== NOVO TRECHO ==========
		$this->mail->isSMTP();
		
		$this->mail->SMTPOptions = array(
    		'ssl' => array(
        	'verify_peer' => false,
        	'verify_peer_name' => false,
        	'allow_self_signed' => true
    		));
    	
		//======FIM DO NOVO TRECHO ======
		
		$this->mail->SMTPSecure = 'tls';
		//$this->mail->SMTPSecure = 'ssl';

		$this->mail->SMTPAuth = true;

		$this->mail->Username = Mailer::USERNAME;

		$this->mail->Passord = Mailer::PASSWORD;

		$this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);

		$this->mail->addAddress($toAddress, $toName);
		//$this->mail->addAddress('montserrat.tecnologia@gmail.com', 'edilsonx');
		
		$this->mail->Subject = $subject;

		$this->mail->msgHTML($html);

		$this->mail->AltBody = 'This is a plain-text message body';		

/*
		var_dump("=============INICIO MAILER PHP ================================================");
		var_dump($this->mail);
		var_dump("=============FIM MAILER PHP ================================================");
		exit;

*/
	}

	public function send()
	{	

	/*
		var_dump("=============INICIO MAILER SEND  ================================================");
		var_dump($this->mail);
		var_dump("=============FIM MAILER SEND  ================================================");
		exit;
	*/

		return $this->mail->send();

	}


}

?>