<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use phpseclib\Crypt\RSA;

class CustomerController extends Controller
{
    //Muestra pagina principal
    public function home(Request $request){

        $auth = session('customer_info');

        //Check if the session is still active
        if (is_null($auth))
        {
            //return the login page 
            return redirect('/');
        }else{
           //return the welcome page 
           return view('index');  
        }

    }

    /*Valida la vida del token */
    public function verifyToken()
    {
        /*
        *check if the token is still valid
        *
        * This conditions is met when the current timestamp 
        * is greater that the access token expiration
        */
        if (Carbon::now()->timestamp > session('expiration_token')) {

           // dd("http://beesys.beenet.com.sv/api/2.0/admin/auth/tokens/.session('refresh_token')");
            // Renew token
            $response = Http::withOptions([
                    'debug' => false,
                    'verify' => false
                ])->get('https://eco-networks.splynx.app/api/2.0/admin/auth/tokens/'.session('refresh_token'), [
                        
                ]);

            $responseToken = json_decode($response->getBody()->getContents()); 
            //dd($responseToken);
            session(['customer_token' => $responseToken->access_token]);
        } 
    }


    /*Muestra el listado de facturas */
    public function invoices(){

        //Call a verifyToken function
        $this->verifyToken();

        //$customerToken = session('customer_token');
        if (is_null(session('customer_token') ))
        {
            return redirect('/');
        }
       
        //this response show invoices list
        $response = Http::withOptions([
            'debug' => false,
            'verify' => false
        ])->withHeaders([
            'Authorization' => 'Splynx-EA (access_token=' . session('customer_token') . ')'
        ])->get('https://eco-networks.splynx.app/api/2.0/admin/finance/invoices', [

        ]);

        $invoices = json_decode($response);
    
	    return view('facturas',compact('invoices'));
    }


    /*Funcion de descarga de factura */
    public function download(Request $request){

    
        $invoiceID = $request->input('invoiceID');
        //dd($invoiceID);
        //this response show invoices list
        $response = Http::withOptions([
            'debug' => false,
            'verify' => false
        ])->withHeaders([
            
            'Authorization' => 'Splynx-EA (access_token=' . session('customer_token') . ')'
        ])->get('https://eco-networks.splynx.app/api/2.0/admin/config/download/invoices--' . $invoiceID, [

        ]);

        $invoicePDF = json_decode($response);
       // dd($invoicePDF);

        // Extract PDF content from the JSON data
        $pdfContent = base64_decode($invoicePDF->content);

        // Set the response headers for the file download
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename=' . $invoicePDF->name,
        ];

        // Return the PDF content as a download
        return response()->stream(
            function () use ($pdfContent) {
                echo $pdfContent;
            },
            200,
            $headers
        );
        
        //return response()($invoicePDF->content);
    }

    
    /* Recupera datos del formulario oculto que se completa al seleccionar las facturas a pagar */
    public function payInvoices(Request $request)
    {
        $incoming = $request->all();
        $email = $request->email;
        $amount= $request->total;
        $invoicesGrid= $request->invoicesGrid;
        //dd($incoming);
       return view('checkout', compact('invoicesGrid', 'email', 'amount'));

    }


    /*Funcion para realizar pago en Banco y CRM */
    public function pay(Request $request)
    {
       $incoming = $request->all();
       
        /*Conexion al banco*/
       $publicKey = <<<EOT
        -----BEGIN PUBLIC KEY-----
        MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7ZEF6eApdXvClbwhc+mV
        KtBWDUFbykd3agzWIx3bREgGO2kU2iSmgn2j3yrKuCGDI+J9xjeKIgWwv0GQWhX4
        CPCprk29acqI1CKSiEZ6E55OA9Md/3MFwphonu616va7kcTyUQF6NHQElF3kl23I
        i5i8OC3CqEM2hfs6fubk9nq9CMbKhrEThCtUstGrhV/5uOIVLizCmRPZiKCvMb3b
        57mfOS4BwzPt7BfnM8X3COhvzMs24PzmtDzuxIHtjtkGpmxfNSK0fDWqoz1VivL1
        a2zfmjtAm4JMX4zehftiNP8VaZmVdvqITpUQwtZGvzwx2b0K3Q469JCkFrPmTvZn
        vwIDAQAB
        -----END PUBLIC KEY-----
        EOT;
        
        
        $key = new RSA();
        $key->loadKey($publicKey);

        
       list($month, $year) = explode('/', $incoming['expiration']);
       $creditcardNumber = str_replace("-", "", $incoming['creditcard']);
    
         // payload array 
		$payload = array(
   		 'Card' => $creditcardNumber,
                 'InfoS' => $incoming['cvv'],
			     'InfoV' => $year . $month,
                 'Amount' => str_pad( str_replace('.', '', $incoming['amount']), 12, '0', STR_PAD_LEFT)
        );



      // encrypted payload
		$encrypted = $key->encrypt(json_encode($payload));
		$encrypted = base64_encode($encrypted);

       // dd($encrypted);

        $response_agricola = Http::withOptions([
							//'debug' => true,
							'verify' => false
						])->post('https://www.serfinsacheckout.com/PaymentRest/Payment', [
							"KeyInfo" => "EA245E5E-B742-4D8A-8536-09E03EBA29EE",
							"PaymentData" => $encrypted
		]);


          if ($response_agricola->json('Satisfactorio')) {

			try {
				
				$response = Http::withOptions([
					'debug' => false,
					'verify' => false
				])->post('https://eco-networks.splynx.app/api/2.0/admin/auth/tokens', [
						//se envian los valores ingresados en el formulario
						'auth_type' => "admin",
						'login' => 'splynx' ,
						'password' => '5b007388'
				]);

				$adminToken = json_decode($response->getBody()->getContents());

                //dd($adminToken);

			} catch (ClientException $e) {
 				return back();
			} 

			$invoiceArray = json_decode($incoming['invoiceArray'], true);
             //dd($invoiceArray);
            
            
			foreach ($invoiceArray as $key => $value) { 
				$invoiceId = $key;
				$price = $value;
				//$authorizationId = $response_agricola->json('Datos')['Autorizacion'];
			    //$referenceId = $response_agricola->json('Datos')['Referencia'];
				
				try {
					$response = Http::withOptions([
						'debug' => false,
						'verify' => false
					])->withHeaders([
						'Authorization' => 'Splynx-EA (access_token=' . $adminToken->access_token . ')'
					])->post('https://eco-networks.splynx.app/api/2.0/admin/finance/payments', [
							//se envian los valores ingresados en el formulario
							"customer_id" => session('customer_info')[0]->id,
							"invoice_id" => $invoiceId,
							"payment_type" => 7,
							"date" => date('Y-m-d'),
							"amount" => $price,
							"comment" => "Pago factura Banco Agricola, Autorizacion: " . $authorizationId . " Referencia: " . $referenceId
					]);

				 $responsePayment = json_decode($response->getBody()->getContents());

				} catch (ClientException $e) {
                    alert()->error('Transacción Denegada','Su pago se ha sido aplicado');

					return back();
				} 
			} // fin for

			alert()->success('Transacción exitosa','Su pago se ha realizado correctamente');
			return redirect()->route('invoices');
	    } /*else {
			Log::error('Cliente' . session('customer_info')[0]->id . 'Codigo de error : ' . $this->mensajeError($response_agricola->json('Datos')['Codigo']));
			alert()->error($response_agricola->json('Mensaje'), $this->mensajeError($response_agricola->json('Datos')['Codigo'])); 
			return redirect()->route('all_Invoices');
		}*/







    }


    public function profile(){
    
        //Call a verifyToken function
        $this->verifyToken();

        //Get customer id 
        $customerId = session('customer_info')[0]->id;

        try {
          
            //this response show the customer info 
            $response1 = Http::withOptions([
                'debug' => false,
                'verify' => false
            ])->withHeaders([
                'Authorization' => 'Splynx-EA (access_token=' . session('customer_token') . ')'
            ])->get("https://eco-networks.splynx.app/api/2.0/admin/customers/customer-billing/$customerId", [

            ]);

            $responseBillingInfo = json_decode($response1->getBody()->getContents());
           // dd($responseBillingInfo);

            //this response show the service information 
            $response2 = Http::withOptions([
                'debug' => false,
                'verify' => false
            ])->withHeaders([
                'Authorization' => 'Splynx-EA (access_token=' . session('customer_token') . ')'
            ])->get("https://eco-networks.splynx.app/api/2.0/admin/customers/customer/$customerId/internet-services", [

            ]);

            $responseCustomerSevices = json_decode($response2->getBody()->getContents());
            //dd($responseCustomerSevices);
 
            //retur view  client info
            return view('perfil', compact('responseBillingInfo','responseCustomerSevices'));

        } catch (ClientException $e) {
            return back();
        }  
       
    }


    


    




}
