<?php

namespace Store\StoreBundle\Controller;

use Common\AdminBaseBundle\Entity\Options;
use Common\SeguridadBundle\Entity\Usuario;
use Store\RestBundle\Entity\Clientes;
use Store\StoreBundle\Entity\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Client;


class MailSender
{
    /**
     * @var Options
     */
    private  $mail;
    /**
     * @var Cart
     */
    private  $cart;
    /**
     * @var Controller
     */
    private  $controller;
    /**
     * @var base_dir
     */
    private  $base_dir;

    /**
     * @param Options $mail
     * @param Cart $cart
     * @param Clientes $clientes
     *
     */


    public function __construct(Options $mail,Cart $cart,Controller $controller,$base_dir)
    {
        $this->mail = $mail;
$this->cart =$cart;
        $this->base_dir = $base_dir;
        $this->controller = $controller;
    }
    private  function  getBody()
    {
        $links = $this->controller->renderView('@CommonAdminBase/Default/_links.html.twig',array('server'=>true));

        $message = '
<html>
<head>
    <title>'. $this->controller->get('translator')->trans('order.mail.send') .' </title>
'.    $links
            .
            '
</head>
<body> <html>'.
            $links.

          $this->controller->renderView('@StoreStore/Cart/view_inner.html.twig',array('base_dir'=>$this->base_dir,'entities'=>$this->cart,'tarifa'=>$this->controller->getUser()->getCliente()->getTarifa()))
           .
            '</html>

</body>
</html>
';
        return $message;
    }

    public  function send()
    {
        $mail = new \PHPMailer();

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	/*	$linux = strpos($_SERVER["PATH"],"sbin")!==false;
	if($linux==true)
	{*/
		/*$user      = $this->controller->getUser()->getEmail();*/
        $user='netadmin@acingeconst.co.cu';
	  $username= $this->controller->getUser()->getNombreCompleto();
		//$username = "Harry";
		$admin = $this->mail->getValueData('email');
		//$user = $admin;
        $titulo    = 'Se ha realizado un pedido';
        $mensaje   = '';
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1 ' . "\r\n";
       $cabeceras .= 'To: '.$username.'<'.$user.'>' . "\r\n";
       $cabeceras .= 'From: '.$this->mail->getValueData('name').' <'.$admin.'>' . "\r\n";
        $cabeceras .= 'Cc: '.$admin. "\r\n";

        // attachment
        $content = $this->controller->getPdf($this->cart->getId());
        $uid = md5(uniqid(time()));
        $filename="pedido.pdf";
        $cabeceras .= "--".$uid."\r\n";
        $cabeceras .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
        $cabeceras .= "Content-Transfer-Encoding: base64\r\n";
        $cabeceras .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
        $cabeceras .= $content."\r\n\r\n";
        $cabeceras .= "--".$uid."--";

        //-----
		$boSend = @mail($user, $titulo, $mensaje, $cabeceras);
		 if(!$boSend) {
            return array('response'=>0,'error'=>'');

        } else {
              return array('response'=>1);
        }/*}
	
		else
		{

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $this->mail->getValueData('server');  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $this->mail->getValueData('email');                 // SMTP username
        $mail->Password = $this->mail->getValueData('password');                           // SMTP password
        $mail->SMTPSecure = '';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port =  $this->mail->getValueData('port');                                    // TCP port to connect to

        $mail->setFrom($this->mail->getValueData('email'), $this->mail->getValueData('name') );
        $mail->addAddress($this->mail->getValueData('email'), $this->mail->getValueData('name'));     // Add a recipient
        $mail->addAddress($this->controller->getUser()->getEmail(), $this->controller->getUser()->getNombreCompleto());
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Se ha realizado un pedido';
        $mail->Body    = $this->getBody();
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            return array('response'=>0,'error'=>$mail->ErrorInfo);

        } else {
              return array('response'=>1);
        }}*/
    }


}